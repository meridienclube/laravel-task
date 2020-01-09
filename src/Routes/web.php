<?php

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['web', 'auth'])
    ->namespace('ConfrariaWeb\Task\Controllers')
    ->group(function () {

        Route::name('tasks.')->prefix('tasks')->group(function () {

            Route::get('index/{page}', 'TaskController@index')->name('index.page')->where('page', '[A-Za-z]+');
            Route::post('comment/{task_id}', 'TaskController@storeComment')->name('store.comment');
            Route::put('reschedule/{id}', 'TaskController@reschedule')->name('reschedule');
            Route::put('update/{id}/status/{status_id}', 'TaskController@updateStatus')->name('update.status');
            Route::post('update/date', 'TaskController@updateDate')->name('update.date');
            Route::get('update/date', 'TaskController@updateDate')->name('update.date');
            Route::get('types/trashed', 'TaskTypeController@trashed')->name('types.trashed');
            Route::resource('types', 'TaskTypeController');
            Route::post('{id}/close', 'TaskController@close')->name('close');

        });

        Route::resource('tasks', 'TaskController');

    });
