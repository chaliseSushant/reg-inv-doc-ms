<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentNotification extends Notification
{
    use Queueable;

    private $assign_remarks;
    private $document_id;
    private $remarks;

    public function __construct($assign_remarks, $document_id, $remarks)
    {
        $this->assign_remarks = $assign_remarks;
        $this->document_id = $document_id;
        $this->remarks = $remarks;
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
            'document_id' => $this->document_id,
            'assign_remarks' => $this->assign_remarks,
            'remarks' => $this->remarks,
        ];
    }
}
