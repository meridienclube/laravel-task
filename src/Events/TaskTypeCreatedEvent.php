<?php

namespace ConfrariaWeb\Task\Events;

use MeridienClube\Meridien\Historics\TaskTypeCreatedHistoricContract;
use MeridienClube\Meridien\TaskType;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TaskTypeCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $obj;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TaskType $task_type)
    {
        $this->obj = $task_type;
        $this->historic = new TaskTypeCreatedHistoricContract($task_type);
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
