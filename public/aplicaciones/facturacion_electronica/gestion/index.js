$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    load_table();
    Listado_de_facturas();

    moment.locale('es');
    $('input[id="date"]').daterangepicker({
        drops: 'down',
        open: 'center',
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function(start, end, label) {
        start_date = start.format('YYYY-MM-DD 00:00:00');
        end_date = end.format('YYYY-MM-DD 23:59:59');
    });


    var table;
    var start_date;
    var end_date;

    function load_table(from_date = '', to_date = '' ,fe_start = '', fe_end = '', type_doc = ''){
        table =  $('#table').DataTable({
            ajax: {
                url:'/aplicaciones/facturacion_electronica/gestions',
                data:{
                    from_date:from_date,
                    to_date:to_date,
                    fe_start:fe_start,
                    fe_end:fe_end,
                    type_doc:type_doc,
                }
            },
            columns: [
                {data: 'DT_RowId', name: 'DT_RowId', orderable: true, searchable: true},
                {data: 'numero', name: 'numero', orderable: true, searchable: true},
                {data: 'desctipodocumentoelectronico', name: 'desctipodocumentoelectronico', orderable: false, searchable: false},
                {data: 'nombreAdquiriente',name: 'nombreAdquiriente'},
                {data: 'identificacionAdquiriente',name: 'identificacionAdquiriente'},
                {data: 'fechageneracion',name: 'fechageneracion'},
                {data: 'fecharegistro',name: 'fecharegistro'},
                {data: 'descestadoenviodian',name: 'descestadoenviodian'},
                {data: 'descestadoenviocliente',name: 'descestadoenviocliente'},
                {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
            ],
            order: [
                [ 1, "asc" ]
            ],
            language: {
                url: '/Spanish.json'
            }
        });
    }

    $('#filter').click(function(){
        const fe_start = $('#fe_start').val();
        const fe_end = $('#fe_end').val();
        const type_doc = $('#type_doc').val();

        if(start_date !== '' &&  end_date !== '') {
            $('#table').DataTable().destroy();
            load_table(start_date, end_date, fe_start, fe_end, type_doc);
            Listado_de_facturas(start_date, end_date, fe_start, fe_end, type_doc);
        }
        else if(fe_start !== '' &&  fe_end !== '') {
            $('#table').DataTable().destroy();
            load_table(start_date, end_date, fe_start, fe_end, type_doc);
            Listado_de_facturas(start_date, end_date, fe_start, fe_end, type_doc);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes seleccionar una fecha inicial y una final o un rango de facturas valido..!',
            });
        }
    });


    $(document).on('click', '.download_ws', function () {
        var id = this.id;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: '/aplicaciones/facturacion_electronica/web_service/descargar_documento',
            data: {
                id: id,
            },
            success: function (data) {
                var base64str = data;
                var binary = atob(base64str.replace(/\s/g, ''));
                var len = binary.length;
                var buffer = new ArrayBuffer(len);
                var view = new Uint8Array(buffer);
                for (var i = 0; i < len; i++) {
                    view[i] = binary.charCodeAt(i);
                }
                var blob = new Blob([view], { type: "application/pdf" });
                var link=document.createElement('a');
                link.href=window.URL.createObjectURL(blob);
                link.download="FE_"+id+".pdf";
                link.click();
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la Descarga...',
                    text: 'Hubo un error al descargar el pdf de esta factura...!',
                });
            }
        });
    });

    var missing = [];
    function Listado_de_facturas(from_date = '', to_date = '' ,fe_start = '', fe_end = '', type_doc = '') {
        missing = [];
        $.ajax({
            url: '/aplicaciones/facturacion_electronica/web_service/listado_documentos',
            type: 'get',
            data: {
                from_date:from_date,
                to_date:to_date,
                fe_start:fe_start,
                fe_end:fe_end,
                type_doc:type_doc,
            },
            success: function (data) {
                var array = [];
                for (let i = 0; i < data.length ; i++) {
                    array.push(data[i].numero);
                }
                array = array.sort();
                for(let i = 1; i < array.length; i++) {
                    if(array[i] - array[i-1] !== 1) {
                        var x = array[i] - array[i-1];
                        let k = 1;
                        while (k<x) {
                            missing.push(array[i-1]+k);
                            k++;
                        }
                    }
                }
            }
        });
    }

    var t = $('#facturas_pendientes_table').DataTable({
        language: {
            url: '/Spanish.json'
        },
        columns: [
            { "orderable": false, "searchable": false },
            { "orderable": true, "searchable": true },
            { "orderable": false, "searchable": false },
        ],
        order: [
            [ 1, "asc" ]
        ]
    });

    $(document).on("click", "#select_all", function() {
        $(".check").prop("checked", this.checked);
    });

    $(document).on("click", ".check", function() {
        if ($(".test").length === $(".check:checked").length) {
            $("#select_all").prop("checked", true);
        } else {
            $("#select_all").prop("checked", false);
        }
    });


    $(document).on('click', '#Auditar', function () {
        t.clear().draw();
        if(missing.length === 0){
            Swal.fire({
                icon: 'success',
                title: 'Todo en orden...',
                text: 'No hay ninguna factura faltante en el rango de fechas seleccionado',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
        }else{
            for (let i = 0; i < missing.length; i++) {
                t.row.add( [
                    `<input type="checkbox" class="checkboxes check" id="`+ missing[i] +`">`,
                    missing[i],
                    `<button class="btn btn-light info_factura_modal" id="`+ missing[i] +`"> <i class="fas fa-info-circle"></i> Info</button>`,
                ] ).draw( false );
            }
            $('#facturas_pendientes_modal').modal('show');
        }
    });


    $(document).on('click', "#crear_xml_modal", function () {
        var selected = [];
        $(".checkboxes").each(function () {
            if (this.checked) {
                const numero = this.id;
                const factura = {
                    "numero": numero,
                };
                selected.push(factura);
            }
        });
        if (selected.length) {
            Swal.fire({
                icon: false,
                title: 'Generando XML un momento por favor...',
                html: '<br><div class="container" style="align-items: center !important; margin-left: 150px; margin-right: 150px"><div class="preloader"></div></div>',
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                cache: false,
                type: 'post',
                dataType: 'json', // importante para que
                data: {selected: JSON.stringify(selected)}, // jQuery convierta el array a JSON
                url: '/aplicaciones/facturacion_electronica/factura/generar_xml',
                success: function () {
                    sweetAlert.close();
                    Swal.fire({
                        title: 'Terminado!',
                        html: 'XML generado con exito!.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                    });
                    let req = new XMLHttpRequest();
                    req.open("GET", "/factura_electronica.xml", true);
                    req.responseType = "blob";
                    req.onload = function (event) {
                        var blob = req.response;
                        var link=document.createElement('a');
                        link.href=window.URL.createObjectURL(blob);
                        let current_datetime = new Date();
                        let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
                        link.download="factura" + formatted_date + "_.xml";
                        link.click();
                    };
                    req.send();
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Hubo un error al generar el XML..!',
                    });
                }
            });
        } else
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes seleccionar al menos una factura...!',
            });
        return false;
    });



    $(document).on('click', '.info_factura_modal', function () {
        let id = this.id;
        $('#erros_sweet').html('');
        $.ajax({
            url: '/aplicaciones/facturacion_electronica/gestions/comprobar_factura',
            type: 'get',
            data: {id:id},
            success:function (data) {
                if (data.length == 0){
                    Swal.fire({
                        icon: 'success',
                        title: 'Factura OK!',
                    });
                }else{
                    for (let i = 0; i <data.length; i++) {
                        $('#erros_sweet').append(data[i]+ '<br>')
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        html: $('#erros_sweet').html()
                    });
                }
            },
            error:function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    $(document).on('click', '#subir_ws_modal', function () {
        var selected = [];
        $(".checkboxes").each(function () {
            if (this.checked) {
                var numero = this.id;
                var factura ={
                    "numero":numero,
                };
                selected.push(factura);
            }
        });
        if (selected.length) {
            Swal.fire({
                icon: false,
                title: 'Enviando Facturas seleccionadas a traves de WebService, un momento por favor...',
                html: '<br><div class="container" style="align-items: center !important; margin-left: 150px; margin-right: 150px"><div class="preloader"></div></div>',
                showConfirmButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'post',
                dataType: 'json', // importante para que
                data: {
                    selected: JSON.stringify(selected),
                }, // jQuery convierta el array a JSON
                url: '/aplicaciones/facturacion_electronica/web_service/envio_facturas',
                success: function (data) {
                    $('#Errors').html('');
                    var i = 0;
                    $(data).each(function () {
                        var estado;

                        if (data[i].success == true){
                            estado = '<label class="text-success">Cargado con exito!</label>'
                        }else{
                            estado = '<label class="text-danger"> Con errores </label>'
                        }

                        $('#Errors').append('<b><label>Estado de carga: </label></b>  <label>'+ estado +'</label> <br>' +
                            '<b><label>Mensaje: </label></b>  <label>'+ data[i].msg +'</label>');
                        i++;
                    });
                    sweetAlert.close();

                    Swal.fire({
                        backdrop: true,
                        title: 'Terminado!',
                        html: $('#Errors').html(),
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                    })
                },
                error: function (data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Hubo un error al enviar los datos por WebService..!',
                    });
                }
            });
        } else
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debes seleccionar al menos una factura...!',
            });
        return false;
    });



    $(document).on('click','.info_ws',function () {
        let id = this.id;
        $.ajax({
            url: '/aplicaciones/facturacion_electronica/web_service/info_documento',
            type: 'get',
            data: {
                id : id,
            },
            success: function (data) {
                $('#nombreAdquiriente').html(data.nombreAdquiriente);
                $('#identificacionAdquiriente').html(data.identificacionAdquiriente);
                $('#correoenvio').html(data.correoenvio);
                $('#fechageneracion').html(data.fechageneracion);
                $('#fecharegistro').html(data.fecharegistro);
                $('#descestadoenviodian').html(data.descestadoenviodian);
                $('#processedmessage').html(data.processedmessage);
                $('#descestadoenviocliente').html(data.descestadoenviocliente);
                $('#comentarioenvio').html(data.comentarioenvio);

                if(data.correosCopia != ''){
                    var i = 0;
                    $('#correosCopia').append('<label><b>Correos Copia: </b></label> ');
                    $(data.correosCopia).each(function () {
                        $('#correosCopia').append('<label>'+ data.correosCopia[i].correo +', </label> ');
                        i++;
                    });
                }else{
                    $('#correosCopia').html('');
                }

                if(data.verificacionfuncionales != ''){
                    var i = 0;
                    $('#verificacionfuncionales').append('<label><b>Observaciones : </b></label> ');
                    $('#verificacionfuncionales').append('<a href="javascript:void(0)" class="infoObsWs" > Observaciones encontradas: '+ data.verificacionfuncionales.length +'</a> <br>');
                    $(data.verificacionfuncionales).each(function () {
                        $('#InfoWsObservDetail').append('<label>'+ data.verificacionfuncionales[i].comentarios +'</label> <br>'),
                            i++
                    });
                }else{
                    $('#verificacionfuncionales').html('');
                    $('#InfoWsObservDetail').html('');
                }
                $('#InfoWsInvoice').modal('show');
            },
            error: function () {
                alert('error');
            }
        });
    });



    $(document).on('click','.infoObsWs',function () {
        $('#InfoWsObserv').modal('show');
    });


    $(document).on('click', '.send_email', function () {
        let id = this.id
        swal.mixin({
            title: 'Reenviar factura',
            text: 'Escriba los email a los cuales desea enviar esta factura',
            icon: 'info',
            showCancelButton: true,
            input: 'text',
            onOpen: () => {
                $('.correos').select2({
                    createTag: function(term, data) {
                        var value = term.term;
                        if(validateEmail(value)) {
                            return {
                                id: value,
                                text: value
                            };
                        }
                        return null;
                    },
                    placeholder: "Escribe uno o varios email..",
                    tags: true,
                    tokenSeparators: [',', ' ',';'],
                    width: '100%',
                });
            }
        }).queue([
            {
                html: '<select class="form-control correos" name="correos" id="correos" multiple="multiple" style="width: 100%"></select>',
                inputValidator: () => {
                    if (document.getElementById('correos').value == '') {
                        return 'Debes escribir al menos una direccion de correo...';
                    }
                },

                preConfirm: function () {
                    return $("#correos").val();
                },
                onBeforeOpen: function (dom) {
                    swal.getInput().style.display = 'none';
                }
            },
        ]).then((result) => {
            if (result.value) {
                Swal.fire({
                    icon: false,
                    title: 'Enviando correo(s), un momento por favor...',
                    html: '<br><video autoplay loop muted playsinline  width="70%"><source src="/img/shake.mp4" type="video/mp4"></video> </div>',
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                $.ajax({
                    url: '/aplicaciones/facturacion_electronica/web_service/enviar_documento_electronico',
                    type: 'post',
                    data: {
                        id : id,
                        correos: result.value[0]
                    },
                    success:function () {
                        sweetAlert.close();
                        Swal.fire({
                            title: 'Factura(s) enviada(s)!',
                            html: 'Proceso finalizado con exito!.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar',
                        });
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.responseText,
                        });
                    }
                })
            }else{
                result.dismiss === Swal.DismissReason.cancel
            }

        });



    });

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }
});
