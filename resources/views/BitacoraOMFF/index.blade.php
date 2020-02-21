@extends('layouts.dashboard')

@section('page_title', 'Bitacora OMFF')

@section('module_title', 'Bitacora OMFF')

@section('subtitle', 'Bitacora de operacion y mantenimiento de fuentes fijas.')

@section('content')
    @can('bitacoraomff')
        <div class="card">
            <div class="card-header">
                Registros
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped CustomerTable" id="CustomerTable">
                        <thead>
                            <tr>
                                <th>MAQUINA</th>
                                <th>FECHA</th>
                                <th>OPERARIO</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
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
