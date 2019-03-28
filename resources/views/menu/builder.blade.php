@extends('layouts.dashboard')

@section('page_title')
Menu ({{ $menu->name }})
@stop

@section('module_title', 'Menus')

@section('subtitle', 'Este módulo sirve para gestionar los menus y sus elementos que permiten acceder a diferentes secciones de la plataforma.')

@section('breadcrumbs')
{{ Breadcrumbs::render('menu_structure', $menu) }}
@stop

@section('content')
    @can('menus.items.create')
    <button type="button" class="btn btn-sm btn-success add_item">
        <i class="fas fa-plus-circle"></i> Crear item
    </button>
    @endcan

    @can('menus.items.list')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <section class="card card-fluid">
                <h5 class="card-header drag-handle">Estructura del Menu ({{ $menu->name }})</h5>
                <div class="dd" id="nestable">
                    {!! evpiu_menu($menu->name, 'menu.items') !!}
                </div>
            </section>
        </div>
    </div>
    @else
    <div class="alert alert-danger" role="alert">
        No tienes permisos para visualizar la estructura de este menú.
    </div>
    @endcan

    @can('menus.items.destroy')
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-trash"></i> Eliminar item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este item del menu?</p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('menus.item.destroy', ['menu' => $menu->id, 'id' => '__id']) }}"
                          id="delete_form"
                          method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger delete-confirm"
                               value="Sí, Eliminar este Item del Menu">
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endcan

    @if(auth()->user()->can('menus.items.create') || auth()->user()->can('menus.items.edit'))
    <div class="modal modal-info fade" tabindex="-1" id="menu_item_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="m_hd_add" class="modal-title hidden"><i class="fas fa-plus-circle"></i> Crear item</h4>
                    <h4 id="m_hd_edit" class="modal-title hidden"><i class="fas fa-edit"></i> Editar item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="m_form" method="POST"
                      data-action-add="{{ route('menus.item.add', ['menu' => $menu->id]) }}"
                      data-action-update="{{ route('menus.item.update', ['menu' => $menu->id]) }}">

                    <input id="m_form_method" type="hidden" name="_method" value="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="name">Nombre del item</label>
                        <input type="text" class="form-control" id="m_title" name="title" placeholder="Nombre"><br>
                        <label for="type">Tipo de link</label>
                        <select id="m_link_type" class="form-control" name="type">
                            <option value="url" selected="selected">Ruta estática</option>
                            <option value="route">Ruta dinámica</option>
                        </select><br>
                        <div id="m_url_type">
                            <label for="url">Ruta estática del item</label>
                            <input type="text" class="form-control" id="m_url" name="url" placeholder="URL"><br>
                        </div>
                        <div id="m_route_type">
                            <label for="route">Ruta dinámica del item</label>
                            <input type="text" class="form-control" id="m_route" name="route" placeholder="Ruta"><br>
                        </div>
                        <label for="icon_class">Icono (Usar <a href="https://fontawesome.com/icons" target="_blank">Font Awesome Free</a>)</label>
                        <input type="text" class="form-control" id="m_icon_class" name="icon_class"
                               placeholder="Icono"><br>
                        <label for="target">Abrir como</label>
                        <select id="m_target" class="form-control" name="target">
                            <option value="_self" selected="selected">Misma pestaña</option>
                            <option value="_blank">Nueva pestaña</option>
                        </select>
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="id" id="m_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-primary delete-confirm__" value="Actualizar">
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    @endif
@stop

@can('menus.items.list')
@push('javascript')
    @can('menus.items.edit')
    <script src="{{ asset('vendor/nestable/jquery.nestable.js') }}"></script>
    @endcan
    <script>
        $(document).ready(function () {
            @can('menus.items.edit')
            $('.dd').nestable({/* config options */});
            @endcan


            /**
             * Set Variables
             */
            var $m_modal       = $('#menu_item_modal'),
                $m_hd_add      = $('#m_hd_add').hide().removeClass('hidden'),
                $m_hd_edit     = $('#m_hd_edit').hide().removeClass('hidden'),
                $m_form        = $('#m_form'),
                $m_form_method = $('#m_form_method'),
                $m_title       = $('#m_title'),
                $m_url_type    = $('#m_url_type'),
                $m_url         = $('#m_url'),
                $m_link_type   = $('#m_link_type'),
                $m_route_type  = $('#m_route_type'),
                $m_route       = $('#m_route'),
                $m_icon_class  = $('#m_icon_class'),
                $m_target      = $('#m_target'),
                $m_id          = $('#m_id');

            /**
             * Add Menu
             */
            $('.add_item').click(function() {
                $m_form.trigger('reset');
                $m_form.find("input[type=submit]").val('Crear');
                $m_modal.modal('show', {data: null});
            });

            /**
             * Edit Menu
             */
            $('.item_actions').on('click', '.edit', function (e) {
                $m_form.find("input[type=submit]").val('Actualizar');
                $m_modal.modal('show', {data: $(e.currentTarget)});
            });

            /**
             * Menu Modal is Open
             */
            $m_modal.on('show.bs.modal', function(e, data) {
                var _adding      = e.relatedTarget.data ? false : true;

                if (_adding) {
                    $m_form.attr('action', $m_form.data('action-add'));
                    $m_form_method.val('POST');
                    $m_hd_add.show();
                    $m_hd_edit.hide();
                    $m_target.val('_self').change();
                    $m_link_type.val('url').change();
                    $m_url.val('');
                    $m_icon_class.val('');

                } else {
                    $m_form.attr('action', $m_form.data('action-update'));
                    $m_form_method.val('PUT');
                    $m_hd_add.hide();
                    $m_hd_edit.show();

                    var _src = e.relatedTarget.data, // the source
                        id   = _src.data('id');

                    $m_title.val(_src.data('title'));
                    $m_url.val(_src.data('url'));
                    $m_route.val(_src.data('route'));
                    $m_icon_class.val(_src.data('icon_class'));
                    $m_id.val(id);

                    if (_src.data('target') == '_self') {
                        $m_target.val('_self').change();
                    } else if (_src.data('target') == '_blank') {
                        $m_target.find("option[value='_self']").removeAttr('selected');
                        $m_target.find("option[value='_blank']").attr('selected', 'selected');
                        $m_target.val('_blank');
                    }
                    if (_src.data('route') != "") {
                        $m_link_type.val('route').change();
                        $m_url_type.hide();
                    } else {
                        $m_link_type.val('url').change();
                        $m_route_type.hide();
                    }
                    if ($m_link_type.val() == 'route') {
                        $m_url_type.hide();
                        $m_route_type.show();
                    } else {
                        $m_route_type.hide();
                        $m_url_type.show();
                    }
                }
            });


            /**
             * Toggle Form Menu Type
             */
            $m_link_type.on('change', function (e) {
                if ($m_link_type.val() == 'route') {
                    $m_url_type.hide();
                    $m_route_type.show();
                } else {
                    $m_url_type.show();
                    $m_route_type.hide();
                }
            });


            /**
             * Delete menu item
             */
            $('.item_actions').on('click', '.delete', function (e) {
                id = $(e.currentTarget).data('id');
                $('#delete_form')[0].action = $('#delete_form')[0].action.replace("__id",id);
                $('#delete_modal').modal('show');
            });


            /**
             * Reorder items
             */
            $('.dd').on('change', function (e) {
                $.post('{{ route('menus.order',['menu' => $menu->id]) }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    toastr.success("El orden del menú se ha actualizado con éxito.");
                });
            });
        });
    </script>
@endpush
@endcan
