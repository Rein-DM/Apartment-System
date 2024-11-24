<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\UserManagementController;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use PDF;
use Auth;

class PaymentController extends Controller
{
    // Display all payments
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 entries per page if not specified
        $search = $request->input('search'); // Retrieve the search query

        // Query payments and apply search filter
        $payments = Payment::when($search, function ($query, $search) {
                return $query->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('payment_method', 'like', "%{$search}%")
                            ->orWhere('amount', $search);
            })
            ->paginate($perPage);

        // Existing code for past due status and other counts remains as it is
        // Update the past due status of users
        $userManagement = new UserManagementController();
        $userManagement->updatePastDueStatus();

        // Retrieve the payment count
        $paymentCount = Payment::count();

        // Retrieve and format payment dates
        $paymentDates = Payment::pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        });

        // Get today's date
        $today = Carbon::today();

        // Check if the user has the admin role
        $isAdmin = Auth::user()->role === 'admin';

        // Initialize dueTodayCount
        $dueTodayCount = 0;

        // Prepare variables for due dates and past due dates
        $dueDates = collect();
        $pastDueDates = collect();

        if ($isAdmin) {
            // Admin can see all upcoming due dates
            $dueTodayCount = User::whereDate('due_date', '>=', $today)->count();
            $dueDates = User::whereDate('due_date', '>=', $today)
                            ->orderBy('due_date')
                            ->pluck('due_date'); // Get only due_date values directly
        
            // Fetch all past due dates
            $pastDueDates = User::where('is_past_due', true)
                                ->orderByDesc('due_date')
                                ->pluck('due_date'); // Get only due_date values directly
        } else {
            // Regular users can only see their own due dates
            $dueTodayCount = User::where('id', Auth::id())
                                ->whereDate('due_date', '>=', $today)
                                ->count();
        
            // Retrieve upcoming due dates for the authenticated user
            $dueDates = User::where('id', Auth::id())
                            ->whereDate('due_date', '>=', $today)
                            ->orderBy('due_date')
                            ->pluck('due_date'); // Get only due_date values directly
        
            // Retrieve past due dates for the authenticated user
            $pastDueDates = User::where('id', Auth::id())
                                ->where('is_past_due', true)
                                ->orderByDesc('due_date')
                                ->pluck('due_date'); // Get only due_date values directly
        }
        // Count of past due dates
        $pastDueCount = $pastDueDates->count();

        // Return view with existing data plus new pagination data and search query
        return view('payment.index', compact('payments', 'paymentCount', 'paymentDates', 'dueTodayCount', 'dueDates', 'pastDueDates', 'pastDueCount', 'perPage', 'search'));
    }
    
    // Show the form for creating a new payment
    public function create()
    {
        // Existing code for past due status and other counts remains as it is
        $userManagement = new UserManagementController();
        $userManagement->updatePastDueStatus();
        
        $paymentCount = Payment::count();
        $paymentDates = Payment::pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        });
        $userId = auth()->id();
        $today = Carbon::today();
        $dueTodayCount = User::where('id', Auth::id())
                            ->whereDate('due_date', '>=', $today)
                            ->count();
         $dueDates = User::where('id', Auth::id())
                        ->whereDate('due_date', '>=', $today)
                        ->orderBy('due_date')
                        ->pluck('due_date')
                        ->map(function ($date) {
                            return Carbon::parse($date)->format('Y-m-d');
                        });

        // Fetch only the past due dates
        $pastDueDates = User::where('id', Auth::id())
                            ->where('is_past_due', true)
                            ->orderByDesc('due_date')
                            ->pluck('due_date')
                            ->map(function ($date) {
                                return Carbon::parse($date)->format('Y-m-d');
                            });

        $pastDueCount = $pastDueDates->count();

        // Return view with existing data plus new pagination data and search query
        return view('payment.create', compact('paymentCount', 'paymentDates', 'dueTodayCount', 'dueDates', 'pastDueDates', 'pastDueCount'));
    }

    // Store function to create a new payment record
    public function store(Request $request)
    {
        // Set validation rules based on payment method
        $rules = [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:11',
            'amount' => 'required|numeric',
            'payment_method' => 'nullable|string|max:255',
            'reason' => 'nullable|string|max:255', // Validate reason for personal payment
            'due_date' => 'required|array', // Validate due_date as an array
            'due_date.*' => 'string|date_format:Y-m-d', // Optional: Validate each due date format
        ];
    
        // Add QR code validation only if the payment method is not PERSONAL PAYMENT
        if ($request->input('payment_method') !== 'PERSONAL PAYMENT') {
            $rules['qr_code'] = 'required|file|mimes:png,jpg,jpeg|max:2048';
        }
    
        $request->validate($rules);
    
        $qrCodePath = null;
        // Handle QR code upload only if it's present
        if ($request->input('payment_method') !== 'PERSONAL PAYMENT') {
            $qrCodePath = $this->handleImageUpload($request->file('qr_code'), 'qr_codes');
        }
    
        // Create the payment record
        $payment = Payment::create([
            'user_id' => Auth::id(),
            'full_name' => $request->input('full_name'),
            'phone_number' => $request->input('phone_number'),
            'amount' => $request->input('amount'),
            'qr_code' => $qrCodePath,
            'payment_method' => $request->input('payment_method'),
            'reason' => $request->input('reason'), // Capture the reason for personal payment
            'due_date' => json_encode($request->input('due_date')),
        ]);
        
        $userId = auth()->user()->id; // Assuming you are getting the user id from auth
        $userManagementController = new UserManagementController();
        $userManagementController->processDueDatePayment($userId);
        $userManagementController->processPastDueDatePayment($userId);
    
        // Your existing logic for processing payment and generating PDF goes here
        $pdf = PDF::loadView('receipts.payment', compact('payment'));
        $pdfPath = 'receipts/receipt_' . $payment->id . '.pdf';
        $pdf->save(public_path($pdfPath)); // Save the PDF to the public directory
    
        // Update the payment record with the PDF path
        $payment->update(['receipt_path' => $pdfPath]);
        
        return redirect()->back()->with([
            'success' => 'Payment processed successfully!',
        ]);
    }
    

    // Show function to view a specific payment record
    public function show($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payment.show', compact('payment'));
    }

    // Update function to modify an existing payment record
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:11',
            'amount' => 'required|numeric',
            'qr_code' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
            'payment_method' => 'nullable|string|max:255', // Validate payment method
            'due_date' => 'required|array', // Validate due_date as an array
            'due_date.*' => 'string|date_format:Y-m-d', // Optional: Validate each due date format if needed
            'reasons' => 'nullable|string|max:255',
        ]);

        // Update QR code if a new file is uploaded
        if ($request->hasFile('qr_code')) {
            // Optionally delete the old QR code file if necessary
            if ($payment->qr_code) {
                Storage::disk('public')->delete($payment->qr_code);
            }
            $qrCodePath = $this->handleImageUpload($request->file('qr_code'), 'qr_codes');
            $payment->qr_code = $qrCodePath;
        }

        // Update other fields
        $payment->full_name = $request->input('full_name');
        $payment->phone_number = $request->input('phone_number');
        $payment->amount = $request->input('amount');
        $payment->payment_method = $request->input('payment_method'); // Update payment method
        $payment->due_date = json_encode($request->input('due_date'));
        $payment->reasons = $request->input('reasons');
        $payment->save();

        return redirect()->back()->with('success', 'Payment info updated successfully!');
    }

    // Delete function to remove a specific payment record
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
    
        // Optionally delete the QR code file if it exists
        if ($payment->qr_code) {
            Storage::disk('public')->delete($payment->qr_code);
        }
    
        // Check if the user has the required role
        if (!in_array(Auth::user()->role, ['admin', 'seller'])) {
            abort(403); // Unauthorized
        }
    
        // Set the payment's status to 0 instead of deleting it
        $payment->status = 0; 
        $payment->save(); // Save changes without deleting
    
        return redirect()->back()->with('success', 'Payment info deleted successfully!');
    }
    
    public function restore($id)
    {
        // Check if the user has the required role
        if (!in_array(Auth::user()->role, ['admin', 'seller'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }
        
        $payment = Payment::findOrFail($id);
        
        // Check if the Payment is marked as deleted (status is 0)
        if ($payment->status === 0) {
            // Restore the payment by setting the status back to 1
            $payment->status = 1;
            $payment->save();
        
            return response()->json(['success' => true, 'message' => 'Payment restored successfully!']);
        }
    
        return response()->json(['success' => false, 'message' => 'Payment is not deleted or already restored.']);
    }

    // Handle image upload and return the path
    private function handleImageUpload($file, $folder)
    {
        return $file->store($folder, 'public');
    }
}