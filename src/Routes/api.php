<?php

Route::middleware(['auth:api'])
    ->namespace('ConfrariaWeb\Task\Controllers')
    ->name('api.')
    ->prefix('api')
    ->group(function () {

        Route::get('calendar', 'TaskController@calendar')->name('calendar');
        Route::get('datatable', 'TaskController@datatable')->name('datatable');

    });

