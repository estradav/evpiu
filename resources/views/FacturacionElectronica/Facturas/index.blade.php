@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite validar las Facturas generadas en MAX.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop

@section('content')

    <div class="col-12"><h3> Por favor seleccione un rango de fechas para comenzar con la busqueda.</h3></div>
    <br>
    {!! Form::open(array('url'=>'fe', 'method'=>'GET', 'autcomplete'=>'off', 'role'=>'search', 'id' => 'myform'))!!}
        <div class="form-group">
            <div class="input-group">
                <div class="col-lg-2 col-sm-2 col-md-2 col-12 ">
                    <div class="form-group">
                        <label class="control-label" for="date">Fecha inicial:</label>
                        <input class="form-control " id="fechaInicial" name="fechaInicial"  placeholder="YYYY-MM-DD" value="{{$f1}}" type="text" autocomplete="off" required readonly ="readonly" />
                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-md-2 col-12">
                    <div class="form-group">
                        <label class="control-label" for="date">Fecha final:</label>
                        <input class="form-control" id="fechaFinal" name="fechaFinal" placeholder="YYYY-MM-DD" value="{{$f2}}" type="text" autocomplete="off" required readonly ="readonly" />
                    </div>
                </div>
                <div class="col-lg-7 col-sm-2 col-md-2 col-12">
                    <br>
                    <div class="form-group">
                        <span><button type="submit" class="btn btn-primary" id="buscar">Buscar facturas</button></span>
                    </div>
                </div>
            </div>
        </div>
    {{Form::close()}}

    {!! Form::open(array('url'=>'fe/xml', 'method'=>'POST', 'autcomplete'=>'off', 'id' => 'myform1'))!!}
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
                                    <th>OV</th>
                                    <th>Fecha</th>
                                    <th>Plazo</th>
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
                            {{--Validacion de campos , aunque se valida desde el controlador, tambien tiene una validacion adicional
                            en la vista --}}
                                <?php  use Carbon\Carbon; $registro = 1; $aux = 0;
                                $tituloov = null; $titulotc = null; $titulomo = null; $titulobr = null;
                                $titulode = null; $titulovd = null; $titulorz = null; $titulofe = null;
                                $colorov = null; $colortc = null; $colormo = null; $colorbr = null;
                                $colorde = null; $colorvd = null; $colorrz = null; $colorfe = null; ?>

                                @foreach( $facturas as $fac)

                                <?php $pordesc = ($fac->descuento / $fac->bruto) * 100; ?>
                                <?php $total   = ($fac->bruto - $fac->descuento) + $fac->valor_iva;  ?>
                                <?php $subtotal = $fac->bruto - $fac->descuento;  ?>
                                <?php $errors = 0; ?>


                                @if($fac->codigo_alterno == null)
								<?php $errors++; $colthr = 'text-danger'; $titulotc = 'Debe tener un tipo de cliente' ?>
                                @else
                                  <?php $colthr = null; $titulotc = null; ?>
                                @endif



                                  {{--evalua que tenga un tipo de cliente --}}
                                  @if ($fac->tipo_cliente == null)
                                    <?php $errors++; $colortc = 'text-danger'; $titulotc = 'Debe tener un tipo de cliente' ?>
                                  @else
                                    <?php $colortc = null; $titulotc = null; ?>
                                  @endif

                                  {{--evalua que la Factura tenga un valor bruto mayor a 0 --}}
                                  @if ($fac->bruto == 0)
                                    <?php $errors++; $colorbr = 'text-danger'; $titulobr = 'El Valor no debe ser 0' ?>
                                  @else
                                    <?php $colorbr = null; $titulobr = null; ?>
                                  @endif

                                  {{--evalua que la Factura no tenga un valor bruto menor a 3000 --}}
                                  @if ($fac->bruto < 3000)
                                    <?php $errors++; $colorbr = 'text-danger'; $titulobr = 'El Valor es demasiado bajo' ?>
                                  @else
                                    <?php $colorbr = null; $titulobr = null; ?>
                                  @endif

                                  {{--evalua que la Factura no tenga un valor bruto mayor a 20.000.000 --}}
                                  @if ($fac->bruto > 20000000)
                                    <?php $errors++; $colorbr = 'text-danger'; $titulobr = 'El Valor es demasiado alto' ?>
                                  @else
                                    <?php $colorbr = null; $titulobr = null; ?>
                                  @endif

                                  {{--evalua que la Factura no tenga un porcentaje de descuento mayor a 25% --}}
                                  @if ($pordesc > 25)
                                    <?php $errors++; $colorde = 'text-danger'; $titulode = 'El descuento es demasiado alto' ?>
                                  @else
                                    <?php $colorde = null; $titulode = null; ?>
                                  @endif

                                  {{--evalua que la Factura tenga razon social --}}
                                  @if ($fac->razon_social == null)
                                    <?php $errors++; $colorrz = 'text-danger'; $titulorz = 'La Factura debe tener Razon Social' ?>
                                  @else
                                    <?php $colorfe = null; $titulofe = null; ?>
                                  @endif

                                  {{--evalua que la Factura tenga Fecha --}}
                                  @if ($fac->fecha == null)
                                    <?php $errors++; $colorfe = 'text-danger'; $titulofe = 'La Factura debe tener fecha' ?>
                                  @else
                                    <?php $colorfe = null; $titulofe = null; ?>
                                  @endif

                                  {{--Muestra si es la primera factura --}}
                                  @if ($registro == 1)
                                    <?php $colornu = 'text-danger'; $titulonu = 'Este es el primer Registro'?>
                                  @else
                                    <?php $colornu = null;; $titulonu = null; ?>
                                  @endif

                                    {{--evalua que el consecutivo sea correcto --}}
                                  @if ($fac->numero - $aux > 1)
                                    <?php $errors++; $colornu = 'text-danger'; $titulonu = 'Error en el consecutivo'   ?>
                                  @else
                                    <?php $colornu = ''; $titulonu = '' ?>
                                  @endif


                                  <tr class="<?php echo $colthr ?>">
                                      <td><input type="checkbox" class="checkboxes" id="CHK{{ $fac->numero }}" name="CHK{{$fac->numero}}"/></td >
                                      <td class=" <?php echo $colornu ?>" title="<?php echo $titulonu ?>" >{{ $fac->numero}}</td>
                                      <td class=" <?php echo $colorov ?>" title="<?php echo $tituloov ?>"> {{ $fac->ov }}</td>
                                      <td class=" <?php echo $colorfe ?>" title="<?php echo $titulofe ?>"> {{ Carbon::parse( $fac->fecha)->format('Y-m-d') }}</td>
                                      <td>{{$fac->plazo}}</td>
                                      <td class=" <?php echo $colorrz ?>" title="<?php echo $titulorz ?>"> {{ $fac->razon_social}} </td>
                                      <td class=" <?php echo $colortc ?>" title="<?php echo $titulotc ?>"> {{ $fac->tipo_cliente }} </td>
                                      <td class=" <?php echo $colorvd ?>" title="<?php echo $titulovd ?>"> {{ $fac->nomvendedor}} </td>
                                      <td class=" <?php echo $colorbr ?>" title="<?php echo $titulobr ?>"> {{ number_format($fac->bruto,0,',','.') }}</td>
                                      <td>{{ number_format($fac->descuento,0,',','.' )}}</td>
                                      <td class=" <?php echo $colorde ?>" title="<?php echo $titulode ?>"> {{ number_format($pordesc ,'0',',','.') }}</td>
                                      <td>{{ number_format($fac->valor_iva,0,',','.' )}}</td>
                                      <td class=" <?php echo $colormo ?>" title="<?php echo $titulomo ?>"> {{ $fac->motivo }}</td>
                                      <td>
                                          <div class="btn-group ml-auto float-right">
                                              @can('fact.edit')
                                                  <button class="btn btn-sm btn-light" disabled>
                                                    <?php echo $errors  ?>
                                                  </button>
                                                  <a href="{{ route('fe.edit', $fac->numero) }}" class="btn btn-sm btn-outline-light" id="edit-fac" >
                                                      <i class="far fa-edit"></i>
                                                  </a>
                                                  <a href="#" class="btn btn-sm btn-outline-light" id="ver-fac">
                                                      <i class="fa fa-eye"></i>
                                                  </a>
                                              @endcan
                                                  <input type="hidden" name="numero{{ $fac->numero }}" value="{{ $fac->numero }}" id="numero{{ $fac->numero }}"  >
                                          </div>
                                      </td>
                                  </tr>
                                <?php $registro++ ?>
                                <?php $aux = $fac->numero ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe id="my_iframe" style="display:none;"></iframe>
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
                    // permite ordenar columnas y le da el abributo buscar
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
                          // preventDefault();  //stop the browser from following

                           window.open('XML/Facturacion_electronica_Facturas.xml');

                         }
                    });
                } else
                  toastr.error("Debes seleccionar al menos una Factura.");
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

