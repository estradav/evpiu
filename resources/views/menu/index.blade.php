@extends('layouts.dashboard')

@section('page_title', 'Menus')

@section('module_title', 'Menus')

@section('subtitle', 'Este módulo sirve para gestionar los menus y sus elementos que permiten acceder a diferentes secciones de la plataforma.')

@section('breadcrumbs')
{{ Breadcrumbs::render('menu_builder') }}
@stop

@section('content')
    @can('menus.create')
    <a href="{{ route('menus.create') }}" class="btn btn-sm btn-success" role="button">
        <i class="fas fa-plus-circle"></i> Crear menu
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menus as $menu)
                                <tr>
                                    <td>{{ $menu->name }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">
                                            @can('menus.items.list')
                                            <a href="{{ route('menus.builder', ['menu' => $menu->id]) }}" class="btn btn-sm btn-outline-light">
                                                <i class="far fa-list-alt"></i> Estructura
                                            </a>
                                            @endcan
                                            @can('menus.edit')
                                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-sm btn-outline-light edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('menus.destroy')
                                            <div class="btn btn-sm btn-outline-light delete" data-id="{{ $menu->id }}">
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

    @can('menus.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este menu?</p>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, Eliminar este Menu">
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
                "columnDefs": [{"targets": -1, "searchable":  false, "orderable": false}]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('menus.destroy', ['menu' => '__menu']) }}'.replace('__menu', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
