<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderStatusUpdated;
use App\Rules\MatchOldPassword;
use Auth;
use DB;
use Carbon\Carbon;
use Session;
use Hash;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default to 10 entries per page if not specified
        $search = $request->input('search'); // Get the search input
    
        // Query to filter users based on search input
        $query = User::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('role', 'LIKE', "%{$search}%");
            });
        }
    
        $users = $query->paginate($perPage); // Use pagination instead of fetching all users
    
        // Check due dates and update is_past_due status accurately
        foreach ($users as $user) {
            if ($user->due_date) {
                if (Carbon::parse($user->due_date)->isToday()) {
                    $user->is_past_due = false; // Due date is today, not past due
                } elseif (Carbon::parse($user->due_date)->isPast()) {
                    $user->is_past_due = true;  // Due date has passed, mark as past due
                } else {
                    $user->is_past_due = false; // Due date is in the future
                }
                $user->save();
            }
        }
    
        // Count the number of users with past due dates
        $pastDueCount = User::where('is_past_due', true)->count();
    
        return view('usermanagement.index', compact('users', 'pastDueCount', 'search')); // Include search in compact
    }

    public function reminder(Request $request, $id) {
        return $this->updateReminderStatus($id, 'Reminder', $request);
    }

    private function updateReminderStatus($id, $status, Request $request) {
        $user = User::find($id);
        $user->reminder_status = $status;
        $user->save();

        // Send email to the buyer
        Mail::to($user->email)->send(new ReminderStatusUpdated($user));

        return redirect()->back()->with('success', 'Reminder status updated to ' . $status . ' and email sent!');
    }
    
    public function create()
    {
        return view('usermanagement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required','regex:/^[A-z a-z]+$/','string','max:255'],
            'role'       => 'required|string|max:255',
            'email' => ['required','regex:/^[A-z a-z 0-9 @_.]+$/','string','max:255','email','unique:users'],
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            
        ]);
        User::create($request->all());
 
        return redirect()->route('usermanagement')->with('success', 'UserManagement Users added successfully');
    }

    public function setDueDate(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'nullable|date',
        ]);

        $user = User::findOrFail($id);
        $user->due_date = $request->due_date;
        $user->reminder_status = 'Peninding';
        $user->save();

        return redirect()->route('usermanagement')->with('success', 'Due date set successfully');
    }
    
    public function pastDue()
    {
        // Get users with due dates that have passed
        $pastDueUsers = User::whereNotNull('due_date')
                            ->where('due_date', '<', Carbon::now())
                            ->get();

        return view('usermanagement.index', compact('pastDueUsers'));
    }
    public function updatePastDueStatus()
    {
        $users = User::all();

        // Check due dates and update is_past_due status accurately
        foreach ($users as $user) {
            if ($user->due_date) {
                $dueDate = Carbon::parse($user->due_date);

                if ($dueDate->isToday()) {
                    $user->is_past_due = false; // Due date is today, not past due
                } elseif ($dueDate->isPast()) {
                    $user->is_past_due = true;  // Due date has passed, mark as past due
                } else {
                    $user->is_past_due = false; // Due date is in the future
                }
                $user->save();
            }
        }
    }
    public function processDueDatePayment($userId)
    {
        $user = User::findOrFail($userId);

        // Check if the user has a due date that is today or in the future
        if ($user->due_date && (Carbon::parse($user->due_date)->isToday() || Carbon::parse($user->due_date)->isFuture())) {
            // Increment payment count
            $user->payment_count += 1;
            $user->due_date = Carbon::parse($user->due_date)->addMonth()->day(28)->toDateString(); 
            $user->is_past_due = false; // Reset past due status
            $user->save();

            // Log the successful payment processing
            \Log::info("Payment processed for User ID: {$user->id}. Payment count: {$user->payment_count}");
        } else {
            \Log::info("User {$user->id} does not have a current due date.");
        }
    }


    public function processPastDueDatePayment($userId)
    {
        $user = User::findOrFail($userId);
        
        \Log::info("User {$user->id} past due_date: {$user->due_date}");
        
        // Check if the user has a due date that is past
        if ($user->due_date && Carbon::parse($user->due_date)->isPast()) {
            \Log::info("User {$user->id} payment for past due date is being processed.");
            
            // Increment payment count
            $user->payment_count += 1;
            $user->due_date = Carbon::parse($user->due_date)->addDays(28)->toDateString();
            $user->is_past_due = false; // Reset past due status
            $user->save();
        } else {
            \Log::info("User {$user->id} does not have a past due date.");
        }
    }

    public function show(string $id)
    {
        $users = User::findOrFail($id);
  
        return view('usermanagement.show', compact('users'));
    }
    public function edit(string $id)
    {
        // Fetch a single user instance
        $user = User::findOrFail($id);
    
        // Pass the single user instance to the view
        return view('components.modal.usermanagement.edit', compact('user'));
    }
    
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name'  => ['required','regex:/^[A-z a-z]+$/','string','max:255'],
            'role'  => ['required','string','max:255'],
            'email' => ['required','regex:/^[A-z a-z 0-9 @_.]+$/','string','max:255','email'],
        ]);
    
        // Fetch the user instance to update
        $user = User::findOrFail($id);
    
        // Update the user with the validated data
        $user->update($validatedData);
    
        // Return a JSON response
        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public function activity()
    {
        $activityLog = DB::table('activity_logs')->get();
        return view ('activity_log', compact('activityLog'));
    }
    public function changePasswordView()
    {
        return view('usermanagement.change_password');
    }
    
    public function changePasswordDB(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        // Find the user by ID
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'Unable to locate the user'], 404);
        }
    
        // Soft delete the user by setting status to 0
        $user->status = 0;
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'User successfully deleted',
            'id' => $id,
        ]);
    }    

    public function restore($id)
    {
        if (!in_array(Auth::user()->role, ['admin', 'user'])) {
            abort(404); // Return a 404 error if user is unauthorized
        }
        $user = User::findOrFail($id);
        
        // Check if the user is already marked as deleted
        if ($user->status === 0) {
            // Restore the user by setting the status back to 1
            $user->status = 1;
            $user->save();
        }

        return response()->json(['success' => true]);
    }
}
