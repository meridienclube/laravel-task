<form class="form" id="filter_tasks">
    <div class="form-group">
        <div>
            <label>{{ trans('Tipo de tarefa') }}</label>
        </div>
        {{ Form::select2('types[]', $types->pluck('name','id'), [], ['id' => 'column0_search', 'class' => 'form-control', 'multiple' => true]) }}
    </div>
    <div class="form-group">
        <div>
            <label>{{ trans('Responsavel da tarefa') }}</label>
        </div>
        <div>
            {{ Form::select2('sync[responsibles][]', [], [], ['id' => 'column6_search', 'class' => 'form-control', 'multiple' => true], ['server_side' => ['route' => 'api.users.select2']]) }}
        </div>
    </div>
    <div class="form-group">
        <div>
            <label>{{ trans('Periodo da tarefa') }}</label>
        </div>
        <div class="row">
            <div class="col-6">
                <input type="text" class="form-control datepicker" name="from" style="width: inherit;"/>
            </div>
            <div class="col-6">
                <input type="text" class="form-control timepicker" name="to" style="width: inherit;"/>
            </div>
        </div>
    </div>
    <div class="form-group">
        {{ Form::checkbox('view_completed', 'view_completed', false, ['id' => 'view_completed_search', 'class' => 'form-checkbox']) }}
        <label>{{ trans('Visualizar concluídas') }}</label>
    </div>
</form>


@push('scripts')
    <script>
        $(function () {
            $("input.datepicker").datepicker({
                dateFormat: "yy-mm-dd"
            });
            $('input.timepicker').timepicker({
                timeFormat: 'HH:mm'
            });
        });
    </script>
@endpush
