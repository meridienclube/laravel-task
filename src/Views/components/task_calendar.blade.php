<div class="task-calendar container-fluid">
    <div class="row mb-4">
        <div class="col-6">
            <div class="btn-group float-left" role="group" aria-label="">
                <a href="?ym={{ $prev }}" class="btn btn-primary btn-sm">&lt;</a>
                <button class="btn btn-secondary btn-sm">{{ $title?? 'Calendar' }}</button>
                <a href="?ym={{ $next }}" class="btn btn-primary btn-sm">&gt;</a>
            </div>
        </div>
        <div class="col-6">
            <div class="btn-group float-right" role="group" aria-label="">
                <a href="{{ route('admin.tasks.calendar') }}" class="btn btn-secondary btn-sm">{{ __('Mês') }}</a>
                <!--button type="button" class="btn btn-secondary btn-sm">{{ __('Semana') }}</button-->
                <!--button type="button" class="btn btn-secondary btn-sm">{{ __('Dia) }}</button-->
                <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary btn-sm">{{ __('Lista') }}</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tr>
                    <th scope="col">D</th>
                    <th scope="col">S</th>
                    <th scope="col">T</th>
                    <th scope="col">Q</th>
                    <th scope="col">Q</th>
                    <th scope="col">S</th>
                    <th scope="col">S</th>
                </tr>
                @foreach ($weeks as $week)
                    {!! $week !!}
                @endforeach
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="kt_modal_calendar" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calendarModalLabel">Modal calendar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div id="calendarModalBodyDate">Date Calendar</div>
                <!--div id="calendarModalBodyContent">Content Calendar</div-->
                <!--div id="calendarModalBodyEmployees">Employees Calendar</div-->
                <div id="calendarModalBodyDestinateds">Destinateds Calendar</div>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-info" id="calendarModalButtonView">Ver</a>
                <a href="" class="btn btn-primary" id="calendarModalButtonEdit">Editar</a>
                <a href="" class="btn btn-outline-danger" id="calendarModalButtonClose">Concluída</a>
                <!--button type="button" class="btn btn-primary">Save changes</button-->
            </div>
        </div>
    </div>
</div>

@push('styles')
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"-->
    <!--link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet"-->
    <style>

        .task-calendar table {
            width: 100%;
            table-layout: fixed;
        }

        .task-calendar table td, th {
            /*border: 1px solid black;*/
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-calendar h3 {
            margin-bottom: 30px;
        }

        .task-calendar th {
            height: 30px;
            text-align: center;
        }

        .task-calendar td {
            height: 120px;
        }

        .task-calendar .today {
            /*background: orange;*/
        }
/*
        .task-calendar th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }

        .task-calendar th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
*/
        .task-calendar span.span_day {
            /*background: #463f3f;*/
            padding: 2px;
            font-size: 12px;
            margin: 0;
            height: 22px;
            width: 22px;
            text-align: center;
            display: block;
            /*color: #fff;*/
            float: right;
            border-radius: 10px;
        }

        .task-calendar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 50%;
            float: left;
        }

        .task-calendar ul li {

        }

        .task-calendar ul li a {
            font-size: 10px;
            display: block;
            color: #fff;
            padding: 2px 4px;
            font-weight: 800;
            border-radius: 6px;
            margin-bottom: 2px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $('a.task_link').on('click', function () {
            let task = JSON.parse($(this).attr('data-task'));
            //console.log(task)
            $('#kt_modal_calendar #calendarModalLabel').html(task.title);
            $('#kt_modal_calendar #calendarModalBodyDate').html('Tarefa criada ' + task.start + ' e a previsão de entrega é ' + task.end);
            //$('#kt_modal_calendar #calendarModalBodyContent').html(task.name);
            $('#kt_modal_calendar #calendarModalBodyDestinateds').html('<b>Destinatários da tarefa</b>: <br>');
            $.each(task.destinateds, function( index, value ) {
                //console.log(value)
                let contacts = '(' + $.map(value.contacts, function(e){
                    return e.content;
                }).join(' ') + ')';
                $( "#kt_modal_calendar #calendarModalBodyDestinateds" ).append( value.name + contacts + '<br>' );
            });
            //$('#kt_modal_calendar #calendarModalBodyEmployees').html('Responsavel da tarefa: <b>' + responsibles + '</b>');
            //$('#kt_modal_calendar #calendarModalBodyDestinateds').html('Destinatário da tarefa: <b>' + destinateds + '</b>');
            $('#kt_modal_calendar #calendarModalButtonView').attr('href', '/admin/tasks/' + task.id);
            $('#kt_modal_calendar #calendarModalButtonEdit').attr('href', '/admin/tasks/' + task.id + '/edit');
            $('#kt_modal_calendar #calendarModalButtonClose').attr('href', '/admin/tasks/' + task.id + '/close');
            $('#kt_modal_calendar').modal();
        });
    </script>
@endpush
