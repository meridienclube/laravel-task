<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
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
                ->on('statuses');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('datetime')->useCurrent();
            //$table->text('options')->nullable();
            $table->smallInteger('priority')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('status_id')
                ->references('id')
                ->on('statuses')
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

        /**
         * Esta tabela relaciona o usuario a tarefa.
         */
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

        /**
         * Relaciona o usuario associado a tarefa,
         * quando  essa for para atender a um associado
         */
        Schema::create('task_associated', function (Blueprint $table) {
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

        /**
         * Relaciona o usuario responsavel da tarefa a tarefa
         */
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

        Schema::create('task_employee', function (Blueprint $table) {
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

        /**
         * Relaciona a tarefa a sua etapa
         */
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
                ->on('steps')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['task_id', 'step_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_step');
        Schema::dropIfExists('task_responsible');
        Schema::dropIfExists('task_employee');
        Schema::dropIfExists('task_destinated');
        Schema::dropIfExists('task_associated');
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('option_task');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_types');
    }
}
