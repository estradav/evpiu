@extends('layouts.architectui')

@section('page_title','Mis recibos de caja')

@section('content')
    @can('recibos_caja.mis_recibos')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-credit icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Recibos de caja
                        <div class="page-title-subheading">
                            Lista de recibos de caja creados
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
                            <table class="table table-striped table-sm" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
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
                                            <td>{{ $row->customer }}</td>
                                            <td>{{ $row->nit }}</td>
                                            <td>{{ '$'.number_format($row->total, 2, ',','.')  }}</td>
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
                                            <td>{{ \Carbon\Carbon::parse($row->updated_at)->diffForHumans() }}</td>
                                            <td>
                                                <div class="btn-group btn-sm">
                                                    <button type="button" class="btn btn-light cartera" id="{{ $row->id.','.$row->state }}" data-toggle="tooltip" data-placement="top" title="Enviar a cartera"><i class="fas fa-paper-plane"></i></button>
                                                    <button type="button" class="btn btn-light anular" id="{{ $row->id.','.$row->state }}" data-toggle="tooltip" data-placement="top" title="Anular"><i class="fas fa-window-close"></i></button>
                                                    <a href="{{ route('recibos_caja.edit', $row->id) }}" type="button" class="btn btn-light editar" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
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

@push('javascript')
    <script type="text/javascript" src="{{ asset('aplicaciones/gestion_terceros/recibos_caja/index.js') }}"></script>
@endpush
