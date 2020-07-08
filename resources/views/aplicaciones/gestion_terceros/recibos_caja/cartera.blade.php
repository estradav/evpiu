@extends('layouts.architectui')

@section('page_title','Recibos de caja')

@section('content')
    @can('recibos_caja.cartera')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-credit icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Recibos de caja
                        <div class="page-title-subheading">
                            Aprobación o rechazo de recibos de caja.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm text-center" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>VENDEDOR</th>
                                        <th>CLIENTE</th>
                                        <th>NIT</th>
                                        <th>TOTAL RC</th>
                                        <th>COMENTARIOS</th>
                                        <th>ESTADO</th>
                                        <th>FECHA DE CREACION</th>
                                        <th>ULTIMA ACTUALIZACION</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ \App\User::where('username',$row->created_by)->first()->name }}</td>
                                            <td>{{ $row->customer }}</td>
                                            <td>{{ $row->nit }}</td>
                                            <td>{{ $row->total }}</td>
                                            <td>{{ $row->comments }}</td>
                                            <td>
                                                @if ($row->state == 0)
                                                    <span class="badge badge-danger">Anulado</span>
                                                @elseif ($row->state == 1)
                                                    <span class="badge badge-info">Borrador</span>
                                                @elseif($row->state == 2)
                                                    <span class="badge badge-primary">Cartera</span>
                                                @elseif($row->state == 3)
                                                    <span class="badge badge-success">Finalizado</span>
                                                @elseif($row->state == 4)
                                                    <span class="badge badge-warning">Rechazado</span>
                                                @endif
                                            </td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ $row->updated_at }}</td>
                                            <td>
                                                <div class="btn-group btn-sm">
                                                    <button type="button" class="btn btn-light ver" id="{{ $row->id }}" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-eye"></i></button>
                                                    <button type="button" class="btn btn-light aprobar" id="{{ $row->id.','.$row->state }}" data-toggle="tooltip" data-placement="top" title="Aprobar"><i class="fas fa-check-double"></i></button>
                                                    <button type="button" class="btn btn-light rechazar" id="{{ $row->id.','.$row->state }}" data-toggle="tooltip" data-placement="top" title="Rechazar"><i class="fas fa-window-close"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
    <div class="modal fade" id="ver_modal" tabindex="-1" role="dialog" aria-labelledby="ver_modal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ver_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="ver_modal_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="info_documento_modal" tabindex="-1" role="dialog" aria-labelledby="info_documento_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="info_documento_modal_title"></h5>
                    <button type="button" class="close reset" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody id="info_documento_modal_table_body">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary reset" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/gestion_terceros/recibos_caja/cartera.js') }}"></script>
@endpush
