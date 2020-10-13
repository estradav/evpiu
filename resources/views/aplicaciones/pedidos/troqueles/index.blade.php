@extends('layouts.architectui')

@section('page_title', 'Pedidos (Troqueles)')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'pedidos_troqueles' ]) !!}
@stop

@section('content')
    @can('aplicaciones.pedidos.troqueles.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-box2 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Troqueles
                        <div class="page-title-subheading">
                            Gestion de pedidos
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pedidos Pendientes
                    </div>
                    <div class="card-body">
                        {{ $data2 }}
                    </div>
                </div>
            </div>
        </div>


    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection
