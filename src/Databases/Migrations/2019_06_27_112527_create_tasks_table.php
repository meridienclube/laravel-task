<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{

    public function up()
    {

        Schema::create('task_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('task_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->integer('order')->default(1);
            $table->integer('closure')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('task_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('closed_status_id');
            $table->string('name');
            $table->string('color')->default('#ffffff');
            $table->string('icon')->default('flaticon-event-calendar-symbol');
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('closed_status_id')
                ->references('id')
                ->on('task_statuses');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('user_id');
            //$table->timestamp('datetime')->useCurrent();
            $table->timestamp('start')->useCurrent();
            $table->timestamp('end')->useCurrent();
            //$table->text('options')->nullable();
            $table->smallInteger('priority')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')
                ->references('id')
                ->on('task_statuses')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('task_types')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::create('option_task', function (Blueprint $table) {
            $table->unsignedBigInteger('option_id');
            $table->unsignedBigInteger('task_id');

            $table->foreign('option_id')
                ->references('id')
                ->on('options')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['option_id', 'task_id']);
        });

        Schema::create('task_user', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['task_id', 'user_id']);
        });

        Schema::create('task_destinated', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['task_id', 'user_id']);
        });

        Schema::create('task_responsible', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['task_id', 'user_id']);
        });

        Schema::create('task_step', function (Blueprint $table) {
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('step_id');

            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('step_id')
                ->references('id')
                ->on('task_steps')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['task_id', 'step_id']);
        });

    }

    public function down()
    {
        Schema::dropIfExists('task_step');
        Schema::dropIfExists('task_responsible');
        Schema::dropIfExists('task_destinated');
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('option_task');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_types');
        Schema::dropIfExists('task_statuses');
        Schema::dropIfExists('task_steps');
    }
}
