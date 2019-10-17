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
            ajax: "/MaterialesIndex",
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

        $('#CrearMaterial').click(function () {
            $('#saveBtn').val("create-material");
            $('#material_id').val('');
            $('#materialForm').trigger("reset");
            $('#modelHeading').html("Crear Nuevo Material");
            $('#materialmodal').modal('show');
        });

        $('body').on('click', '.editmaterial', function () {

            var material_id = $(this).data('id');
            $.get("/ProdCievCodMaterial" +'/' + material_id +'/edit', function (data) {
                $('#modelHeading').html("Editar Material");
                $('#saveBtn').val("edit-Material");
                $('#materialmodal').modal('show');
                $('#material_id').val(data.id);
                $('#cod').val(data.cod);
                $('#mat_lineas_id').val(data.mat_lineas_id);
                $('#mat_sublineas_id').val(data.mat_sublineas_id);
                $('#name').val(data.name);
                $('#abreviatura').val(data.abreviatura);
                $('#coments').val(data.coments);
            })
        });


        $('#saveBtn').click(function (e) {
            e.preventDefault();
            //$(this).html('Guardando...');
            $.ajax({
                data: $('#materialForm').serialize(),
                url: "/MaterialesPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#materialForm').trigger("reset");
                    $('#materialmodal').modal('hide');
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

        $('body').on('click', '.deletematerial', function () {

            var material_id = $(this).data("id");
            if(confirm("¿Esta seguro de Eliminar?")) {
                $.ajax({
                    type: "DELETE",
                    url: "/ProdCievCodMaterial" + '/' + material_id,
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

    $('#mat_lineas_id').on('change', function () {
        var lineas_id = $(this).val();
        if ($.trim(lineas_id) != ''){
            $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                $('#mat_sublineas_id').empty();
                $('#mat_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                $.each(getsublineas, function (index, value) {
                    $('#mat_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
    });
});
