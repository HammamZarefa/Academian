<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\SubmittedWork;

class WorkSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public $submittedWork;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SubmittedWork $submittedWork)
    {
        $this->submittedWork    = $submittedWork;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if(isset($notifiable->id))
        {
            return ['mail','database'];
        }
        else
        {
            return ['mail'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $order  = $this->submittedWork->order;
        $name   = $this->submittedWork->user->full_name;

        return (new MailMessage)      
                    ->subject($order->number. ' - Ready for download')              
                    ->line('Works for '. $order->number .' has been uploaded. Please login to the application and download the file')
                    ->action('View Order',  route('orders_show', $order->id))
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $order  = $this->submittedWork->order;
        
        return [
            'message'   => $order->number. ' - is ready for download',
            'url'       => route('orders_show', $order->id),
        ];
    }
}
