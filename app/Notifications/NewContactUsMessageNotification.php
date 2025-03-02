<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\NewContactUsMessageMailable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class NewContactUsMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $data=[];

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->afterCommit();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        if($this->data['admin']->is_still_online == 0)
        {
            return ['mail'];
        }else{
            return ['broadcast'];
        }
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new NewContactUsMessageMailable($this->data))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        //$notification = $notifiable->notifications()->latest()->first();
        return new BroadcastMessage ( [
            'targetId'    =>$this->data['url'],
            'name'  => $this->data['title'],
            'message'   => $this->data['body'],
            //'updated_at'  => $notification->updated_at,
        ]);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.'.$this->data['admin']->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'adminNotification';
    }
}
