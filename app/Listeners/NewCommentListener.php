<?php

namespace App\Listeners;

use App\Events\NewCommentEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewComment;

class NewCommentListener
{
    /**
     * Handle the event.
     *
     * @param NewCommentEvent $event
     * @return void
     */
    public function handle(NewCommentEvent $event)
    {
        $comment = $event->comment;
        $order = $comment->order;
        $commenter = $comment->user;

        // Log user's activity
        $subject = anchor($order->number, route('orders_show', $order->id));
        logActivity($order, 'posted comment ' . $subject);

        $followers = NULL;

        if ($commenter->id == $order->customer->id) {
            /*
             * If the comment is a customer,
             * and if an assignee exists include him in the email list,
             */
            $followers = $order->followers;
            if (!is_null($order->assignee)) {
                // If assignee exists              
                $followers = $order->followers->push($order->assignee);
            }
        } elseif ($commenter->id == $order->staff_id) {
            /*
             * If the commenter is a task assignee,
             * include the customer in the email list,
             */
            $followers = $order->followers->push($order->customer);
        } else {
            /*
             * Otherwise it means the message is posted by
             * admin who is not assigned to the task. Therefore
             * include both the client and task assignee in the email
             * list
             */
            $followers = $order->followers()->where('user_id', '<>', $comment->user_id)->get();

            $order->followers()->sync($comment->user_id);
            $followers = $followers->push($order->customer);

            if (!is_null($order->assignee)) {
                // If assignee exists
                $followers = $followers->push($order->assignee);
            }
        }
        if ($followers) {
            Notification::send($followers, new NewComment($comment));
        }

        Notification::route('mail', company_notification_email())
            ->notify(new NewComment($comment));
    }
}
