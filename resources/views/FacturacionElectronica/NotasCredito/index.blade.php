@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite validar las Notas Credito generadas en MAX.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_notas_cre') }}
@stop

@section('content')

    <div class="col-12"><h3> Por favor, seleccione un rango de fechas para comenzar con la busqueda.</h3></div>
    <br>
    {!! Form::open(array('url'=>'nc', 'method'=>'GET', 'autcomplete'=>'off', 'role'=>'search', 'id' => 'myform'))!!}
    <div class="form-group">
        <div class="input-group">
            <div class="col-lg-2 col-sm-2 col-md-2 col-12 ">
                <div class="form-group">
                    <label class="control-label" for="date">Fecha inicial:</label>
                    <input class="form-control " id="fechaInicial" name="fechaInicial"  placeholder="YYYY-MM-DD" value="{{$fe1}}" type="text" autocomplete="off" required readonly ="readonly" />
                </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-12">
                <div class="form-group">
                    <label class="control-label" for="date">Fecha final:</label>
                    <input class="form-control" id="fechaFinal" name="fechaFinal" placeholder="YYYY-MM-DD" value="{{$fe2}}" type="text" autocomplete="off" required readonly ="readonly" />
                </div>
            </div>
            <div class="col-lg-7 col-sm-2 col-md-2 col-12">
                <br>
                <div class="form-group">
                    <span><button type="submit" class="btn btn-primary" id="buscar">Buscar Notas Credito</button></span>
                </div>
            </div>
        </div>
    </div>
    {{Form::close()}}

    {!! Form::open(array('url'=>'nc/xml', 'method'=>'POST', 'autcomplete'=>'off', 'id' => 'myform1'))!!}
    <div class="col-lg-4">
        <div class="form-group">
            <span><input type="button" class="btn btn-primary" id="CrearXml" value="Crear XML"></span>
        </div>
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
                                    <th>Numero</th>
                                    <th>Factura Ref</th>
                                    <th>Fecha</th>
                                    <th>Razon Social</th>
                                    <th>Tipo Cliente</th>
                                    <th>Vendedor</th>
                                    <th>Valor bruto</th>
                                    <th>Descuento</th>
                                    <th>%</th>
                                    <th>IVA</th>
                                    <th>Motivo</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            @foreach( $Notas_credito as $nc)
                              <?php $pordesc = ($nc->descuento / $nc->bruto) * 100; ?>
                                  <tr>
                                      <td><input type="checkbox" class="checkboxes" id="CHK{{ $nc->numero }}" name="CHK{{ $nc->numero}}"/></td>
                                      <td>{{ $nc->numero }}</td>
                                      <td>{{ $nc->ov }}</td>
                                      <td>{{ $nc->fecha }}</td>
                                      <td>{{ $nc->razon_social }} </td>
                                      <td>{{ $nc->tipo_cliente }} </td>
                                      <td>{{ $nc->nomvendedor }}</td>
                                      <td>{{ number_format($nc->bruto,0,',','.') }}</td>
                                      <td>{{ number_format($nc->descuento,0,',','.') }}</td>
                                      <td>{{ $pordesc }}</td>
                                      <td>{{ number_format($nc->valor_iva,0,',','.') }}</td>
                                      <td>{{ $nc->motivo }}</td>
                                      <td>
                                          <div class="btn-group ml-auto float-right">
                                              <a href="#" class="btn btn-sm btn-outline-light" id="edit-fac" >
                                                  <i class="far fa-edit"> </i>
                                              </a>
                                              <a href="#" class="btn btn-sm btn-outline-light" id="ver-fac">
                                                  <i class="fa fa-eye"> </i>
                                              </a>
                                          </div>
                                      </td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
    {{Form::close()}}
@push('javascript')
    <script>
        $( function() {
            var from = $( "#fechaInicial" )
                .datepicker({
                    dateFormat: "yymmdd 00:00:00",
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
                to = $( "#fechaFinal" ).datepicker({
                    dateFormat: "yymmdd 23:59:59",
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
                var dateFormat = "yymmdd";
                try {
                    date = $.datepicker.parseDate( dateFormat, element.value );
                } catch( error ) {
                    date = null;
                }
                return date;
            }
        });
  {{--- fin de datepicker --}}


  {{--Inicio datatables--}}
        $(document).ready(function () {
            $("#tfac").DataTable({
                order: [],
                columns: [
                    {"orderable": false, "searchable": false},
                    {"orderable": true, "searchable": true},
                    {"orderable": false, "searchable": true},
                    {"orderable": false, "searchable": false},
                    {"orderable": true, "searchable": true},
                    {"orderable": true, "searchable": true},
                    {"orderable": true, "searchable": false},
                    {"orderable": true, "searchable": true},
                    {"orderable": false, "searchable": false},
                    {"orderable": false, "searchable": false},
                    {"orderable": false, "searchable": false},
                    {"orderable": false, "searchable": false},
                    {"orderable": true, "searchable": true},
                    {"orderable": false, "searchable": false},
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
                }
            });
        });

        $(document).ready(function () {
            $("#CrearXml").click(function () {
                var selected = [];
                $(".checkboxes").each(function () {
                    if (this.checked) {
                        var numero = this.id.substring(3,9);
                        var factura ={
                            "numero":numero,
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
                    toastr.info('Un momento por favor...','Generando XML.',{
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "10000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });

                    $.ajax({
                        cache: false,
                        type: 'post',
                        dataType: 'json', // importante para que
                        data: {selected: JSON.stringify(selected)}, // jQuery convierta el array a JSON
                        url: 'fe/xml',
                        success: function () {
                            toastr.success("El Archivo XML se ha generado con Exito!.");
                        }
                    });
                } else
                    toastr.error("Debes seleccionar al menos una Nota Credito.");
                return false;
            });
        });

        $("#selectAll").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
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
@endpush
