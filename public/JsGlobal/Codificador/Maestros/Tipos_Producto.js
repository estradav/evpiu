$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/TiposProductoIndex",
        columns: [
            {data: 'cod', name: 'cod'},
            {data: 'name', name: 'name'},
            {data: 'coments', name: 'coments'},
            {data: 'created_at', name: 'updated_at'},
            {data: 'updated_at', name: 'updated_at'},
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

    $('#Crear_tipo_producto').on('click',function () {
        $('#saveBtn').val("create-tipoproducto");
        $('#tipoproducto_id').val('');
        $('#tipoproductoForm').trigger("reset");
        $('#modelHeading').html("NUEVO TIPO DE PRODUCTO");
        $('#tipoproductomodal').modal('show');
        document.getElementById("cod").readOnly = false;
    });

    var tipoproducto_id;

    $('body').on('click', '.editTipoProducto', function () {
        document.getElementById("cod").readOnly = true;
        tipoproducto_id = $(this).data('id');
        $.get("/ProdCievCodTipoProducto" +'/' + tipoproducto_id +'/edit', function (data) {
            $('#edit_modelHeading').html("EDITAR "+ data.name);
            $('#saveBtn').val("edit-tipoproducto");
            $('#edit_tipoproducto_modal').modal('show');
            $('#edit_cod').val(data.cod);
            $('#edit_name').val(data.name);
            $('#edit_coments').val(data.coments);
        })
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

    $("#tipoproductoForm").validate({
        ignore: "",
        rules: {
            cod: {
                remote: {
                    url: '/GetUniqueCod',
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
            // Only validation controls
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
            //$('#saveBtn').html('Reintentar');
        },
        unhighlight: function (element) {
            // Only validation controls
            $(element).closest('.form-control').removeClass('is-invalid');
        },

        submitHandler: function (form) {
            $(this).html('Guardando...');
            //e.preventDefault();
            $.ajax({
                data: $('#tipoproductoForm').serialize(),
                url: "/TiposProductoPost",
                type: "POST",
                dataType: 'json',
                success: function () {
                    $('#tipoproductoForm').trigger("reset");
                    $('#tipoproductomodal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                    //   $(this).html('Crear');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
            return false;
        }
    });


    $("#edit_tipo_producto_Form").validate({
        ignore: "",
        rules: {
            edit_name: "required",
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
            var form_data = $('#edit_tipo_producto_Form').serializeArray();
            var id = {
                name: 'id',
                value:  tipoproducto_id
            };
            var username = {
                name: 'user',
                data: Username
            };

            form_data.push(id);
            form_data.push(username);

            $.ajax({
                url: '/types_products_update',
                type: 'post',
                dataType: 'json',
                data: form_data,
                success: function () {
                    $('#edit_tipo_producto_Form').trigger("reset");
                    $('#edit_tipoproducto_modal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
            return false;
        }
    });

    $('body').on('click', '.deleteTipoProducto', function () {
        var tipoproducto_id = $(this).data("id");
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
                    url: "ProdCievCodTipoProducto" + '/' + tipoproducto_id,
                    success: function (data) {
                        table.draw();
                        Swal.fire({
                            title: 'Eliminado!',
                            text: "El registro ha sido eliminado.",
                            icon: 'success',

                        })
                    },
                    error: function (data) {
                        Swal.fire(
                            'Error al eliminar!',
                            'Hubo un error al eliminar. Verifique que este registro no tenga lineas relacionadas, si el problema persiste contacte con el area de sistemas',
                            'error'
                        )
                    }
                });
            }else  {
                result.dismiss === Swal.DismissReason.cancel
            }
        })

    });

    $('#tipoproductomodal').on('hide.bs.modal', function (event) {
        $('#saveBtn').html('Guardar');
        $('.form-control').removeClass('is-invalid');
        $('.error').remove();
    });
});

