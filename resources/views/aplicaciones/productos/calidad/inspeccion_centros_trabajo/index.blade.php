@extends('layouts.architectui')

@section('page_title', 'Control de calidad')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'aplicaciones_calidad_revision' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.calidad.revision')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-check icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Calidad
                        <div class="page-title-subheading">
                            Control de calidad
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-group">
                                    <input type="number" class="form-control" aria-label="search" aria-describedby="search" id="search" name="search" placeholder="Ingrese el numero de la orden sin los ultimos 4 ceros">
                                    <h5 class="text-center"></h5>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-block" type="button" id="search_button"><i class="fas fa-search"></i> CONSULTAR ORDEN PRODUCCION</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card card">
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

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/productos/calidad/revision.js') }}"></script>
@endpush

@section('modal')
    <div class="modal fade" id="new_review_modal" tabindex="-1" aria-labelledby="new_review_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="new_review_modal_title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="new_review_modal_form">
                    <div class="modal-body">
                        <input type="hidden" id="production_order" name="production_order">
                        <input type="hidden" id="inspector_id" name="inspector_id" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <label for="quantity_inspected">Cantidad inspeccionada</label>
                            <input type="number" class="form-control" id="quantity_inspected" name="quantity_inspected">
                        </div>
                        <div class="form-group">
                            <label for="conforming_quantity">Cantidad conforme</label>
                            <input type="number" class="form-control" id="conforming_quantity" name="conforming_quantity">
                        </div>
                        <div class="form-group">
                            <label for="non_conforming_quantity">Cantidad no conforme</label>
                            <input type="number" class="form-control" id="non_conforming_quantity" name="non_conforming_quantity">
                        </div>
                        <div class="form-group">
                            <label for="cause">Causa</label>
                            <select class="form-control" name="cause" id="cause">
                                <option value="" selected>Seleccione...</option>
                                <option value="CASCARA">CASCARA</option>
                                <option value="CONTAMINACION DE LOTE">CONTAMINACION DE LOTE</option>
                                <option value="EMBOMBADAS">EMBOMBADAS</option>
                                <option value="FUERA DE MEDIDA">FUERA DE MEDIDA</option>
                                <option value="HUNDIDOS">HUNDIDOS</option>
                                <option value="LASER BORRADO">LASER BORRADO</option>
                                <option value="MAL ENSAMBLE">MAL ENSAMBLE</option>
                                <option value="MANCHADAS">MANCHADAS</option>
                                <option value="MUY PULIDO">MUY PULIDO</option>
                                <option value="OPACAS">OPACAS</option>
                                <option value="PEGADOS">PEGADOS</option>
                                <option value="PICADAS">PICADAS</option>
                                <option value="PIEL POROSA">PIEL POROSA</option>
                                <option value="POROSIDAD MATERIAL">POROSIDAD MATERIAL</option>
                                <option value="QUEMADAS">QUEMADAS</option>
                                <option value="REBABA">REBABA</option>
                                <option value="REVIENTA TERMINADO">REVIENTA TERMINADO</option>
                                <option value="TALLON">TALLON</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="operator_id">Operario</label>
                            <select class="form-control" name="operator_id" id="operator_id">
                                <option value="" selected>Seleccione...</option>
                                @foreach ($operators as $operator)
                                    <option value="{{ $operator->id }}">{{ $operator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="non_compliant_treatment">Tratamiento a la no conformidad</label>
                            <textarea class="form-control" name="non_compliant_treatment" id="non_compliant_treatment" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="action">Accion tomada</label>
                            <textarea class="form-control" name="action" id="action" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="observation">Observaciones</label>
                            <textarea class="form-control" name="observation" id="observation" cols="30" rows="2"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="center">Centro</label>
                            <input class="form-control" type="text" name="center" id="center" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="review_info_modal" tabindex="-1" aria-labelledby="review_info_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="review_info_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="review_info_modal_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="ViewArtModal" tabindex="-1" role="dialog" aria-labelledby="ViewArtModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ViewArtTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <div id="ViewArtPdf" style="height:750px;" ></div>
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button class="btn btn-primary" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #loader-wrapper {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }
        #loader {
            display: block;
            position: relative;
            left: 45%;
            top: 50%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #3498db;

            -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #e74c3c;

            -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #f9c922;

            -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        @-webkit-keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }
        @keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }
    </style>
@endpush
