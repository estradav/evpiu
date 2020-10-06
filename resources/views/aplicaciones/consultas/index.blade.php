@extends('layouts.architectui')

@section('page_title', 'Consultas')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'consultas' ]) !!}
@endsection

@section('content')
    @can('home.consultas.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-search icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Consultas
                        <div class="page-title-subheading">
                            Accesos directos a consultas generales
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="card col-3 shadow-sm">
                <div class="card-body text-center">
                    <i class="pe-7s-download pe-5x icon-gradient bg-mean-fruit"></i>
                    <h1 class="card-title pricing-card-title">Descarga / reenvio de documentos electronicos</h1>
                    <a href="{{route('consultas.reenvio_facturas')}}" class="btn btn-lg btn-block btn-outline-primary">CONSULTAR</a>
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
