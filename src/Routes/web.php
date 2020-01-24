<?php

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth'])
    ->namespace('ConfrariaWeb\Task\Controllers')
    ->group(function () {

        Route::name('tasks.')
            ->prefix('tasks')
            ->group(function () {

                Route::get('calendar', 'TaskController@calendar')->name('calendar');
                Route::get('index/{page}', 'TaskController@index')->name('index.page')->where('page', '[A-Za-z]+');
                Route::post('comment/{task_id}', 'TaskController@storeComment')->name('store.comment');
                Route::put('reschedule/{id}', 'TaskController@reschedule')->name('reschedule');
                Route::put('update/{id}/status/{status_id}', 'TaskController@updateStatus')->name('update.status');
                Route::post('update/date', 'TaskController@updateDate')->name('update.date');
                Route::get('update/date', 'TaskController@updateDate')->name('update.date');
                Route::get('types/trashed', 'TaskTypeController@trashed')->name('types.trashed');
                Route::match(['get', 'post'], '{id}/close', 'TaskController@close')->name('close');
                Route::resource('types', 'TaskTypeController');

                Route::name('steps.')
                    ->prefix('steps')
                    ->group(function () {
                        Route::get('trashed', 'TaskStepController@trashed')->name('trashed');
                    });
                Route::resource('steps', 'TaskStepController');

                Route::name('statuses.')
                    ->prefix('statuses')
                    ->group(function () {
                        Route::get('trashed', 'TaskStatusController@trashed')->name('trashed');
                    });
                Route::resource('statuses', 'TaskStatusController');

            });

        Route::resource('tasks', 'TaskController');
    });
