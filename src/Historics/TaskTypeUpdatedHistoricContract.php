<?php

namespace MeridienClube\Meridien\Historics;

use MeridienClube\Meridien\TaskType;
use ConfrariaWeb\Historic\Contracts\HistoricContract;

class TaskTypeUpdatedHistoricContract implements HistoricContract
{
    protected $type;

    public function __construct(TaskType $type)
    {
        $this->type = $type;
    }

    public function data()
    {
        return [
            'action' => 'updated',
            'content' => 'Tipo de Tarefa ' . $this->type->name . ' atualizada com sucesso'
        ];
    }

    public function title()
    {
        return 'Tipo de Tarefa atualizada';
    }

    public function user($collunn = null)
    {
        if($collunn == 'id'){
            return auth()->id();
        }
        return auth()->user();
    }
}
