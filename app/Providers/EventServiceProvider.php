<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'App\Events\NewOrderEvent' => [
            'App\Listeners\NewOrderListener',
        ],
        'App\Events\TaskSelfAssignedEvent' => [
            'App\Listeners\TaskSelfAssignedListener',
        ],
        'App\Events\TaskAssignedEvent' => [
            'App\Listeners\TaskAssignedListener',
        ],
        'App\Events\NewCommentEvent' => [
            'App\Listeners\NewCommentListener',
        ],
        'App\Events\WorkSubmittedEvent' => [
            'App\Listeners\WorkSubmittedListener',
        ],
        'App\Events\BillReceivedEvent' => [
            'App\Listeners\BillReceivedListener',
        ],
        'App\Events\BillPaidEvent' => [
            'App\Listeners\BillPaidListener',
        ],
        'App\Events\StartedWorkingEvent' => [
            'App\Listeners\StartedWorkingListener',
        ],
        'App\Events\DeliveryAcceptedEvent' => [
            'App\Listeners\DeliveryAcceptedListener',
        ],
        'App\Events\RequestedForRevisionEvent' => [
            'App\Listeners\RequestedForRevisionListener',
        ],
        'App\Events\OrderStatusChangedEvent' => [
            'App\Listeners\OrderStatusChangedListener',
        ],
        'Illuminate\Notifications\Events\NotificationSent' => [
            'App\Listeners\NotificationSentListener',
        ],
        'App\Events\PaymentApprovedEvent' => [
            'App\Listeners\PaymentApprovedListener',
        ],
        'App\Events\PaymentDisapprovedEvent' => [
            'App\Listeners\PaymentDisapprovedListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
