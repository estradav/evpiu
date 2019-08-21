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
                                            @can('permission_groups.destroy')
                                            <div class="btn btn-sm btn-outline-light delete" data-id="{{ $permissionGroup->id }}">
                                                <i class="far fa-trash-alt"></i>
                                            </div>
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

    @can('permission_groups.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar grupo de permisos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este grupo de permisos?</p>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, eliminar este grupo de permisos">
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endcan
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

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('permission_groups.destroy', ['permission' => '__permission']) }}'.replace('__permission', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
