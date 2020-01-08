@extends('meridien::layouts.metronic')
@section('title', 'Tarefas')
@section('content')

    @include('meridien::partials.kt_subheader', ['breadcrumb' => $breadcrumb, 'buttons' => $buttons])

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col-4">
                {!! Form::open(['route' => 'tasks.store', 'class' => 'horizontal-form']) !!}
                @include('tasks.partials.form')
                {!! Form::close() !!}
            </div>
            <div class="col-8">
                <div class="kt-portlet">
                    <div class="kt-portlet__body">
                        {!! Form::open(['route' => 'tasks.create', 'method' => 'GET', 'class' => 'horizontal-form']) !!}
                        <div class="form-group">
                            <label class="control-label">{{ trans('meridien.tasks.user.responsible') }}</label>
                            @select2([
                                'url' => 'users',
                                'id' => 'taskemployees',
                                'name' => 'taskemployees',
                                'options' => request()->get('taskemployees', auth()->user()->pluck('name', 'id')),
                                'selected' => request()->get('taskemployees', auth()->user()->id)
                            ])
                            @slot('title')
                                Responsáveis
                            @endslot
                            @endselect2
                        </div>
                        {!! Form::close() !!}
                        @taskCalendar(['tasks' => $tasks])
                        You are not allowed to access this resource!
                        @endtaskCalendar
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@include('tasks.partials.kt_aside')

@push('scripts')
    <script>
        $(document).ready(function () {
            $("#taskemployees").on("change", function () {
                this.form.submit();
            });
        });
    </script>
@endpush
