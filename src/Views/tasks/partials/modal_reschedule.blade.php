@modal(['id' => 'modalReschedule'])
{!! Form::open(['url' => "#", 'method' => 'put', 'class' => 'formModalReschedule horizontal-form', 'id' => "formModalReschedule"]) !!}
    <div class="row">
        <div class="form-group col-md-6">
            <label class="control-label">{{ trans('meridien.tasks.date') }}<span class=""> </span></label>
            {!! Form::text('datetime[date]', null, ['autocomplete' => "off", 'readonly', 'class' => 'kt_datepicker form-control', 'placeholder' => 'Digite a data e hora para esta tarefa']) !!}
        </div>
        <div class="form-group col-md-6">
            <label class="control-label">{{ trans('meridien.tasks.hour') }}<span class=""> </span></label>
            {!! Form::text('datetime[time]', null, ['autocomplete' => "off", 'class' => 'kt_timepicker form-control', 'placeholder' => 'Digite a data e hora para esta tarefa']) !!}
        </div>
    </div>
{!! Form::close() !!}
@endmodal
