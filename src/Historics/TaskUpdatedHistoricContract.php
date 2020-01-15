<?php

namespace ConfrariaWeb\Task\Historics;

use ConfrariaWeb\Task\Models\Task;
use ConfrariaWeb\Historic\Contracts\HistoricContract;

class TaskUpdatedHistoricContract implements HistoricContract
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function data()
    {
        return [
            'action' => 'updated',
            'content' => 'Tarefa ' . $this->task->type->name . ' atualizada com sucesso'
        ];
    }

    public function title()
    {
        return 'Tarefa atualizada';
    }

    public function user($collunn = null)
    {
        if($collunn == 'id'){
            return auth()->id();
        }
        return auth()->user();
    }
}
