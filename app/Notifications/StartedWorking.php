<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Order;

class StartedWorking extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order            = $order;
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
        $data = $this->getMessage();

        return (new MailMessage)
                    ->subject($this->order->number. ' - In Progress ') 
                    ->line($data['message'])
                    ->action('View Order', $data['url'])
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
        return [
            'message' => $this->order->assignee->full_name. ' has started working on ' . $this->order->number,
            'url' => route('orders_show', $this->order->id)

        ];
    }

    private function getMessage()
    {
        return [
            'message' => $this->order->assignee->full_name. ' has started working on ' . $this->order->number,
            'url' => route('orders_show', $this->order->id)

        ];
    }
}
