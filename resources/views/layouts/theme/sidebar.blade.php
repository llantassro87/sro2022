<div class="sidebar-wrapper sidebar-theme">
            
    <nav id="compactSidebar">
        <ul class="menu-categories">
            @can('administracion')
            <li class="menu" id="toggleAccordion1">
                <a href="javascript:void(0)" role="menu" class="menu-toggle collapsed" data-toggle="collapse" data-target="#adminAccordion" aria-expanded="false" aria-controls="adminAccordion">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        </div>
                        <span>ADMINISTRACIÓN</span>
                    </div>
                </a>
                <div id="adminAccordion" class="collapse" aria-labelledby="headingTwo1" data-parent="#toggleAccordion2" style="">
                    <div class="">
                        <ul class="list-group text-left">
                            @can('ver asignar')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('asignar')}}">Asignar</a>
                            </li>
                            @endcan

                            @can('ver roles')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('roles')}}">Roles</a>
                            </li>
                            @endcan

                            @can('ver usuarios')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('usuarios')}}">Usuarios</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </li>
            @endcan

            @can('inventario')
            <li class="menu" id="toggleAccordion2">
                <a href="javascript:void(0)" role="menu" class="menu-toggle collapsed" data-toggle="collapse" data-target="#inventarioAccordion" aria-expanded="false" aria-controls="inventarioAccordion">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                        <span>INVENTARIO</span>
                    </div>
                </a>
                <div id="inventarioAccordion" class="collapse" aria-labelledby="headingTwo2" data-parent="#toggleAccordion2" style="">
                    <div class="">
                        <ul class="list-group text-left">
                            @can('ver categorias')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('categorias')}}">Categorías</a>
                            </li>
                            @endcan

                            @can('ver compras')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('compras')}}">Compras</a>
                            </li>
                            @endcan

                            @can('ver productos')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('productos')}}">Productos</a>
                            </li>
                            @endcan

                            @can('ver proveedores')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('proveedores')}}">Proveedores</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </li>
            @endcan

            @can('pos')
            <li class="menu" id="toggleAccordion3">
                <a href="javascript:void(0)" role="menu" class="menu-toggle collapsed" data-toggle="collapse" data-target="#posAccordion" aria-expanded="false" aria-controls="posAccordion">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                        <span>POS</span>
                    </div>
                </a>
                <div id="posAccordion" class="collapse" aria-labelledby="headingTwo3" data-parent="#toggleAccordion3" style="">
                    <div class="">
                        <ul class="list-group text-left">
                            @can('ver caja')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('caja')}}">Caja</a>
                            </li>
                            @endcan

                            @can('ver denominaciones')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('monedas')}}">Monedas</a>
                            </li>
                            @endcan

                            @can('ver reportes')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('reportes')}}">Reportes</a>
                            </li>
                            @endcan

                            @can('ver ventas')
                            <li class="list-group-item" style="background-color: #515365;">
                                <a class="text-white" href="{{url('ventas')}}">Ventas</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </div>
            </li>
            @endcan
            <li class="menu">
                <a href="{{url('ayuda')}}" role="menu" class="menu-toggle collapsed">
                    <div class="base-menu">
                        <div class="base-icons">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                        <span>AYUDA</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>

    <div id="compact_submenuSidebar" class="submenu-sidebar" style="display: none"></div>
</div>