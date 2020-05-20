$(document).ready(function() {
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/ProductosIndex",
            order: [[ 2, "desc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'desc', name: 'desc', orderable: false, searchable: false },
                {data: 'CreationDate', name: 'CreationDate'},
                {data: 'update', name: 'update'},
                {data:  'Creado', name:'Creado', orderable: false, searchable: false},
                {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
            ],
            language: {
                url: '/Spanish.json'
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

        $("#ProductForm").validate({
            ignore: "",
            rules: {
                Maestro_Cod:{required: true, minlength: 10, maxlength: 10,digits: false},
                Maestro_desc: "required",
                Maestro_TP:{selectcheck: true},
                Maestro_Comprador: {selectcheck: true},
                Maestro_Plan: {selectcheck: true},
                Maestro_Al_Pref:{selectcheck: true},
                Maestro_Umd_Ldm:{selectcheck: true},
                Maestro_Umd_Cos:{selectcheck: true},
                Maestro_Cod_Clase:{selectcheck: true},
                Maestro_Cod_Com:{selectcheck: true},
                Maestro_cos_und:"required",
               /* Maestro_Zona:"required",
                Maestro_Niv_Rev:"required",*/
                Maestro_Rend:{required: true, minlength: 0, maxlength: 100, digits: true},
                Ingenieria_desec:{required: true, minlength: 0, maxlength: 100, digits: true},
                Ingenieria_Est_Ing:{selectcheck: true},
                Ingenieria_Cbn:{required: true, digits: true},
                Contabilidad_TipCuent:{selectcheck: true},
                Planificador_PolOrd:{selectcheck: true},
                Planificador_Prg:{selectcheck: true},
                Planificador_Tc_Crit:{required: true, digits: true},
                Planificador_Pdr:{required: true, digits: true},
                Planificador_Cdr:{required: true, digits: true},
                Planificador_Fa_Pl:{required: true, digits: true},
                Planificador_Fa_Fab:{required: true, digits: true},
                Planificador_Fa_Alm:{required: true, digits: true},
                Planificador_Com_TiCi:{required: true, digits: true},
                Planificador_Com_Pl:{required: true, digits: true},
                Planificador_Com_Comp:{required: true, digits: true },
                Planificador_Com_Alm:{required: true,digits: true},
                Planificador_CaOr_Prom:{required: true, digits: true},
                Planificador_CaOr_Min:{required: true, digits: true},
                Planificador_CaOr_Max:{required: true, digits: true},
                Planificador_CaOr_Mult:{required: true, digits: true},
                Inventario_PesProm:"required",
                Inventario_UdmPes:{selectcheck: true },
                Inventario_Re_Cod:{selectcheck: true },
                Inventario_ToleMoney:"required",
                Inventario_TolePorc:{required: true, minlength: 0, maxlength: 100, digits: true},
                /*Ingenieria_NumPln: "required"*/
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
                $('#saveBtn').html('Guardando...');
                $.ajax({
                    data: $('#ProductForm').serialize(),
                    url: "/SaveProducts",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        if (data.hasOwnProperty('error')) {
                            toastr.error('SQLSTATE[' + data.error.code + ']: ¡El Producto ya existe!');
                            $('#saveBtn').html('Reintentar');
                        }
                        else {
                            $('#ProductForm').trigger("reset");
                            $('#Modal').modal('hide');
                            table.draw();
                            toastr.success("Registro Guardado con Exito!");
                            $('#saveBtn').html('Guardar');
                        }
                    }
                });
                return false; // required to block normal submit since you used ajax
            },
        });

        jQuery.validator.addMethod("selectcheck", function(value){
            return (value != '');
        }, "Por favor, seleciona una opcion.");

    });

    $('#New').click(function () {
        $('#saveBtn').val("CreateProduct");
        $('#linea_id').val('');
        $('#ProductForm').trigger("reset");
        $('#modelHeading').html("Crear ò Clonar Producto");
        $('#Modal').modal('show');
        document.getElementById("Maestro_Cod").readOnly = true;
        document.getElementById("Maestro_desc").readOnly = true;
    });

    $("#Planificador_PlnFirmVal").val('N');
    $("#Planificador_PlnFirm").change(function () {
        if($(this).prop('checked') == true) {
            $("#Planificador_PlnFirmVal").val('Y')
        }else{
            $("#Planificador_PlnFirmVal").val('N')
        }
    });

    $("#Planificador_NcndVal").val('N');
    $("#Planificador_Ncnd").change(function () {
        if($(this).prop('checked') == true) {
            $("#Planificador_NcndVal").val('Y')
        }else{
            $("#Planificador_NcndVal").val('N')
        }
    });

    $("#Planificador_RumpVal").val('N');
    $("#Planificador_Rump").change(function () {
        if($(this).prop('checked') == true) {
            $("#Planificador_RumpVal").val('Y')
        }else{
            $("#Planificador_RumpVal").val('N')
        }
    });

    $("#Planificador_PieCritVal").val('N');
    $("#Planificador_PieCrit").change(function () {
        if($(this).prop('checked') == true) {
            $("#Planificador_PieCritVal").val('Y')
        }else{
            $("#Planificador_PieCritVal").val('N')
        }
    });

    $("#Inventario_ReqInspVal").val('N');
    $("#Inventario_ReqInsp").change(function () {
        if($(this).prop('checked') == true) {
            $("#Inventario_ReqInspVal").val('Y')
        }else{
            $("#Inventario_ReqInspVal").val('N')
        }
    });

    $("#Inventario_CtrLotVal").val('N');
    $("#Inventario_CtrLot").change(function () {
        if($(this).prop('checked') == true) {
            $("#Inventario_CtrLotVal").val('Y')
        }else{
            $("#Inventario_CtrLotVal").val('N')
        }
    });

    $("#Inventario_CtrNsVal").val('N');
    $("#Inventario_CtrNs").change(function () {
        if($(this).prop('checked') == true) {
            $("#Inventario_CtrNsVal").val('Y')
        }else{
            $("#Inventario_CtrNsVal").val('N')
        }
    });

    $("#Inventario_MultEntVal").val('N');
    $("#Inventario_MultEnt").change(function () {
        if($(this).prop('checked') == true) {
            $("#Inventario_MultEntVal").val('Y')
        }else{
            $("#Inventario_MultEntVal").val('N')
        }
    });

    $("#Inventario_LotCdpVal").val('N');
    $("#Inventario_LotCdp").change(function () {
        if($(this).prop('checked') == true) {
            $("#Inventario_LotCdpVal").val('Y')
        }else{
            $("#Inventario_LotCdpVal").val('N')
        }
    });

    $("#Inventario_NsCdpVal").val('N');
    $("#Inventario_NsCdp").change(function () {
        if($(this).prop('checked') == true) {
            $("#Inventario_NsCdpVal").val('Y')
        }else{
            $("#Inventario_NsCdpVal").val('N')
        }
    });


    $( "#product_name" ).autocomplete({
        appendTo: "#Modal",
        source: function(request, response) {
            var product = $( "#product_name" ).val();
            $.ajax({
                url: "/SearchProducts",
                method: "get",
                data: {
                    query : product
                },
                dataType: "json",
                success: function(data){
                    var resp = $.map(data,function(obj){
                        return obj
                    });
                    response(resp);
                },
            });
        },
        focus: function( event, ui ) {
            $("#ProductOrig").val([ui.item.id]);
            $("#Maestro_TP").val([ui.item.t_pieza]);
            $("#Maestro_Umd_Ldm").val([ui.item.Umd_Ldm]);
            $("#Maestro_Umd_Cos").val([ui.item.Umd_Cos]);
            $("#Maestro_Cod_Clase").val([ui.item.Cod_Clase]);
            $("#Maestro_Al_Pref").val([ui.item.Al_Pref]);
            $("#Maestro_cos_und").val([ui.item.Cos_Und]);
            $("#Maestro_Inv").val([ui.item.M_Inv]);
            $("#Maestro_Zona").val([ui.item.M_Zona]);
            $("#Maestro_Plan").val([ui.item.M_Planif]);
            $("#Maestro_Niv_Rev").val([ui.item.Niv_Rev]);
            $("#Maestro_Cod_Com").val([ui.item.Cod_Comd]);
            $("#Maestro_Comprador").val([ui.item.M_Compr]);
            $("#Maestro_Rend").val([ui.item.M_Rend]);
            $("#Maestro_Tc_Manu").val([ui.item.Tc_Manu]);
            $("#Maestro_Tc_Compras").val([ui.item.TC_Comp]);

            /*PESTAÑA INGENIERIA*/
            $("#Ingenieria_desec").val([ui.item.Ig_PorcDes]);
            $("#Ingenieria_Est_Ing").val([ui.item.Ig_EstIng]);
            $("#Ingenieria_Cbn").val([ui.item.Ig_Cbn]);
            $("#Ingenieria_NumPln").val([ui.item.Ig_NumPln]);

            /*PESTAÑA PLANIFICADOR*/
            $("#Planificador_PolOrd").val([ui.item.Pl_PolOrd]);
            $("#Planificador_Prg").val([ui.item.Pl_Prgm]);
            $("#Planificador_Tc_Crit").val([ui.item.Pl_TcCrit]);
            $("#Planificador_Pdr").val([ui.item.Pl_Pdr]);
            $("#Planificador_Cdr").val([ui.item.Pl_Cdr]);
            $("#Planificador_InvSeg").val([ui.item.Pl_InvSeg]);
            $("#Planificador_Fa_TiCi").val([ui.item.Pl_Fb_TiCi]);
            $("#Planificador_Fa_Pl").val([ui.item.Pl_Fb_Pl]);
            $("#Planificador_Fa_Fab").val([ui.item.Pl_Fb_Fab]);
            $("#Planificador_Fa_Alm").val([ui.item.Pl_Fb_Alm]);
            $("#Planificador_Com_TiCi").val([ui.item.Pl_Com_TiCi]);
            $("#Planificador_Com_Pl").val([ui.item.Pl_Com_Pl]);
            $("#Planificador_Com_Comp").val([ui.item.Pl_Com_Comp]);
            $("#Planificador_Com_Alm").val([ui.item.Pl_Com_Alm]);
            $("#Planificador_CaOr_Prom").val([ui.item.Pl_CaOrd_Prom]);
            $("#Planificador_CaOr_Min").val([ui.item.Pl_CaOrd_Min]);
            $("#Planificador_CaOr_Max").val([ui.item.Pl_CaOrd_Max]);
            $("#Planificador_CaOr_Mult").val([ui.item.Pl_CaOrd_Mult]);
            $("#Planificador_PlnFirmVal").val([ui.item.Pl_PlFirm]);
            $("#Planificador_NcndVal").val([ui.item.Pl_Ncnd]);
            $("#Planificador_RumpVal").val([ui.item.Pl_Rump]);
            $("#Planificador_PieCritVal").val([ui.item.Pl_PieCrit]);

            /* PESTAÑA INVENTARIO*/
            $("#Inventario_ExcEnt").val([ui.item.Inv_ExcEnt]);
            $("#Inventario_PesProm").val([ui.item.Inv_Pes_Prom]);
            $("#Inventario_UdmPes").val([ui.item.Inv_Udm_Pes]);
            $("#Inventario_DiasVen").val([ui.item.Inv_DiasVen]);
            $("#Inventario_CtrLot").val([ui.item.Inv_CtrLot]);
            $("#Inventario_CtrNs").val([ui.item.Inv_CtrNs]);
            $("#Inventario_MultEnt").val([ui.item.Inv_MultEnt]);
            $("#Inventario_LotCdp").val([ui.item.Inv_LotCpd]);
            $("#Inventario_NsCdp").val([ui.item.Inv_NsCdp]);
            $("#Inventario_Re_Cod").val([ui.item.Inv_ReCod]);
            $("#Inventario_ToleMoney").val([ui.item.Inv_TolMoney]);
            $("#Inventario_TolePorc").val([ui.item.Inv_TolPorc]);

            /* checkbox */
            $("#Inventario_ReqInspVal").val([ui.item.Inv_ReqInsp]);
            $("#Inventario_CtrLotVal").val([ui.item.Inv_CtrLot]);
            $("#Inventario_CtrNsVal").val([ui.item.Inv_CtrNs]);
            $("#Inventario_MultEntVal").val([ui.item.Inv_MultEnt]);
            $("#Inventario_LotCdpVal").val([ui.item.Inv_LotCpd]);
            $("#Inventario_NsCdpVal").val([ui.item.Inv_NsCdp]);

            /*Pestaña Contabilidad*/
            $("#Contabilidad_TipCuent").val([ui.item.Cont_TipCuent]);

            /*Otros campos */
            $("#CSTTYP_01").val([ui.item.CSTTYP_01]);
            $("#LABOR_01").val([ui.item.LABOR_01]);
            $("#VOH_01").val([ui.item.VOH_01]);
            $("#FOH_01").val([ui.item.FOH_01]);
            $("#QUMMAT_01").val([ui.item.QUMMAT_01]);
            $("#QUMLAB_01").val([ui.item.QUMLAB_01]);
            $("#QUMVOH_01").val([ui.item.QUMVOH_01]);
            $("#HRS_01").val([ui.item.HRS_01]);
            $("#QUMHRS_01").val([ui.item.QUMHRS_01]);
            $("#PURUOM_01").val([ui.item.PURUOM_01]);
            $("#PERDAY_01").val([ui.item.Pl_Dias_Pe]);

            return true;
        },
        select: function(event, ui)	{
            $("#ProductOrig").val([ui.item.id]);
            $("#Maestro_TP").val([ui.item.t_pieza]);
            $("#Maestro_Umd_Ldm").val([ui.item.Umd_Ldm]);
            $("#Maestro_Umd_Cos").val([ui.item.Umd_Cos]);
            $("#Maestro_Cod_Clase").val([ui.item.Cod_Clase]);
            $("#Maestro_Al_Pref").val([ui.item.Alm_Pref]);
            $("#Maestro_cos_und").val([ui.item.Cos_Und]);
            $("#Maestro_Inv").val([ui.item.M_Inv]);
            $("#Maestro_Zona").val([ui.item.M_Zona]);
            $("#Maestro_Plan").val([ui.item.M_Planif]);
            $("#Maestro_Niv_Rev").val([ui.item.Niv_Rev]);
            $("#Maestro_Cod_Com").val([ui.item.Cod_Comd]);
            $("#Maestro_Comprador").val([ui.item.M_Compr]);
            $("#Maestro_Rend").val([ui.item.M_Rend]);
            $("#Maestro_Tc_Manu").val([ui.item.Tc_Manu]);
            $("#Maestro_Tc_Compras").val([ui.item.TC_Comp]);

            /*PESTAÑA INGENIERIA*/
            $("#Ingenieria_desec").val([ui.item.Ig_PorcDes]);
            $("#Ingenieria_Est_Ing").val([ui.item.Ig_EstIng]);
            $("#Ingenieria_Cbn").val([ui.item.Ig_Cbn]);
            $("#Ingenieria_NumPln").val([ui.item.Ig_NumPln]);

            /*PESTAÑA PLANIFICADOR*/
            $("#Planificador_PolOrd").val([ui.item.Pl_PolOrd]);
            $("#Planificador_Prg").val([ui.item.Pl_Prgm]);
            $("#Planificador_Tc_Crit").val([ui.item.Pl_TcCrit]);
            $("#Planificador_Pdr").val([ui.item.Pl_Pdr]);
            $("#Planificador_Cdr").val([ui.item.Pl_Cdr]);
            $("#Planificador_InvSeg").val([ui.item.Pl_InvSeg]);
            $("#Planificador_Fa_TiCi").val([ui.item.Pl_Fb_TiCi]);
            $("#Planificador_Fa_Pl").val([ui.item.Pl_Fb_Pl]);
            $("#Planificador_Fa_Fab").val([ui.item.Pl_Fb_Fab]);
            $("#Planificador_Fa_Alm").val([ui.item.Pl_Fb_Alm]);
            $("#Planificador_Com_TiCi").val([ui.item.Pl_Com_TiCi]);
            $("#Planificador_Com_Pl").val([ui.item.Pl_Com_Pl]);
            $("#Planificador_Com_Comp").val([ui.item.Pl_Com_Comp]);
            $("#Planificador_Com_Alm").val([ui.item.Pl_Com_Alm]);
            $("#Planificador_CaOr_Prom").val([ui.item.Pl_CaOrd_Prom]);
            $("#Planificador_CaOr_Min").val([ui.item.Pl_CaOrd_Min]);
            $("#Planificador_CaOr_Max").val([ui.item.Pl_CaOrd_Max]);
            $("#Planificador_CaOr_Mult").val([ui.item.Pl_CaOrd_Mult]);
            $("#Planificador_PlnFirmVal").val([ui.item.Pl_PlFirm]);
            $("#Planificador_NcndVal").val([ui.item.Pl_Ncnd]);
            $("#Planificador_RumpVal").val([ui.item.Pl_Rump]);
            $("#Planificador_PieCritVal").val([ui.item.Pl_PieCrit]);

            /**/
            if([ui.item.Pl_PlFirm] == 'Y'){
                $("#Planificador_PlnFirm").prop('checked', true);
            }else{
                $("#Planificador_PlnFirm").prop('checked', false);
            }
            /**/
            if ([ui.item.Pl_Ncnd] == 'Y'){
                $("#Planificador_Ncnd").prop('checked', true);
            }else{
                $("#Planificador_Ncnd").prop('checked', false);
            }
            /**/
            if([ui.item.Pl_Rump] == 'Y'){
                $("#Planificador_Rump").prop('checked', true);
            }else{
                $("#Planificador_Rump").prop('checked', false);
            }
            /**/
            if([ui.item.Pl_PieCrit] == 'Y'){
                $("#Planificador_PieCrit").prop('checked', true);
            }else{
                $("#Planificador_PieCrit").prop('checked', false);
            }
            /**/

            /* PESTAÑA INVENTARIO*/
            $("#Inventario_ExcEnt").val([ui.item.Inv_ExcEnt]);
            $("#Inventario_PesProm").val([ui.item.Inv_Pes_Prom]);
            $("#Inventario_UdmPes").val([ui.item.Inv_Udm_Pes]);
            $("#Inventario_DiasVen").val([ui.item.Inv_DiasVen]);

            if([ui.item.Inv_ReqInsp] == 'Y'){
                $("#Inventario_ReqInsp").prop('checked', true);

            }else{
                $("#Inventario_ReqInsp").prop('checked', false);
            }

            if([ui.item.Inv_CtrLot] == 'Y') {
                $("#Inventario_CtrLot").prop('checked', true);
            }else{
                $("#Inventario_CtrLot").prop('checked', false);
            }

            if([ui.item.Inv_CtrNs] == 'Y'){
                $("#Inventario_CtrNs").prop('checked',true);
            }else{
                $("#Inventario_CtrNs").prop('checked',false);
            }

            if([ui.item.Inv_MultEnt] == 'Y'){
                $("#Inventario_MultEnt").prop('checked',true);
            }else{
                $("#Inventario_MultEnt").prop('checked',false);
            }

            if([ui.item.Inv_LotCpd] == 'Y'){
                $("#Inventario_LotCdp").prop('checked',true);
            }else{
                $("#Inventario_LotCdp").prop('checked',false);
            }

            if ([ui.item.Inv_NsCdp] == 'Y'){
                $("#Inventario_NsCdp").prop('checked',true);
            }else{
                $("#Inventario_NsCdp").prop('checked',false);
            }

            $("#Inventario_Re_Cod").val([ui.item.Inv_ReCod]);
            $("#Inventario_ToleMoney").val([ui.item.Inv_TolMoney]);
            $("#Inventario_TolePorc").val([ui.item.Inv_TolPorc]);
            $("#Inventario_ReqInspVal").val([ui.item.Inv_ReqInsp]);

            /* checkbox */
            $("#Inventario_ReqInspVal").val([ui.item.Inv_ReqInsp]);
            $("#Inventario_CtrLotVal").val([ui.item.Inv_CtrLot]);
            $("#Inventario_CtrNsVal").val([ui.item.Inv_CtrNs]);
            $("#Inventario_MultEntVal").val([ui.item.Inv_MultEnt]);
            $("#Inventario_LotCdpVal").val([ui.item.Inv_LotCpd]);
            $("#Inventario_NsCdpVal").val([ui.item.Inv_NsCdp]);

            /*Pestaña Contabilidad*/
            $("#Contabilidad_TipCuent").val([ui.item.Cont_TipCuent]);

            /* Otros campos */
            $("#CSTTYP_01").val([ui.item.CSTTYP_01]);
            $("#LABOR_01").val([ui.item.LABOR_01]);
            $("#VOH_01").val([ui.item.VOH_01]);
            $("#FOH_01").val([ui.item.FOH_01]);
            $("#QUMMAT_01").val([ui.item.QUMMAT_01]);
            $("#QUMLAB_01").val([ui.item.QUMLAB_01]);
            $("#QUMVOH_01").val([ui.item.QUMVOH_01]);
            $("#HRS_01").val([ui.item.HRS_01]);
            $("#QUMHRS_01").val([ui.item.QUMHRS_01]);
            $("#PURUOM_01").val([ui.item.PURUOM_01]);
            $("#PERDAY_01").val([ui.item.Pl_Dias_Pe]);


        },
        minLength: 2
    });

    //Busca el Codigo de Destino
    $( "#dest_produc" ).autocomplete({
        appendTo: "#Modal",
        source: function (request, response) {
            var cod = $("#dest_produc").val();
            $.ajax({
                url: "/SearchCodes",
                method: "get",
                data: {
                    query: cod
                },
                dataType: "json",
                success: function (data) {
                    var resp = $.map(data, function (obj) {
                        return obj
                    });
                    response(resp);
                },
            });
        },
        focus: function( event, ui ) {
            $("#Maestro_Cod").val([ui.item.codigo]);
            $("#Maestro_desc").val([ui.item.descripcion]);

            return true;
        },

        select: function(event, ui)	{
            $("#Maestro_Cod").val([ui.item.codigo]);
            $("#Maestro_desc").val([ui.item.descripcion]);
        },
        minLength: 1
    });

    /*Cada vez que el modal se cierra o guarda un registro , se reinicia y deja todos los campos en blanco*/
    $('#Modal').on('show.bs.modal', function (event) {
        $("#Modal input").val("");
        $("#Modal textarea").val("");
        $("#Modal select").val("");
        $("#Modal input[type='checkbox']").prop('checked', false).change();
        $('#saveBtn').html('Guardar');
        $('.form-control').removeClass('is-invalid');
        $('.error').remove();
    });
});
