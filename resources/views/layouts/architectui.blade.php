<!DOCTYPE html>
<html lang="es">
    <head>
        <title>@yield('page_title') - {{ config('app.name') }}</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" type="image/png" href="{{ asset('/img/favicon_192x192.png') }}">
        <link rel="shortcut icon" sizes="192x192" href="{{ asset('/img/favicon_192x192.png') }}">
        <link rel="stylesheet" href="{{ asset('architectui/main.css') }}">


        {{--Select2--}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" />


        {{--Datatables--}}
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>


        {{--Jqueryui--}}
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />


        {{--Animate CSS--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">


        {{--ChartJs--}}
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>


        {{--Boostrap Switch--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.css">


        {{--Toastr Alerts--}}
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"></script>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="cache-control" content="no-cache">

        <style>
            .scrollbar-sidebar{
                overflow: hidden;
            }

            .app-sidebar__inner {
                overflow: auto;

                /* Make sure the inner div is not larger than the container
                 * so that we have room to scroll.
                 */
                max-height: 100%;

                /* Pick an arbitrary margin/padding that should be bigger
                 * than the max width of all the scroll bars across
                 * the devices you are targeting.
                 * padding = -margin
                 */
                margin-right: -100px;
                padding-right: 100px;
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            <div class="app-header header-shadow">
                <div class="app-header__logo">
                    <img src="{{ asset('architectui/assets/images/logo_ev.png')}}" class="logo-src">
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div>


                <div class="app-header__content">
                    <div class="app-header-left">
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" class="search-input" placeholder="Buscar...">
                                <button class="search-icon"><span></span></button>
                            </div>
                            <button class="close"></button>
                        </div>
                    </div>
                    <div class="app-header-right">
                        <div class="header-btn-lg pr-0">
                            <div class="widget-content p-0">
                                <div class="widget-content-wrapper">
                                    <div class="widget-content-left">

                                        <div class="btn-group">
                                            <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                                <img width="42" class="rounded-circle" src="{{asset('img/favicon_192x192.png')}}" alt="">
                                                <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                            </a>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                                <button type="button" tabindex="0" class="dropdown-item">Cuenta</button>
                                                <button type="button" tabindex="0" class="dropdown-item">Configuracion</button>
                                                <div tabindex="-1" class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"><i class="fas fa-power-off mr-2"></i>{{ __('Cerrar sesión') }}</a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="widget-content-left  ml-3 header-user-info">
                                        <div class="widget-heading">
                                            {{ Auth::user()->name  }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading">Home</li>
                                <li class="{{ request()->route()->named('home') ? 'mm-active' : '' }}">
                                    <a href="{{ route('home') }}">
                                        <i class="metismenu-icon pe-7s-home"></i>
                                        Home
                                    </a>
                                </li>
                                <li class="{{ request()->route()->named('blog') ? 'mm-active' : '' }}">
                                    <a href="{{ route('blog') }}">
                                        <i class="metismenu-icon pe-7s-global"></i>
                                        Blog
                                    </a>
                                </li>
                                <li class="{{ request()->is('accesos_remotos') ? 'mm-active' : '' }}">
                                    <a href="{{ url('accesos_remotos') }}">
                                        <i class="metismenu-icon pe-7s-paper-plane">
                                        </i>Accesos remotos
                                    </a>
                                </li>
                                <li class="{{ request()->is('medida_prevencion') ? 'mm-active' : '' }}">
                                    <a href="{{ url('medida_prevencion') }}">
                                        <i class="metismenu-icon pe-7s-like">
                                        </i>Medida de prevencion
                                    </a>
                                </li>
                                <li class="{{ request()->route()->named('edit_medida_prevencion.*') ? 'mm-active' : '' }}">
                                    <a href="{{ url('edit_medida_prevencion') }}">
                                        <i class="metismenu-icon pe-7s-magic-wand">
                                        </i>G. Medida de prevencion
                                        <span class="badge badge-success">New!</span>
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Aplicativos</li>
                                    <li class="{{ request()->route()->named('Artes.index') ? 'mm-active' : '' }}">
                                        <a href="{{ route('Artes.index') }}">
                                            <i class="metismenu-icon  pe-7s-pen"></i>
                                            Artes
                                        </a>
                                    </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon  pe-7s-graph1"></i>
                                        Bitacora Omff
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('bitacoraomff.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('bitacoraomff.create') }}">
                                                <i class="metismenu-icon"></i>
                                                Registro P0XX
                                            </a>
                                        </li>
                                        <li class="{{ (request()->is('bitacoraomff_hl1')) ? 'mm-active' : '' }}">
                                        <a href="{{ url('bitacoraomff_hl1') }}">
                                                <i class="metismenu-icon"></i>
                                                Registro HL1
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('bitacoraomff.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('bitacoraomff.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Gestion
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-cash"></i>
                                        Facturacion electronica
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('fe.*') ? 'mm-active' : '' }}">
                                            <a href="{{ route('fe.index') }}">
                                                <i class="metismenu-icon"></i>
                                                  Facturas
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('nc.*') ? 'mm-active' : '' }}">
                                            <a href="{{ route('nc.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Notas credito
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('GestionFacturacionElectronica.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('GestionFacturacionElectronica.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Gestion FE
                                            </a>
                                        </li>
                                        <li class="{{ request()->is('ConfigFe') ? 'mm-active' : '' }}">
                                            <a href="{{ url('ConfigFe') }}">
                                                <i class="metismenu-icon">
                                                </i>Configuracion
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-rocket"></i>
                                        Productos
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('clonador.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('clonador.index') }}">
                                                <i class="metismenu-icon"></i>
                                                Clonador
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('codificador.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('codificador.index') }}">
                                                <i class="metismenu-icon"></i>
                                                Codificador
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="metismenu-icon">
                                                </i>Maestros
                                                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                            </a>
                                            <ul>
                                                <li class="{{ request()->route()->named('ProdCievCodTipoProducto.index') ? 'mm-active' : '' }}">
                                                    <a href="{{ route('ProdCievCodTipoProducto.index') }}">
                                                        <i class="metismenu-icon">
                                                        </i>Tipo producto
                                                    </a>
                                                </li>
                                                <li class="{{ request()->route()->named('ProdCievCod.index') ? 'mm-active' : '' }}">
                                                    <a href="{{ route('ProdCievCod.index') }}">
                                                        <i class="metismenu-icon">
                                                        </i>Lineas
                                                    </a>
                                                </li>
                                                <li class="{{ request()->route()->named('ProdCievCodSublinea.index') ? 'mm-active' : '' }}">
                                                    <a href="{{ route('ProdCievCodSublinea.index') }}">
                                                        <i class="metismenu-icon">
                                                        </i>Sublineas
                                                    </a>
                                                </li>
                                                <li class="{{ request()->route()->named('ProdCievCodCaracteristica.index') ? 'mm-active' : '' }}">
                                                    <a href="{{ route('ProdCievCodCaracteristica.index') }}">
                                                        <i class="metismenu-icon">
                                                        </i>Caracteristicas
                                                    </a>
                                                </li>
                                                <li class="{{ request()->route()->named('ProdCievCodMaterial.index') ? 'mm-active' : '' }}">
                                                    <a href="{{ route('ProdCievCodMaterial.index') }}">
                                                        <i class="metismenu-icon">
                                                        </i>Materiales
                                                    </a>
                                                </li>
                                                <li class="{{ request()->route()->named('ProdCievCodMedida.index') ? 'mm-active' : '' }}">
                                                    <a href="{{ route('ProdCievCodMedida.index') }}">
                                                        <i class="metismenu-icon">
                                                        </i>Medidas
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        Pedidos
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('pedidos.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('pedidos.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Ventas
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('PedidoCartera.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('PedidoCartera.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Cartera
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('PedidoCostos.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('PedidoCostos.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Costos
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('PedidoProduccion.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('PedidoProduccion.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Produccion
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('PedidoBodega.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('PedidoBodega.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Bodega
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-note2"></i>
                                        Requerimientos
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->is('misrequerimientos') ? 'mm-active' : '' }}">
                                            <a href="{{ url('misrequerimientos') }}">
                                                <i class="metismenu-icon">
                                                </i>Mis requerimientos
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('Requerimientoss.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('Requerimientoss.index') }}">
                                                <i class="metismenu-icon">
                                                </i> Gestion
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('requerimientos_dashboard.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('requerimientos_dashboard.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Indicadores
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-user"></i>
                                        Gestion de terceros
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('GestionClientes.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('GestionClientes.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Clientes
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{{ request()->route()->named('pronosticos.index') ? 'mm-active' : '' }}">
                                    <a href="{{ route('pronosticos.index') }}">
                                        <i class="metismenu-icon  pe-7s-umbrella"></i>
                                        Pronosticos
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Blog</li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-news-paper"></i>
                                        Publicaciones
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('posts.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('posts.create') }}">
                                                <i class="metismenu-icon">
                                                </i>Crear publicacion
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('posts.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('posts.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Mostrar Publicaciones
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-folder"></i>
                                        Categorias
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('categories.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('categories.create') }}">
                                                <i class="metismenu-icon">
                                                </i>Crear categoria
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('categories.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('categories.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Mostrar categorias
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-ticket"></i>
                                        Etiquetas
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('tags.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('tags.create') }}">
                                                <i class="metismenu-icon">
                                                </i>Crear etiqueta
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('tags.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('tags.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Mostrar etiquetas
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                                <li class="app-sidebar__heading">Administracion</li>
                                <li class="{{ request()->route()->named('users.index') ? 'mm-active' : '' }}">
                                    <a href="{{ route('users.index') }}">
                                        <i class="metismenu-icon pe-7s-user">
                                        </i>Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-unlock">
                                        </i>Roles
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('roles.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('roles.create') }}">
                                                <i class="metismenu-icon">
                                                </i>Crear rol
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('roles.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('roles.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Mostrar roles
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="metismenu-icon pe-7s-key">
                                        </i>Permisos
                                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                                    </a>
                                    <ul>
                                        <li class="{{ request()->route()->named('permissions.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('permissions.create') }}">
                                                <i class="metismenu-icon">
                                                </i>Crear permiso
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('permissions.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('permissions.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Mostrar permisos
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('permission_groups.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('permission_groups.index') }}">
                                                <i class="metismenu-icon">
                                                </i>Grupos de permisos
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('permission_groups.create') ? 'mm-active' : '' }}">
                                            <a href="{{ route('permission_groups.create') }}">
                                                <i class="metismenu-icon">
                                                </i>Crear grupo de permisos
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="{{ request()->route()->named('backup.index') ? 'mm-active' : '' }}">
                                    <a href="{{ route('backup.index') }}">
                                        <i class="metismenu-icon pe-7s-server">
                                        </i>Backups
                                    </a>
                                </li>
                                <li class="{{ request()->is('logs') ? 'mm-active' : '' }}">
                                    <a href="{{ url('logs') }}">
                                        <i class="metismenu-icon pe-7s-video">
                                        </i>Logs
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        @yield('content')
                    </div>
                    <br>
                    <div class="app-wrapper-footer">
                        <div class="app-footer">
                            <div class="app-footer__inner">
                                <div class="app-footer-right">
                                    Copyright © <script>var d = new Date(); document.write(d.getFullYear());</script> <a href="https://estradavelasquez.com/">&nbsp; Estrada Velasquez</a>. Todos los derechos reservados.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @yield('modal')

        <script src="{{ asset('architectui/assets/scripts/main.js') }}"></script>


        {{--Jquery--}}
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        {{--Jquery ui--}}
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

        {{--Sweet Alert--}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>

        {{--Datatables--}}
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

        {{--Select2--}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

        {{--PopperJs--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

        {{--Jquery Validate--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

        {{--Boostrap--}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>


        {{--Pdf Object--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js"></script>


        {{--ChartJs--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>


        {{--JsPdf--}}
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
        <script src="https://unpkg.com/jspdf-autotable@3.2.11/dist/jspdf.plugin.autotable.js" ></script>


        {{--Boostrap Switch--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>


        {{--Firebase --}}
        <!-- The core Firebase JS SDK is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-analytics.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.14.3/firebase-database.js"></script>


        {{--Toastr Alerts--}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src=""></script>



        <script type="text/javascript">
            var session_id = "{!! (Session::getId())?Session::getId():'' !!}";
            var user_id = "{!! (Auth::user())?Auth::user()->id:'' !!}";

            // Initialize Firebase
            var firebaseConfig = {
                apiKey: "AIzaSyCCrUM3pajbhlaAB1IrmCnUgefE5rOZoZM",
                authDomain: "evpiu-test.firebaseapp.com",
                databaseURL: "https://evpiu-test.firebaseio.com",
                projectId: "evpiu-test",
                storageBucket: "evpiu-test.appspot.com",
                messagingSenderId: "881208017465",
                appId: "1:881208017465:web:9809ad0390e83179c683e8",
                measurementId: "G-7B7ERZP1XC"
            };
            firebase.initializeApp(firebaseConfig);
            firebase.analytics();

            var database = firebase.database();


            if({!! Auth::user() !!}) {
                firebase.database().ref('/users/' + user_id + '/session_id').set(session_id);
            }

            firebase.database().ref('/users/' + user_id).on('value', function(snapshot2) {
                var v = snapshot2.val();

                if(v.session_id != session_id) {
                    toastr.warning('se ha iniciado sesión en tu cuenta desde otro dispositivo', 'ALERTA DE SEGURIDAD', {timeOut: 6000});
                    setTimeout(function() {
                        window.location = '/login';
                    }, 8000);
                }
            });
        </script>

        <script>
                @if(Session::has('alerts'))
            let alerts = {!! json_encode(Session::get('alerts')) !!};
            helpers.displayAlerts(alerts, toastr);
            @endif

            @if(Session::has('message'))

            // TODO: change Controllers to use AlertsMessages trait... then remove this
            var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
            var alertMessage = {!! json_encode(Session::get('message')) !!};
            var alerter = toastr[alertType];

            if (alerter) {
                alerter(alertMessage);
            } else {
                toastr.error("toastr alert-type " + alertType + " is unknown");
            }

            @endif
        </script>
        @stack('javascript')
    </body>

</html>

