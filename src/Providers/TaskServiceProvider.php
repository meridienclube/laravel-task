<?php

namespace ConfrariaWeb\Task\Providers;

use ConfrariaWeb\Task\Contracts\TaskContract;
use ConfrariaWeb\Task\Contracts\TaskStatusContract;
use ConfrariaWeb\Task\Contracts\TaskTypeContract;
use ConfrariaWeb\Task\Repositories\TaskRepository;
use ConfrariaWeb\Task\Repositories\TaskStatusRepository;
use ConfrariaWeb\Task\Repositories\TaskTypeRepository;
use ConfrariaWeb\Task\Services\TaskService;
use ConfrariaWeb\Task\Services\TaskStatusService;
use ConfrariaWeb\Task\Services\TaskTypeService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class TaskServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Databases/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Translations', 'task');
        $this->loadViewsFrom(__DIR__ . '/../Views', 'task');
        $this->publishes([__DIR__ . '/../../config/cw_task.php' => config_path('cw_task.php')], 'cw_task');

        Blade::component('task::components.task_calendar', 'taskCalendar');
        Blade::component('task::components.task_list', 'taskList');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(TaskContract::class, TaskRepository::class);
        $this->app->bind('TaskService', function ($app) {
            return new TaskService($app->make(TaskContract::class));
        });

        $this->app->bind(TaskTypeContract::class, TaskTypeRepository::class);
        $this->app->bind('TaskTypeService', function ($app) {
            return new TaskTypeService($app->make(TaskTypeContract::class));
        });

        $this->app->bind(TaskStatusContract::class, TaskStatusRepository::class);
        $this->app->bind('TaskStatusService', function ($app) {
            return new TaskStatusService($app->make(TaskStatusContract::class));
        });

    }

}
