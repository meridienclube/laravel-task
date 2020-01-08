@extends('meridien::layouts.metronic')
@section('title', 'Tarefas')
@section('content')

    @include('meridien::partials.kt_subheader', ['breadcrumb' => $breadcrumb, 'buttons' => $buttons])

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-lg-12">

                @taskCalendar(['tasks' => []])
                @slot('title')
                    {{ trans('meridien.Calendário de tarefas') }}
                @endslot
                    calendario de tarefas
                @endtaskCalendar

            </div>
        </div>
    </div>
@endsection

@include('tasks.partials.kt_aside')
