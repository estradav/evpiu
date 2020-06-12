$(document).ready(function () {
    let star_date = moment().format('YYYY-MM-DD 00:00:00'), end_date = moment().format('YYYY-MM-DD 23:59:59');
    moment.locale('es');
    $('input[id="date_time"]').daterangepicker({
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
        star_date = start.format('YYYY-MM-DD 00:00:00');
        end_date = end.format('YYYY-MM-DD 23:59:59');
    });

    load_data();
    var table;

    function load_data(from_date, to_date) {
        const errors = [];
        const count = 0;
        const id = this.id;
        table =  $('#tfac').DataTable({
            responsive: true,
            ajax: {
                url:'/aplicaciones/facturacion_electronica/nota_credito',
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
                {data: 'selectAll', name: 'selectAll', orderable: false, searchable: false },
                {data: 'id', name: 'id', orderable: false, searchable: true},
                {data: 'OC', name: 'OC', orderable: false, searchable: true},
                {data: 'fecha', name: 'fecha', orderable: false, searchable: false},
                {data: 'razon_social', name: 'razon_social'},
                {data: 'nit_cliente', name: 'nit_cliente'},
                {data: 'tipo_cliente', name: 'tipo_cliente', orderable: false, searchable: true},
                {data: 'vendedor', name: 'vendedor'},
                {data: 'bruto', name:'bruto', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                {data: 'desc', name: 'desc', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                {data: 'valor_iva', name: 'valor_iva', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                {data: 'EstadoDian',name: 'EstadoDian',orderable: true, searchable: true},
                {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
            ],
            language: {
                url: '/Spanish.json'
            },
            rowCallback: function( row, data, index ) {
                let id = data.id;
                $.ajax({
                    url: '/aplicaciones/facturacion_electronica/web_service/estado_dian',
                    type: 'get',
                    data: {
                        id:id,
                        Username: Username
                    },
                    success: function (data) {
                        if (data !== ''){
                            $(row).find('td:eq(11)').html('<label id="'+id+'" class="text-success">'+data+'</label>')
                        }else{
                            $(row).find('td:eq(11)').html('<a href="javascript:void(0)" id="'+id+'" class="text-danger">Error</a>')
                        }
                    },
                    error: function () {
                        $(row).find('td:eq(11)').html('<a href="javascript:void(0)" id="'+id+'" class="text-danger ErrorEstDianFac">Pendiente</a>')
                    }
                });

                if ( data.fecha == null ) {
                    $(row).find('td:eq(4)').css('color', 'red');
                }

                if (data.plazo == null) {
                    $(row).find('td:eq(5)').css('color', 'red');
                }

                if (data.razon_social == null) {
                    $(row).find('td:eq(6)').css('color', 'red');
                }

                if (data.tipo_cliente == null) {
                    $(row).find('td:eq(8)').css('color', 'red');
                }

                if (data.vendedor == null) {
                    $(row).find('td:eq(9)').css('color', 'red');
                }

                if (data.bruto == null) {
                    $(row).find('td:eq(10)').css('color', 'red');
                }

                if (data.bruto <= 3000) {
                    $(row).find('td:eq(10)').css('color', 'red');
                }

                if (data.bruto >= 20000000) {
                    $(row).find('td:eq(10)').css('color', 'red');
                }

                if ((data.desc / data.bruto) * 100 >= 20) {
                    $(row).find('td:eq(10)').css('color', 'red');
                }

                var porc_iva = (data.valor_iva / data.subtotal) * 100;
                if (data.motivo != 27 && porc_iva <= 18.95 || porc_iva >= 19.05 ) {
                    $(row).find('td:eq(10)').css('color', 'red');
                }

                if (data.cod_alter == null) {
                    $('td', row).css('color', 'red');
                }

                if (data.motivo == null) {
                    $(row).find('td:eq(12)').css('color', 'red');
                }

                if (data.email == null || data.email == '') {
                    $('td', row).css('color', 'red');
                }

                if (data.nombres == null){
                    $('td', row).css('color', 'red');
                }

                if (data.emailcontacto == '' || data.emailcontacto == null){
                    $('td', row).css('color', 'red');
                }

                if (data.tipo_cliente != 'ZF' && data.tipo_cliente != 'EX' && data.valor_iva == 0 ){
                    $('td', row).css('color', 'red');
                }
            }
        });
    }

    table.column( '.init-hide' ).visible( false );
    var detailRows = [];

    $(document).on( 'click', '.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    });

    table.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    });

    $('#filter').click(function(){

        if(star_date !== '' &&  end_date !== ''){
            $('#tfac').DataTable().destroy();
            load_data(star_date, end_date);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ambas fechas son requeridas para poder filtrar..!',
            });
        }
    });



    $("#CrearXml").click(function () {
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
                data: {selected: JSON.stringify(selected)},
                url: '/aplicaciones/facturacion_electronica/nota_credito/generar_xml',
                success: function () {
                    sweetAlert.close();
                    Swal.fire({
                        title: 'Terminado!',
                        html: 'XML generado con exito!.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                    });
                    let req = new XMLHttpRequest();
                    req.open("GET", "/notas_credito.xml", true);
                    req.responseType = "blob";
                    req.onload = function (event) {
                        var blob = req.response;
                        var link=document.createElement('a');
                        link.href=window.URL.createObjectURL(blob);
                        let current_datetime = new Date();
                        let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
                        link.download="nota_credito" + formatted_date + "_.xml";
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
                text: 'Debes seleccionar al menos una nota credito...!',
            });
        return false;
    });

    $("#selectAll").on("click", function() {
        $(".test").prop("checked", this.checked);
    });

    $(".test").on("click", function() {
        if ($(".test").length === $(".test:checked").length) {
            $("#selectAll").prop("checked", true);
        } else {
            $("#selectAll").prop("checked", false);
        }
    });

    var resultado;
    function format ( d ) {
        var porc_iva = (d.valor_iva / d.subtotal) * 100;
        var count = 0;
        resultado = [];

        if ( d.fecha == null ) {
            resultado.push('<label class="alert-danger">La factura no tiene fecha</label> <br>');
            count = 1;
        }

        if (d.plazo == null) {
            resultado.push('<label class="alert-danger">La factura no tiene plazo</label> <br>');
            count = 1;
        }

        if (d.razon_social == null) {
            resultado.push('<label class="alert-danger">La factura no tiene razon social</label> <br>');
            count = 1;
        }

        if (d.tipo_cliente == null) {
            resultado.push('<label class="alert-danger">La factura no tiene tipo de cliente</label> <br>');
            count = 1;
        }

        if (d.vendedor == null) {
            resultado.push('<label class="alert-danger">La factura no tiene vendedor</label> <br>');
            count = 1;
        }

        if (d.cod_alter == null) {
            resultado.push('<label class="alert-danger">Cliente no exite en Dms </label> <br>');
            count = 1;
        }

        if ((d.desc / d.bruto) * 100 >= 20) {
            resultado.push('<label class="alert-danger">El descuento es demasiado alto </label> <br>');
            count = 1;
        }

        if (d.email == null || d.email == '') {
            resultado.push('<label class="alert-danger">El cliene no tiene email para el envio de facturas</label> <br> ');
            count = 1;
        }

        if (d.motivo != 27 && porc_iva <= 18.95 || porc_iva >= 19.05 ) {
            resultado.push('<label class="alert-danger">Porcentaje de iva es mayor o menor a 19% </label> <br>');
            count = 1;
        }

        if (d.motivo == null) {
            resultado.push('<label class="alert-danger">la factura debe llevar motivo </label><br>');
            count = 1;
        }

        if (d.bruto == null) {
            resultado.push('<label class="alert-danger">Valor bruto Vacio</label><br>');
            count = 1;
        }

        if (d.bruto >= 20000000) {
            resultado.push('<label class="alert-danger">Valor bruto demasiado Alto!</label><br>');
            count = 1;
        }

        if (d.bruto <= 3000) {
            resultado.push('<label class="alert-danger">Valor bruto demasiado Bajo!</label><br>');
            count = 1;
        }

        if (d.motivo == null) {
            resultado.push('<label class="alert-danger">la factura debe llevar motivo </label><br>');
            count = 1;
        }

        if (d.nombres == ''){
            resultado.push('<label class="alert-danger">Falta nombres en DMS </label><br>');
            count = 1;
        }

        if (d.emailcontacto == '' || d.emailcontacto == null){
            resultado.push('<label class="alert-danger">Falta email de Contacto </label><br>');
            count = 1;
        }

        if (d.tipo_cliente != 'ZF' && d.tipo_cliente != 'EX' && d.valor_iva == 0){
            resultado.push('<label class="alert-danger">Falta IVA en esta factura </label><br>');
            count = 1;
        }

        if (count == 0) {
            resultado = '<label class="alert-success">Factura OK</label><br>';
        }
        return  'Detalle de Factura : '+d.id+' <br>'+ resultado ;
    }


    $('#WebService').on('click',function () {
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
                title: 'Enviando Nota credito seleccionadas a traves de WebService, un momento por favor...',
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
                    Username: Username
                },
                url: '/aplicaciones/facturacion_electronica/web_service/envio_notas_credito',
                success: function (data) {
                    console.log(data);
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
                text: 'Debes seleccionar al menos una nota credito...!',
            });
        return false;
    });

    $(document).on('click','.download-vg', function () {
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
                Username: Username
            },
            success: function (data) {
                var base64str = data;

                // decode base64 string, remove space for IE compatibility
                var binary = atob(base64str.replace(/\s/g, ''));
                var len = binary.length;
                var buffer = new ArrayBuffer(len);
                var view = new Uint8Array(buffer);
                for (var i = 0; i < len; i++) {
                    view[i] = binary.charCodeAt(i);
                }

                // create the blob object with content-type "application/pdf"
                var blob = new Blob( [view], { type: "application/pdf" });
                var link=document.createElement('a');
                link.href=window.URL.createObjectURL(blob);
                let current_datetime = new Date();
                // let formatted_date = 'Fecha: '+current_datetime.getDate() + "/" + (current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear()+ " Hora:" + current_datetime.getHours()+':'+ current_datetime.getMinutes()+':'+current_datetime.getSeconds();
                link.download="nota_credito"+id+".pdf";
                link.click();
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la Descarga...',
                    text: 'Hubo un error al descargar el pdf de esta nota credito...!',
                });
            }
        });
    });

    $(document).on('click', '.ErrorEstDianFac', function () {
        var id = this.id;
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'La  Nota credito '+id+'  no ha sido subida a Factible!',
        });
    });

    $(document).on('click','.ErrorDianFac', function () {
        var id =  this.id;
        $.ajax({
            url: '/aplicaciones/facturacion_electronica/web_service/estado_dian',
            type: 'get',
            data: {id: id},
            success: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Esta nota credito tiene errores !',
                    html: '<label>La  nota credito '+id+'  no ha podido ser enviarda a la DIAN!</label><br>' +
                        '<label> <b>Error: </b> '+data.data.comments+'</label>',
                });
            }
        });
    });


});


