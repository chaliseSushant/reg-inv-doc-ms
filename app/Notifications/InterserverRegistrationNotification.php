<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InterserverRegistrationNotification extends Notification
{
    use Queueable;

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
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

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
}
