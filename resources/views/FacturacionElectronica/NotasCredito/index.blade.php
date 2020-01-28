@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite validar las Notas Credito generadas en MAX.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_notas_cre') }}
@stop

@section('content')
@can('notascredito.view')
    <div class="col-12">
        <div class="row">
            <h3> Por favor, seleccione un rango de fechas para comenzar con la busqueda.</h3>
        </div>
    </div>
    <br>
    <div class="form-group">
        <div class="input-group">
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Fecha inicial" readonly />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Fecha final" readonly />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary btn-sm">Buscar</button>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="col-lg-4">
        <div class="form-group">
            <span><input type="button" class="btn btn-primary btn-sm" id="CrearXml" value="Descargar XML"></span>
            <span><input type="button" class="btn btn-primary btn-sm" id="WebService" value="Enviar via WebService"></span>
        </div>
    </div>

    <div class="DatosWebServ" id="DatosWebServ" name="DatosWebServ" style="display: none !important;">
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive table-striped" id="tfac">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" name="selectAll"></th>
                                    <th>&nbsp; &nbsp;</th>
                                    <th>Numero</th>
                                    <th>Factura Ref</th>
                                    <th>Fecha</th>
                                    <th>Razon Social</th>
                                    <th>Tipo Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Valor bruto</th>
                                    <th>Descuento</th>
                                    <th>IVA</th>
                                    <th>Motivo</th>
                                    <th>Estado DIAN</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .red {
            background-color: red !important;
        }

        td.details-control {
            background: url('/img/informacion.png') no-repeat center center;
            cursor: pointer;
        }
        tr.details td.details-control {
            background: url('/img/x.png') no-repeat center center;
        }

        .preloader {
            width: 140px;
            height: 140px;
            border: 20px solid #eee;
            border-top: 20px solid #008000;
            border-radius: 50%;
            animation-name: girar;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

        @keyframes girar {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .preloader_datatable {
            width: 35px;
            height: 35px;
            border: 7px solid #eee;
            border-top: 7px solid #008000;
            border-radius: 50%;
            animation-name: girar;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

    </style>
@else
    <div class="alert alert-danger" role="alert">
        No tienes permisos para visualizar las Notas Credito.
    </div>
@endcan
@push('javascript')
    <script>
        $(document).ready(function () {
            var Username = @json( Auth::user()->username);

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

            function load_data(from_date = '', to_date = '') {
                var errors = [];
                var count = 0;
                var id = $(this).data('id');
                table = $('#tfac').DataTable({
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
                        url: '/NotasCreditoIndex',
                        data: {from_date: from_date, to_date: to_date}
                    },
                    columns: [
                        {data: 'selectAll', name: 'selectAll', orderable: false, searchable: false },
                        {class: "details-control", orderable:false, data: null, defaultContent: ""},
                        {data: 'id', name: 'id', orderable: false, searchable: true},
                        {data: 'OC', name: 'OC', orderable: false, searchable: true},
                        {data: 'fecha', name: 'fecha', orderable: false, searchable: false},
                        {data: 'razon_social', name: 'razon_social'},
                        {data: 'tipo_cliente', name: 'tipo_cliente', orderable: false, searchable: true},
                        {data: 'vendedor', name: 'vendedor'},
                        {data: 'bruto', name:'bruto', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                        {data: 'desc', name: 'desc', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                        {data: 'valor_iva', name: 'valor_iva', orderable: false, searchable: false, render: $.fn.dataTable.render.number('.', ',', 2, '$')},
                        {data: 'motivo', name: 'motivo', orderable: false, searchable: true},
                        {data: 'EstadoDian',name: 'EstadoDian',orderable: true, searchable: true},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
                    ],

                    columnDefs: [
                        {
                            targets: 0,
                        }
                    ],

                    select: {
                        style: 'multi'
                    },

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

                        var id = data.id;
                        console.log(id);
                        $.ajax({
                            url: '/EstadoEnvioDianFacturacionElectronica',
                            type: 'get',
                            data: {
                                id:id,
                                Username: Username
                            },
                            success: function (data) {
                                if (data != ''){
                                    $(row).find('td:eq(12)').html('<label id="'+id+'" class="text-success">'+data+'</label>')
                                }else{
                                    $(row).find('td:eq(12)').html('<a href="javascript:void(0)" id="'+id+'" class="text-danger">Error</a>')
                                }
                            },
                            error: function () {
                                $(row).find('td:eq(12)').html('<a href="javascript:void(0)" id="'+id+'" class="text-danger ErrorEstDianFac">Pendiente</a>')
                            }
                        });

                        if (data.fecha == null) {
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
                            $(row).find('td:eq(8)').css('color', 'red');
                        }


                        if (data.bruto <= 3000) {
                            $(row).find('td:eq(8)').css('color', 'red');
                        }

                        if (data.bruto >= 20000000) {
                            $(row).find('td:eq(8)').css('color', 'red');
                        }

                        if ((data.desc / data.bruto) * 100 >= 20) {
                            $(row).find('td:eq(8)').css('color', 'red');
                        }

                        var porc_iva = (data.valor_iva / data.subtotal) * 100;
                        if (data.motivo != 27 && porc_iva <= 18.95 || porc_iva >= 19.05) {
                            $(row).find('td:eq(10)').css('color', 'red');
                        }

                        if (data.cod_alter == null) {
                            $('td', row).css('color', 'red');
                        }

                        if (data.motivo == null) {
                            $(row).find('td:eq(11)').css('color', 'red');
                        }

                        if (data.email == null) {
                            $('td', row).css('color', 'red');
                        }
                    }
                });
            }

            var detailRows = [];

            $('#tfac tbody').on('click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var idx = $.inArray(tr.attr('id'), detailRows);

                if (row.child.isShown()) {
                    tr.removeClass('details');
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice(idx, 1);
                } else {
                    tr.addClass('details');
                    row.child(format(row.data())).show();

                    // Add to the 'open' array
                    if (idx === -1) {
                        detailRows.push(tr.attr('id'));
                    }
                }
            });

            table.on('draw', function () {
                $.each(detailRows, function (i, id) {
                    $('#' + id + ' td.details-control').trigger('click');
                });
            });

            $('#filter').click(function () {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                if (from_date != '' && to_date != '') {
                    $('#tfac').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    toastr.error("Ambas fechas son requeridas para poder filtrar.");
                }
            });


            $("#CrearXml").click(function () {
                var selected = [];
                $(".checkboxes").each(function () {
                    if (this.checked) {
                        var numero = this.id;
                        var factura = {
                            "numero": numero,
                        };
                        selected.push(factura);
                    }
                });
                if (selected.length) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    Swal.fire({
                        icon: false,
                        title: 'Generando XML un momento por favor...',
                        html: '<br><div class="container" style="align-items: center !important; margin-left: 150px; margin-right: 150px"><div class="preloader"></div></div>',
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });

                    $.ajax({
                        cache: false,
                        type: 'post',
                        dataType: 'json', // importante para que
                        data: {selected: JSON.stringify(selected)}, // jQuery convierta el array a JSON
                        url: 'nc/xml',
                        success: function () {
                            sweetAlert.close();
                            Swal.fire({
                                title: 'Terminado!',
                                html: 'XML generado con exito!.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                            });
                            // preventDefault();  //stop the browser from following
                            var req = new XMLHttpRequest();
                            req.open("GET", "XML/NotasCredito.xml", true);
                            req.responseType = "blob";

                            req.onload = function (event) {
                                var blob = req.response;
                                console.log(blob.size);
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                let current_datetime = new Date();
                                let formatted_date = 'Fecha: ' + current_datetime.getDate() + "/" + (current_datetime.getMonth() + 1) + "/" + current_datetime.getFullYear() + " Hora:" + current_datetime.getHours() + ':' + current_datetime.getMinutes() + ':' + current_datetime.getSeconds();
                                link.download = "Notas_Credito_" + formatted_date + "_.xml";
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

            $("#selectAll").on("click", function () {
                $(".test").prop("checked", this.checked);
            });

            // if all checkbox are selected, check the selectall checkbox and viceversa
            $(".test").on("click", function () {
                if ($(".test").length == $(".test:checked").length) {
                    $("#selectAll").prop("checked", true);
                } else {
                    $("#selectAll").prop("checked", false);
                }
            });

            var resultado;
            function format ( d ) {
                console.log(d);
                var porc_iva = (d.valor_iva / d.subtotal) * 100;
                var count = 0;
                resultado = [];

                if ( d.fecha == null ) {
                    resultado.push('<label class="alert-danger">La nota credito no tiene fecha</label> <br>');
                    count = 1;
                }

                if (d.plazo == null) {
                    resultado.push('<label class="alert-danger">La nota credito no tiene plazo</label> <br>');
                    count = 1;
                }

                if (d.razon_social == null) {
                    resultado.push('<label class="alert-danger">La nota credito no tiene razon social</label> <br>');
                    count = 1;
                }

                if (d.tipo_cliente == null) {
                    resultado.push('<label class="alert-danger">La nota credito no tiene tipo de cliente</label> <br>');
                    count = 1;
                }

                if (d.vendedor == null) {
                    resultado.push('<label class="alert-danger">La nota credito no tiene vendedor</label> <br>');
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

                if (d.email == null) {
                    resultado.push('<label class="alert-danger">El cliene no tiene email para el envio de nota credito</label> <br> ');
                    count = 1;
                }

                if (d.motivo != 27 && porc_iva <= 18.95 || porc_iva >= 19.05 ) {
                    resultado.push('<label class="alert-danger">Porcentaje de iva es mayor o menor a 19% </label> <br>');
                    count = 1;
                }

                if (d.motivo == null) {
                    resultado.push('<label class="alert-danger">la nota credito debe llevar motivo </label><br>');
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
                    resultado.push('<label class="alert-danger">la nota credito debe llevar motivo </label><br>');
                    count = 1;
                }

                if (count == 0) {
                    resultado = '<label class="alert-success">Nota credito OK</label><br>';
                }

                return  'Detalle de Nota credito : '+d.id+' <br>'+ resultado ;
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
                        cache: false,
                        type: 'post',
                        dataType: 'json', // importante para que
                        data: {
                            selected: JSON.stringify(selected),
                            Username: Username
                        }, // jQuery convierta el array a JSON
                        url: '/NotasCreditoWebService',
                        success: function (data) {
                            $('#DatosWebServ').html('');
                            var i = 0;
                            $(data).each(function () {
                                var estado;

                                if (data[i].success == true){
                                    estado = '<label class="text-success">Cargado con exito!</label>'
                                }else{
                                    estado = '<label class="text-danger"> Con errores </label>'
                                }

                                $('#DatosWebServ').append('<b><label>Estado de carga: </label></b>  <label>'+ estado +'</label> <br>' +
                                    '<b><label>Mensaje: </label></b>  <label>'+ data[i].msg +'</label>');
                                i++;
                            });
                            sweetAlert.close();

                            Swal.fire({
                                backdrop: true,
                                title: 'Terminado!',
                                html: $('#DatosWebServ').html(),
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                            })
                        },
                        error: function (data) {
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



            $('body').on('click','.download-vg', function () {
                var id = this.id;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: '/DescargarVersionGrafica',
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
                        link.download="Nota_Credito_"+id+".pdf";
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

        });
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
    <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
    <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/awesome-bootstrap-checkbox/0.3.7/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
@endpush
@stop
