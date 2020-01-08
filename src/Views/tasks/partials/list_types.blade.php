<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @isset($title)
                    {{ $title }}
                @else
                    {{ trans('meridien.Listagem de Tarefas') }}
                @endisset
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="kt-section">
            <div class="kt-section__content">
                <table class="table table-striped" id="">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">{{ trans('meridien.Tipo') }}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $type)
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $type->name }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm float-right" role="group" aria-label="...">
                                @permission('tasks.show')
                                <a href="{{ route('tasks.types.show', $type->id) }}"
                                   class="btn btn-clean btn-icon btn-label-primary btn-icon-md " title="View">
                                    <i class="la la-eye"></i>
                                </a>
                                @endpermission
                                @permission('tasks.edit')
                                <a href="{{ route('tasks.types.edit', $type->id) }}"
                                   class="btn btn-clean btn-icon btn-label-success btn-icon-md " title="Edit">
                                    <i class="la la-edit"></i>
                                </a>
                                @endpermission
                                @permission('tasks.destroy')
                                <a href="javascript:void(0);"
                                   onclick="event.preventDefault();
                                       if(!confirm('Tem certeza que deseja deletar este item?')){ return false; }
                                       document.getElementById('delete-task-type-{{ $type->id }}').submit();"
                                   class="btn btn-clean btn-icon btn-label-danger btn-icon-md "
                                   title="Deletar">
                                    <i class="la la-remove"></i>
                                </a>
                                <form
                                    action="{{ route('tasks.types.destroy', $type->id) }}"
                                    method="POST" id="delete-task-type-{{ $type->id }}">
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
                {{ $types->links() }}
            </div>
        </div>
    </div>
</div>

