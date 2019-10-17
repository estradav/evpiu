$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/SublineasIndex",
        columns: [
            {data: 'tp', name: 'tp'},
            {data: 'linea', name: 'linea'},
            {data: 'cod', name: 'cod'},
            {data: 'name', name: 'name',orderable: false, searchable: false},
            {data: 'coment', name: 'coment',orderable: false, searchable: false},
            {data: 'update', name: 'update'},
            {data: 'Opciones', name: 'Opciones', orderable: false, searchable: false},
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

    $('#CrearSubLineas').click(function () {
        $('#saveBtn').val("create-sublinea");
        $('#sublinea_id').val('');
        $('#sublineaForm').trigger("reset");
        $('#modelHeading').html("Crear Nueva Sublinea");
        $('#sublineamodal').modal('show');
    });

    $('body').on('click', '.editsublinea', function () {
        var sublinea_id = $(this).data('id');
        $.get("/ProdCievCodSublinea" +'/' + sublinea_id +'/edit', function (data) {
            $('#modelHeading').html("Editar Sublinea");
            $('#saveBtn').val("edit-sublinea");
            $('#sublineamodal').modal('show');
            $('#sublinea_id').val(data.id);
            $('#cod').val(data.cod);
            $('#tipoproductos_id').val(data.tipoproductos_id);
            $('#lineas_id').val(data.lineas_id);
            $('#name').val(data.name);
            $('#abreviatura').val(data.abreviatura);
            $('#coments').val(data.coments);
        })
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $.ajax({
            data: $('#sublineaForm').serialize(),
            url: "/SublineasPost",
            type: "POST",
            dataType: 'json',
            success: function (data) {
                $('#sublineaForm').trigger("reset");
                $('#sublineamodal').modal('hide');
                table.draw();
                toastr.success("Registro Guardado con Exito!");
            },
            error: function (data) {
                console.log('Error:', data);
                $('#saveBtn').html('Guardar Cambios');
            }
        });
    });

    $('body').on('click', '.deletesubLinea', function () {
        var sublinea_id = $(this).data("id");
        if(confirm("¿Esta seguro de Eliminar?")) {
            $.ajax({
                type: "DELETE",
                url: "/ProdCievCodSublinea" + '/' + sublinea_id,
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

    $('#tipoproductos_id').on('change', function () {
        var tipoproductos_id = $(this).val();
        if ($.trim(tipoproductos_id) != ''){
            $.get('getlineasp',{tipoproductos_id: tipoproductos_id}, function(getlineasp) {
                $('#lineas_id').empty();
                $('#lineas_id').append("<option value=''>Seleccione una Linea...</option>");
                $.each(getlineasp, function (index, value) {
                    $('#lineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
    });
});
