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
            ajax: "/SublineasIndex",
            columns: [
                {data: 'DT_Row_Index', name: 'DT_Row_Index'},
                {data: 'linea', name: 'linea'},
                {data: 'cod', name: 'cod'},
                {data: 'name', name: 'name',orderable: false, searchable: false},
                {data: 'coment', name: 'coment',orderable: false, searchable: false},
                {data: 'Medidas', name: 'Medidas',orderable: false, searchable: false},
                {data: 'Car_Medidas', name: 'Car_Medidas',orderable: false, searchable: false},
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




        $('#CrearSubLineas').click(function () {
            $('#saveBtn').val("create-sublinea");
            $('#sublinea_id').val('');
            $('#sublineaForm').trigger("reset");
            $('#modelHeading').html("Nuevo");
            $('#sublineamodal').modal('show');
            document.getElementById("cod").readOnly = false;
        });


        $("#sublineaForm").validate({
            ignore: "",
            rules: {
                lineas_id : {
                    selectcheck: true
                },
                cod: {
                    remote: {
                        url: '/GetUniqueCodSubLines',
                        type: 'POST',
                        async: true,
                        data: {
                            linea: function () {
                                return $("#lineas_id").val();
                            }
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
                var umedidas = $("#um_id").val();
                var carmedidas = $("#car_um_id").val();
                console.log(carmedidas, umedidas);
                var encabezado = [];
                var Inputs = {
                    id: $('#sublinea_id').val(),
                    linea: $('#lineas_id').val(),
                    cod: $('#cod').val(),
                    hijo: $('#hijo').val(),
                    name: $('#name').val(),
                    abre: $('#abreviatura').val(),
                    coments: $('#coments').val(),
                };
                encabezado.push(Inputs);

                $.ajax({
                    data: {
                        encabezado, umedidas, carmedidas
                    },
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
                        $('#saveBtn').html('Guardar Cambios');
                    }
                });
            }
        });


        $('body').on('click', '.editsublinea', function () {
            document.getElementById("cod").readOnly = true;
            var sublinea_id = $(this).data('id');
            $('#cod').attr('formnovalidate',true);
            $.get("/ProdCievCodSublinea" +'/' + sublinea_id +'/edit', function (data) {
                $('#modelHeading').html("Editar");
                $('#saveBtn').val("edit-sublinea");
                $('#sublineamodal').modal('show');
                $('#sublinea_id').val(data.sublinea.id);
                $('#cod').val(data.sublinea.cod);
                $('#lineas_id').val(data.sublinea.lineas_id);
                $('#name').val(data.sublinea.name);
                $('#abreviatura').val(data.sublinea.abreviatura);
                $('#coments').val(data.sublinea.coments);

                console.log(data.medida);
                $.each(data.medida, function (index, value) {
                    $('#um_id').append('<option value="'+ index+'" selected>'+value+'</option>');
                });
                $.each(data.carmedida, function (index, value) {
                    $('#car_um_id').append('<option value="'+ index+'" selected>'+value+'</option>');
                });
            });

            $("#sublineaForm").validate({
                ignore: "",
                rules: {
                    lineas_id : {
                        selectcheck: true
                    },
                    cod: {
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
                    var umedidas = $("#um_id").val();
                    var carmedidas = $("#car_um_id").val();

                    var encabezado = [];
                    var Inputs = {
                        id: $('#sublinea_id').val(),
                        linea: $('#lineas_id').val(),
                        cod: $('#cod').val(),
                        hijo: $('#hijo').val(),
                        name: $('#name').val(),
                        abre: $('#abreviatura').val(),
                        coments: $('#coments').val(),
                    };
                    encabezado.push(Inputs);

                    $.ajax({
                        data: {
                            encabezado, umedidas, carmedidas
                        },
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
                            $('#saveBtn').html('Guardar Cambios');
                        }
                    });
                }
            });
        });

        $('body').on('click', '.deletesubLinea', function () {
            var sublinea_id = $(this).data("id");
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
                        url: "/ProdCievCodSublinea" + '/' + sublinea_id,
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
                                'Hubo un error al eliminar. Verifique que este registro no tenga registros relacionadas, si el problema persiste contacte con el area de sistemas',
                                'error'
                            )
                        }
                    });
                }else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Cancelado',
                        'El registro NO fue eliminado :)',
                        'error'
                    )
                }
            })
        });

        $('#sublineamodal').on('show.bs.modal', function (event) {
            $('#saveBtn').html('Guardar');
            $('.form-control').removeClass('is-invalid');
            $("#sublineaForm").validate().resetForm();
            $('#saveBtn').removeAttr('formnovalidate','');
            $('.error').remove();
            $('#um_id').html('');
            $('#car_um_id').html('');
        });

        $('.um_idSelect').select2({
            placeholder: "Seleccione...",
            ajax: {
                url: 'getALLUnidadMedidas',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            required: true
        });

        $('.car_um_idSelect').select2({
            placeholder: "Seleccione...",
            ajax: {
                url: 'getALLCaracteristicasUnidadMedidas',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            required: true
        });

        $('tbody').on( 'click', '.showMed', function () {
            var id =  this.id;
            $.ajax({
                url: "/getUnidadMedidas",
                type: "get",
                data: {
                    Sub_id: id
                },
                success: function (data) {
                    Swal.fire({
                        title: 'Unidades de Medida',
                        text: data,
                        icon: 'info',
                        confirmButtonText: 'Aceptar',
                        timer: 10000,
                        showClass: {
                            popup: 'animated bounceIn'
                        },
                        hideClass: {
                            popup: 'animated zoomOut'
                        }
                    })
                }
            });
        });

        $('tbody').on( 'click', '.showCarMed', function () {
            var id =  this.id;
            $.ajax({
                url: "/getCarUnidadMedidas",
                type: "get",
                data: {
                    Sub_id: id
                },
                success: function (data) {
                    Swal.fire({
                        title: 'Caracteristicas de Medidas',
                        text: data,
                        icon: 'info',
                        confirmButtonText: 'Aceptar',
                        timer: 10000,
                        showClass: {
                            popup: 'animated bounceIn'
                        },
                        hideClass: {
                            popup: 'animated zoomOut'
                        }
                    })
                }
            });
        });

    });
});



