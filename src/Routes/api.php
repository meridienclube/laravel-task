<?php

Route::middleware(['auth:api'])
    ->namespace('ConfrariaWeb\Task\Controllers')
    ->name('api.tasks.')
    ->prefix('api/tasks')
    ->group(function () {

        Route::name('status.')
            ->prefix('status')
            ->group(function () {
                Route::get('select2', 'TaskStatusController@select2')->name('select2');
                Route::get('calendar', 'TaskStatusController@calendar')->name('calendar');
                Route::get('datatable', 'TaskStatusController@datatable')->name('datatable');
            });

        Route::name('types.')
            ->prefix('types')
            ->group(function () {
                Route::get('select2', 'TaskTypeController@select2')->name('select2');
                Route::get('calendar', 'TaskTypeController@calendar')->name('calendar');
                Route::get('datatable', 'TaskTypeController@datatable')->name('datatable');
            });

        Route::get('calendar', 'TaskController@calendar')->name('calendar');
        Route::get('datatable', 'TaskController@datatable')->name('datatable');

    });

