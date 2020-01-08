<div class="kt-portlet form_task">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                {{ trans('meridien.tasks.form') }}
            </h3>
        </div>
    </div>
    <div class="kt-portlet__body">

        <div class="form-group">
            @foreach($types as $type)
                <label>
                    <input type="radio" name="type_id" {{ (isset($task) && $task->type_id == $type->id)? ' checked ' : '' }} value="{{ $type->id }}">
                    <i style="color:{{ $type->color }}; padding: 0 2px;" class="{{ $type->icon }}" data-container="body" data-toggle="kt-popover" data-placement="top" data-content="{{ $type->name }}"></i>
                </label>
            @endforeach
        </div>

        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.user.destinated') }}</label>
            @select2(['url' => 'users', 'name' => 'sync[destinateds][]', 'options' => $selecteds['destinateds'], 'selected' => $selecteds['destinateds'], 'attributes' => ['required' => 'required']])
                @slot('title')
                    Destinatários
                @endslot
            @endselect2
        </div>

        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.user.responsible') }}</label>
            @select2(['url' => 'users', 'name' => 'sync[responsibles][]', 'options' => $selecteds['responsibles'], 'selected' => $selecteds['responsibles'], 'attributes' => ['required' => 'required']])
            @slot('title')
                Responsáveis
            @endslot
            @endselect2
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label">{{ trans('meridien.tasks.date') }}<span class=""> </span></label>
                {!! Form::text('datetime[date]', isset($task)? $task->datetime->format('d/m/Y') : \Carbon\Carbon::now(+1)->format('d/m/Y'), ['readonly', 'class' => 'form-control date kt_datepicker', 'placeholder' => isset($task)? $task->datetime->format('d/m/Y') : \Carbon\Carbon::now(+1)->format('d/m/Y')]) !!}
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">{{ trans('meridien.tasks.hour') }}<span class=""> </span></label>
                {!! Form::text('datetime[time]', isset($task)? $task->datetime->format('H:i') : \Carbon\Carbon::now()->format('H:i'), ['readonly', 'class' => 'form-control kt_timepicker', 'placeholder' => isset($task)? $task->datetime->format('H:m') : \Carbon\Carbon::now(+1)->format('H:m')]) !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label">{{ trans('meridien.tasks.status') }}</label>
                {{ Form::select('status_id',  $statuses->pluck('name','id'), isset($task)? $task->status_id : null, ['class' => 'form-control select2 kt-select2']) }}
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">{{ trans('meridien.tasks.priorityd') }}</label>
                {{ Form::select('priority', [1 => 'Muito baixa',2 => 'Baixa',3 => 'Normal', 4 => 'Alta', 5 => 'Muito alta'], isset($task)? $task->priority : null, ['class' => 'form-control select2 kt-select2']) }}
            </div>
        </div>

        @foreach ($options as $option)
            {!! option_input(isset($task)? $task : null, $option) !!}
        @endforeach
    </div>
    @include('meridien::partials.portlet_footer_form_actions', ['cancel' => route('tasks.index')])
</div>
