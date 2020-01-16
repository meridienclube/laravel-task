<?php

namespace ConfrariaWeb\Task\Historics;

use ConfrariaWeb\Task\Models\Task;
use ConfrariaWeb\Historic\Contracts\HistoricContract;

class TaskCreatedHistoric implements HistoricContract
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function data()
    {
        return [
            'action' => 'created',
            'content' => 'Tarefa ' . $this->task->type->name . ' criada com sucesso'
        ];
    }

    public function title()
    {
        return 'Tarefa criada';
    }

    public function user($collunn = null)
    {
        if($collunn == 'id'){
            return auth()->id();
        }
        return auth()->user();
    }
}
