<table class="table table-striped" id="">
    <thead class="thead">
    <tr>
        <th scope="col"></th>
        <th scope="col">{{ trans('meridien.Tipo') }}</th>
        <th scope="col">{{ trans('meridien.tasks.user.destinated') }}</th>
        <th scope="col">{{ trans('meridien.Data') }}</th>
        <th scope="col">{{ trans('meridien.De') }}</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <th scope="row">
                <div class="">
                    {!! task($task, 'icon', Str::substr($task->type->name, 0, 1)) !!}
                </div>
            </th>
            <td>
                {!! task($task, 'name', 'Tarefa') !!}
            </td>
            <td>
                {{ $task->associates->implode('name', ' - ') }}
            </td>
            <td>{{ $task->datetime->format('d/m/Y') }}</td>
            <td>{{ $task->user->name }}</td>
            <td>
                <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                    @permission('tasks.show')
                    <a href="{{ route('admin.tasks.show', $task->id) }}"
                       class="btn btn-clean btn-icon btn-label-primary btn-icon-md " title="View">
                        <i class="la la-eye"></i>
                    </a>
                    @endpermission
                    @permission('tasks.edit')
                    <button
                        route="javascript:void(0);"
                        type="button"
                        class="reschedule btn btn-icon btn-icon-md"
                        data-toggle="modal"
                        data-target="#modalReschedule">
                        <i class="la la-calendar"></i>
                    </button>
                    <a href="{{ route('admin.tasks.edit', $task->id) }}"
                       class="btn btn-clean btn-icon btn-label-success btn-icon-md " title="Edit">
                        <i class="la la-edit"></i>
                    </a>
                    @endpermission
                    @permission('tasks.destroy')
                    <a href="javascript:void(0);"
                       onclick="event.preventDefault();
                           if(!confirm('Tem certeza que deseja deletar este item?')){ return false; }
                           document.getElementById('delete-task-{{ $task->id }}').submit();"
                       class="btn btn-clean btn-icon btn-label-danger btn-icon-md "
                       title="Deletar">
                        <i class="la la-remove"></i>
                    </a>
                    <form
                        action="{{ route('admin.tasks.destroy', $task->id) }}"
                        method="POST" id="delete-task-{{ $task->id }}">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                    </form>
                    @endpermission
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $tasks->links() }}
