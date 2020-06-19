$(document).ready(function () {
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
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
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


    $(document).on('click','.download_ws', function () {
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
                console.log(array);


                array = array.sort();

                console.log(array.length);
                for(let i = 1; i < array.length; i++) {

                    if(array[i] - array[i-1] !== 1) {
                        console.log(array[i]);
                        var x = array[i] - array[i-1];
                        let k = 1;
                        while (k<x) {
                            missing.push(array[i-1]+k);
                            k++;
                        }
                    }
                    console.log(missing)
                }
            }
        });
    }

    $(document).on('click', '#Auditar', function () {
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
            Swal.fire({
                icon: 'info',
                title: 'Hay facturas pendientes por cargar',
                html: '<h3 >Facturas pendientes por cargar en el rango seleccionado:</h3> <h3>'+ missing +'</h3>',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            });
        }
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
                console.log(data);
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




        $('body').on('click','.infoObsWs',function () {
            $('#InfoWsObserv').modal('show');
        });
    });
});
