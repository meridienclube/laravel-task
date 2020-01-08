<div class="kt-portlet ">
    <div class="kt-portlet__body">
        <div class="kt-widget kt-widget--user-profile-3">
            <div class="kt-widget__top">
                <div class="kt-widget__media kt-hidden">
                    {!!  $task_format['icon_html'] !!}
                </div>
                <div class="kt-widget__pic kt-widget__pic--danger kt-font-hover-primary kt-font-boldest kt-font-light kt-hidden-"  style="font-size: 60px; background: {{ $task_format['color'] }}">
                    {!!  $task_format['icon_html'] !!}
                </div>
                <div class="kt-widget__content">
                    <div class="kt-widget__head">
                        <a href="#" class="kt-widget__title">
                            {{ $task_format['title'] }} ({{ $task_format['datetime'] }} às {{ $task_format['time'] }})
                        </a>
                    </div>
                    <div class="kt-widget__subhead">
                        <a href="#">
                            <i class="flaticon2-calendar-9"></i>
                            {{ trans('meridien.created') }} {{ $task_format['created_at'] }}
                        </a>
                        <a href="#">
                            <i class="flaticon2-calendar-9"></i>
                            {{ trans('meridien.updated') }} {{ $task_format['updated_at'] }}
                        </a>
                    </div>
                    <div class="kt-widget__info">
                        <div class="kt-widget__desc col-7">
                            {{ $task_format['description'] }}
                        </div>
                        <div class="kt-widget__desc col-5">

                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-widget__bottom">
                <div class="kt-widget__item">
                    <div class="kt-widget__icon">
                        <i class="flaticon-pie-chart"></i>
                    </div>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">{{ trans('meridien.status') }}</span>
                        <span class="kt-widget__value">{{ $task_format['status'] }}</span>
                    </div>
                </div>
                <div class="kt-widget__item">
                    <div class="kt-widget__icon">
                        <i class="flaticon-chat-1"></i>
                    </div>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">{{ trans_choice('tasks.comments', count($task_format['comments']), ['value' => count($task_format['comments'])]) }}</span>
                        <a href="#comments" class="kt-widget__value kt-font-brand">{{ trans('meridien.view') }}</a>
                    </div>
                </div>
                <div class="kt-widget__item">
                    <div class="kt-widget__icon">
                        <i class="flaticon-file-2"></i>
                    </div>
                    <div class="kt-widget__details">
                        <span class="kt-widget__title">{{ trans_choice('tasks.historics', count($task_format['historics']), ['value' => count($task_format['historics'])]) }}</span>
                        <a href="#historics" class="kt-widget__value kt-font-brand">{{ trans('meridien.view') }}</a>
                    </div>
                </div>
                <div class="kt-widget__item">
                    <div class="kt-widget__icon">
                        <i class="flaticon-network"></i>
                    </div>
                    <div class="kt-widget__details">
                        <div class="kt-section__content kt-section__content--solid">
                            <div class="kt-badge kt-badge__pics">
                                @foreach($task_format['destinateds'] as $destinated)
                                    <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="{{ $destinated->name }}" data-original-title="{{ $destinated->name }}">
                                        <img src="{{ $destinated->avatar() }}" alt="image">
                                    </a>
                                @endforeach
                                @foreach($task_format['employees'] as $employee)
                                    <a href="#" class="kt-badge__pic" data-toggle="kt-tooltip" data-skin="brand" data-placement="top" title="{{ $employee->name }}" data-original-title="{{ $employee->name }}">
                                        <img src="{{ $employee->avatar() }}" alt="image">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
