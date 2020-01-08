<div class="kt-portlet" id="kt_portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
					<span class="kt-portlet__head-icon">
						<i class="flaticon-map-location"></i>
					</span>
            <h3 class="kt-portlet__head-title">
                {{ $title ?? trans('meridien.calendar') }}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">
        <div id="kt_calendar"></div>
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
                <div id="calendarModalBodyContent">Content Calendar</div>
                <div id="calendarModalBodyEmployees">Employees Calendar</div>
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

@push('scripts')
    <script>
        "use strict";
        var KTCalendarBasic = {
            init: function () {
                var e = moment().startOf("day"),
                    t = e.format("YYYY-MM"),
                    i = e.clone().subtract(1, "day").format("YYYY-MM-DD"),
                    n = e.format("YYYY-MM-DD"),
                    r = e.clone().add(1, "day").format("YYYY-MM-DD"),
                    o = document.getElementById("kt_calendar");
                new FullCalendar.Calendar(o, {
                        locale: 'pt-br',
                        timeZone: 'America/Sao_Paulo',
                        plugins: ["interaction", "dayGrid", "timeGrid", "list"],
                        isRTL: KTUtil.isRTL(),
                        header: {
                            left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,timeGridDay"
                        },
                        height: 800,
                        contentHeight: 780,
                        aspectRatio: 3,
                        nowIndicator: !0,
                        now: n + "T09:25:00",
                        views: {
                            dayGridMonth: {
                                buttonText: "Mês"
                            }
                            , timeGridWeek: {
                                buttonText: "Semana"
                            }
                            , timeGridDay: {
                                buttonText: "Dia"
                            }
                        },
                        businessHours: {
                            daysOfWeek: [1, 2, 3, 4, 5],
                            startTime: '08:00',
                            endTime: '18:00',
                        },
                        buttonText: {
                            next: '>',
                            nextYear: '>>',
                            prev: '<',
                            prevYear: '<<',
                            today: "Hoje",
                            month: 'Mês',
                            week: 'Semana',
                            day: 'Dia',
                            list: 'Lista'
                        },
                        defaultView: "dayGridMonth",
                        defaultDate: n,
                        editable: !0,
                        eventLimit: !0,
                        navLinks: !0,

                        events: function (info, successCallback, failureCallback) {
                            $.ajax({
                                dataType: "json",
                                type: "GET",
                                url: "{{ url('api/tasks/calendar?api_token=' . auth()->user()->api_token) }}",
                                success: function (obj) {
                                    successCallback(obj.data);
                                }
                            });
                        },

                        eventDrop: function (info) {
                            if (confirm("Você tem certeza sobre essa mudança? ")) {
                                $.post("{{ route('tasks.update.date') }}",
                                    {
                                        task_id: info.event.extendedProps.task_id,
                                        date: info.event.start.toUTCString()
                                    },
                                    function (data, status) {
                                        if ('success' !== status) {
                                            info.revert();
                                        }
                                    }
                                );
                            } else {
                                info.revert();
                            }
                        },

                        eventResize: function (info) {
                            //alert(info.event.title + " end is now " + info.event.end.toISOString());
                            if (!confirm("Você tem certeza sobre essa mudança?")) {
                                info.revert();
                            }
                        },

                        eventClick: function (info) {
                            info.jsEvent.preventDefault();

                            var destinateds = $.map(info.event.extendedProps.destinateds, function (n, i) {
                                return n.name;
                            }).join(', ');

                            var responsibles = $.map(info.event.extendedProps.responsibles, function (n, i) {
                                return n.name;
                            }).join(', ');

                            $('#kt_modal_calendar #calendarModalLabel').html(info.event.title);

                            $('#kt_modal_calendar #calendarModalBodyDate').html('Tarefa criada ' + info.event.extendedProps.created_at + ' e a previsão de entrega é ' + info.event.extendedProps.datetime);
                            $('#kt_modal_calendar #calendarModalBodyContent').html(info.event.extendedProps.description);

                            $('#kt_modal_calendar #calendarModalBodyEmployees').html('Responsavel da tarefa: <b>' + responsibles + '</b>');
                            $('#kt_modal_calendar #calendarModalBodyDestinateds').html('Destinatário da tarefa: <b>' + destinateds + '</b>');

                            $('#kt_modal_calendar #calendarModalButtonView').attr('href', '/tasks/' + info.event.extendedProps.task_id);
                            $('#kt_modal_calendar #calendarModalButtonEdit').attr('href', '/tasks/' + info.event.extendedProps.task_id + '/edit');
                            $('#kt_modal_calendar #calendarModalButtonClose').attr('href', '/tasks/' + info.event.extendedProps.task_id + '/close');

                            $('#kt_modal_calendar').modal();
                        }
                        /*
                        ,
                        eventRender: function (e) {
                            var t = $(e.el);
                            e.event.extendedProps && e.event.extendedProps.description && (t.hasClass("fc-day-grid-event") ? (t.data("content", e.event.extendedProps.description), t.data("placement", "top"), KTApp.initPopover(t)) : t.hasClass("fc-time-grid-event") ? t.find(".fc-title").append('<div class="fc-description">' + e.event.extendedProps.description + "</div>") : 0 !== t.find(".fc-list-item-title").lenght && t.find(".fc-list-item-title").append('<div class="fc-description">' + e.event.extendedProps.description + "</div>"))
                        }
                        */
                    }
                ).render()
            }
        };
        jQuery(document).ready(function () {
            KTCalendarBasic.init()
        });
    </script>
@endpush
