<?php

namespace MeridienClube\Meridien\Events;

use MeridienClube\Meridien\Historics\TaskUpdatedHistoricContract;
use MeridienClube\Meridien\Notifications\TaskUpdatedNotification;
use MeridienClube\Meridien\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class TaskUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $obj;
    public $notification;
    public $when;
    public $users;
    public $historic;

    /**
     * Create a new event instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->obj = $task;
        $this->historic = new TaskUpdatedHistoricContract($task);
        $this->when = 'updated';
        $this->notification = new TaskUpdatedNotification($task);
        $this->users = $task->employees;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
