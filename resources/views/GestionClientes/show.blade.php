@extends('layouts.dashboard')

@section('page_title', 'Cliente: ')



@section('content')
    @can('gestion_clientes.show')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile igualar">
                            <h3 class="profile-username text-center">{{ $cliente[0]->RAZON_SOCIAL }}</h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Facturas</b> <a class="float-right" id="total_facturas">{{ $facturas }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Notas Credito</b> <a class="float-right" id="total_notas">{{ $notas_credito }}</a>
                                </li>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Localización:</strong>
                            <p class="text-muted" id="localizacion" name="localizacion">
                                <span>{{ $cliente[0]->CIUDAD}}</span><br>
                                <span>{{ $cliente[0]->DIRECCION}}</span>
                            </p>


                            <strong><i class="fas fa-info-circle mr-1"></i> Estado:</strong>
                            <p class="text-muted">
                                @if ($cliente[0]->ACTIVO == 'H')
                                    <span class="alert-danger">RETENIDO</span>
                                @elseif($cliente[0]->ACTIVO == 'R')
                                    <span class="alert-success">LIBERADO</span>
                                @endif

                            </p>

                            <strong><i class="fas fa-phone mr-1"></i> Telefono:</strong>
                            <p class="text-muted">{{ $cliente[0]->TEL1 }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-9 ">
                    <div class="card igualar">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#informacion" data-toggle="tab">Informacion</a></li>
                                <li class="nav-item"><a class="nav-link" href="#Facturacion" data-toggle="tab">Facturacion electronica</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body ">
                            <div class="tab-content">
                                <div class="active tab-pane" id="informacion">
                                    <!-- Post -->
                                    <div class="post">
                                        <!-- /.user-block -->
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>NOMBRE:</b> <label>{{ $cliente[0]->RAZON_SOCIAL }}</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>RAZON SOCIAL:</b> <label>{{ $cliente[0]->RAZON_SOCIAL }}</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>NIT/CC:</b> <label>{{ $cliente[0]->NIT }}</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CODIGO CLIENTE:</b> <label>{{ $cliente[0]->CODIGO_CLIENTE }}</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>DIRECCION 1:</b> <label>{{ $cliente[0]->DIRECCION }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>DIRECCION 2:</b> <label>{{ $cliente[0]->DIRECCION }}</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>MONEDA:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TIPO CLIENTE:</b>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>CONTACTO:</b> <label> Marin de jesus</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO 1:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO 2:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CELULAR:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>E-MAIL CONTACTO:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>E-MAIL FACTURACION:</b>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>FORMA ENVIO:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>GRAVADO:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CODIGO FISCAL:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>PLAZO DE PAGO:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>PORC. DE DESCUENTO:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>VENDEDOR:</b>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>¿RUT ENTREGADO?:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>GRAN CONTRIBUYENTE:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>RESPOSABLE IVA:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>RESPOSABLE FE:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO FE:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>COD. CIUDAD EXT:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>GRUPO ECONOMICO:</b>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>CORREOS COPIA:</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="Facturacion">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-responsive table-striped" id="facturas_webservice">
                                                        <thead>
                                                            <tr>
                                                                <th>ID Factible</th>
                                                                <th>Factura/Nota</th>
                                                                <th>Tipo</th>
                                                                <th>Fecha Generacion</th>
                                                                <th>Fecha Registro</th>
                                                                <th>Estado DIAN</th>
                                                                <th>Estado Cliente</th>
                                                                <th class="text-center">Opciones</th>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="profile-username text-center">Dashboard</h3>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-6">
                                    <canvas id="Total_facturas_notascredito"></canvas>
                                </div>
                                <div class="col-6">
                                    <canvas id="Productos_tendencia"></canvas>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="Ventas_por_mes"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar los clientes.
        </div>
    @endcan

    @push('javascript')
        <script>
            $(document).ready(function () {
                TotalFacAndNotes();
                TrendsProducts();


                var altura_arr = [];
                $('.igualar').each(function(){
                    var altura = $(this).height();
                    altura_arr.push(altura);
                });
                altura_arr.sort(function(a, b){return b-a});
                $('.igualar').each(function(){
                    $(this).css('height',altura_arr[0]);
                });


                function TotalFacAndNotes() {
                    var facturas = [];
                    var notas_credito =[];

                    facturas.push(@json($facturas));
                    notas_credito.push(@json($notas_credito));

                    var chartdata = {
                        labels: ['Facturas:'+facturas+' - Notas credito:'+notas_credito],
                        datasets: [
                            {
                                label: 'Facturas',
                                backgroundColor: 'rgb(15,157,88)',
                                borderColor: 'rgb(15,157,88)',
                                borderWidth: 1,
                                hoverBackgroundColor: 'rgb(15,157,88)',
                                hoverBorderColor: 'rgb(15,157,88)',
                                data: facturas
                            },

                            {
                                label: 'Notas Credito',
                                backgroundColor: 'rgb(219,68,55)',
                                borderColor: 'rgb(219,68,55)',
                                borderWidth: 1,
                                hoverBackgroundColor: 'rgb(219,68,55)',
                                hoverBorderColor: 'rgb(219,68,55)',
                                data: notas_credito
                            }
                        ]
                    };
                    var mostrar = $("#Total_facturas_notascredito");
                    graf_prop_est = new Chart(mostrar, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Total de Facturas y notas credito'
                            },
                        }
                    });
                }


                function TrendsProducts() {
                    var labels = [];
                    var Total = [];
                    var Comprado = [];

                    var data = @json($productos_tend);

                    var i = 0;
                    $(data).each(function () {
                        Total.push(data[i].Total);
                        Comprado.push(data[i].Comprado);
                        labels.push(data[i].CodigoProducto);
                        i++;
                    });


                    var chartdata = {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Pedido',
                                backgroundColor: 'rgb(15,157,88)',
                                borderColor: 'rgb(15,157,88)',
                                borderWidth: 1,
                                hoverBackgroundColor: 'rgb(15,157,88)',
                                hoverBorderColor: 'rgb(15,157,88)',
                                data: Total
                            },

                            {
                                label: 'Total Comprado',
                                backgroundColor: 'rgb(219,68,55)',
                                borderColor: 'rgb(219,68,55)',
                                borderWidth: 1,
                                hoverBackgroundColor: 'rgb(219,68,55)',
                                hoverBorderColor: 'rgb(219,68,55)',
                                data: Comprado
                            }
                        ]
                    };
                    var mostrar = $("#Productos_tendencia");
                    graf_prop_est = new Chart(mostrar, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Top 5 de los items mas comprados'
                            },
                        }
                    });
                }

                var Year = new Date().getFullYear();


                TrendsProductsPeerMoth(Year);

                function TrendsProductsPeerMoth(Year = ''){
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var Year = Year;

                    $.ajax({
                        url: '/ProductosEnTendenciaPorMes',
                        type: 'get',
                        data: {
                            cliente: cliente,
                            año: Year
                        },
                        success: function (data) {









                            var chartdata = {
                                labels: labels_ene,
                                datasets: [
                                    {
                                        label: "Veces Comprado",
                                        backgroundColor: "pink",
                                        borderColor: "red",
                                        borderWidth: 1,
                                        data: veces_comprado_ene
                                    },
                                    {
                                        label: "Unidades Compradas",
                                        backgroundColor: "lightblue",
                                        borderColor: "blue",
                                        borderWidth: 1,
                                        data: total_comprado_ene
                                    },
                                    {
                                        label: "Valor Mercancia",
                                        backgroundColor: "lightgreen",
                                        borderColor: "green",
                                        borderWidth: 1,
                                        data: base_ene
                                    },
                                ]
                            };
                            var mostrar = $("#Ventas_por_mes");
                            graf_prop_est = new Chart(mostrar, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        text: 'Top 5 de los items mas comprados'
                                    },
                                }
                            });

                        },
                        error: function () {

                        }
                    });






                    /*var chartdata = {
                        labels: labels_ene,
                        datasets: [
                            {
                                label: "Veces Comprado",
                                backgroundColor: "pink",
                                borderColor: "red",
                                borderWidth: 1,
                                data: veces_comprado_ene
                            },
                            {
                                label: "Unidades Compradas",
                                backgroundColor: "lightblue",
                                borderColor: "blue",
                                borderWidth: 1,
                                data: total_comprado_ene
                            },
                            {
                                label: "Valor Mercancia",
                                backgroundColor: "lightgreen",
                                borderColor: "green",
                                borderWidth: 1,
                                data: base_ene
                            },
                        ]
                    };
                    var mostrar = $("#Productos_tendencia_por_mes");
                    graf_prop_est = new Chart(mostrar, {
                        type: 'bar',
                        data: chartdata,
                        options: {
                            responsive: true,
                            title: {
                                display: true,
                                text: 'Top 5 de los items mas comprados'
                            },
                        }
                    });*/
                }





            });


        </script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">


    @endpush
@stop
