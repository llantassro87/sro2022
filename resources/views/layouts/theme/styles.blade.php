<script src="{{ asset('assets/js/loader.js') }}"></script>
<link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/structure.css') }}" rel="stylesheet" type="text/css" class="structure" />
    <!-- END GLOBAL MANDATORY STYLES -->
<link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css">


<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css">

<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css">
@if (request()->is('asignar'))
<link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css">
@endif
@if (request()->is('dashboard'))
<link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" class="dashboard-sales" />
@endif
<link href="{{ asset('assets/css/apps/scrumboard.css') }}" rel="stylesheet" type="text/css">
@if (request()->is('usuarios') || request()->is('proveedores') || request()->is('compras'))
<script src="https://unpkg.com/imask"></script>
@endif

<style>
    aside {
        display: none!important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #3b3f5c;
        border-color: #3b3f5c;
    }

    @media (max-width: 480px) {
        .mtmobile {
            margin-bottom: 20px!important;
        }
        .mbmobile {
            margin-bottom: 10px!important;
        }
        .hideonsm {
            display: none!important;
        }
        .inblock {
            display: block;
        }
    }

    .sidebar-theme #compactSidebar {
        background: #191e3a!important;
    }

    .header-container .sidebarCollapse {
        color: #3b3f5c!important;
    }

    ::-moz-selection {
        color: #ffffff;
        background: #1b55e2;    
    }

    ::selection {
        color: #ffffff;
        background: #1b55e2;    
    }

    .navbar .navbar-item .nav-item form.form-inline input.search-form-control {
        font-size: 15px;
        background-color: #3b3f5c!important;
        padding-right: 40px;
        padding-top: 12px;
        border: none;
        color: #fff;
        box-shadow: none;
        border-radius: 30px;
    }

    .opacity-0{opacity:0!important}
    .opacity-25{opacity:.25!important}
    .opacity-50{opacity:.5!important}
    .opacity-75{opacity:.75!important}
    .opacity-100{opacity:1!important}
</style>

@livewireStyles