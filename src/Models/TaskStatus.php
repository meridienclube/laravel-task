<?php

namespace ConfrariaWeb\Task\Models;

use Illuminate\Database\Eloquent\Model;
use ConfrariaWeb\Historic\Traits\HistoricTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{

    use HistoricTrait;
    use SoftDeletes;

    protected $table = 'task_statuses';

    protected $fillable = [
        'name', 'slug', 'order', 'closure'
    ];

    public function tasks()
    {
        return $this->hasMany('ConfrariaWeb\Task\Models\Task', 'status_id');
    }

}
