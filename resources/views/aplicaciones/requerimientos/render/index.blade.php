@extends('layouts.architectui')

@section('page_title', 'Render')

@section('content')
    @can('aplicaciones.requerimientos.render')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-box2 icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Render
                        <div class="page-title-subheading">
                            Lista de requerimientos asignados
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DESCRIPCION</th>
                                        <th>INFORMACION</th>
                                        <th>VENDEDOR</th>
                                        <th>DISEÑADOR</th>
                                        <th>ESTADO</th>
                                        <th>FECHA CREACION</th>
                                        <th>ULTIMA ACTUALIZACION</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach( $data as $row )
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ \App\CodCodigo::find($row->producto_id)->descripcion }}</td>
                                            <td>{{ $row->informacion }}</td>
                                            <td>{{ \App\User::find($row->vendedor_id)->name }}</td>
                                            <td>{!! \App\User::find($row->diseñador_id)->name ?? '<span class="badge badge-danger">Sin asignar</span>' !!} </td>
                                            <td>
                                                @if ( $row->estado == 0 )
                                                    <span class="badge badge-danger">Anulado</span>
                                                @elseif( $row->estado == 1 )
                                                    <span class="badge badge-primary">Pendiente revision</span>
                                                @elseif( $row->estado == 2 )
                                                    <span class="badge badge-info">Asignado</span>
                                                @elseif( $row->estado == 3 )
                                                    <span class="badge badge-success">Iniciado</span>
                                                @elseif( $row->estado == 4 )
                                                    <span class="badge badge-success">Finalizado</span>
                                                @elseif( $row->estado == 5 )
                                                    <span class="badge badge-danger">Anulado diseño</span>
                                                @elseif( $row->estado == 6 )
                                                    <span class="badge badge-warning">Rechazado</span>
                                                @endif
                                            </td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ \Carbon\Carbon::parse($row->updated_at )->diffForHumans() }}</td>
                                            <td>
                                                <a href="{{ route('ventas.edit', $row->id) }}" class="btn btn-light btn-sm"><i class="fas fa-eye"></i> VER </a>
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
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').dataTable({
                language: {
                    url: '/Spanish.json'
                }
            })
        });
    </script>

@endpush
