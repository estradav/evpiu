$(document).ready(function(){
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/CaracteristicasIndex",
            columns: [
                {data: 'linea', name: 'linea'},
                {data: 'sublinea', name: 'sublinea'},
                {data: 'cod', name: 'cod'},
                {data: 'name', name: 'name'},
                {data: 'coment', name: 'coment'},
                {data: 'upt', name: 'upt'},
                {data: 'Opciones', name: 'Opciones', orderable: false, searchable: false},
            ],
            language: {
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

        $('#CrearCaracteristica').click(function () {
            $('#saveBtn').val("create-caracteristica");
            $('#caracteristica_id').val('');
            $('#caracteristicaForm').trigger("reset");
            $('#modelHeading').html("Crear Nueva Caracteristica");
            $('#caracteristicamodal').modal('show');
        });

        $('body').on('click', '.editcaracteristica', function () {

            var caracteristica_id = $(this).data('id');
            $.get("/ProdCievCodCaracteristica" +'/' + caracteristica_id +'/edit', function (data) {
                $('#modelHeading').html("Editar Caracteristica");
                $('#saveBtn').val("edit-caracteristica");
                $('#caracteristicamodal').modal('show');
                $('#caracteristica_id').val(data.id);
                $('#cod').val(data.cod);
                $('#car_lineas_id').val(data.car_lineas_id);
                $('#car_sublineas_id').val(data.car_sublineas_id);
                $('#name').val(data.name);
                $('#abreviatura').val(data.abreviatura);
                $('#coments').val(data.coments);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            //$(this).html('Guardando...');
            $.ajax({
                data: $('#caracteristicaForm').serialize(),
                url: "/CaracteristicasPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#caracteristicaForm').trigger("reset");
                    $('#caracteristicamodal').modal('hide');
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

        $('body').on('click', '.deletecaracteristica', function () {

            var caracteristica_id = $(this).data("id");
            if(confirm("¿Esta seguro de Eliminar?")) {
                $.ajax({
                    type: "DELETE",
                    url: "/ProdCievCodCaracteristica" + '/' + caracteristica_id,
                    success: function (data) {
                        table.draw();
                        toastr.success("Registro eliminado con exito");
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        toastr.danger("Error al eliminar el registro");
                    }
                });
            }
        });
    });

    $('#car_lineas_id').on('change', function () {
        var lineas_id = $(this).val();
        if ($.trim(lineas_id) != ''){
            $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                $('#car_sublineas_id').empty();
                $('#car_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                $.each(getsublineas, function (index, value) {
                    $('#car_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
    });
});
