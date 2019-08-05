@extends('layouts.dashboard')

@section('page_title', 'Grupos de Permisos')

@section('module_title', 'Permisos')

@section('subtitle', 'Este módulo gestiona todos los permisos de los roles de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('permission_groups') }}
@stop

@section('content')
    @can('permission_groups.create')
    <a href="{{ route('permission_groups.create') }}" class="btn btn-sm btn-success" role="button">
        <i class="fas fa-plus-circle"></i> Crear grupo de permisos
    </a>
    @endcan
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissionGroups as $permissionGroup)
                                <tr>
                                    <td>{{ $permissionGroup->id }}</td>
                                    <td>{{ $permissionGroup->name }}</td>
                                    <td>{{ $permissionGroup->created_at->format('d M Y h:ia') }}</td>
                                    <td>{{ $permissionGroup->updated_at->format('d M Y h:ia') }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">
                                            @can('permission_groups.list')
                                            <a href="{{ route('permission_groups.show', $permissionGroup->id) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            @endcan
                                            @can('permission_groups.edit')
                                            <a href="{{ route('permission_groups.edit', $permissionGroup->id) }}" class="btn btn-sm btn-outline-light">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
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
                    { "orderable": false, "searchable": false },
                ]
            });
        });
    </script>
@endpush
