@if(!$task_format['closed'])
    @permission('tasks.edit')
        @can('update', $task)
            @include('tasks.partials.modal_comment_finalize', ['data' => ['task' => $task, 'url' => route('admin.tasks.reschedule', $task_format['id']), 'btn' => ['label' => __($task_format['closedStatusName'])], 'title' => __($task_format['closedStatusName']), 'id' => 'formModalCommentFinalize', 'data' => ['toggle' => 'modal', 'target' => '#formModalCommentFinalize']]])
            @btnEdit(["href" => route('admin.tasks.edit', $task_format['id'])])
            {{ trans('meridien.edit') }}
            @endbtnEdit
            @include('tasks.partials.modal_reschedule', ['data' => ['url' => route('admin.tasks.reschedule', $task_format['id']), 'btn' => ['label' => 'Reagendar'], 'title' => 'Reagendar Tarefa', 'id' => 'modalReschedule', 'data' => ['toggle' => 'modal', 'target' => '#modalReschedule']]])
        @endcan
    @endpermission
    @permission('tasks.destroy')
        @can('delete', $task)
            @btnDelete(["onclick" => "event.preventDefault(); if(!confirm('Tem certeza quedeseja deletar este item?')){ return false; }document.getElementById('deleteTask').submit();"])
                {{ trans('meridien.tasks.destroy') }}
            @endbtnDelete
        @endcan
    @endpermission
    @permission('tasks.destroy')
        @can('delete', $task)
            {!! Form::open(['route' => ['tasks.destroy', $task_format['id']], 'method' => 'DELETE', 'class' => 'horizontal-form', 'id' => 'deleteTask']) !!}
                {!! Form::hidden('status_id', $task_format['closedStatus']) !!}
            {!! Form::close() !!}
        @endcan
    @endpermission
@endif
