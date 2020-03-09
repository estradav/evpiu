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
        {{--<link rel="stylesheet" href="{{ asset('dashboard/styles/app.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('dashboard/styles/main.css') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="cache-control" content="no-cache">
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
                        <ul class="header-menu nav">
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa fa-database"> </i>
                                    Estadisticas
                                </a>
                            </li>
                            <li class="btn-group nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa fa-edit"></i>
                                    Proyectos
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-link-icon fa fa-cog"></i>
                                    Configuracion
                                </a>
                            </li>
                        </ul>
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
            <div class="ui-theme-settings">
                <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                    <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
                </button>
                <div class="theme-settings__inner">
                    <div class="scrollbar-container">
                        <div class="theme-settings__options-wrapper">
                            <h3 class="themeoptions-heading">Opciones de visualizacion
                            </h3>
                            <div class="p-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                                        <div class="switch-animate switch-on">
                                                            <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Encabezado fijo
                                                    </div>
                                                    <div class="widget-subheading">Hace que la parte superior siempre sea visible.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
                                                        <div class="switch-animate switch-on">
                                                            <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Barra lateral fija
                                                    </div>
                                                    <div class="widget-subheading">Hace que la barra lateral quede fija.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item">
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                        <div class="switch-animate switch-off">
                                                            <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget-content-left">
                                                    <div class="widget-heading">Pie de página fijo
                                                    </div>
                                                    <div class="widget-subheading">Hace que el pie de página de la aplicación sea fijo.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="themeoptions-heading">
                                <div>
                                    Opciones de encabezado
                                </div>
                                <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                    Restablecer
                                </button>
                            </h3>
                            <div class="p-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5 class="pb-2">Elije el color del encabezado
                                        </h5>
                                        <div class="theme-settings-swatches">
                                            <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                            </div>
                                            <div class="divider">
                                            </div>
                                            <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                            </div>
                                            <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="themeoptions-heading">
                                <div>Opciones de barra lateral</div>
                                <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                    Restablecer
                                </button>
                            </h3>
                            <div class="p-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5 class="pb-2">Elije el color de la barra lateral
                                        </h5>
                                        <div class="theme-settings-swatches">
                                            <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                            </div>
                                            <div class="divider">
                                            </div>
                                            <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                            </div>
                                            <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                            </div>
                                            <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <h3 class="themeoptions-heading">
                                <div>Main Content Options</div>
                                <button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                                </button>
                            </h3>
                            <div class="p-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5 class="pb-2">Pestañas de sección de página
                                        </h5>
                                        <div class="theme-settings-swatches">
                                            <div role="group" class="mt-2 btn-group">
                                                <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
                                                    Linea
                                                </button>
                                                <button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
                                                    Sombra
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
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
                                                Registro
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
                                        <li class="{{ request()->route()->named('fe.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('fe.index') }}">
                                                <i class="metismenu-icon"></i>
                                                  Facturas
                                            </a>
                                        </li>
                                        <li class="{{ request()->route()->named('nc.index') ? 'mm-active' : '' }}">
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
                                        <li class="{{ request()->route()->named('ConfigFe.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('ConfigFe.index') }}">
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
                                        <li class="{{ request()->route()->named('requerimientos_dashboard.index') ? 'mm-active' : '' }}">
                                            <a href="{{ route('requerimientos_dashboard.index') }}">
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
                                <li class="{{ request()->route()->named('backup.index') ? 'mm-active' : '' }}">
                                    <a href="#">
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
        <script src="{{ asset('dashboard/scripts/app.js') }}"></script>
        <script src="{{ asset('dashboard/scripts/main.js') }}"></script>
        <script src="{{ asset('architectui/assets/scripts/main.js') }}"></script>


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
@yield('modal')
