<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    private $assign_remarks;
    private $registration_id;
    private $subject;

    public function __construct($assign_remarks, $registration_id, $subject)
    {
        $this->assign_remarks = $assign_remarks;
        $this->registration_id = $registration_id;
        $this->subject = $subject;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
       return ['database'];
        //return ['database', 'broadcast', 'mail'];
    }

    /*public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'registration_id' => $this->registration_id,
            'assign_remarks' => $this->assign_remarks,
            'subject' => $this->subject,
        ];
    }

    /*public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastType()
    {
        return 'Registration-Received';
    }*/

}
