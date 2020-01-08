@section('kt_aside')
<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--submenu-fullheight kt-menu__item--open kt-menu__item--here"  >
  <a href="{{ route('tasks.index') }}" class="kt-menu__link " title="Listagem de Tarefas">
    <i class="kt-menu__link-icon flaticon-list"></i>
    <span class="kt-menu__link-text">Tarefas</span>
    <i class="kt-menu__ver-arrow la la-angle-right"></i>
  </a>
</li>
<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--submenu-fullheight kt-menu__item--open kt-menu__item--here"  >
  <a href="{{ route('tasks.index.page', ['page' => 'calendar']) }}" class="kt-menu__link " title="Calendário de Tarefas">
    <i class="kt-menu__link-icon flaticon-calendar-2"></i>
    <span class="kt-menu__link-text">Calendário de Tarefas</span>
    <i class="kt-menu__ver-arrow la la-angle-right"></i>
  </a>
</li>
<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--submenu-fullheight kt-menu__item--open kt-menu__item--here"  >
  <a href="{{ route('tasks.create') }}" class="kt-menu__link " title="Criar Tarefa">
    <i class="kt-menu__link-icon flaticon-plus"></i>
    <span class="kt-menu__link-text">Criar Tarefas</span>
    <i class="kt-menu__ver-arrow la la-angle-right"></i>
  </a>
</li>
@endsection