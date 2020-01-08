@extends('meridien::layouts.metronic')
@section('title', 'Tarefas')
@section('content')

    @include('meridien::partials.kt_subheader', ['breadcrumb' => $breadcrumb, 'buttons' => $buttons])

    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
        <div class="row">
            <div class="col">
                @include('tasks.show.user')
            </div>
        </div>
        <div class="row">
            <div class="col">
                @include('tasks.show.info')
            </div>
        </div>
        <div class="row">
            <div class="col">
                @comments(['id' => $task_format['id'], 'route' => 'tasks.store.comment', 'comments' =>
                    $task_format['comments']])
                    @slot('title')
                        Comentários da tarefa
                    @endslot
                    Comentários da tarefa
                @endcomments
            </div>
            <div class="col">
                @historics(['historics' => $task_format['historics']])
                    @slot('title')
                        Históricos da tarefa
                    @endslot
                    Históricos da tarefa
                @endhistorics
            </div>
        </div>
@endsection

@include('tasks.partials.kt_aside')
