<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function sendNotification()
    {
        // Fetch users who need the reminder (adjust query conditions as needed)
        $users = User::where('rent_due_soon', true)->get(); 

        foreach ($users as $user) {
            $details = [
                'title' => 'Friendly Reminder: Rent Payment Due Soon',
                'body' => 'Hello ' . $user->name . ', just a quick reminder that your rent payment is due in the next few days. Please make arrangements to complete the payment by the due date. Thank you for your attention to this matter!',
            ];

            Mail::to($user->email)->send(new NotificationEmail($details));
        }

        return 'Notification emails sent!';
    }
}
