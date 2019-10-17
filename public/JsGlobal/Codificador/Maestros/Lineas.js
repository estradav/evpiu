$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/LineasIndex",
        columns: [
            {data: 'tp', name: 'tp'},
            {data: 'cod', name: 'cod'},
            {data: 'name', name: 'name'},
            {data: 'abrev', name: 'abrev'},
            {data: 'coment', name: 'coment'},
            {data: 'update', name: 'update'},
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
        $('#saveBtn').val("create-linea");
        $('#linea_id').val('');
        $('#lineaForm').trigger("reset");
        $('#modelHeading').html("Crear Nueva Linea");
        $('#Lineamodal').modal('show');
    });

    $('body').on('click', '.editLinea', function () {

        var linea_id = $(this).data('id');
        $.get("/ProdCievCod" +'/' + linea_id +'/edit', function (data) {
            $('#modelHeading').html("Editar Linea");
            $('#saveBtn').val("edit-linea");
            $('#Lineamodal').modal('show');
            $('#linea_id').val(data.id);
            $('#cod').val(data.cod);
            $('#tipoproducto_id').val(data.tipoproducto_id);
            $('#name').val(data.name);
            $('#abreviatura').val(data.abreviatura);
            $('#coments').val(data.coments);
        })
    });


    $('#saveBtn').click(function (e) {
        e.preventDefault();
        //$(this).html('Guardando...');
        $.ajax({
            data: $('#lineaForm').serialize(),
            url: "/LineasPost",
            type: "POST",
            dataType: 'json',
            success: function (data) {

                $('#lineaForm').trigger("reset");
                $('#Lineamodal').modal('hide');
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

        var linea_id = $(this).data("id");
        if(confirm("¿Esta seguro de Eliminar?")) {
            $.ajax({
                type: "DELETE",
                url: "ProdCievCod" + '/' + linea_id,
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
