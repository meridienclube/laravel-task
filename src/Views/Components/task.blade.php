@php
    $data = isset($data)? $data : NULL;
    $data = isset($data->pivot)? $data->pivot : $data;
    $col = option($data, 'col', 'col-md-3');
    $task_id = option($data, 'task_id');
    $task = isset($task)? $task : $data;
    $background = option($data, 'background', '');
    $task = isset($data['task'])? $data['task'] : $task;
    $task = isset($task)? $task : resolve('TaskService')->find($task_id);

@endphp
<div class="{{ $col }}">
    <div class="kt-portlet kt-portlet--height-fluid">
        <div class="kt-portlet__head kt-portlet__head--noborder">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    @isset($title)
                        {{ $title }}
                    @else($task->type->name)
                        Tarefa
                    @endisset
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <a href="#" class="btn btn-clean btn-icon" data-toggle="dropdown">
                    <i class="flaticon-more-1"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="kt-nav">
                        <li class="kt-nav__item">
                            <a href="{{ route('tasks.show', $task->id) }}" class="kt-nav__link">
                                <i class="kt-nav__link-icon flaticon-visible"></i>
                                <span class="kt-nav__link-text">{{ trans('meridien.tasks.show') }}</span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="kt-nav__link">
                                <i class="kt-nav__link-icon flaticon2-edit"></i>
                                <span class="kt-nav__link-text">{{ trans('meridien.tasks.edit') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="kt-portlet__body kt-portlet__body--fit-y">
            <div class="kt-widget kt-widget--user-profile-4">
                <div class="kt-widget__head">
                    <div class="kt-widget__media">
                        <div class="kt-widget__pic kt-widget__pic--{{ option($task->type, 'class_color', 'primary') }} kt-font-{{ option($task->type, 'class_color', 'primary') }} kt-font-boldest">
                            @if(isset($task->type->options['icon']))
                                <i class="{{ $task->type->options['icon'] }} kt-font-{{ $task->type->options['class_color'] }}" style="font-size:40px"></i>
                            @else
                                {{ Str::substr($task->type->name, 0, 1) }}
                            @endif
                        </div>
                    </div>
                    <div class="kt-widget__content">
                        <div class="kt-widget__section">
                            <a href="#" class="kt-widget__username">
                                {{ $task->type->name }}
                            </a>
                            <div class="kt-widget__button">
                                <span class="btn btn-label-warning btn-sm">{{ $task->datetime->format('d/m/Y') }}</span>
                            </div>
                            <div class="kt-widget__action">
                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-label-brand btn-bold btn-sm btn-upper">
                                    {{ trans('meridien.tasks.show') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
