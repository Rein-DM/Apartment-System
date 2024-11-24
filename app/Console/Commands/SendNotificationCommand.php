<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User; // Import the User model
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;

class SendNotificationCommand extends Command
{
    protected $signature = 'send:notification';
    protected $description = 'Send a notification email to all users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch all users
        $users = User::all(); // Fetch all users without any conditions

        foreach ($users as $user) {
            $details = [
                'title' => 'Friendly Reminder: Rent Payment Due Soon',
                'body' => 'Hello ' . $user->name . ', just a quick reminder that your rent payment is due in the next few days. Please make arrangements to complete the payment by the due date. Thank you for your attention to this matter!',
            ];

            // Send the email to each user use crontjob
            Mail::to($user->email)->send(new NotificationEmail($details));
        }

        $this->info('Notification emails sent to all users!');
    }
}
