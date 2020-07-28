@extends('layouts.architectui')

@section('page_title', 'Pedidos (Ventas)')

@section('content')
    @can('aplicaciones.pedidos.ventas')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-call icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Pedidos
                        <div class="page-title-subheading">
                            Mis pedidos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    @can('aplicaciones.pedidos.ventas.nuevo')
                        <div class="card-header">
                            <a class="btn btn-primary" href="{{ route('venta.create') }}"><i class="fas fa-plus-circle"></i> Nuevo</a>
                        </div>
                    @endcan
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OC</th>
                                        <th>COD CLIENTE</th>
                                        <th>NOMBRE CLIENTE</th>
                                        <th>CONDICION PAGO</th>
                                        <th>DESCUENTO</th>
                                        <th>IVA</th>
                                        <th>ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th style="text-align:center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@section('modal')
    @include('aplicaciones.pedidos.ventas.pdf_modal')
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/ventas/modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/ventas/index.js') }}"></script>
@endpush
