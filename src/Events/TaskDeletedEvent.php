<?php

namespace ConfrariaWeb\Task\Events;

use MeridienClube\Meridien\Historics\TaskDeletedHistoricContract;
use MeridienClube\Meridien\Notifications\TaskDeletedNotification;
use MeridienClube\Meridien\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskDeletedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $obj;
    public $users;
    public $notification;
    public $when;
    public $historic;

    /**
     * Create a new event instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->obj = $task;
        $this->historic = new TaskDeletedHistoricContract($task);
        $this->when = 'deleted';
        $this->users = $task->employees;
        $this->notification = new TaskDeletedNotification($task);
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
