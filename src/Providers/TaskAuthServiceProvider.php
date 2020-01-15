<?php

namespace ConfrariaWeb\Task\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use ConfrariaWeb\Task\Models\Task;
use ConfrariaWeb\Task\Policies\TaskPolicy;

class TaskAuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Task::class => TaskPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
