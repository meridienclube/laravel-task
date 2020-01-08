<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">
                {{ trans('meridien.tasks.types.form') }}
            </h3>
        </div>
    </div>

    <div class="kt-portlet__body">
        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.types.name') }}<span class="required"> * </span></label>
            {!! Form::text('name', isset($type)? $type->name : null, ['class' => 'form-control', 'placeholder' => 'Digite o nome', 'required']) !!}
        </div>
        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.types.color') }}<span class="required"> * </span></label>
            {!! Form::color('color', isset($type)? $type->color : null, ['class' => 'form-control', 'placeholder' => 'Digite a cor', 'required']) !!}
        </div>
        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.types.icon') }}<span class="required"> * </span></label>
            {!! Form::text('icon', isset($type)? $type->icon : null, ['class' => 'form-control', 'placeholder' => 'Digite o icone', 'required']) !!}
        </div>
        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.types.order') }}<span class="required"> * </span></label>
            {!! Form::selectRange('order', 1, 10, isset($type)? $type->order : null, ['class' => 'form-control', 'required']) !!}
        </div>
        <div class="form-group">
            <label class="control-label">{{ trans('meridien.tasks.types.close.status') }}<span class="required"> * </span></label>
            {!! Form::select('closed_status_id', $statuses, isset($type)? $type->closed_status_id : null, ['class' => 'form-control', 'required']) !!}
        </div>
    </div>
    @include('meridien::partials.portlet_footer_form_actions', ['cancel' => route('tasks.types.index')])
</div>
