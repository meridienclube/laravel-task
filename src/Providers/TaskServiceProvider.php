<?php

namespace ConfrariaWeb\Task\Providers;

use ConfrariaWeb\Task\Contracts\TaskContract;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
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

        $this->app->bind(TaskContract::class, Task::class);
        $this->app->bind('TaskService', function ($app) {
            return new TaskService($app->make(TaskContract::class));
        });

        $this->app->bind(TaskTypeContract::class, TaskTypeEloquent::class);
        $this->app->bind('TaskTypeService', function ($app) {
            return new TaskTypeService($app->make(TaskTypeContract::class));
        });

    }

}
