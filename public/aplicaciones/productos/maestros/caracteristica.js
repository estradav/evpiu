$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#table').dataTable({
        language: {
            url: '/Spanish.json'
        },
    });


    $(document).on('click', '#nuevo', function () {
        document.getElementById("cod").disabled = false;
        document.getElementById("heading").innerHTML = "Nuevo";
        $('input').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#sublinea').empty().append('<option value="">Seleccione... </option>');
        $('#form').trigger('reset');
        $('#modal').modal('show');
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
                    url: "/aplicaciones/productos/maestros/caracteristica/" + id,
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


    $('body').on('click', '.edit', function () {
        let id = this.id;

        $.ajax({
            url:  '/aplicaciones/productos/maestros/caracteristica/' + id + '/edit',
            type: 'get',
            success: function (data) {
                document.getElementById("cod").disabled = true;
                document.getElementById('code').value = data.cod;
                document.getElementById('linea').value = data.car_lineas_id;
                document.getElementById('id').value = data.id;
                document.getElementById('cod').value = data.cod;
                document.getElementById('name').value = data.name;
                document.getElementById('abrev').value = data.abreviatura;
                document.getElementById('coments').value = data.coments;
                document.getElementById('heading').innerHTML = "EDITAR "+ data.name;

                let linea_id = data.car_lineas_id;

                $.ajax({
                    url: '/aplicaciones/productos/maestros/caracteristica/listar_sublineas',
                    type: 'get',
                    data: {
                        linea_id:linea_id
                    },
                    success: function (data) {
                        $('#sublinea').empty();
                        for (let i = 0; i < data.length ; i++) {
                            $('#sublinea').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>')
                        }
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
                document.getElementById('sublinea').value = data.car_sublineas_id;
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
            linea: {
                select_check: true
            },
            sublinea: {
                select_check: true
            },
            cod: {
                remote: {
                    type: 'POST',
                    async: false,
                    data: {
                        linea: function () {
                            return $("#linea").val();
                        },
                        sublinea: function () {
                            return $("#sublinea").val();
                        },
                    }
                },
                required: true,
                maxlength: 2,
                minlength: 2
            },
            name: "required",
            abrev: "required",
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                url: "/aplicaciones/productos/maestros/caracteristica",
                type: "POST",
                data: $('#form').serialize(),
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


    $(document).on('change', '#linea', function () {
        let linea_id = this.value;
        $.ajax({
            url: '/aplicaciones/productos/maestros/caracteristica/listar_sublineas',
            type: 'get',
            data: {
                linea_id:linea_id
            },
            success: function (data) {
                $('#sublinea').empty();
                for (let i = 0; i < data.length ; i++) {
                    $('#sublinea').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>')
                }
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
