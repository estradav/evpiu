$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#table').dataTable({
        ajax: {
            url: '/aplicaciones/pedidos/bodega'
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: false},
            {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: true},
            {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: true},
            {data: 'cliente.RAZON_SOCIAL', name: 'cliente.RAZON_SOCIAL', orderable: false, searchable: true},
            {data: 'vendedor.name', name: 'vendedor.name', orderable: false, searchable: true},
            {data: 'cliente.PLAZO', name: 'cliente.PLAZO', orderable: false, searchable: false},
            {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
            {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
            {data: 'info_area.Bodega', name: 'info_area.Bodega', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
        ],
        language: {
            url: '/Spanish.json'
        },
        order: [
            [ 0, "asc" ]
        ],
        rowCallback: function (row, data, index) {
            if (data.Iva == 'Y') {
                $(row).find('td:eq(7)').html('<span class="badge badge-success">SI</span>');
            }
            else{
                $(row).find('td:eq(7)').html('<span class="badge badge-danger">NO</span>');
            }
            if(data.info_area.Bodega == 8){
                $(row).find('td:eq(8)').html('<span class="badge badge-success">Pendiente</span>');
            }

            if(data.info_area.Bodega == 9){
                $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado</span>');
            }
        }
    });


    $('#table_terminados').DataTable({
        ajax: {
            url:'/aplicaciones/pedidos/produccion/listar_terminados',
        },
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: true},
            {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: true},
            {data: 'Ped_MAX', name: 'Ped_MAX', orderable: false, searchable: true},
            {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: true},
            {data: 'cliente.RAZON_SOCIAL', name: 'cliente.RAZON_SOCIAL', orderable: false, searchable: true},
            {data: 'vendedor.name', name: 'vendedor.name', orderable: false, searchable: true},
            {data: 'cliente.PLAZO', name: 'cliente.PLAZO', orderable: false, searchable: false},
            {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
            {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
            {data: 'Estado', name: 'Estado', orderable: false, searchable: true},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

        ],
        language: {
            url: '/Spanish.json'
        },
        order: [
            [ 0, "desc" ]
        ],
        rowCallback: function (row, data, index) {
            if (data.Estado == 10) {
                $(row).find('td:eq(9)').html('<span class="badge badge-success">Finalizado</span>');
            }else{
                $(row).find('td:eq(9)').html('<span class="badge badge-danger">Error</span>');
            }
            if (data.Iva == 'Y') {
                $(row).find('td:eq(8)').html('<span class="badge badge-success">SI</span>');
            } else{
                $(row).find('td:eq(8)').html('<span class="badge badge-danger">NO</span>');
            }

            if (data.Ped_MAX){
                $(row).find('td:eq(2)').html('<span class="badge badge-success">'+ data.Ped_MAX +'</span>');
            }else{
                $(row).find('td:eq(2)').html('<span class="badge badge-danger">N/A</span>');
            }
        }
    });


    $(document).on('draw.dt', '#table', function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    $(document).on('click', '.opciones', function () {
        $('input').closest('.form-control').removeClass('is-invalid');
        $('select').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#form').trigger('reset');

        let id = this.id;
        document.getElementById('id').value = id;

        $('#opciones').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#opciones_title').html('Pedido #' + id)
    });


    $("#form").validate({
        ignore: "",
        rules: {
            estado: {
                select_check: true
            },
            descripcion: {
                required: true,
                minlength: 10,
                maxlength: 250
            }
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            let estado = document.getElementById('estado').value;

            if (estado == 10){
                Swal.fire({
                    title: '¿Finalizar pedido y subir a MAX?',
                    html: "<span class='badge badge-danger'>ESTA ACCION NO ES REVERSIBLE </span>",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Si, finalizar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            data: $('#form').serialize(),
                            url: "/aplicaciones/pedidos/bodega/actualizar_estado",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#opciones').modal('hide');
                                $('#table').DataTable().ajax.reload();
                                $('#table_terminados').DataTable().ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pedido Actualizado',
                                    text: data
                                });
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
            }else{
                $.ajax({
                    data: $('#form').serialize(),
                    url: "/aplicaciones/pedidos/bodega/actualizar_estado",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        $('#opciones').modal('hide');
                        $('#table').DataTable().ajax.reload();
                        $('#table_terminados').DataTable().ajax.reload();
                        toastr.success(data);
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
            return false;
        }
    });


    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
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
