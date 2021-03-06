<?php

namespace ConfrariaWeb\Task\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TaskUserScope implements Scope
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
        if (!app()->runningInConsole()) {
            if (!auth()->user()->isAdmin()) {
                $builder
                    ->where(function (Builder $query) {
                        return $query->where('tasks.user_id', auth()->id())
                            ->orWhereHas('responsibles', function ($query) {
                                $query->where('task_responsible.user_id', auth()->id());
                            });
                    });


            }

        }
    }
}
