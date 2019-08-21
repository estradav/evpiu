@extends('layouts.dashboard')

@section('page_title', 'Roles')

@section('module_title', 'Roles')

@section('subtitle', 'Este módulo gestiona todos los roles de los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('roles') }}
@stop

@section('content')
    @can('roles.create')
    <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success" role="button">
        <i class="fas fa-plus-circle"></i> Crear rol
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
                                    <th>Identificador</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>
                                        @if ($role->protected)
                                            <span class="badge badge-primary"><i class="fas fa-lock"></i></span>
                                            {{ $role->name }}
                                        @else
                                            {{ $role->name }}
                                        @endif
                                    </td>
                                    <td>{{ $role->description }}</td>
                                    <td>{{ $role->guard_name }}</td>
                                    <td>{{ $role->created_at->format('d M Y h:ia') }}</td>
                                    <td>{{ $role->updated_at->format('d M Y h:ia') }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">
                                            @can('roles.list')
                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            @endcan
                                            @can('roles.edit')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-light">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('roles.destroy')
                                            <div class="btn btn-sm btn-outline-light delete" data-id="{{ $role->id }}">
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

    @can('roles.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar rol</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este rol?</p>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, eliminar este rol">
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
                    { "orderable": true, "searchable": true },
                    { "orderable": false, "searchable": false },
                    { "orderable": true, "searchable": false },
                    { "orderable": true, "searchable": false },
                    { "orderable": false, "searchable": false },
                ]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('roles.destroy', ['role' => '__role']) }}'.replace('__role', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
