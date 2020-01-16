<?php

namespace ConfrariaWeb\Task\Historics;

use ConfrariaWeb\Task\Models\TaskType;
use ConfrariaWeb\Historic\Contracts\HistoricContract;

class TaskTypeCreatedHistoric implements HistoricContract
{
    protected $type;

    public function __construct(TaskType $type)
    {
        $this->type = $type;
    }

    public function data()
    {
        return [
            'action' => 'created',
            'content' => 'Tipo de Tarefa ' . $this->type->name . ' criada com sucesso'
        ];
    }

    public function title()
    {
        return 'Tipo de Tarefa criada';
    }

    public function user($collunn = null)
    {
        if($collunn == 'id'){
            return auth()->id();
        }
        return auth()->user();
    }
}
