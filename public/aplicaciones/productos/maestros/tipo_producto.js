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
                    url: "/aplicaciones/productos/maestros/tipo_producto/" + id,
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado!',
                            text: "El registro ha sido eliminado.",
                        });
                        setTimeout(function() {
                            window.location.reload(true);
                        }, 5000);
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: data.responseText
                        })
                    }
                });
            }else  {
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
            url: '/aplicaciones/productos/maestros/tipo_producto/'+ id + '/edit',
            type: 'get',
            success: function (data) {
                document.getElementById("id").value = id;
                document.getElementById("cod").value = data.cod;
                document.getElementById("code").value = data.cod;
                document.getElementById("name").value = data.name;
                document.getElementById("comments").value = data.coments;
                document.getElementById("heading").innerHTML = "EDITAR "+ data.name;
                $('#modal').modal('show');
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                })
            }
        });
    });


    $("#form").validate({
        ignore: "",
        rules: {
            cod: {
                remote: {
                    url: '/aplicaciones/productos/maestros/tipo_producto/validar_codigo',
                    type: 'POST',
                    async: false,
                },
                required: true,
                minlength: 1,
                maxlength: 1,
                digits: false
            },
            name: "required",
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            console.log(form);
            $.ajax({
                url: "/aplicaciones/productos/maestros/tipo_producto",
                data: $('#form').serialize(),
                type: "POST",
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado!',
                        text: "El registro ha sido guardado.",
                    });
                    $('#Form').trigger("reset");
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
            return false;
        }
    });


    $(document).on('click', '#nuevo', function () {
        $('input').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        document.getElementById("cod").disabled = false;
        document.getElementById("heading").innerHTML = "Nuevo";
        $('#modal').modal('show');
        $('#form').trigger('reset');
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
});
