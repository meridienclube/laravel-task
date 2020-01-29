<table class="table table-bordered table-task-per-week">
    <tr>
        <th scope="col">Data</th>
        <th scope="col" >Tarefas</th>
    </tr>
    @foreach($days_of_the_week as $day_k_week => $day_this_week)
        <tr>
            <td><!-- {{ __($day_k_week) }} - -->{{ date('d/m/Y', strtotime($day_this_week)) }}</td>
            <td >
                @foreach($tasks as $taskweek)
                    @if($taskweek->start->format('d') == date('d', strtotime($day_this_week)))
                        <a data-task="{{ $taskweek->format() }}"
                           href='javascript:void(0)'
                           style="background:{{ $taskweek->type->color }};"
                           class='task-per-week task_link text-white'>{{ $taskweek->type->name }}</a>
                    @endif
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
