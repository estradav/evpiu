@extends('layouts.dashboard')

@section('page_title', 'Grupos de Permisos')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_groups') }}
@stop

@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissionGroups as $permissionGroup)
                                <tr>
                                    <td>{{ $permissionGroup->id }}</td>
                                    <td>{{ $permissionGroup->name }}</td>
                                    <td>{{ $permissionGroup->created_at->format('d M Y h:ia') }}</td>
                                    <td>{{ $permissionGroup->updated_at->format('d M Y h:ia') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('javascript')
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('.table').DataTable({
                "order": [],
                "columns": [
                    { "orderable": true, "searchable": false },
                    { "orderable": true, "searchable": true },
                    { "orderable": true, "searchable": false },
                    { "orderable": true, "searchable": false },
                ]
            });
        });
    </script>
@endpush
