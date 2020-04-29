@extends('layouts.architectui')

@section('page_title', 'Administracion medida de prevencion')

@section('content')
    @can('admin_medida_prevencion')
        <div class="container-fluid">
            <div class="card card-shadow-dark">
                <div class="card-header">
                    registros
                </div>
                <div class="card-body">
                    <table class="table" id="empleados_table">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center">EMPLEADO</th>
                            <th scope="col" class="text-center">ESTADO</th>
                            <th scope="col" class="text-center">ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($registros as $registro)
                            <tr>
                                <td class="text-center">{{ $registro->employee }}</td>
                                <td class="text-center">
                                    @if($registro->state == 1)
                                        <span class="badge badge-primary">trabajando</span>
                                    @else
                                        <span class="badge badge-success">en casa</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('edit_medida_prevencion.edit', $registro->id) }}" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Ver/Editar</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
    <script>
        $(document).ready(function () {
            $('#empleados_table').dataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                }
            });
        });
    </script>
@endpush
