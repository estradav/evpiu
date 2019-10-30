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
            {data: 'tp', name: 'tp'},
            {data: 'linea', name: 'linea'},
            {data: 'cod', name: 'cod'},
            {data: 'name', name: 'name',orderable: false, searchable: false},
            {data: 'coment', name: 'coment',orderable: false, searchable: false},
            {data: 'update', name: 'update'},
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

    $('#CrearSubLineas').click(function () {
        $('#saveBtn').val("create-sublinea");
        $('#sublinea_id').val('');
        $('#sublineaForm').trigger("reset");
        $('#modelHeading').html("Nuevo");
        $('#sublineamodal').modal('show');
        document.getElementById("cod").readOnly = false;
    });

    $('body').on('click', '.editsublinea', function () {
        var sublinea_id = $(this).data('id');
        $.get("/ProdCievCodSublinea" +'/' + sublinea_id +'/edit', function (data) {
            $('#modelHeading').html("Editar");
            $('#saveBtn').val("edit-sublinea");
            $('#sublineamodal').modal('show');
            $('#sublinea_id').val(data.id);
            $('#cod').val(data.cod);
            $('#tipoproductos_id').val(data.tipoproductos_id);
            $('#lineas_id').val(data.lineas_id);
            $('#name').val(data.name);
            $('#abreviatura').val(data.abreviatura);
            $('#coments').val(data.coments);
            document.getElementById("cod").readOnly = true;
        })
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

    jQuery.validator.addMethod("selectcheck", function(value){
        return (value != '');
    }, "Por favor, seleciona una opcion.");

    $("#sublineaForm").validate({
        ignore: "",
        rules: {
            tipoproductos_id: {
                selectcheck: true
            },
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
            $.ajax({
                data: $('#sublineaForm').serialize(),
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
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
        }
    });



    $('body').on('click', '.deletesubLinea', function () {
        var sublinea_id = $(this).data("id");
        if(confirm("¿Esta seguro de Eliminar?")) {
            $.ajax({
                type: "DELETE",
                url: "/ProdCievCodSublinea" + '/' + sublinea_id,
                success: function (data) {
                    table.draw();
                    toastr.success("Registro Eliminado con exito");
                },
                error: function (data) {
                    console.log('Error:', data);
                    toastr.danger("Error al eliminar el registro");
                }
            });
        }
    });

    $('#tipoproductos_id').on('change', function () {
        var tipoproductos_id = $(this).val();
        if ($.trim(tipoproductos_id) != ''){
            $.get('getlineasp',{tipoproductos_id: tipoproductos_id}, function(getlineasp) {
                $('#lineas_id').empty();
                $('#lineas_id').append("<option value=''>Seleccione una Linea...</option>");
                $.each(getlineasp, function (index, value) {
                    $('#lineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
    });

    $('#sublineamodal').on('show.bs.modal', function (event) {
        $('#saveBtn').html('Guardar');
        $('.form-control').removeClass('is-invalid');
        $('.error').remove();
    });
});
