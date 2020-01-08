<div class="btn-group pull-right">
    <a href="{{ route('roles.index') }}" class="btn btn-warning">
        <i class="fa fa-arrow-left"></i> Voltar
    </a>
    @if(isset($role))
        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-success">
            <i class="fa fa-edit"></i> Editar
        </a>
    @endif
    <a href="{{ route('roles.create') }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> Criar novo
    </a>
</div>
<div class="clearfix"></div>