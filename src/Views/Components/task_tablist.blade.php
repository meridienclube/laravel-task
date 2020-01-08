@php
    $data = isset($data)? $data : NULL;
    $data = isset($data->pivot)? $data->pivot : $data;
    $col = option($data, 'col', 'col-md-12');
    $amount = option($data, 'amount', 10);
    $background = option($data, 'background', '');
    $where =[
        'statuses' => option($data, 'statuses', []),
        'types' => option($data, 'task_types', []),
        'employees' => option($data, 'users', [])
    ];
    $tasks = isset($data['tasks'])? $data['tasks'] : resolve('TaskService')->where($where, $amount);

@endphp
<div class="{{ $col }}">
    <div class="kt-portlet kt-portlet--tabs kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                @isset($title)
                    {{ $title }}
                @else
                    Tarefas
                @endisset
                </h3>
            </div>
            <div class="kt-portlet__head-toolbar">
                <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#kt_widget2_tab1_content" role="tab" aria-selected="true">
                        Hoje
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_widget2_tab2_content" role="tab" aria-selected="false">
                        Semana
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_widget2_tab3_content" role="tab" aria-selected="false">
                        Mês
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#kt_widget2_tab4_content" role="tab" aria-selected="false">
                        Todas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kt-portlet__body">
            <div class="tab-content">
                @if(isset($tasks) && $tasks->count() > 0)
                <div class="tab-pane active" id="kt_widget2_tab1_content">
                    <div class="row">
                        @each('components.task', $tasks->whereBetween('datetime', [Carbon\Carbon::now()->startOfDay(Carbon\Carbon::MONDAY), Carbon\Carbon::now()->endOfDay(Carbon\Carbon::MONDAY)]), 'task', 'components.task_empty')
                    </div>
                </div>
                <div class="tab-pane" id="kt_widget2_tab2_content">
                    <div class="row">
                        @each('components.task', $tasks->whereBetween('datetime', [Carbon\Carbon::now()->startOfWeek(Carbon\Carbon::MONDAY), Carbon\Carbon::now()->endOfWeek(Carbon\Carbon::MONDAY)]), 'task', 'components.task_empty')
                    </div>
                </div>
                <div class="tab-pane" id="kt_widget2_tab3_content">
                    <div class="row">
                        @each('components.task', $tasks->whereBetween('datetime', [Carbon\Carbon::now()->startOfMonth(Carbon\Carbon::MONDAY), Carbon\Carbon::now()->endOfMonth(Carbon\Carbon::MONDAY)]), 'task', 'components.task_empty')
                    </div>
                </div>
                <div class="tab-pane" id="kt_widget2_tab4_content">
                    <div class="row">
                        @each('components.task', $tasks, 'task', 'components.task_empty')
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
