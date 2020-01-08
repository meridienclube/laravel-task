<?php


namespace MeridienClube\Meridien\Historics;

use MeridienClube\Meridien\Task;
use ConfrariaWeb\Historic\Contracts\HistoricContract;

class TaskCreatedHistoricContract implements HistoricContract
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
