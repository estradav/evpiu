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
            ajax: "/MedidasIndex",
            columns: [
                {data: 'linea', name: 'linea'},
                {data: 'sublinea', name: 'sublinea'},
                {data: 'cod', name: 'cod'},
                {data: 'name', name: 'name'},
                {data: 'denm', name: 'denm'},
                {data: 'int', name: 'int'},
                {data: 'ext', name: 'ext'},
                {data: 'ld1', name: 'ld1'},
                {data: 'ld2', name: 'ld2'},
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

        $('#CrearMedida').click(function () {
            $('#saveBtn').val("create-medida");
            $('#medida_id').val('');
            $('#medidaForm').trigger("reset");
            $('#modelHeading').html("Crear Nueva Medida");
            $('#medidamodal').modal('show');
        });

        $('body').on('click', '.editmedida', function () {

            var medida_id = $(this).data('id');
            $.get("/ProdCievCodMedida" +'/' + medida_id +'/edit', function (data) {
                $('#modelHeading').html("Editar Medida");
                $('#saveBtn').val("edit-Medida");
                $('#medidamodal').modal('show');
                $('#medida_id').val(data.id);
                $('#cod').val(data.cod);
                $('#interior').val(data.interior);
                $('#exterior').val(data.exterior);
                $('#lado_1').val(data.lado_1);
                $('#lado_2').val(data.lado_2);
                $('#denominacion').val(data.denominacion);
                $('#largo').val(data.largo);
                $('#med_lineas_id').val(data.med_lineas_id);
                $('#med_sublineas_id').val(data.med_sublineas_id);
                $('#name').val(data.name);
                $('#coments').val(data.coments);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $.ajax({
                data: $('#medidaForm').serialize(),
                url: "/MedidasPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#medidaForm').trigger("reset");
                    $('#medidamodal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
        });

        $('body').on('click', '.deletemedida', function () {

            var medida_id = $(this).data("id");
            if(confirm("¿Esta seguro de Eliminar?")) {
                $.ajax({
                    type: "DELETE",
                    url: "/ProdCievCodMedida" + '/' + medida_id,
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

    $('#med_lineas_id').on('change', function () {
        var lineas_id = $(this).val();
        if ($.trim(lineas_id) != ''){
            $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                $('#med_sublineas_id').empty();
                $('#med_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                $.each(getsublineas, function (index, value) {
                    $('#med_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
    });
});
