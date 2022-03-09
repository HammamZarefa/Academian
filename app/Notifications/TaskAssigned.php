<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\User;
use App\Order;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public $assigned_by;    
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $assigned_by, Order $order)
    {
        $this->assigned_by      = $assigned_by;      
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
        return ['database','mail'];
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
                    ->subject('You have a new task')
                    ->greeting('Hi, '.$notifiable->first_name )
                    ->line('You have been assigned a new task by ' . $this->assigned_by->full_name)
                    ->action('View Task', route('orders_show', $this->order->id))
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
            'message'   => 'You have a new task',
            'url'       => route('orders_show', $this->order->id),
        ];
    }
}
