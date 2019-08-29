@extends('layouts.dashboard')

@section('page_title', 'Usuarios DMS')

@section('module_title', 'Usuarios DMS')

@section('subtitle', 'Este módulo gestiona todos los usuarios de la aplicación DMS.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('dmsusers') }}
@stop

@section('content')
    @can('permissions.create')
        <a href="{{ route('dmsusers.create') }}" class="btn btn-sm btn-success" role="button">
            <i class="fas fa-plus-circle"></i> Crear Usuario de DMS
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
                                <th>Usuario</th>
                                <th>Descripcion</th>
                                <th>¿Bloqueado?</th>
                                <th>Razon de bloqueo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dmsusers as $dmsuser)
                                <tr>
                                    <td>{{ $dmsuser->usuario }}</td>
                                    <td>{{ $dmsuser->des_usuario }}</td>
                                    <td>{{ $dmsuser->bloqueado }}</td>
                                    <td>{{ $dmsuser->razon_bloqueado }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">

                                                <a href="{{ route('dmsusers.show', $dmsuser->usuario) }}" class="btn btn-sm btn-outline-light">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>

                                            @can('dmsusers.edit')
                                                <a href="{{ route('dmsusers.edit', $dmsuser->usuario) }}" class="btn btn-sm btn-outline-light">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('dmsusers.destroy')
                                                <div class="btn btn-sm btn-outline-light delete" data-id="{{ $dmsuser->usuario }}">
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

    @can('dmsusers.destroy')
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
                    { "orderable": true, "searchable": true },
                    { "orderable": true, "searchable": true },
                    { "orderable": true, "searchable": true },
                    { "orderable": true, "searchable": true },
                    { "orderable": false, "searchable": false },
                ]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('dmsusers.destroy', ['user' => '__user']) }}'.replace('__user', $(this).data('usuario'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
