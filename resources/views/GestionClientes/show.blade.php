@extends('layouts.dashboard')

@section('page_title',  $cliente[0]->RAZON_SOCIAL )



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
                                    <span> {{ $cliente[0]->PAIS}} - {{ $cliente[0]->ESTADO}} - {{ $cliente[0]->CIUDAD}}</span><br>
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
                            </ul>

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
                                                    <b>DIRECCION 1:</b> <label>{{ $cliente[0]->DIRECCION }} <a href="javascript:void(0)" id="change_ddr1"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>DIRECCION 2:</b> <label>{{ $cliente[0]->DIRECCION }} <a href="javascript:void(0)" id="change_ddr2"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>MONEDA:</b> <label>{{ $cliente[0]->MONEDA }} <a href="javascript:void(0)" id="change_moneda"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TIPO CLIENTE:</b> <label>{{ $cliente[0]->TIPO_CLIENTE }} <a href="javascript:void(0)" id="change_tipo_cliente"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>CONTACTO:</b> <label> {{ $cliente[0]->CONTACTO }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO 1:</b> <label> {{ $cliente[0]->TEL1 }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO 2:</b> <label> {{ $cliente[0]->TEL2 }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CELULAR:</b> <label> {{ $cliente[0]->CELULAR }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>E-MAIL CONTACTO:</b> <label> {{ $cliente[0]->CORREO_CONTACTO }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>E-MAIL FACTURACION:</b> <label> {{ $cliente[0]->CORREO_FE }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>FORMA ENVIO:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>GRAVADO:</b>
                                                    @if($cliente[0]->GRABADO == 'Y')
                                                        <label class="text-success">SI</label>
                                                        @else
                                                        <label class="text-danger">NO</label>
                                                    @endif
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CODIGO FISCAL:</b> <label> {{ $cliente[0]->IVA }}</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>PLAZO DE PAGO:</b> <label> {{ $cliente[0]->PLAZO }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>PORC. DE DESCUENTO:</b> <label> {{ $cliente[0]->DESCUENTO }}% <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>VENDEDOR:</b>  <label> {{ $cliente[0]->NOMBRE_VENDEDOR }} <a href="javascript:void(0)"><i class="fas fa-pen-square"></i></a></label>
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
                            <br>

                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Año</span>
                                        </div>
                                        <select id="Valor_año" class="custom-select" style="height: 43px;">
                                            <option value="" selected >Seleccione...</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="CambiarAñoGrafico">Cambiar año</button>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-success" id="AñadirAñoGrafico">Agregar año</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                TrendsProductsPeerMoth(Year);

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

                function TrendsProductsPeerMoth(Year = ''){
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);

                    $.ajax({
                        url: '/ProductosEnTendenciaPorMes',
                        type: 'get',
                        data: {
                            cliente: cliente,
                            Year: Year
                        },
                        success: function (data) {
                            console.log(data);
                            var chartdata = {
                                labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                                datasets: [
                                    {
                                        label: "2020",
                                        fill: false,
                                        backgroundColor: 'rgb(54, 162, 235)',
                                        borderColor: 'rgb(54, 162, 235)',
                                        data: data[0]
                                    },

                                ]
                            };
                            var mostrar = $("#Ventas_por_mes");
                            graf_prop_est = new Chart(mostrar, {
                                type: 'line',
                                data: chartdata,
                                options: {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        text: 'Ventas Mensuales'
                                    },
                                    hover: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true,
                                                callback: function(value, index, values) {
                                                    return '$ ' + number_format(value);
                                                }
                                            }
                                        }]
                                    },
                                    tooltips: {
                                        callbacks: {
                                            label: function(tooltipItem, chart){
                                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                                return datasetLabel + ': $ ' + number_format(tooltipItem.yLabel, 2);
                                            }
                                        }
                                    }
                                }
                            });

                        },
                        error: function () {

                        }
                    });
                }

                function number_format(number, decimals, dec_point, thousands_sep) {
                    // *     example: number_format(1234.56, 2, ',', ' ');
                    // *     return: '1 234,56'
                    number = (number + '').replace(',', '').replace(' ', '');
                    var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function (n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + Math.round(n * k) / k;
                        };
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                    if (s[0].length > 3) {
                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                    }
                    if ((s[1] || '').length < prec) {
                        s[1] = s[1] || '';
                        s[1] += new Array(prec - s[1].length + 1).join('0');
                    }
                    return s.join(dec);
                }

                $('#CambiarAñoGrafico').on('click', function () {
                    var Year = $('#Valor_año').val();
                    if (Year != ''){
                        graf_prop_est.destroy();
                        TrendsProductsPeerMoth(Year)
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Escoge un año',
                            text: 'Debes escoger un año',
                            showConfirmButton: true,
                            showCancelButton: false,
                            allowOutsideClick: true,
                            allowEscapeKey: true
                        });
                    }
                });

                function addData(chart, label, color, data) {
                    chart.data.datasets.push({
                        label: label,
                        data: data,
                        fill: false,
                        backgroundColor: color,
                        borderColor: color,
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                    });
                    chart.update();
                }

                $('#AñadirAñoGrafico').on('click',function () {
                    var Year = $('#Valor_año').val();
                    if (Year != ''){
                        var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                        var color = '';
                        if (Year == 2019){
                            color = '#DB4437';
                        }
                        if (Year == 2018){
                            color = '#0F9D58';
                        }
                        if (Year == 2017){
                            color = '#F4B400';
                        }
                        if (Year == 2016){
                            color = '#9966FF'
                        }

                        $.ajax({
                            url: '/ProductosEnTendenciaPorMes',
                            type: 'get',
                            data: {
                                cliente: cliente,
                                Year: Year
                            },
                            success: function (data) {
                                addData(graf_prop_est, Year, color, data[0]);
                                $('option:selected', '#Valor_año').attr('disabled', true);
                            }
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Escoge un año',
                            text: 'Debes escoger un año',
                            showConfirmButton: true,
                            showCancelButton: false,
                            allowOutsideClick: true,
                            allowEscapeKey: true
                        });
                    }
                });

                $('#change_ddr1').on('click',function () {
                    var direccion = @json($cliente[0]->DIRECCION);
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    swal.mixin({
                        icon: 'question',
                        title: 'Direccion 1',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        buttonsStyling: true,
                        showCancelButton: true,
                        input: 'text',
                    }).queue([
                        {
                            html: '<label>Direccion:</label> <br> ' +
                                '<input type="text" class="form-control" id="addr1" value="'+  direccion.trim() +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('addr1').value == '') {
                                    return 'Este campo no puede ir en blanco';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'state': document.getElementById("state").value,
                                    'justify': document.getElementById("justify").value,
                                };
                                return array;
                            },
                            onBeforeOpen: function (dom) {
                                swal.getInput().style.display = 'none';
                            }
                        },
                    ]).then((result) => {
                        if (result.value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/CambiarEstadoRequeEd',
                                type: 'post',
                                data: {
                                    result, cliente, username
                                },
                                success: function () {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Guardardo',
                                        text: 'Estado cambiado con exito!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'La solicitud no pudo ser procesada!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                }
                            });
                        } else {
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });

                $('#change_ddr2').on('click',function () {
                    var direccion = @json($cliente[0]->DIRECCION);
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    swal.mixin({
                        icon: 'question',
                        title: 'Direccion 2',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        buttonsStyling: true,
                        showCancelButton: true,
                        input: 'text',
                    }).queue([
                        {
                            html: '<label>Direccion:</label> <br> ' +
                                '<input type="text" class="form-control" id="addr2" value="'+direccion.trim()+'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('addr2').value == '') {
                                    return 'Este campo no puede ir en blanco';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'state': document.getElementById("state").value,
                                    'justify': document.getElementById("justify").value,
                                };
                                return array;
                            },
                            onBeforeOpen: function (dom) {
                                swal.getInput().style.display = 'none';
                            }
                        },
                    ]).then((result) => {
                        if (result.value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/CambiarEstadoRequeEd',
                                type: 'post',
                                data: {
                                    result, cliente, username
                                },
                                success: function () {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Guardardo',
                                        text: 'Datos guardados con exito!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'La solicitud no pudo ser procesada!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                }
                            });
                        } else {
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });

                $('#change_moneda').on('click',function () {
                    var moneda = @json($cliente[0]->MONEDA);
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    swal.mixin({
                        icon: 'question',
                        title: 'Moneda',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        buttonsStyling: true,
                        showCancelButton: true,
                        input: 'text',
                    }).queue([
                        {
                            html: '<label>Moneda:</label> <br> ' +
                                '<select name="moneda" id="moneda" class="form-control">' +
                                '<option value="">Seleccione...</option>' +
                                '<option value="COP">COP</option>' +
                                '<option value="USD">USD</option>' +
                                '</select>' +
                                '<br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('moneda').value == '') {
                                    return 'Selecciona una opcion...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'moneda': document.getElementById("moneda").value,
                                    'justify': document.getElementById("justify").value,
                                };
                                return array;
                            },
                            onBeforeOpen: function (dom) {
                                swal.getInput().style.display = 'none';
                            }
                        },
                    ]).then((result) => {
                        if (result.value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/CambiarEstadoRequeEd',
                                type: 'post',
                                data: {
                                    result, cliente, username
                                },
                                success: function () {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Guardardo',
                                        text: 'Datos guardados con exito!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'La solicitud no pudo ser procesada!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                }
                            });
                        } else {
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });

                $('#change_tipo_cliente').on('click',function () {
                    var moneda = @json($cliente[0]->TIPO_CLIENTE);
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);

                    function getOptions(){
                        $.ajax({
                           url: '',
                           type: 'get',
                           success: function (data) {

                           }
                        });
                    }


                    swal.mixin({
                        icon: 'question',
                        title: 'Tipo de cliente',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        buttonsStyling: true,
                        showCancelButton: true,
                        className: "red-bg",
                        input: 'text',
                    }).queue([
                        {
                            html: '<label>Tipo de Cliente:</label> <br> ' +
                                '<select name="tipo_cliente" id="tipo_cliente" class="form-control">' +
                                '<option value="">Seleccione...</option>' +
                                '<option value="COP">COP</option>' +
                                '<option value="USD">USD</option>' +
                                '</select>' +
                                '<br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('tipo_cliente').value == '') {
                                    return 'Selecciona una opcion...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'tipo_cliente': document.getElementById("tipo_cliente").value,
                                    'justify': document.getElementById("justify").value,
                                };
                                return array;
                            },
                            onBeforeOpen: function (dom) {
                                swal.getInput().style.display = 'none';
                            }
                        },
                    ]).then((result) => {
                        if (result.value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/CambiarEstadoRequeEd',
                                type: 'post',
                                data: {
                                    result, cliente, username
                                },
                                success: function () {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Guardardo',
                                        text: 'Datos guardados con exito!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'La solicitud no pudo ser procesada!',
                                        confirmButtonColor: '#3085d6',
                                        confirmButtonText: 'Aceptar',
                                    })
                                }
                            });
                        } else {
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });
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
        <link rel="stylesheet" href="@sweetalert2/theme-minimal/minimal.css">



    @endpush
@stop
