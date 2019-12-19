$(document).ready(function () {
    var from = $( "#from_date" )
    .datepicker({
        dateFormat: "yy-mm-dd 00:00:00",
        changeMonth: true,
        changeYear: false,
        closeText: 'Cerrar',
        prevText: 'Ant',
        nextText: 'Sig',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        showAnim: "drop"
    })
    .on( "change", function() {
        to.datepicker( "option", "minDate", getDate( this ) );
    }),
    to = $( "#to_date" ).datepicker({
        dateFormat: "yy-mm-dd 23:59:59",
        changeMonth: true,
        changeYear: false,
        closeText: 'Cerrar',
        prevText: 'Ant',
        nextText: 'Sig',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        weekHeader: 'Sm',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: '',
        showAnim: "drop"
    })
    .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
    });

    function getDate( element ) {
        var date;
        var dateFormat = "yy-mm-dd";
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }
        return date;
    }
    load_data();

    var table;

    function load_data(from_date = '', to_date = '')
    {
        var errors = [];
        var count = 0;
        var id = $(this).data('id');
        table =  $('#tfac').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: true,
            scrollY: false,
            scrollX: false,
            scrollCollapse: true,
            paging: true,
            fixedColumns: true,
            ajax: {
                url:'/FacturasIndex',
                data:{from_date:from_date, to_date:to_date}
            },
            columns: [
                {data: 'selectAll', name: 'selectAll', orderable: false, searchable: false },
                {class: "details-control", orderable:false, data: null, defaultContent: ""},
                {data: 'id', name: 'id', orderable: false, searchable: true},
                {data: 'ov', name: 'ov', orderable: false, searchable: true},
                {data: 'fecha', name: 'fecha', orderable: false, searchable: false},
                {data: 'plazo', name: 'plazo', orderable: false, searchable: false},
                {data: 'razon_social', name: 'razon_social'},
                {data: 'tipo_cliente', name: 'tipo_cliente', orderable: false, searchable: true},
                {data: 'vendedor', name: 'vendedor'},
                {data: 'bruto', name:'bruto', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                {data: 'desc', name: 'desc', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                {data: 'valor_iva', name: 'valor_iva', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                {data: 'motivo', name: 'motivo', orderable: false, searchable: true},
                {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

            ],
            language: {
                // traduccion de datatables
                processing: "Cargando Facturas...",
                search: "Buscar&nbsp;:",
                lengthMenu: "Mostrar _MENU_ Facturas",
                info: "Mostrando Facturas del _START_ al _END_ de un total de _TOTAL_ Facturas",
                infoEmpty: "Mostrando Facturas del 0 al 0 de un total de 0 Facturas",
                infoFiltered: "(filtrado de un total de _MAX_ facturas)",
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
            rowCallback: function( row, data, index ) {
                if ( data.fecha == null ) {
                    $(row).find('td:eq(3)').css('color', 'red');
                }

                if (data.plazo == null) {
                    $(row).find('td:eq(4)').css('color', 'red');
                }

                if (data.razon_social == null) {
                    $(row).find('td:eq(5)').css('color', 'red');
                }

                if (data.tipo_cliente == null) {
                    $(row).find('td:eq(6)').css('color', 'red');
                }

                if (data.vendedor == null) {
                    $(row).find('td:eq(7)').css('color', 'red');
                }

                if (data.bruto == null) {
                    $(row).find('td:eq(9)').css('color', 'red');
                }

                if (data.bruto <= 3000) {
                    $(row).find('td:eq(9)').css('color', 'red');
                }

                if (data.bruto >= 20000000) {
                    $(row).find('td:eq(9)').css('color', 'red');
                }

                if ((data.desc / data.bruto) * 100 >= 20) {
                    $(row).find('td:eq(9)').css('color', 'red');
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
                    $(row).find('td:eq(11)').css('color', 'red');
                }
            },

        });
    }

    var detailRows = [];

    $('#tfac tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );

        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();

            // Remove from the 'open' array
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

    // On each draw, loop over the `detailRows` array and show any child rows
    table.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    });

    $('#filter').click(function(){
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        if(from_date != '' &&  to_date != '')
        {
            $('#tfac').DataTable().destroy();
            load_data(from_date, to_date);
        }
        else
        {
            toastr.error("Ambas fechas son requeridas para poder filtrar.");
        }
    });

    $("#CrearXml").click(function () {
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
                title: 'Generando XML un momento por favor...',
                html: '<img src="../img/carga.gif" alt="">',
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
                url: '/fe/xml',
                success: function ( data) {
                    sweetAlert.close();
                    Swal.fire({
                        title: 'Terminado!',
                        html: 'XML generado con exito!.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar',
                    });
                    // preventDefault();  //stop the browser from following
                    var req = new XMLHttpRequest();
                    req.open("GET", "XML/Facturacion_electronica_Facturas.xml", true);
                    req.responseType = "blob";
                    console.log(req);
                    req.onload = function (event) {
                        var blob = req.response;
                        var link=document.createElement('a');
                        link.href=window.URL.createObjectURL(blob);
                        let current_datetime = new Date();
                        let formatted_date = 'Fecha: '+current_datetime.getDate() + "/" + (current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear()+ " Hora:" + current_datetime.getHours()+':'+ current_datetime.getMinutes()+':'+current_datetime.getSeconds();
                        link.download="Factura_Electronica_" + formatted_date + "_.xml";
                        link.click();
                    };
                    req.send();
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

    $("#selectAll").on("click", function() {
        $(".test").prop("checked", this.checked);
    });

// if all checkbox are selected, check the selectall checkbox and viceversa
    $(".test").on("click", function() {
        if ($(".test").length == $(".test:checked").length) {
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
});

