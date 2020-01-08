@section('kt_aside')
<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--submenu-fullheight kt-menu__item--open kt-menu__item--here"  >
  <a href="{{ route('roles.index') }}" class="kt-menu__link " title="Listagem de Perfis">
    <i class="kt-menu__link-icon flaticon-profile"></i>
    <span class="kt-menu__link-text">Perfis</span>
    <i class="kt-menu__ver-arrow la la-angle-right"></i>
  </a>
</li>
<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--submenu-fullheight kt-menu__item--open kt-menu__item--here"  >
  <a href="{{ route('roles.create') }}" class="kt-menu__link " title="Criar Perfil">
    <i class="kt-menu__link-icon flaticon-plus"></i>
    <span class="kt-menu__link-text">Criar Perfil</span>
    <i class="kt-menu__ver-arrow la la-angle-right"></i>
  </a>
</li>
@endsection
