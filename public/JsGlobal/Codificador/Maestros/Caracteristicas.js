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
            $('#saveBtn').removeAttr('formnovalidate','');
            $('#caracteristica_id').val('');
            $('#caracteristicaForm').trigger("reset");
            $('#modelHeading').html("Nuevo");
            $('#caracteristicamodal').modal('show');
            $('#car_sublineas_id').empty();

            document.getElementById("cod").readOnly = false;
        });

        $('body').on('click', '.editcaracteristica', function () {
            $("#caracteristicaForm").validate().resetForm();
            $('#saveBtn').attr('formnovalidate','');
            var caracteristica_id = $(this).data('id');
            $.get("/ProdCievCodCaracteristica" +'/' + caracteristica_id +'/edit', function (data) {
                $('#car_lineas_id').val(data.car_lineas_id);
                $('#modelHeading').html("Editar");
                $('#saveBtn').val("edit-caracteristica");
                $('#caracteristica_id').val(data.id);
                $('#cod').val(data.cod);
                $('#name').val(data.name);
                $('#abreviatura').val(data.abreviatura);
                $('#coments').val(data.coments);

                document.getElementById("cod").readOnly = true;

                var lineas_id = data.car_lineas_id;
                $('#car_sublineas_id').empty();
                if ($.trim(lineas_id) != ''){
                    $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                        $('#car_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                        $.each(getsublineas, function (index, value) {
                            $('#car_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                        });
                        $('#car_sublineas_id').val(data.car_sublineas_id);
                    });
                }
                $('#caracteristicamodal').modal('show');
            });
        });

        jQuery.extend(jQuery.validator.messages, {
            required: "Este campo es obligatorio.",
            remote: "Este codigo ya existe.",
            email: "Por favor, escribe una dirección de correo válida",
            url: "Por favor, escribe una URL válida.",
            date: "Por favor, escribe una fecha válida.",
            dateISO: "Por favor, escribe una fecha (ISO) válida.",
            number: "Por favor, escribe un número entero válido.",
            digits: "Por favor, escribe sólo dígitos.",
            creditcard: "Por favor, escribe un número de tarjeta válido.",
            equalTo: "Por favor, escribe el mismo valor de nuevo.",
            accept: "Por favor, escribe un valor con una extensión aceptada.",
            maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
            minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
            rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
            range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
            max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
            min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
            selectcheck: "Por favor seleccione una opcion!"
        });

        jQuery.validator.addMethod("selectcheck", function(value){
            return (value != '');
        }, "Por favor, seleciona una opcion.");

        $("#caracteristicaForm").validate({
            ignore: "",
            rules: {
                car_lineas_id: {
                    selectcheck: true
                },
                car_sublineas_id: {
                    selectcheck: true
                },
                cod: {
                    remote: {
                        url: '/GetUniqueCodCaracteristics',
                        type: 'POST',
                        async: false,
                        data: {
                            linea: function () {
                                return $("#car_lineas_id").val();
                            },
                            sublinea: function () {
                                return $("#car_sublineas_id").val();
                            },
                        }
                    },
                    required: true,
                    maxlength: 2,
                    minlength: 2
                },
                name: "required",
                abreviatura: "required",
                coments: "required"
            },
            highlight: function (element) {
                // Only validation controls
                $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function (element) {
                // Only validation controls
                $(element).closest('.form-control').removeClass('is-invalid');
            },
            submitHandler: function (form) {
                $(this).html('Guardando...');
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
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Guardar Cambios');
                    }
                });
            }
        });

        $('body').on('click', '.deletecaracteristica', function () {
            var caracteristica_id = $(this).data("id");
            Swal.fire({
                title: '¿Esta seguro de Eliminar?',
                text: "¡Esta accion no se puede revertir!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "DELETE",
                        url: "/ProdCievCodCaracteristica" + '/' + caracteristica_id,
                        success: function (data) {
                            Swal.fire({
                                title: 'Eliminado!',
                                text: "El registro ha sido eliminado.",
                                icon: 'success',
                            });
                            table.draw();
                        },
                        error: function (data) {
                            Swal.fire(
                                'Error al eliminar!',
                                'Hubo un error al eliminar. Verifique que este registro no tenga Sublineas relacionadas, si el problema persiste contacte con el area de sistemas',
                                'error'
                            )
                        }
                    });
                }else {
                    result.dismiss === Swal.DismissReason.cancel
                }
            })
        });

        $('#car_lineas_id').on('change', function () {
            var lineas_id = $(this).val();
            $('#car_sublineas_id').empty();
            if ($.trim(lineas_id) != ''){
                $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                    $('#car_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                    $.each(getsublineas, function (index, value) {
                        $('#car_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                    })
                });
            }
        });

        $('#caracteristicamodal').on('show.bs.modal', function (event) {
            $('#saveBtn').html('Guardar');
            $('.form-control').removeClass('is-invalid');
            $('.error').remove();
        });


    });
});


