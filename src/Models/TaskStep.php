<?php

namespace ConfrariaWeb\Task\Models;

use Illuminate\Database\Eloquent\Model;
use ConfrariaWeb\Historic\Traits\HistoricTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStep extends Model
{

    use HistoricTrait;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function tasks()
    {
        return $this->belongsToMany('ConfrariaWeb\Task\Models\Task', 'task_step');
    }

}
