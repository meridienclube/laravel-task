<?php

namespace ConfrariaWeb\Task\Providers;

use ConfrariaWeb\Historic\Listeners\HistoricListener;
use ConfrariaWeb\Task\Events\TaskCreatedEvent;
use ConfrariaWeb\Task\Events\TaskUpdatedEvent;
use ConfrariaWeb\Task\Events\TaskDeletedEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class TaskEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TaskCreatedEvent::class => [
            HistoricListener::class,
        ],
        TaskUpdatedEvent::class => [
            HistoricListener::class,
        ],
        TaskDeletedEvent::class => [
            HistoricListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
