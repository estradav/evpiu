@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite validar las Facturas generadas en MAX.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop

@section('content')
    @can('facturacion.view')
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

                                <?php
                                use Carbon\Carbon;
                                $registro = 1; $aux = 0;
                                $tituloov = null; $titulotc = null; $titulomo = null; $titulobr = null;
                                $titulode = null; $titulovd = null; $titulorz = null; $titulofe = null;
                                $checkbox = 'enable';
                                ?>

                                @foreach( $facturas as $fac)

                                <?php $pordesc = ($fac->descuento / $fac->bruto) * 100; ?>
                                <?php $total   = ($fac->bruto - $fac->descuento) + $fac->valor_iva;  ?>
                                <?php $subtotal = $fac->bruto - $fac->descuento;  ?>
                                <?php $errors = 0; ?>

                                @if($fac->codigo_alterno == null)
                                <?php $errors++;  $titulohtr = '* Cliente no ha sido creado en DMS *'; ?>
                                @else
                                  <?php $titulohtr = null; ?>
                                @endif

                                {{--evalua que tenga un tipo de cliente --}}
                                @if ($fac->tipo_cliente == null)
                                  <?php $errors++; $titulotc = '* Debe tener un tipo de cliente *'; ?>
                                @else
                                  <?php $titulotc = null; ?>
                                @endif

                                  {{--evalua que la Factura tenga un valor bruto mayor a 0 --}}
                                @if ($fac->bruto == 0)
                                  <?php $errors++; $titulobr = '* El Valor no debe ser 0 *'; ?>
                                @else
                                  <?php $titulobr = null; ?>
                                @endif

                                  {{--evalua que la Factura no tenga un valor bruto menor a 3000 --}}
                                @if ($fac->bruto < 3000)
                                  <?php $errors++; $titulobr = '* El Valor es demasiado bajo *'; ?>
                                @else
                                  <?php $titulobr = null; ?>
                                @endif

                                  {{--evalua que la Factura no tenga un valor bruto mayor a 20.000.000 --}}
                                @if ($fac->bruto > 20000000)
                                  <?php $errors++;  $titulobr = '* El Valor es demasiado alto *'; ?>
                                @else
                                  <?php $titulobr = null; ?>
                                @endif

                                  {{--evalua que la Factura no tenga un porcentaje de descuento mayor a 25% --}}
                                @if ($pordesc > 25)
                                  <?php $errors++; $titulode = '* El descuento es demasiado alto *'; ?>
                                @else
                                  <?php $titulode = null; ?>
                                @endif

                                  {{--evalua que la Factura tenga razon social --}}
                                @if ($fac->razon_social == null)
                                  <?php $errors++; $titulorz = '* La Factura debe tener Razon Social *'; ?>
                                @else
                                  <?php $titulofe = null; ?>
                                @endif

                                  {{--evalua que la Factura tenga Fecha --}}
                                @if ($fac->fecha == null)
                                  <?php $errors++; $titulofe = '* La Factura debe tener fecha *'; ?>
                                @else
                                  <?php $titulofe = null; ?>
                                @endif

                                  {{--Muestra si es la primera factura --}}
                                @if ($registro == 1)
                                  <?php $titulonu = '* Este es el primer Registro *'; ?>
                                @else
                                  <?php $titulonu = null; ?>
                                @endif

                                    {{--evalua que el consecutivo sea correcto --}}
                                @if ($fac->numero - $aux > 1)
                                  <?php $errors++; $titulonu = '* Error en el consecutivo *'; ?>
                                @else
                                  <?php $titulonu = null; ?>
                                @endif

                                @if ($errors >= 1)
                                  <?php $checkbox = 'disabled'; ?>
                                  <?php $colthr = 'text-danger'; ?>
                                @else
                                  <?php $checkbox = 'enable'; ?>
                                  <?php $colthr = null; ?>
                                @endif

                                <?php $errortex = ' '.$titulohtr.' '.$titulotc.' '.$titulobr.' '.$titulonu.' '.$titulode.' '.$titulorz.' '.$titulofe ?>

                                  <tr class="<?php echo $colthr ?>">
                                      <td><input type="checkbox" class="checkboxes" id="CHK{{ $fac->numero }}" name="CHK{{$fac->numero}}" <?php echo $checkbox ?> ></td >
                                      <td> {{ $fac->numero}}</td>
                                      <td> {{ $fac->ov }}</td>
                                      <td> {{ Carbon::parse( $fac->fecha)->format('Y-m-d') }}</td>
                                      <td> {{ $fac->plazo}}</td>
                                      <td> {{ $fac->razon_social}} </td>
                                      <td> {{ $fac->tipo_cliente }} </td>
                                      <td> {{ $fac->nomvendedor}} </td>
                                      <td> {{ number_format($fac->bruto,0,',','.') }}</td>
                                      <td> {{ number_format($fac->descuento,0,',','.' )}}</td>
                                      <td> {{ number_format($pordesc ,'0',',','.') }}</td>
                                      <td> {{ number_format($fac->valor_iva,0,',','.' )}}</td>
                                      <td> {{ $fac->motivo }}</td>
                                      <td>
                                          <div class="btn-group ml-auto float-right">
                                              <button class="btn btn-sm btn-light " id="BTN{{$fac->numero}}" data-toggle="tooltip" data-placement="top" title="<?php echo $errortex ?>">
                                                <?php echo $errors  ?>
                                              </button>
                                              @can('fact.edit')
                                                  <a href="{{ route('fe.edit', $fac->numero) }}" class="btn btn-sm btn-outline-light" id="edit-fac" >
                                                      <i class="far fa-edit"></i>
                                                  </a>
                                              @endcan
                                              <input type="hidden" name="numero{{ $fac->numero }}" value="{{ $fac->numero }}" id="numero{{ $fac->numero }}">
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
    {{Form::close()}}
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar las Facturas.
        </div>
    @endcan
@push('javascript')
    <script>
			$(document).ready(function() {
				$('[data-toggle="tooltip"]').tooltip();
			});
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/JsGlobal/FE/index.js" ></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
@endpush
@stop
