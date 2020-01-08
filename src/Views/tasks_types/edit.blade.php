@extends('meridien::layouts.metronic')
@section('title', trans('meridien.types'))
@section('content')

    @include('meridien::partials.kt_subheader', [
      'breadcrumb' => [
        route('tasks.types.index') => trans('meridien.tasks.types.list'),
        '#' => trans('meridien.tasks.types.edit')
      ],
      'buttons' => [
        route('tasks.types.create') => [
          'label' => trans('meridien.tasks.types.create'),
          'icon' => 'fa fa-plus'
        ],
        route('tasks.types.trashed') => [
          'label' => trans('meridien.tasks.types.trashed'),
          'class' => 'btn-warning',
          'icon' => 'fa fa-trash-alt'
        ],
        route('tasks.types.index') => [
          'label' => trans('meridien.return'),
          'icon' => 'fa fa-return'
        ]
      ]
    ])

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-6">
                {!! Form::model($type, ['route' => ['tasks.types.update', $type->id], 'method' => 'put', 'class' => 'horizontal-form']) !!}
                    @include('tasks_types.partials.form')
                {!! Form::close() !!}
            </div>
            <div class="col-6">
                @historics(['historics' => $type->historics])
                    @slot('title')
                        {{ trans('meridien.tasks.types.stage.history', ['name' => $type->name]) }}
                    @endslot

                    Históricos Do Tipo de tarefa
                @endhistorics
            </div>
        </div>
    </div>

@endsection

@include('tasks_types.partials.kt_aside')
