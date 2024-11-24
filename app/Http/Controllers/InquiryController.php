<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Db;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApprovedStatusUpdated;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    // Display a listing of inquiries
    public function index(Request $request)
    {
        // Get the search query
        $search = $request->input('search');

        // Get the number of entries per page
        $entriesPerPage = $request->input('entries_per_page', 10); // Default to 10

        // Retrieve inquiries with search functionality and pagination
        $inquiries = Inquiry::when($search, function($query) use ($search) {
                return $query->where('full_name', 'like', '%' . $search . '%')
                            ->orWhere('contact_number', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->paginate($entriesPerPage); // Pagination

        return view('inquiries.index', compact('inquiries', 'search', 'entriesPerPage'));
    }

    // Show the form for creating a new inquiry
    public function create()
    {
        return view('inquiries.create'); // Return the create view
    }

    public function approved(Request $request, $id) {
        return $this->updateApprovedStatus($id, 'Approved', $request);
    }

    private function updateApprovedStatus($id, $status, Request $request) {
        $inquiry = Inquiry::find($id);
        $inquiry->inquiry_status = $status;
        $inquiry->save();

        // Send email to the buyer
        Mail::to($inquiry->email)->send(new ApprovedStatusUpdated($inquiry));

        return redirect()->back()->with('success', 'Approved status updated to ' . $status . ' and email sent!');
    }

    // Store a newly created inquiry in storage
    public function store(Request $request)
    {
        // Log incoming request data
        \Log::info('Incoming request data:', $request->all());
    
        // Validate the incoming request
        $request->validate([
            'price' => 'required|string',
            'room_number' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string',
            'email' => 'required|email',
            'valid_id' => 'file|mimes:jpg,jpeg,png,pdf|max:2048', // Adjust as needed
            'agreement' => 'required|accepted',
        ]);

        $agreementValue = $request->has('agreement') ? 1 : 0;
    
        // Handle file upload for valid ID
        $path = '';
        if ($request->hasFile('valid_id')) {
            $path = $request->file('valid_id')->store('valid_ids', 'public');
            \Log::info('File stored at: ' . $path);
        } else {
            \Log::warning('No file uploaded for valid_id');
        }
    
        // Create a new inquiry
        Inquiry::create([
            'price' => $request->price,
            'room_number' => $request->room_number,
            'full_name' => $request->full_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'valid_id' => $path,
            'agreement' => $agreementValue,
            'inquiry_status' => 'pending',
        ]);
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Inquiry submitted successfully.');
    }
    

    // Display the specified inquiry
    public function show($id)
    {
        $inquiry = Inquiry::findOrFail($id); // Find the inquiry by ID or fail
        return view('inquiries.show', compact('inquiries')); // Pass inquiry to the view
    }

    // Show the form for editing the specified inquiry
    public function edit($id)
    {
        $inquiry = Inquiry::findOrFail($id); // Find the inquiry by ID or fail
        return view('booking.forms', compact('inquiries')); // Pass inquiry to the edit view
    }

    // Update the specified inquiry in storage
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'price' => 'required|numeric',
            'room_number' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'valid_id' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Optional valid ID
            'agreement' => 'required|boolean',
        ]);

        // Find the inquiry by ID
        $inquiry = Inquiry::findOrFail($id);

        // Handle file upload for valid ID (if provided)
        $path = $inquiry->valid_id; // Keep the old path by default
        if ($request->hasFile('valid_id')) {
            // Delete the old file if it exists
            if ($path) {
                \Storage::disk('public')->delete($path);
            }
            // Store the new file
            $path = $request->file('valid_id')->store('valid_ids', 'public');
        }

        // Update the inquiry
        $inquiry->update([
            'price' => $request->price,
            'room_number' => $request->room_number,
            'full_name' => $request->full_name,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'valid_id' => $path,
            'agreement' => $request->agreement,
        ]);

        // Redirect back with a success message
        return redirect()->route('inquiries.index')->with('success', 'Inquiry updated successfully.');
    }

    // Remove the specified inquiry from storage
    public function destroy($id)
    {
        // Find the inquiry by ID or fail
        $inquiry = Inquiry::findOrFail($id);
    
        // Check if the user is authorized
        if (!in_array(Auth::user()->role, ['admin', 'seller'])) {
            abort(403); // Return a 403 error if user is unauthorized
        }
    
        // Set the inquiry's status to 0 instead of deleting it
        $inquiry->status = 0; // Mark as deleted
    
        // Delete the file if it exists
        if ($inquiry->valid_id) {
            \Storage::disk('public')->delete($inquiry->valid_id);
        }
    
        $inquiry->save(); // Save the inquiry with updated status
    
        // Redirect back with a success message
        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }    

    public function restore($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'users'])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }
        
        $inquiry = Inquiry::findOrFail($id);
        
        // Check if the inquiry is already marked as deleted
        if ($inquiry->status === 0) {
            // Restore the inquiry by setting the status back to 1
            $inquiry->status = 1;
            $inquiry->save();

            // Return success response without session message
            return response()->json(['success' => true]);
        }

        // Return error response if the inquiry is not deleted
        return response()->json(['success' => false, 'message' => 'Inquiry is not deleted or already restored.']);
    }
}
