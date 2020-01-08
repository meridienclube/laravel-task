<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use MeridienClube\Meridien\TaskType;
use MeridienClube\Meridien\User;
use MeridienClube\Meridien\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! TaskType::first()) {
            $task_types = [
                ['name' => 'Visita', 'color' => '#0066ff', 'icon' => 'flaticon-presentation', 'closed_status_id' => 6],
                ['name' => 'Reunião', 'color' => '#0066ff', 'icon' => 'flaticon-presentation-1', 'closed_status_id' => 6],
                ['name' => 'Proposta', 'color' => '#0066ff', 'icon' => 'flaticon-attachment', 'closed_status_id' => 6],
                ['name' => 'Ligação', 'color' => '#0066ff', 'icon' => 'flaticon-support', 'closed_status_id' => 6],
                ['name' => 'Email', 'color' => '#0066ff', 'icon' => 'socicon-mail', 'closed_status_id' => 6],
                ['name' => 'Indicação', 'color' => '#0066ff', 'icon' => 'flaticon-businesswoman', 'closed_status_id' => 6]
            ];

            foreach ($task_types as $obj) {
                TaskType::create($obj);
                $this->command->info('Tipo de tarefa ' . $obj['name'] . ' criada.');
            }
        }
/*
        $this->command->info('Tarefas fakes sendo criadas...');
        $onlyEmployees = User::onlyEmployees()->get();
        $onlyAssociates = User::onlyAssociates()->get();
        factory(Task::class, 10)->create()->each(function ($task) use($onlyEmployees, $onlyAssociates) {
            $onlyEmployeesRand = $onlyEmployees->random(rand(1, 2))->pluck('id')->toArray();
            $onlyAssociatesRand = $onlyAssociates->random(rand(1, 2))->pluck('id')->toArray();
            $task->employees()->sync($onlyEmployeesRand);
            $task->associates()->sync($onlyAssociatesRand);
            $task->users()->sync($onlyEmployeesRand);
            $task->users()->sync($onlyAssociatesRand);
        });
        $this->command->info('Pronto, uma pá de tarefas criadas...');
*/
    }
}
