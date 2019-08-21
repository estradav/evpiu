@extends('layouts.dashboard')

@section('page_title', 'Categorías')

@section('module_title', 'Categorías')

@section('subtitle', 'Este módulo gestiona todas las categorías de las publicaciones del blog de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('categories') }}
@stop

@section('content')
    @can('categories.create')
    <a href="{{ route('categories.create') }}" class="btn btn-sm btn-success" role="button">
        <i class="fas fa-plus-circle"></i> Crear categoría
    </a>
    @endcan

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered first">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Slug</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->created_at->format('d M Y h:ia') }}</td>
                                    <td>{{ $category->updated_at->format('d M Y h:ia') }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">
                                            <a href="{{ route('category', $category->slug) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            @can('categories.edit')
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-light edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('categories.destroy')
                                            <div class="btn btn-sm btn-outline-light delete" data-id="{{ $category->id }}">
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

    @can('categories.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar categoría</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta categoría?</p>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, eliminar esta categoría">
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
                    { "orderable": false, "searchable": true },
                    { "orderable": true, "searchable": false },
                    { "orderable": true, "searchable": false },
                    { "orderable": false, "searchable": false },
                ]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('categories.destroy', ['category' => '__category']) }}'.replace('__category', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
