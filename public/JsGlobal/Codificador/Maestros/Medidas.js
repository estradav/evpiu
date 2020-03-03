$(document).ready(function(){
    var table;
    var lineas_id = $('#med_lineas_id').val();
    var sublineas_id = $('#med_sublineas_id').val();
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/MedidasIndex",
            columns: [
                {data: 'linea', name: 'linea', orderable: false, searchable: false},
                {data: 'sublinea', name: 'sublinea', orderable: false, searchable: false},
                {data: 'cod', name: 'cod'},
                {data: 'denm', name: 'denm', orderable: false, searchable: false},
                {data: 'diametro', name: 'diametro', orderable: false, searchable: false},
                {data: 'largo', name: 'largo', orderable: false, searchable: false},
                {data: 'espesor', name: 'espesor', orderable: false, searchable: false},
                {data: 'base', name: 'base', orderable: false, searchable: false},
                {data: 'altura', name: 'altura', orderable: false, searchable: false},
                {data: 'perforacion', name: 'perforacion', orderable: false, searchable: false},
                {data: 'mm2', name: 'mm2', orderable: false, searchable: false},
                {data: 'coment', name: 'coment', orderable: false, searchable: false},
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
            },
             rowCallback: function (row, data, index) {
                 if (data.diametro == null) {
                     $(row).find('td:eq(4)').html('<label class="alert-light">N/A</label>');
                 }
                 if (data.largo == null) {
                     $(row).find('td:eq(5)').html('<label class="alert-light">N/A</label>');
                 }
                 if (data.espesor == null) {
                     $(row).find('td:eq(6)').html('<label class="alert-light">N/A</label>');
                 }
                 if (data.base == null) {
                     $(row).find('td:eq(7)').html('<label class="alert-light">N/A</label>');
                 }
                 if (data.altura == null) {
                     $(row).find('td:eq(8)').html('<label class="alert-light">N/A</label>');
                 }
                 if (data.perforacion == null) {
                     $(row).find('td:eq(9)').html('<label class="alert-light">N/A</label>');
                 }
             }
        });

        document.getElementById("cod").readOnly = true;
        document.getElementById("mm2").readOnly = true;
        document.getElementById("denominacion").readOnly = true;

        $('#CrearMedida').click(function () {
            $('#saveBtn').val("create-medida");
            $('#medida_id').val('');
            $('#medidaForm').trigger("reset");
            $('#modelHeading').html("Nuevo");
            $('#medidamodal').modal('show');

        });

        $('body').on('click', '.editmedida', function () {
            $("#medidaForm").validate().resetForm();
            $('#saveBtn').attr('formnovalidate','');
            var medida_id = $(this).data('id');
            $.get("/ProdCievCodMedida" +'/' + medida_id +'/edit', function (data) {
                $('#med_lineas_id').val(data.med_lineas_id);
                $('#modelHeading').html("Editar");
                $('#saveBtn').val("edit-Medida");
                $('#medida_id').val(data.id);
                $('#cod').val(data.cod);
                $('#mm2').val(data.mm2);
                $('#denominacion').val(data.denominacion);
                $('#UndMedida').val(data.undmedida);
                $('#Diametro').val(data.diametro);
                $('#Base').val(data.base);
                $('#Altura').val(data.altura);
                $('#Espesor').val(data.espesor);
                $('#Perforacion').val(data.perforacion);

                var lineas_id = data.med_lineas_id;
                $('#med_sublineas_id').empty();
                if ($.trim(lineas_id) != ''){
                    $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                        $('#med_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                        $.each(getsublineas, function (index, value) {
                            $('#med_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                        });
                        $('#med_sublineas_id').val(data.med_sublineas_id);
                    });
                }
                $('#medidamodal').modal('show');
            });
        });

        $('body').on('click', '.deletemedida', function () {
            var medida_id = $(this).data("id");
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
                        url: "/ProdCievCodMedida" + '/' + medida_id,
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
    });

    $('#med_lineas_id').on('change', function () {
        var lineas_id = $(this).val();
        if ($.trim(lineas_id) != ''){
            $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                $('#med_sublineas_id').empty();
                $('#med_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                $.each(getsublineas, function (index, value) {
                    $('#med_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
    });

    $('#med_sublineas_id').on('change', function () {
        var sublineas_id = $(this).val();
        $('#campos').html('');
        if ($.trim(sublineas_id) != ''){
            $.get('getCaractUnidadMedidas',{sublineas_id: sublineas_id}, function(getCaractUnidadMedidas) {
                $.each(getCaractUnidadMedidas, function (index, value) {
                    $('#campos').append("<div class='col-sm-6'> <div class='form-group'>" +
                        "<label for='"+ value +"' class='col-sm-6 control-label'>"+ value +":</label>" +
                        "<div class='col-sm-12'>" +
                        "<input type='text' class='form-control "+ value +"' id='"+ value +"' name='"+ value +"' value='' onkeyup='this.value=this.value.toUpperCase();'>" +
                        "</div></div></div>"
                    );
                })
            });

            $.get('getUnidadMedidasMed',{Sub_id: sublineas_id}, function(getUnidadMedidasMed) {
                $('#UndMedida').empty();
                $('#UndMedida').append("<option value=''>Seleccionar una Medida...</option>");
                $.each(getUnidadMedidasMed, function (index, value) {
                  $('#UndMedida').append("<option value='" + index + "'>"+ value +"</option>")

                })
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

    jQuery.validator.addMethod("selectcheck", function(value){
        return (value != '');
    }, "Por favor, seleciona una opcion.");



    console.log(sublineas_id,lineas_id);

    $("#medidaForm").validate({
        ignore: "",
        rules: {
            med_lineas_id:{
                selectcheck: true
            },
            med_sublineas_id:{
                selectcheck: true
            },
            cod: {
                remote: {
                    url: '/GetUniqueCodMed',
                    type: 'POST',
                    async: false,
                },
                minlength: 2,
                maxlength: 2,
                required: true
            },
            denominacion: {
                remote: {
                    url: '/UniqueDenominacion',
                    type: 'POST',
                    data: {
                        lineas_id, sublineas_id

                    },
                    async: true,
                },
                minlength: 2,
                required : true,
            }
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
                data: $('#medidaForm').serialize(),
                url: "/MedidasPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#medidaForm').trigger("reset");
                    $('#medidamodal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                },
                error: function (data) {
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
        }
    });

    $('#medidamodal').on('show.bs.modal', function (event) {
        $('#saveBtn').html('Guardar');
        $('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#campos').html('');

    });

    function calcular(){

        var diametro = $('#Diametro').val();
        var Umedida = $('#UndMedida').val();
        var Altura = $('#Altura').val();
        var Base = $('#Base').val();
        var resultado = 0;
        var sub;
        var totalMayor;
        var totalMenor;

        if (diametro != null && Umedida == 'mm'){
            resultado =  Math.floor(diametro * diametro);
            sub = resultado.toString().substr(-2);
            totalMayor = (resultado - sub) + 100;
            totalMenor = resultado - sub;

            if (resultado < 100){
                $('#mm2').val(100);
            }
            if (resultado > 100 && sub < 50){
                $('#mm2').val(totalMenor);
            }
            if (resultado > 100 && sub > 50){
                $('#mm2').val(totalMayor);
            }
        }

        if (diametro != null && Umedida == 'l'){
            var suma2 = ((diametro * 0.64) * (diametro * 0.64)) * 2 ;
            resultado = Math.floor(suma2);
            sub = resultado.toString().substr(-2);
            totalMayor = (resultado - sub) + 100;
            totalMenor = resultado - sub;

            if (resultado < 100){
                $('#mm2').val(100);
            }
            if (resultado > 100 && sub < 50){
                $('#mm2').val(totalMenor);
            }
            if (resultado > 100 && sub > 50){
                $('#mm2').val(totalMayor);
            }
        }

        if (diametro != null && Umedida == 'un'){
            var suma3 = ((diametro * 25.40) * (diametro * 25.40)) * 2 ;
            resultado = Math.floor(suma3);
            sub = resultado.toString().substr(-2);
            totalMayor = (resultado - sub) + 100;
            totalMenor = resultado - sub;

            if (resultado < 100){
                $('#mm2').val(100);
            }
            if (resultado > 100 && sub < 50){
                $('#mm2').val(totalMenor);
            }
            if (resultado > 100 && sub > 50){
                $('#mm2').val(totalMayor);
            }
        }


        if (Altura != null  && Base != null &&  diametro == null && Umedida == 'mm'){
            resultado =  Math.floor(Base * Altura);
            sub = resultado.toString().substr(-2);
            totalMayor = (resultado - sub) + 100;
            totalMenor = resultado - sub;

            if (resultado < 100){
                $('#mm2').val(100);
            }
            if (resultado > 100 && sub < 50){
                $('#mm2').val(totalMenor);
            }
            if (resultado > 100 && sub > 50){
                $('#mm2').val(totalMayor);
            }
        }

        if (Altura != null  && Base != null &&  diametro == null && Umedida == 'l'){
            var suma5 = ((Base * 0.64) * (Altura * 0.64)) * 2;
            resultado = Math.floor(suma5);
            sub = resultado.toString().substr(-2);
            totalMayor = (resultado - sub) + 100;
            totalMenor = resultado - sub;

            if (resultado < 100){
                $('#mm2').val(100);
            }
            if (resultado > 100 && sub < 50){
                $('#mm2').val(totalMenor);
            }
            if (resultado > 100 && sub > 50){
                $('#mm2').val(totalMayor);
            }
        }

        if (Altura != null  && Base != null &&  diametro == null && Umedida == 'un'){
            var suma6 = ((Base * 25.40) * (Altura * 25.40)) * 2;
            resultado = Math.floor(suma6);
            sub = resultado.toString().substr(-2);
            totalMayor = (resultado - sub) + 100;
            totalMenor = resultado - sub;

            if (resultado < 100){
                $('#mm2').val(100);
            }
            if (resultado > 100 && sub < 50){
                $('#mm2').val(totalMenor);
            }
            if (resultado > 100 && sub > 50){
                $('#mm2').val(totalMayor);
            }
        }
    }

    function denominacion(){
        var Diametro = $('#Diametro').val();
        var Perforacion = $('#Perforacion').val();
        var Lado = $('#Lado').val();
        var Espesor = $('#Espesor').val();

        var Base = $('#Base').val();
        var Altura = $('#Altura').val();
        var Pestaña = $('#Pestaña').val();
        var medida = $('#UndMedida').val();

        var D = null;
        var B = null;

        /*DIAMETRO*/
        if (Diametro != null && Base == null && Altura == null){
            D = 'D:'+Diametro +medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO PERFORACION*/
        if (Diametro != null && Base == null && Altura == null && Perforacion != null){
            D = 'D:'+Diametro+'P:'+Perforacion+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO PERFORACION LADO*/
        if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado != null){
            D = 'D:'+Diametro+'P:'+Perforacion+'L:'+Lado+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO PERFORACION LADO ESPESOR*/
        if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado != null && Espesor != null){
            D = 'D:'+Diametro+'P:'+Perforacion+'L:'+Lado+'E:'+Espesor+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO PERFORACION LADO ESPESOR PESTAÑA*/
        if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado != null && Espesor != null && Pestaña != null){
            D = 'D:'+Diametro+'P:'+Perforacion+'L:'+Lado+'E:'+Espesor+'PS:'+Pestaña+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO LADO */
        if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado != null && Espesor == null){
            D = 'D:'+Diametro+'L:'+Lado+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO LADO ESPESOR*/
        if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado != null && Espesor != null){
            D = 'D:'+Diametro+'L:'+Lado+'E:'+Espesor+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO LADO ESPESOR PESTAÑA*/
        if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado != null && Espesor != null && Pestaña != null){
            D = 'D:'+Diametro+'L:'+Lado+'E:'+Espesor+'PS:'+Pestaña+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO ESPESOR*/
        if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado == null && Espesor != null){
            D = 'D:'+Diametro+'E:'+Espesor+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO ESPESOR PESTAÑA*/
        if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado == null && Espesor != null && Pestaña != null){
            D = 'D:'+Diametro+'E:'+Espesor+'PS:'+Pestaña+medida;
        }

        /*DIAMETRO PESTAÑA*/
        if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado == null && Espesor == null && Pestaña != null){
            D = 'D:'+Diametro+'PS:'+Pestaña+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO PERFORACION ESPESOR*/
        if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado == null && Espesor != null && Pestaña == null){
            D = 'D:'+Diametro+'P:'+Perforacion+'PS:'+Espesor+medida;
            $('#denominacion').val(D);
        }

        /*DIAMETRO PERFORACION ESPESOR  PESTAÑA*/
        if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado == null && Espesor != null && Pestaña != null){
            D = 'D:'+Diametro+'P:'+Perforacion+'E:'+Espesor+'PS:'+Pestaña+medida;
            $('#denominacion').val(D);
        }

        if (Diametro == null && Base != null && Altura != null){
            B = 'B:'+Base+'A:'+Altura+medida;
            $('#denominacion').val(B);
        }

        if (Diametro == null && Base != null && Altura != null && Espesor != null){
            B = 'B:'+Base+'A:'+Altura+'E:'+Espesor+medida;
            $('#denominacion').val(B);
        }

        if (Diametro == null && Base != null && Altura != null && Espesor != null && Pestaña != null){
            B = 'B:'+Base+'A:'+Altura+'E:'+Espesor+'PS:'+Pestaña+medida;
            $('#denominacion').val(B);
        }

        if (Diametro == null && Base != null && Altura != null && Espesor == null && Pestaña != null){
            B = 'B:'+Base+'A:'+Altura+'PS:'+Pestaña+medida;
            $('#denominacion').val(B);
        }
    }


    $('body').on("keyup",'.Base', function(){
        calcular();
        denominacion();
    });
    $('body').on("keyup",'.Altura', function(){
        calcular();
        denominacion();
    });
    $('body').on("keyup",'.Diametro', function(){
        calcular();
        denominacion();
    });
    $('body').on("keyup",'.Perforacion', function(){
        denominacion();
    });

    $('body').on("keyup",'.Pestaña', function(){
        denominacion();
    });

    $('body').on("change",'.UndMedida', function(){
        ObtenerCodid();
        denominacion();
        calcular();


    });

    var datos;
    function ObtenerDatos(){
        jQuery.ajax({
            url: "/sublineasUltimoId",
            type: "get",
            dataType: 'json',
            success: function (data) {
                datos = [data][0];
                OriginalValue();
            },
        });
    }

    var codID;
    function ObtenerCodid(){
        jQuery.ajax({
            url: "/UltimoCodId",
            type: "get",
            dataType: 'json',
            success: function (data) {
                codID = [data][0];
                ObtenerDatos();
            },
        });
    }


    function OriginalValue(){
        var incremental     = 0;
        var charStringRange = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var vectorc         = [];
        var t1              = 0;
        var numerof         = 0;
        var OriginalProductCodes =  datos;
        var OriginalProductCodes2 = codID;

        for (var f = 0; f < OriginalProductCodes.length; f++) {

            if (OriginalProductCodes2  == OriginalProductCodes[f] && OriginalProductCodes[f]){
                var cadena = OriginalProductCodes[f];

                var text2  = cadena.split('').reverse().join('');
                text2      = text2.split('');

                for (var v2 = 0; v2 < 2; v2++) {
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
        for (var i = 0; i < 2; i++){
            incretemp = Math.floor(incretemp)/36;
            text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp))*36));
        }
        text = text.split('').reverse().join('');
        $('#cod').val(text);
    }
});
