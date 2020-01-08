<?php

namespace MeridienClube\Meridien\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TaskStatusCompletedScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (!app()->runningInConsole()) {
            $ids = DB::table('task_types')
                ->select('closed_status_id')
                ->distinct()
                ->get()->pluck('closed_status_id');
            $view_completed = request('columns.3.search.value', 0);
            $builder->when(('view_completed' === $view_completed), function ($query) use($ids) {
                //return $query->whereNotIn('tasks.status_id', $ids);
            }, function ($query) use($ids) {
                return $query->whereNotIn('tasks.status_id', $ids);
            });
        }
    }
}
