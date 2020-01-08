<?php

namespace MeridienClube\Meridien\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TaskDatabaseScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        /*

        if (!app()->runningInConsole()) {
            $builder->addSelect(DB::raw('TaskDatabaseScopeTaskTypes.name AS type_name'))
                ->addSelect(DB::raw('GROUP_CONCAT(DISTINCT TaskDatabaseScopeUsers.name) AS users_destinatedd'))

                ->leftJoin('task_types AS TaskDatabaseScopeTaskTypes', 'tasks.type_id', '=', 'TaskDatabaseScopeTaskTypes.id')

                ->leftJoin('task_destinated AS TaskDatabaseScopeTaskDestinated', 'tasks.id', '=', 'TaskDatabaseScopeTaskDestinated.task_id')
                ->leftJoin('users AS TaskDatabaseScopeUsers', 'TaskDatabaseScopeTaskDestinated.user_id', '=', 'TaskDatabaseScopeUsers.id');
        }

        */
    }
}
