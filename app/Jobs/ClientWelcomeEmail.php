<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\NotificationEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
class ClientWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;

    public function __construct(User $user)
    {
       $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = $this->user->name .' '. $this->user->last_name .' has created new account';
        $mail_data = [
            'subject' => 'New user has created account',
            'body' => $message,
            'button_link' => route('voyager.users.edit', $this->user->id),
            'button_text' => 'View User',
            'emails' => [],
        ];
        Mail::to(setting('site.email'))->send(new NotificationEmail($mail_data));

        $message = 'Welcome! <br>
        Thank you for signing up with us.<br>
        Your new account has been setup and you can now login.';
        $mail_data = [
            'subject' => 'Thank you for creating account',
            'body' => $message,
            'button_link' => route('login'),
            'button_text' => 'Login',
            'emails' => [],
        ];
        Mail::to($this->user->email)->send(new NotificationEmail($mail_data));
    }
}
