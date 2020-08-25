$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#table').dataTable({
        language: {
            url: '/Spanish.json'
        }
    });


    $(document).on('click', '#nuevo', function () {
        document.getElementById("cod").disabled = false;
        document.getElementById("heading").innerHTML = "NUEVA SUBLINEA";
        $('input').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#um_id').val('').trigger('change');
        $('#car_um_id').val('').trigger('change');
        $('#modal').modal('show');
        $('#form').trigger('reset');
    });


    $('.um_idSelect').select2({
        placeholder: "Seleccione...",
        required: true
    });


    $('.car_um_idSelect').select2({
        placeholder: "Seleccione...",
        required: true
    });


    $(document).on('click', '.unidad_medida', function () {
        let id =  this.id;
        $.ajax({
            url: "/aplicaciones/productos/maestros/sublinea/unidades_medida",
            type: "get",
            data: {
                id: id
            },
            success: function (data) {
                Swal.fire({
                    title: 'Unidades de Medida',
                    text: data,
                    icon: 'info',
                    confirmButtonText: 'Aceptar',
                    timer: 10000,
                })
            }
        });
    });


    $(document).on('click', '.carac_unidad_medida', function () {
        let id =  this.id;
        $.ajax({
            url: "/aplicaciones/productos/maestros/sublinea/caracteristicas_unidades_medida",
            type: "get",
            data: {
                id: id
            },
            success: function (data) {
                Swal.fire({
                    icon: 'info',
                    text: data,
                    title: 'Caracteristicas de Medidas',
                    confirmButtonText: 'Aceptar',
                    timer: 10000,
                })
            }
        });
    });


    $(document).on('click', '.delete', function () {
        let id = this.id;
        Swal.fire({
            title: '¿Esta seguro de Eliminar?',
            html: "¡Esta accion <b class='text-danger'>NO</b> se puede revertir!",
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
                    url: "/aplicaciones/productos/maestros/sublinea/" + id,
                    success: function () {
                        Swal.fire({
                            title: 'Eliminado!',
                            text: "El registro ha sido eliminado.",
                            icon: 'success',
                        });
                        setTimeout(function() {
                            window.location.reload(true);
                        }, 3000);
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: data.responseText
                        })
                    }
                });
            }else{
                result.dismiss === Swal.DismissReason.cancel
            }
        })
    });


    $(document).on('click', '.edit', function () {
        let id = this.id;

        document.getElementById("cod").disabled = true;
        $('input').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();


        $.ajax({
            url: '/aplicaciones/productos/maestros/sublinea/'+ id + '/edit',
            type: 'get',
            success: function (data) {
                console.log(data);
                document.getElementById("id").value = id;
                document.getElementById("linea").value = data.sublinea.lineas_id;
                document.getElementById("cod").value = data.sublinea.cod;
                document.getElementById("code").value = data.sublinea.cod;
                document.getElementById("hijo").value = data.sublinea.hijo;
                document.getElementById("name").value = data.sublinea.name;
                document.getElementById("abrev").value = data.sublinea.abreviatura;
                document.getElementById("coments").value = data.sublinea.coments;
                document.getElementById("heading").innerHTML = "EDITAR "+ data.sublinea.name;

                var medidas = [];
                var car_und_med = [];

                $.each(data.medida, function (index) {
                    medidas.push(index);
                });

                $.each(data.carmedida, function (index) {
                    car_und_med.push(index);
                });

                $("#um_id").val(medidas).trigger('change');
                $("#car_um_id").val(car_und_med).trigger('change');

                $('#modal').modal('show');
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    $("#form").validate({
        ignore: "",
        rules: {
            linea : {
                select_check: true
            },
            cod: {
                remote: {
                    url: '/aplicaciones/productos/maestros/sublinea/validar_codigo',
                    type: 'POST',
                    async: true,
                    data: {
                        linea: function () {
                            return $("#linea").val();
                        }
                    }
                },
                required: true,
                maxlength: 2,
                minlength: 2
            },
            name: "required",
            abrev: "required",
            um_id: {
                select_check: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            var umedidas = $("#um_id").val();
            var carmedidas = $("#car_um_id").val();

            const encabezado = {
                id: $('#id').val(),
                linea: $('#linea').val(),
                codigo: $('#cod').val(),
                hijo: $('#hijo').val(),
                name: $('#name').val(),
                abre: $('#abrev').val(),
                coments: $('#coments').val(),
            };

            $.ajax({
                url: "/aplicaciones/productos/maestros/sublinea",
                type: "POST",
                data: {
                    encabezado: encabezado,
                    umedidas: umedidas,
                    carmedidas: carmedidas
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado!',
                        text: "El registro ha sido guardado.",
                    });

                    $('#form').trigger("reset");
                    $('#modal').modal('hide');

                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data.responseText
                    });
                }
            });
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


    jQuery.validator.addMethod("select_check", function(value){
        return (value != '');
    }, "Por favor, seleciona una opcion.");
});
