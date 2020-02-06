<table class="table table-bordered table-task-per-day">
    <tr>
        <th scope="col">Hora</th>
        <th scope="col">Tarefas</th>
    </tr>
    @foreach(range(1, 24) as $dayRange)
        <tr>
            <td>{{ $dayRange }}h</td>
            <td>
                @foreach($tasks as $task)
                    @if($task->start->format('H') == $dayRange)
                        <a data-task="{{ $task->format() }}"
                           href='javascript:void(0)'
                           style="background:{{ $task->type->color }};"
                           class='task-per-day task_link text-white'>{{ $task->type->name }}</a>
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
