@extends('layouts.dashboard')

@section('page_title', 'Publicaciones')

@section('module_title', 'Publicaciones')

@section('subtitle', 'Este módulo gestiona todas las publicaciones del blog de la aplicación.')

@section('breadcrumbs')
{{ Breadcrumbs::render('posts') }}
@stop

@section('content')
    @can('posts.create')
    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-success" role="button">
        <i class="fas fa-plus-circle"></i> Crear publicación
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
                                    <th>Título</th>
                                    <th>Slug</th>
                                    <th>Estado</th>
                                    <th>Posteado por</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->slug }}</td>
                                    <td>
                                        @if ($post->status == 1)
                                        <span class="badge badge-success"><i class="fas fa-check"></i> Publicado</span>
                                        @else
                                        <span class="badge badge-brand"><i class="fas fa-exclamation-triangle"></i> Sin publicar</span>
                                        @endif
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->created_at->format('d M Y h:ia') }}</td>
                                    <td>{{ $post->updated_at->format('d M Y h:ia') }}</td>
                                    <td>
                                        <div class="btn-group ml-auto float-right">
                                            <a href="{{ route('post', $post->slug) }}" class="btn btn-sm btn-outline-light">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                            @can('posts.edit')
                                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-light edit">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            @endcan
                                            @can('posts.destroy')
                                            <div class="btn btn-sm btn-outline-light delete" data-id="{{ $post->id }}">
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

    @can('posts.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar publicación</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar esta publicación?</p>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, eliminar esta publicación">
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
                    { "orderable": false, "searchable": false },
                    { "orderable": true, "searchable": true },
                    { "orderable": true, "searchable": false },
                    { "orderable": true, "searchable": false },
                    { "orderable": false, "searchable": false },
                ]
            });
        });

        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('posts.destroy', ['post' => '__post']) }}'.replace('__post', $(this).data('id'));

            $('#delete_modal').modal('show');
        });
    </script>
@endpush
