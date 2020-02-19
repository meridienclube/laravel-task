<?php

namespace ConfrariaWeb\Task\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TaskStatusClosedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $view_closed = request()->view_closed ?? false;
        if (
            !app()->runningInConsole() &&
            (
                (
                    \Route::currentRouteName() != 'admin.tasks.show' &&
                    \Route::currentRouteName() != 'admin.tasks.edit'
                ) &&
                !$view_closed
            )
        ) {
            $ids = DB::table('task_statuses')
                ->distinct()
                ->where(['closure' => 1])
                ->get()
                ->pluck('id');

            $builder->whereNotIn('tasks.status_id', $ids);

            //$view_completed = request('columns.3.search.value', 0);
            //$view_completed = false;
            //$builder->when($view_completed, function ($query) use($ids) {
            //return $query->whereNotIn('tasks.status_id', $ids);
            //}, function ($query) use($ids) {
            //return $query->whereNotIn('tasks.status_id', $ids);
            //});
        }
    }
}
