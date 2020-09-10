@extends('layouts.architectui')

@section('page_title', 'Informes calidad')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'aplicaciones_calidad_dashboard' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.calidad.dashboard')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-check icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Informes calidad
                        <div class="page-title-subheading">
                            Informes bimestrales
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <h4 class="text-center">Por favor seleccione el bimestre a generar informe</h4>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <select name="date" id="date" class="form-control">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="1-2">Enero - Febrero</option>
                                    <option value="3-4">Marzo - Abril</option>
                                    <option value="5-6">Mayo - Junio</option>
                                    <option value="7-8">Julio - Agosto</option>
                                    <option value="9-10">Septiembre - Octubre</option>
                                    <option value="11-12">Noviembre - Diciembre</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body" id="result_search">
                        <div class="alert alert-info text-center" role="alert">
                            <h4 class="alert-heading text-center">
                                <i class="fas fa-info-circle fa-3x"></i> <br>
                                <b>Por favor, realice una busqueda para ver la informacion..!</b>
                            </h4>
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


{{--
<div class="alert alert-warning text-center" role="alert">
    <h4 class="alert-heading text-center">
        <i class="fas fa-exclamation-triangle fa-4x"></i><br>
        <b>¡No se encontro infomacion!</b>
    </h4>
    <h5>Por favor verifique que el numero de la orden de produccion sea correcto!</h5>
</div>
--}}
