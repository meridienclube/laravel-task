<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                Listagem de Tarefas
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <h5 class="kt-font-brand kt-font-bold">{{ $tasks->total() }} Tarefas</h5>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section">
            <div class="kt-section__content">
                <table class="table table-striped" id="">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"></th>  
                            <th scope="col">Tipo</th>  
                            <th scope="col">Associado</th>         
                            <!--th scope="col">Responsavel</th-->
                            <th scope="col">Data</th>
                            <th scope="col">De</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr> 
                            <th scope="row">
                                <div class="">
                                    @if(isset($task->type->options['icon']))
                                        <i class="{{ $task->type->options['icon'] }} kt-font-{{ $task->type->options['class_color'] }}" style="font-size:20px"></i>
                                    @else
                                        {{ Str::substr($task->type->name, 0, 1) }}
                                    @endif
                                </div>
                            </th>
                            <td>
                                {{ $task->type->name }}
                            </td>   
                            <td>
                                {{ $task->associates->implode('name', ' - ') }}
                            </td>              
                            <!--td>{{ $task->employees->implode('name', ' - ') }}</td-->
                            <td>{{ $task->datetime->format('d/m/Y') }}</td>
                            <td>{{ $task->user->name }}</td>
                            <td>
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                                    @permission('tasks.show')
                                    <a href="{{ route('tasks.show', $task->id) }}" 
                                        class="btn btn-clean btn-icon btn-label-primary btn-icon-md " title="View">
                                        <i class="la la-eye"></i>
                                    </a>
                                    @endpermission
                                    @permission('tasks.edit')
                                    <a href="{{ route('tasks.edit', $task->id) }}" 
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
                                        action="{{ route('tasks.destroy', $task->id) }}" 
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
            </div>
        </div>
    </div>
</div>