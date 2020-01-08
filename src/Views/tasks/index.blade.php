@extends('meridien::layouts.metronic')
@section('title', 'Tarefas')
@section('content')

    @include('meridien::partials.kt_subheader', ['breadcrumb' => $breadcrumb, 'buttons' => $buttons])

    <div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-md-3">
                @include('tasks.partials.filter')
            </div>

            <div class="col-9">
                @datatable($datatable)
                @slot('title')
                    {{ $title ?? trans('meridien.tasks.list') }}
                @endslot

                @slot('createdRow')
                    $(row).find('td:eq(-1) a.reschedule').attr('onclick', 'rescheduleTask(' + data.id + ')');
                @endslot

                @slot('buttons')
                    @permission('tasks.edit')
                    <a href="javascript:void(0);"
                       onclick="return false"
                       class="dropdown-item reschedule"
                       data-toggle="modal"
                       data-target="#modalReschedule">
                        <i class="la la-calendar"></i>{{ trans('meridien.tasks.reschedule') }}
                    </a>
                    @endpermission
                @endslot

                @slot('columns')
                    {"data": "title", "name": "title"},
                    {"data": "date", "name": "date"},
                    {"data": "time", "name": "time"},
                    {"data": "status", "name": "status"},
                    {"data": "priority", "name": "priority"},
                    {"data": "destinateds", "render": "[, ].name", "name": "destinateds"},
                    {"data": "responsibles", "render": "[, ].name", "name": "responsibles"},
                @endslot

                @slot('script')

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

                @endslot
                @enddatatable
            </div>
        </div>
    </div>

    @includeIf('tasks.partials.modal_reschedule')

@endsection

@include('tasks.partials.kt_aside')

@push('scripts')
    <script>
        function rescheduleTask(userID) {
            console.log(userID);
            $('#formModalReschedule').attr('action', "/tasks/reschedule/" + userID);
        }
    </script>
@endpush
