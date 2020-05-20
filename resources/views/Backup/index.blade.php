@extends('layouts.architectui')

@section('page_title', 'Backup')

@section('content')
    @can('backup')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <a id="create-new-backup-button" href="{{ url('backup/create') }}" class="btn btn-primary pull-right" ><i class="fa fa-plus"></i> Crear Backup</a>
                    </div>
                    <div class="card-body">
                        @if (count($backups))
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Fecha</th>
                                        <th>Creado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($backups as $backup)
                                    <tr>
                                        <td>{{ $backup['file_name'] }}</td>
                                        <td>{{ formatSizeUnits($backup['file_size']) }}</td>
                                        <td>{{ \Carbon\Carbon::createFromTimestamp($backup['last_modified'])->toDateTimeString() }}</td>
                                        <td>{{ \Carbon\Carbon::createFromTimestamp($backup['last_modified'])->diffForHumans( \Carbon\Carbon::now()) }}</td>
                                        <td>
                                            <a class="btn btn-xs btn-success"
                                               href="{{action('BackupController@download', [$backup['file_name']])}}"><i class="fa fa-cloud-download"> </i> Decargar</a>
                                            <a class="btn btn-xs btn-danger link_confirmation" data-button-type="delete"
                                               href="{{action('BackupController@delete', [$backup['file_name']])}}"><i class="fa fa-trash-o"></i>
                                                Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="well">
                                <h4>Ningun backup creado</h4>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
        <strong>Para activar los backups automaticos:</strong><br>
        <code>{{$cron_job_command}}</code>
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
<?php
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        }elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        }else{
            $bytes = '0 bytes';
        }
        return $bytes;
    }
    ?>
@endsection
