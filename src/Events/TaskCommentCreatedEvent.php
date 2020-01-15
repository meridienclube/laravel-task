<?php

namespace ConfrariaWeb\Task\Events;

use ConfrariaWeb\Task\Historics\TaskCommentCreatedHistoric;
use ConfrariaWeb\Task\Notifications\TaskCreatedNotification;
use ConfrariaWeb\Task\Notifications\TaskUpdatedNotification;
use ConfrariaWeb\Task\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskCommentCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $obj;
    public $when;

    /**
     * Create a new event instance.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->obj = $task;
        $this->historic = new TaskCommentCreatedHistoric($task);
        $this->when = 'created';
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
