<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                @isset($title)
                    {{ $title }}
                @else
                    {{ trans('meridien.tasks.list') }}
                @endisset
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="kt-section">
            <div class="kt-section__content">
                <table class="table table-striped" id="datatable_tasks">
                    <thead>
                    <tr>
                        <th scope="col">{{ trans('meridien.tasks.type') }}</th>
                        <th scope="col">{{ trans('meridien.tasks.date') }}</th>
                        <th scope="col">{{ trans('meridien.tasks.hour') }}</th>
                        <th scope="col">{{ trans('meridien.status') }}</th>
                        <th scope="col">{{ trans('meridien.tasks.priority') }}</th>
                        <th scope="col">{{ trans('meridien.tasks.user.destinated') }}</th>
                        <th scope="col">{{ trans('meridien.tasks.user.responsible') }}</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>

                </table>

            </div>
        </div>
        @if(isset($slot))
            {{ $slot }}
        @endif
    </div>
</div>

<div style="display: none" id="btnsTask">
    @include('task::tasks.partials.buttons_datatable')
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            var table = $('#datatable_tasks').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/tasks/datatable?api_token=' . auth()->user()->api_token) }}",
                "columns": [
                    {"data": "title", "name": "title"},
                    {"data": "date", "name": "date"},
                    {"data": "time", "name": "time"},
                    {"data": "status", "name": "status"},
                    {"data": "priority", "name": "priority"},
                    {"data": "destinateds", "render": "[, ].name", "name": "destinateds"},
                    {"data": "responsibles", "render": "[, ].name", "name": "responsibles"},
                    { defaultContent: $('#btnsTask').html() }
                ],
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    },
                    "select": {
                        "rows": {
                            "_": "Selecionado %d linhas",
                            "0": "Nenhuma linha selecionada",
                            "1": "Selecionado 1 linha"
                        }
                    }
                }
            });

            $('#column0_search').on( 'change', function () {
                table.columns(0).search($(this).val()).draw();
            });

            $('.data_search').on( 'keyup', function () {
                var dataa = $('#data_from_search').val() + ',' + $('#data_to_search').val();
                table.columns(1).search(dataa).draw();
            });

            $('#view_completed_search').on( 'click', function () {
                if( $(this).is(':checked') ) {
                    table.columns(3).search('view_completed').draw();
                }else{
                    table.columns(3).search(0).draw();
                }

            });

            $('#column1_search').on( 'change', function () {
                table.columns(6).search($(this).val()).draw();
            });

            $('#datatable_tasks tbody').on('click', '.show', function () {
                var row = $(this).closest('tr');
                var userID = table.row(row).data()["id"];
                window.location.href = "/tasks/" + userID;
            });

            $('#datatable_tasks tbody').on('click', '.edit', function () {
                var row = $(this).closest('tr');
                var userID = table.row(row).data()["id"];
                window.location.href = "/tasks/" + userID + '/edit';
            });

            $('#datatable_tasks tbody').on('click', '.destroy', function (event) {
                event.preventDefault();
                var row = $(this).closest('tr');
                var userID = table.row(row).data()["id"];
                var formDestroy = $('#delete-task-id');
                if(confirm('Tem certeza que deseja deletar este item?')) {
                    formDestroy.attr('action', "/tasks/" + userID);
                    formDestroy.submit();
                }
            });

        });
    </script>
@endpush
