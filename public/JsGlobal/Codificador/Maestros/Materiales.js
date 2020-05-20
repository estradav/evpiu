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
                url: '/Spanish.json'
            }
        });

        $('#CrearMaterial').click(function () {
            $('#saveBtn').val("create-material");
            $('#material_id').val('');
            $('#materialForm').trigger("reset");
            $('#modelHeading').html("Nuevo");
            $('#materialmodal').modal('show');
            document.getElementById("codigo").readOnly = false;
        });

        $('body').on('click', '.editmaterial', function () {
            $("#materialForm").validate().resetForm();
            $('#saveBtn').attr('formnovalidate','');
            document.getElementById("codigo").readOnly = true;
            var material_id = $(this).data('id');
            $.get("/ProdCievCodMaterial" +'/' + material_id +'/edit', function (data) {
                $('#mat_lineas_id').val(data.mat_lineas_id);
                $('#modelHeading').html("Editar");
                $('#saveBtn').val("edit-Material");
                $('#material_id').val(data.id);
                $('#codigo').val(data.cod);

                $('#name').val(data.name);
                $('#abreviatura').val(data.abreviatura);
                $('#coments').val(data.coments);

                var lineas_id = data.mat_lineas_id;
                $('#mat_sublineas_id').empty();
                if ($.trim(lineas_id) != ''){
                    $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                        $('#mat_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                        $.each(getsublineas, function (index, value) {
                            $('#mat_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                        });
                        $('#mat_sublineas_id').val(data.mat_sublineas_id);
                    });
                }
                $('#materialmodal').modal('show');
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

        $("#materialForm").validate({
            ignore: "",
            rules: {
                mat_lineas_id: {
                    selectcheck: true,
                },
                mat_sublineas_id: {
                    selectcheck: true,
                },
                codigo: {
                    remote: {
                        url: '/GetUniqueCodMaterials',
                        type: 'POST',
                        async: false,
                        data: {
                            linea: function () {
                                return $("#mat_lineas_id").val();
                            },
                            sublinea: function () {
                                return $("#mat_sublineas_id").val();
                            },
                        }
                    },
                    required: true,
                    maxlength: 1,
                    minlength: 1
                },
                name: "required",
                abreviatura: "required",
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
            }
        });

        $('body').on('click', '.deletematerial', function () {
            var material_id = $(this).data("id");
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
                        url: "/ProdCievCodMaterial" + '/' + material_id,
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
                }else{
                    result.dismiss === Swal.DismissReason.cancel
                }
            })
        })
    });

    $('#mat_lineas_id').on('change', function () {
        $('#mat_sublineas_id').empty();
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

    $('#materialmodal').on('show.bs.modal', function (event) {
        $('#saveBtn').html('Guardar');
        $('.form-control').removeClass('is-invalid');
        $('.error').remove();
    });

    $('#name').autocomplete({
        appendTo: '#materialmodal',
        source: function (request, response) {
            var material = $("#name").val();
            $.ajax({
                url: "/get_materiales",
                method: "get",
                data: {
                    query: material,
                },
                dataType: "json",
                success: function (data) {
                    var resp = $.map(data, function (obj) {
                        return obj
                    });
                    response(resp);
                }
            })
        },
        focus: function (event, ui) {
            $('#codigo').val([ui.item.code]);
            $('#name').val([ui.item.name]);
            $('#abreviatura').val([ui.item.abbreviation]);
            return true;
        },
        select: function (event, ui) {
            $('#codigo').val([ui.item.code]);
            $('#name').val([ui.item.name]);
            $('#abreviatura').val([ui.item.abbreviation]);
        },
        minlength: 2
    });
});
