$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/CodigosIndex",
        columns: [
            {data: 'codigo', name: 'codigo'},
            {data: 'desc', name: 'desc'},
            {data: 'tp', name: 'tp'},
            {data: 'lin', name: 'lin'},
            {data: 'subl', name: 'subl'},
            {data: 'med', name: 'med'},
            {data: 'car', name: 'car'},
            {data: 'mat', name: 'mat'},
            {data: 'coment', name: 'coment'},
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
        remote: "Este Codigo ya existe...",
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
    $("#CodigoForm").validate({
        ignore: "",
        rules: {
            codigo:{
                required: true,
                remote: {
                    url: '/GetUniqueCode',
                    type: 'POST',
                    async: true,
                },
                minlength: 10,
                maxlength: 10,
            },
            descripcion:{
                required: true,
                remote: {
                    url: '/GetUniqueDescription',
                    type: 'POST',
                    async: true,
                }
            },
            tipoproducto_id: { selectcheck: true },
            lineas_id: { selectcheck: true },
            sublineas_id: { selectcheck: true },
            caracteristica_id: { selectcheck: true },
            material_id: { selectcheck: true },
            medida_id: { selectcheck: true },

        },
        submitHandler: function (form) {
            $('#saveBtn').html('Guardando...');
            $.ajax({
                data: $('#CodigoForm').serialize(),
                url: "/CodigosPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#CodigoForm').trigger("reset");
                    $('#Codigomodal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                    $(this).html('Crear');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
            return false; // required to block normal submit since you used ajax
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
    });

    $('#CrearCodigo').click(function () {
        $('#saveBtn').val("create-codigo");
        $('#Codigo_id').val('');
        $('#CodigoForm').trigger("reset");
        $('#modelHeading').html("Crear Nuevo Codigo");
        $('#Codigomodal').modal('show');
    });

    $('body').on('click', '.editCodigo', function () {
        var codigo_id = $(this).data('id');
        $.get("/codificador" +'/' + codigo_id +'/edit', function (data) {
            $('#modelHeading').html("Editar Codigo");
            $('#saveBtn').val("edit-Medida");
            $('#Codigomodal').modal('show');
            $('#medida_id').val(data.id);
            $('#codigo').val(data.codigo);
            $('#descripcion').val(data.descripcion);
            $('#tipoproducto_id').val(data.tipoproducto_id);
            $('#lineas_id').val(data.lineas_id);
            $('#sublineas_id').val(data.sublineas_id);
            $('#medida_id').val(data.medida_id);
            $('#caracteristica_id').val(data.caracteristica_id);
            $('#material_id').val(data.material_id);
            $('#coments').val(data.coments);
        })
    });

    $('body').on('click', '.deleteCodigo', function () {
        var codigo_id = $(this).data("id");
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
                    url: "/codificador" + '/' + codigo_id,
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
            }else if (
                /* Read more about handling dismissals below */
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


    $('#tipoproducto_id').on('change', function () {
        var tipoproducto_id = $(this).val();
        $('#lineas_id').empty();
        $('#sublinea_id').empty();
        if ($.trim(tipoproducto_id) != ''){
            $.get('getlineas',{tipoproducto_id: tipoproducto_id}, function(getlineas) {
                $('#lineas_id').append("<option value=''>Seleccione una Linea...</option>");
                $.each(getlineas, function (index, value) {
                    $('#lineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
            $.get('ctp',{tipoproducto_id: tipoproducto_id}, function(ctp) {
                $('#ctp-g').empty();
                $.each(ctp, function (index, value) {
                    document.getElementById("ctp-g").value=index;
                })
            });
        }
        ObtenerDatos();
    });

    $('#lineas_id').on('change', function () {
        var lineas_id = $(this).val();
        if ($.trim(lineas_id) != ''){
            $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                $('#sublineas_id').empty();
                $('#sublineas_id').append("<option value=''>Seleccione una Sublinea...</option>");
                $.each(getsublineas, function (index, value) {
                    $('#sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
            $.get('lns',{lineas_id: lineas_id}, function(lns) {
                $('#lin-g').empty();
                $.each(lns, function (index, value) {
                    document.getElementById("lin-g").value=index;
                    document.getElementById("lin-d").value=value;
                })
            });
        }
        ObtenerDatos();
    });

    $('#sublineas_id').on('change', function () {
        var car_sublineas_id = $(this).val();
        if ($.trim(car_sublineas_id) != ''){
            $.get('getcaracteristica',{car_sublineas_id: car_sublineas_id}, function(getcaracteristica) {
                $('#caracteristica_id').empty();
                $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                $.each(getcaracteristica, function (index, value) {
                    $('#caracteristica_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }

        var mat_sublineas_id = $(this).val();
        if ($.trim(mat_sublineas_id) != ''){
            $.get('getmaterial',{mat_sublineas_id: mat_sublineas_id}, function(getmaterial) {
                $('#material_id').empty();
                $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                $.each(getmaterial, function (index, value) {
                    $('#material_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }

        var med_sublineas_id = $(this).val();
        if ($.trim(med_sublineas_id) != ''){
            $.get('getmedida',{med_sublineas_id: med_sublineas_id}, function(getmedida) {
                $('#medida_id').empty();
                $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");
                $.each(getmedida, function (index, value) {
                    $('#medida_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
        ObtenerDatos();
    });

    $('#caracteristica_id').on('change', function () {
        var caracteristica_id = $(this).val();
        if ($.trim(caracteristica_id) != '') {
            $.get('car', {caracteristica_id: caracteristica_id}, function (car) {
                $('#car-d').empty();
                $.each(car, function (index, value) {
                    document.getElementById("car-d").value = value;
                    // $('#codigo')
                })
            });
        }
        ObtenerDatos();
    });

    $('#material_id').on('change', function () {
        var material_id = $(this).val();
        if ($.trim(material_id) != '') {
            $.get('mat', {material_id: material_id}, function (mat) {
                $('#mat-g').empty();
                $.each(mat, function (index, value) {
                    document.getElementById("mat-g").value = index;
                    document.getElementById("mat-d").value = value;
                })
            });
        }
        ObtenerDatos();
    });

    $('#sublineas_id').on('change', function () {
        var med_sublineas_id = $(this).val();
        $.get('sln',{sublineas_id: med_sublineas_id}, function(sln) {
            $('#sln-g').empty();
            $.each(sln, function (index, value) {
                document.getElementById("sln-g").value=index;
                document.getElementById("sln-d").value=value;
            })
        });
        ObtenerDatos();
    });

    $('#medida_id').on('change', function () {
        var medida_id = $(this).val();
        if ($.trim(medida_id) != '') {
            $.get('med', {medida_id: medida_id}, function (med) {
                $('#med-d').empty();
                $.each(med, function (index, value) {
                    document.getElementById("med-d").value = value;
                })
            });
        }
        ObtenerDatos();
    });

    var datos;
    function ObtenerDatos(){
        jQuery.ajax({
            url: "/test",
            type: "get",
            dataType: 'json',
            success: function (data) {
                datos = [data][0];
                Description();
            },
        });
    }

    function Description(){
        tipoProducto=document.getElementById('ctp-g').value;
        Linea=document.getElementById('lin-g').value;
        Sublinea=document.getElementById('sln-g').value;
        material=document.getElementById('mat-g').value;
        final=tipoProducto+Linea+Sublinea+material;
        document.getElementById('CodNam').value=final;

        DLinea=document.getElementById('lin-d').value;
        DSublinea=document.getElementById('sln-d').value;
        Dcaracteristica=document.getElementById('car-d').value;
        Dmaterial=document.getElementById('mat-d').value;
        Dmedida=document.getElementById('med-d').value;

        Dfinal=DLinea+' '+DSublinea+' '+Dcaracteristica+' '+Dmaterial+' '+Dmedida;
        document.getElementById('descripcion').value=Dfinal;
        OriginalValue();
    }

    function OriginalValue(){
        var incremental     = 0;
        var charStringRange = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var vectorc         = [];
        var t1              = 0;
        var numerof         = 0;
        var OriginalProductCodes =  datos;
        var OriginalProductCodes2 = $('#CodNam').val();

        for (var f = 0; f < OriginalProductCodes.length; f++) {
            if (OriginalProductCodes2  == OriginalProductCodes[f].substring(0,6) && OriginalProductCodes[f].length==10){
                var cadena = OriginalProductCodes[f].substring(6);
                var text2  = cadena.split('').reverse().join('');
                text2      = text2.split('');

                for (var v2 = 0; v2 < 4; v2++) {
                    for (var i = 0; i < 36; i++) {
                        if (text2[v2] == charStringRange[i]) {
                            break;
                        }
                    }
                    numerof += i*Math.pow(36,v2);
                }
                vectorc[t1] = numerof;
                t1++;
                numerof = 0;
            }
        }

        maxvector = Math.max.apply(Math,vectorc); //saca el valor maximo de un arreglo
        if (maxvector >= 0) {
            incremental = maxvector + 1;
        }
        var text = '';
        var incretemp = incremental;
        for (var i = 0; i < 4; i++){
            incretemp = Math.floor(incretemp)/36;
            text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp))*36));
        }
        text = text.split('').reverse().join('');
        $('#codigo').val(final + text);
    }

    $('#Codigomodal').on('show.bs.modal', function (event) {
        $('#saveBtn').html('Guardar');
        $('.form-control').removeClass('is-invalid');
        $('.error').remove();
    });
});
