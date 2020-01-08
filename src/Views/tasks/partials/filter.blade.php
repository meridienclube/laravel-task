<div class="kt-portlet">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
        <h3 class="kt-portlet__head-title">
            Filtro de Tarefas
        </h3>
        </div>
    </div>
    <form class="kt-form" id="filter_tasks">
        <div class="kt-portlet__body">
            <div class="form-group">
                <label>Tipo de tarefa</label>
                {{ Form::select('types[]', $types->pluck('name','id'), isset($get['types'])? $get['types'] : null, ['id' => 'column0_search', 'class' => 'form-control select2 kt-select2', 'multiple'=>true]) }}
            </div>
            <div class="form-group">
                <label>Responsavel da tarefa</label>
                @select2(['url' => 'users', 'name' => 'sync[responsibles][]', 'options' => [], 'selected' => [], "id" => "column1_search"])
                @slot('title')
                    Responsáveis
                @endslot
                @endselect2
            </div>
            <div class="form-group">
                <label>Periodo da tarefa</label>
                <div class="input-daterange input-group kt_datepicker" id="kt_datepicker">
                    <input type="text" class="form-control data_search" name="from" id="data_from_search" />
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-ellipsis-h"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control data_search" id="data_to_search" name="to" />
                </div>
            </div>
            <div class="form-group">
                {{ Form::checkbox('view_completed', 'view_completed', false, ['id' => 'view_completed_search', 'class' => 'form-checkbox']) }}
                <label>Visualizar concluídas</label>
            </div>
        </div>
        <div class="kt-portlet__foot">
            <div class="kt-form__actions">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Limpar</a>
            </div>
        </div>
    </form>
</div>
