<?php

namespace ConfrariaWeb\Task\Events;

use MeridienClube\Meridien\Historics\TaskCreatedHistoricContract;
use MeridienClube\Meridien\Notifications\TaskCreatedNotification;
use MeridienClube\Meridien\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskCreatedEvent
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
        $this->historic = new TaskCreatedHistoricContract($task);
        $this->when = 'created';
        $this->users = $task->employees;
        $this->notification = new TaskCreatedNotification($task);

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
