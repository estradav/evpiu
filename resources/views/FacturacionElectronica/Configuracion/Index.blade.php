@extends('layouts.dashboard')

@section('page_title', 'Facturacion Electronica')

@section('module_title', 'Facturacion Electronica')

@section('subtitle', 'Este módulo permite editar facturas.')

@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr') }}
@stop
@section('content')
    <form action="{{ route('ConfigFe.update', $feconfigs[0]->id )  }}" method="post">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Configuracion de Facturas</h5>
                    <div class="card-body">
                        <div class="row">
                            @foreach($feconfigs as $fec)
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Numeracion Factura:</label>
                                    <input type="number" class="form-control" placeholder="Razon Social" value="{{$fec->id_numeracion_fac}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Reporte Factura:</label>
                                    <input type="number" class="form-control" placeholder="Direccion" value="{{$fec->id_reporte_fac}}" >
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Numeracion Nota Credito:</label>
                                    <input type="number" class="form-control" placeholder=" " value="{{$fec->id_numeracion_nc}}" >
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Reporte Nota Credito:</label>
                                    <input type="number" class="form-control" placeholder="Telefono"  value="{{ $fec->id_reporte_nc}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Numeracion Nota Debito</label>
                                    <input type="text" class="form-control" placeholder="Seleccione" value="{{ $fec->id_numeracion_nd}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Reporte Nota Debito:</label>
                                    <input type="text" class="form-control" placeholder="Nombre de contacto" value="{{$fec->id_reporte_nd}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>ID Estado Envio Dian:</label>
                                    <button class="btn btn-info" style="width: 20px; height: 20px; padding: 4px 4px; border-radius:15px;font-size: 9px; line-height: 1.33"  type="button" value="" onclick="infodian()"><i class="fa fa-info"></i></button>
                                    <input type="text" class="form-control" placeholder="id dian" value="{{ $fec->id_estado_envio_dian}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Estado Envio Cliente:</label>
                                    <button class="btn btn-info" style="width: 20px; height: 20px; padding: 4px 4px; border-radius:15px;font-size: 9px; line-height: 1.33"  type="button" value="" onclick="infocliente()"><i class="fa fa-info"></i></button>
                                    <input type="text" class="form-control" placeholder="id dian" value="{{ $fec->id_estado_envio_Cliente}}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-sm-12 pl-0">
                <p class="text-right">
                    <button class="btn btn-sm btn-primary" type="submit">Guardar cambios</button>
                </p>
            </div>
        </div>
    </form>
@endsection

@push('javascript')
    <script>
        function infodian() {
            toastr.info('Escribe 3 para Enviar a la dian ò 4 para verificar antes de enviar','INFO.',{
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-center",
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
        }

        function infocliente() {
            toastr.info('Escribe 3 para Enviar al Usuario ò 4 para verificar antes de enviar','INFO.',{
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": false,
                "positionClass": "toast-top-center",
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
        }
    </script>

@endpush
