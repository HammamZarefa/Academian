<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Comment;

class NewComment extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if(isset($notifiable->id) && $notifiable->hasAnyRole(['staff','admin']))
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
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $order = $this->comment->order;
        $name = $this->comment->user->full_name;

        return (new MailMessage())->subject($order->number . ' - New comment by ' . $name)
            ->line($name . ' has posted the following comment')
            ->line("\n")
            ->line($this->comment->body)
            ->action('View Message', route('orders_show', [
            $order->id,
            'group' => 'messages'
        ]))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $order  = $this->comment->order;
        $name   = $this->comment->user->full_name;

        return [
            'message' => $name. ' comment on '. $order->number ,
            'url' => route('orders_show', [$order->id, 'group' => 'messages'])

        ];
    }
}
