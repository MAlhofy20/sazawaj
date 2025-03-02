<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationReminderMailable;

class SendActivationReminderEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:activation-reminders';
    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to users who haven’t activated their accounts after 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find users who registered more than 24 hours ago and haven't activated
        $users = User::where('active','=',0)
                     ->where('sendReminder','=',0)
                     ->where('created_at', '<=', Carbon::now()->subHours(24))
                     ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new ActivationReminderMailable($user));
            $user->update([
                'sendReminder'=> 1 ,
            ]);
        }

        $this->info(count($users) . ' reminder emails sent.');
    }
}
