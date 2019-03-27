@extends('layouts.dashboard')

@section('page_title', 'Usuarios')

@section('module_title', 'Usuarios')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('users') }}
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
                                    <th>E-mail</th>
                                    <th>Nick</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->created_at->format('d M Y h:ia') }}</td>
                                    <td>{{ $user->updated_at->format('d M Y h:ia') }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">
                                            @can('users.list')
                                            <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            @endcan
                                            @can('users.edit')
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-light">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('users.destroy')
                                            <div class="btn btn-sm btn-outline-light delete" data-id="{{ $user->id }}">
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

    @can('users.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, eliminar este usuario">
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
                    { "orderable": true, "searchable": true },
                    { "orderable": true, "searchable": false },
                    { "orderable": true, "searchable": false },
                    { "orderable": false, "searchable": false },
                ]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('users.destroy', ['user' => '__user']) }}'.replace('__user', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
