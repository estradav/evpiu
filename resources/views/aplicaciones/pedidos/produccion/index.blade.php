@extends('layouts.architectui')

@section('page_title', 'Pedidos (Produccion)')

@section('content')
    @can('aplicaciones.pedidos.produccion.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-paint icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Produccion
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
                        Pedidos pendientes
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OC</th>
                                        <th>COD CLIENTE</th>
                                        <th>CLIENTE</th>
                                        <th>VENDEDOR</th>
                                        <th>CONDICION PAGO</th>
                                        <th>DESCUENTO</th>
                                        <th>IVA</th>
                                        <th>SUB ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th style="text-align:center ">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        Pedidos terminados
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="table_terminados">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>OC</th>
                                        <th>COD CLIENTE</th>
                                        <th>CLIENTE</th>
                                        <th>VENDEDOR</th>
                                        <th>CONDICION PAGO</th>
                                        <th>DESCUENTO</th>
                                        <th>IVA</th>
                                        <th>ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th style="text-align:center ">ACCIONES</th>
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
        <div class="card">
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

    <div class="modal fade" id="opciones" tabindex="-1" role="dialog" aria-labelledby="opciones" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="opciones_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form" name="form">
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="estado" class="control-label" ><b>Estado:&nbsp;&nbsp;</b></label>
                                <select name="estado" id="estado" class="form-control">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="7">Rechazar y enviar al vendedor</option>
                                    <option value="8">Enviar a bodega</option>
                                    <option value="10">Finalizar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="descripcion" class="control-label" ><b>Descripcion:&nbsp;&nbsp;</b></label>
                                <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control" placeholder="Por favor escriba una descripcion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">GUARDAR</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/ventas/modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('aplicaciones/pedidos/_produccion/index.js') }}"></script>
@endpush
