<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                {{ __($title ?? 'tasks.types.list') }}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div class="kt-section">
            <div class="kt-section__content">

                <table class="table table-striped table-hover" id="types_datatable">
                    <thead>
                    <tr>
                        <th width="">{{ trans('meridien.tasks.types.name') }}</th>
                        <th width="">{{ trans('meridien.tasks.types.color') }}</th>
                        <th width="">{{ trans('meridien.tasks.types.icon') }}</th>
                        <th width="">{{ trans('meridien.tasks.types.order') }}</th>
                        <th width="">{{ trans('meridien.tasks.types.close.status') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($types as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            <td><span style="color: {{ $type->color }}">{{ $type->color }}</span></td>
                            <td><i style="color: {{ $type->color }}" class="{{ $type->icon }}"></i></td>
                            <td>{{ $type->order }}</td>
                            <td>{{ $type->closedStatus->name }}</td>
                            <td>
                                @if (Route::current()->getName() != 'tasks.types.trashed')
                                    @datatableActions(['obj' => $type, 'slug' => 'tasks.types'])
                                    Botões de tipos de tarefas
                                    @enddatatableActions
                                @else
                                    Deletado em @datetime($type->deleted_at)
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#types_datatable').DataTable();
        });
    </script>
@endpush
