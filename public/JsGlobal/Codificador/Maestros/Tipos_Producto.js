$(document).ready(function () {
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/TiposProductoIndex",
            columns: [
                {data: 'cod', name: 'cod'},
                {data: 'name', name: 'name'},
                {data: 'coments', name: 'coments'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
            ],
            language: {
                // traduccion de datatables
                processing: "Procesando...",
                search: "Buscar&nbsp;:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún registro disponible en esta tabla :C",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultimo"
                },
                aria: {
                    sortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $('#CrearLineas').click(function () {
            $('#saveBtn').val("create-tipoproducto");
            $('#tipoproducto_id').val('');
            $('#tipoproductoForm').trigger("reset");
            $('#modelHeading').html("Crear Nuevo");
            $('#tipoproductomodal').modal('show');
        });

        $('body').on('click', '.editLinea', function () {

            var tipoproducto_id = $(this).data('id');
            $.get("/ProdCievCodTipoProducto" +'/' + tipoproducto_id +'/edit', function (data) {
                $('#modelHeading').html("Editar Linea");
                $('#saveBtn').val("edit-tipoproducto");
                $('#tipoproductomodal').modal('show');
                $('#tipoproducto_id').val(data.id);
                $('#cod').val(data.cod);
                $('#name').val(data.name);
                $('#coments').val(data.coments);
            })
        });


        $('#saveBtn').click(function (e) {
            e.preventDefault();
            //$(this).html('Guardando...');
            $.ajax({
                data: $('#tipoproductoForm').serialize(),
                url: "/TiposProductoPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#tipoproductoForm').trigger("reset");
                    $('#tipoproductomodal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                    //   $(this).html('Crear');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
        });

        $('body').on('click', '.deleteLinea', function () {

            var tipoproducto_id = $(this).data("id");
            if(confirm("¿Esta seguro de Eliminar?")) {
                $.ajax({
                    type: "DELETE",
                    url: "ProdCievCodTipoProducto" + '/' + tipoproducto_id,
                    success: function (data) {
                        table.draw();
                        toastr.success("Registro Eliminado con exito");
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        toastr.danger("Error al eliminar el registro");
                    }
                });
            }
        });
    });
});
