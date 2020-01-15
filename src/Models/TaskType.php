<?php

namespace ConfrariaWeb\Task\Models;

use Illuminate\Database\Eloquent\Model;
use ConfrariaWeb\Historic\Traits\HistoricTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskType extends Model
{

    use HistoricTrait;
    use SoftDeletes;

    protected $table = 'task_types';

    protected $fillable = [
        'name',
        'color',
        'icon',
        'closed_status_id',
        'order'
    ];

    public function tasks()
    {
        return $this->hasMany('ConfrariaWeb\Task\Models\Task', 'task_id');
    }

    /**
     * Indica o status de fechado para esta tarefa.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function closedStatus()
    {
        return $this->belongsTo('ConfrariaWeb\Task\Models\TaskStatus', 'closed_status_id');
    }

}
