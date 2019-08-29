@extends('layouts.dashboard')

@section('page_title', 'Terceros DMS')

@section('module_title', 'Terceros DMS')

@section('subtitle', 'Este módulo gestiona todos los Terceros de la aplicación DMS.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('terceros') }}
@stop

@section('content')
    @can('permissions.create')
        <a href="#" class="btn btn-sm btn-success" role="button">
            <i class="fas fa-plus-circle"></i> Crear Tercero de DMS
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
                                <th>Nombres</th>
                                <th>Pais</th>
                                <th>Ciudad</th>
                                <th>Direccion</th>
                                <th>Tipo Identificacion</th>
                                <th>#. Identificacion</th>
                                <th>Definicion Triburaria</th>
                                <th>Telefono</th>
                                <th>E-Mail</th>

                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($terceros as $terc)
                                <tr>
                                    <td>{{ $terc->nombres }}</td>
                                    <td>{{ $terc->pais }}</td>
                                    <td>{{ $terc->ciudad }}</td>
                                    <td>{{ $terc->direccion }}</td>
                                    <td>{{ $terc->identificacion}}</td>
                                    <td>{{ $terc->nit_real }}</td>
                                    <td>{{ $terc->definicion_tributaria}}</td>
                                    <td>{{ $terc->telefono_1 }}</td>
                                    <td>{{ $terc->mail }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">

                                            <a href="#" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>

                                            @can('terceros.edit')
                                                <a href="#" class="btn btn-sm btn-outline-light">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            @endcan
                                            @can('terceros.destroy')
                                                <div class="btn btn-sm btn-outline-light delete" data-id="{{ $terc->usuario }}">
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
                    { "orderable": true, "searchable": true },   // nombres
                    { "orderable": true, "searchable": true },   // pais
                    { "orderable": true, "searchable": true },   // ciudad
                    { "orderable": true, "searchable": true },   // direccion
                    { "orderable": true, "searchable": true },   // tipo identificacion
                    { "orderable": false, "searchable": true },  // nit
                    { "orderable": false, "searchable": false }, // def tributaria
                    { "orderable": false, "searchable": true },  // telefono
                    { "orderable": false, "searchable": true },  // mail
                    { "orderable": false, "searchable": false }, // opciones
                ]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('dmsusers.destroy', ['user' => '__user']) }}'.replace('__user', $(this).data('usuario'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
