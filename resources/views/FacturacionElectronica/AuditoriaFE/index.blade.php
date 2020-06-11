@extends('layouts.architectui')

@section('page_title', 'Gestion Facturacion Electronica')

@section('content')
    @can('AuditoriaFe.view')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-2">
                                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Fecha inicial" readonly />
                            </div>
                            <div class="col-2">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Fecha final" readonly />
                            </div>
                            <div class="col-2">
                                <input type="number" name="fe_start" id="fe_start" class="form-control" placeholder="Factura Inicia"/>
                            </div>
                            <div class="col-2">
                                <input type="number" name="fe_end" id="fe_end" class="form-control" placeholder="Factura Final"/>
                            </div>
                            <div class="col-2">
                                <select name="type_doc" id="type_doc" class="form-control">
                                    <option value="1">Factura</option>
                                    <option value="2">Nota Debito</option>
                                    <option value="3">Nota Credito</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-primary" id="filter"><i class="fas fa-search"></i> Filtrar</button>
                                <button class="btn btn-primary" id="Auditar"><i class="fas fa-file-invoice"></i> <i class="fas fa-check-double"></i> Auditar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped" id="tfac">
                                <thead>
                                    <tr>
                                        <th>ID FACTIBLE</th>
                                        <th>FACTURA/NOTA</th>
                                        <th>TIPO</th>
                                        <th>CLIENTE</th>
                                        <th>NIT/CC</th>
                                        <th>F. GENERACION</th>
                                        <th>F. REGISTRO</th>
                                        <th>ESTADO DIAN</th>
                                        <th>ESTADO CLIENTE</th>
                                        <th class="text-center">ACCIONES</th>
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
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
    @push('javascript')
        <script>
            $(document).ready(function () {
                let Username = @json( Auth::user()->username);

                var from = $( "#from_date" ).datepicker({
                    dateFormat: "yy-mm-dd",
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
                }).datepicker('widget').wrap('<div class="ll-skin-nigran"/>'),

                to = $( "#to_date" ).datepicker({
                    dateFormat: "yy-mm-dd",
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
                Listado_de_facturas();

                var table;

                function load_data(from_date = '', to_date = '' ,fe_start = '', fe_end = '', type_doc = '')
                {
                    table =  $('#tfac').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: true,
                        autoWidth: false,
                        ajax: {
                            url:'/GestionFacturacionElectronica_data',
                            data:{
                            	from_date:from_date,
                                to_date:to_date,
                                fe_start:fe_start,
                                fe_end:fe_end,
                                type_doc:type_doc,
                                Username:Username
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
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    var fe_start = $('#fe_start').val();
                    var fe_end = $('#fe_end').val();
                    var type_doc = $('#type_doc').val();

                    if(from_date != '' &&  to_date != '')
                    {
                        $('#tfac').DataTable().destroy();
                        load_data(from_date, to_date, fe_start, fe_end, type_doc);
                        Listado_de_facturas(from_date, to_date, fe_start, fe_end, type_doc);
                    }
                    else if(fe_start != '' &&  fe_end != '')
                    {
                        $('#tfac').DataTable().destroy();
                        load_data(from_date, to_date, fe_start, fe_end, type_doc);
                        Listado_de_facturas(from_date, to_date, fe_start, fe_end, type_doc);
                    }
                    else {
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
                        url: '/GestionFacturacionElectronica_DownloadPdf',
                        data: {
                            id: id,
                            Username: Username
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
                            var blob = new Blob( [view], { type: "application/pdf" });
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

                $(document).on('click','.info_ws',function () {
                	let id = this.id;
                    $.ajax({
                        type: 'get',
                        url: '/GestionFacturacionElectronica_InfoWs',
                        data: {
                        	id : id,
                            Username: Username
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


                var missing = [];
                function Listado_de_facturas(from_date = '', to_date = '' ,fe_start = '', fe_end = '', type_doc = '') {
                    missing = [];
                    $.ajax({
                        url: '/GestionFacturacionElectronica_ListadeFacturas',
                        type: 'get',
                        data: {
                            from_date:from_date,
                            to_date:to_date,
                            fe_start:fe_start,
                            fe_end:fe_end,
                            type_doc:type_doc,
                            Username: Username
                        },
                        success: function (data) {
                        	var array = [];
                        	var j = 0;
                            $(data).each(function () {
                                array.push(data[j].numero);
                                j++;
                            });
                            array = array.sort();
                            for(let i = 1; i < array.length; i++) {
                                if(array[i] - array[i-1] != 1) {
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

                $('#Auditar').on('click',function () {
                	if(missing == ''){
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
            });
        </script>
    @endpush
@stop
@section('modal')
    <div class="modal fade bd-example-modal-xl" id="InfoWsInvoice" tabindex="-1" role="dialog" aria-labelledby="InfoWsInvoice" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="InfoWsInvoiceTitle">Detalles Factura #</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Cliente:</b></label>
                                    <label id="nombreAdquiriente"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Nit/CC:</b> </label>
                                    <label id="identificacionAdquiriente"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Correo envio:</b></label>
                                    <label id="correoenvio"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Fecha Generacion:</b></label>
                                    <label id="fechageneracion"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Fecha Registro:</b></label>
                                    <label id="fecharegistro"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Estado DIAN:</b></label>
                                    <label id="descestadoenviodian"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Observacion:</b></label>
                                    <label id="processedmessage"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Estado Cliente:</b></label>
                                    <label id="descestadoenviocliente"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label for="name" class="control-label"><b>Observacion:</b></label>
                                    <label id="comentarioenvio">Mensaje almacenado, pronto sera enviado.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12" id="correosCopia">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-12" id="verificacionfuncionales">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg" id="InfoWsObserv" tabindex="-1" role="dialog" aria-labelledby="InfoWsObserv" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="InfoWsObservTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="InfoWsObservDetail">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
