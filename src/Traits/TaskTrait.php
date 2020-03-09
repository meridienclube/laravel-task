<?php

namespace ConfrariaWeb\Task\Traits;

use Carbon\Carbon;

trait TaskTrait
{

    /*
     * Metodo utilizado em conjunto ao pacote "confrariaweb/laravel-task"
     */
    public function tasks()
    {
        return $this->hasMany('ConfrariaWeb\Task\Models\Task');
    }

    /*
     * Metodo utilizado em conjunto ao pacote "confrariaweb/laravel-task"
     */
    public function responsibleTasks()
    {
        return $this->belongsToMany('ConfrariaWeb\Task\Models\Task', 'task_responsible');
    }

    /*
     * Metodo utilizado em conjunto ao pacote "confrariaweb/laravel-task"
     */
    public function destinatedTasks()
    {
        return $this->belongsToMany('ConfrariaWeb\Task\Models\Task', 'task_destinated');
    }

}
