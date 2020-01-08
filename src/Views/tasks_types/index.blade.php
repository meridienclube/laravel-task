@extends('meridien::layouts.metronic')
@section('title', trans('meridien.types'))
@section('content')
    @include('meridien::partials.kt_subheader', [
      'breadcrumb' => [
        '#' => trans('meridien.types.list')
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
            <div class="col-md-9">
                @include('tasks_types.partials.list')
            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
@endsection

@include('tasks_types.partials.kt_aside')
