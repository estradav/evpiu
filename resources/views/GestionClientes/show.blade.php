@extends('layouts.dashboard')

@section('page_title',  $cliente[0]->RAZON_SOCIAL )
@section('content')
    @can('gestion_clientes.show')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile igualar">
                            <h2 class="profile-username text-center">
                                <i class="far fa-building "></i>  {{ $cliente[0]->RAZON_SOCIAL }}
                            </h2>

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
                                                    <b>CONTACTO:</b> <label> {{ $cliente[0]->CONTACTO }} <a href="javascript:void(0)" id="change_contacto"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO 1:</b> <label> {{ $cliente[0]->TEL1 }} <a href="javascript:void(0)" id="change_tel1"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>TELEFONO 2:</b> <label> {{ $cliente[0]->TEL2 }} <a href="javascript:void(0)" id="change_tel2"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CELULAR:</b> <label> {{ $cliente[0]->CELULAR }} <a href="javascript:void(0)" id="change_cel"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>E-MAIL CONTACTO:</b> <label> {{ $cliente[0]->CORREO_CONTACTO }} <a href="javascript:void(0)" id="change_email_contact"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>E-MAIL FACTURACION:</b> <label> {{ $cliente[0]->CORREO_FE }} <a href="javascript:void(0)" id="change_email_fact"><i class="fas fa-pen-square"></i></a></label>
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
                                                    <b>PLAZO DE PAGO:</b> <label> {{ $cliente[0]->PLAZO }} <a href="javascript:void(0)" id="change_plazo_pago"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>PORC. DE DESCUENTO:</b> <label> {{ $cliente[0]->DESCUENTO }}% <a href="javascript:void(0)" id="change_descuento"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>VENDEDOR:</b> <label> {{ $cliente[0]->NOMBRE_VENDEDOR }} <a href="javascript:void(0)" id="change_vendedor"><i class="fas fa-pen-square"></i></a></label>
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
                                                    <b>CORREOS COPIA:</b> <label> {{--{{ $cliente[0]->NOMBRE_VENDEDOR }}--}} <a href="javascript:void(0)" id="change_correos_copia"><i class="fas fa-pen-square"></i></a></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="Facturacion">
                                    <div class="table-responsive">
                                        <div class="col-12">
                                            <table class="table table-responsive table-striped" id="facturacion_electronica">
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
                var Year = new Date().getFullYear();

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

                var nombre_cliente = @json($cliente[0]->RAZON_SOCIAL);

                $('#facturacion_electronica').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    autoWidth: true,
                    scrollY: 400,
                    scrollCollapse: true,
                    paging: false,
                    ajax: {
                        url:'/FacturacionElectronicaGc',
                        data:{
                            nombre_cliente: nombre_cliente
                        }
                    },
                    columns: [
                        {data: 'DT_RowId', name: 'DT_RowId', orderable: true, searchable: true},
                        {data: 'numero', name: 'numero', orderable: true, searchable: true},
                        {data: 'desctipodocumentoelectronico', name: 'desctipodocumentoelectronico', orderable: false, searchable: false},
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
                    }
                });


                $('body').on('click','.download_ws', function () {
                    var username = 'dcorreah';
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
                            Username: username,

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
                            var blob = new Blob( [view], { type: "application/pdf" });
                            var link=document.createElement('a');
                            link.href=window.URL.createObjectURL(blob);
                            let current_datetime = new Date();
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


                $('#CambiarAñoGrafico').on('click',function () {
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
                                    'addr1': document.getElementById("addr1").value,
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
                                url: '/',
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
                                    'addr2': document.getElementById("addr2").value,
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
                                url: '/',
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
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);

                    function getOptionsTipoCliente(){
                        $.ajax({
                            type: "get",
                            url: '/get_tipo_cliente',
                            success: function (data) {
                                var i = 0;
                                $('#tipo_cliente').append('<option value="">Seleccione...</option>');
                                $(data).each(function () {
                                    $('#tipo_cliente').append('<option value="'+data[i].CUSTYP_62 +'">'+data[i].DESC_62+'</option>');
                                    i++;
                                });
                            }
                        })
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
                                '<select name="tipo_cliente" id="tipo_cliente" class="form-control">'+ getOptionsTipoCliente() +'</select>' +
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
                                url: '/',
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

                $('#change_contacto').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var contacto = @json($cliente[0]->CONTACTO);

                    swal.mixin({
                        icon: 'question',
                        title: 'Contacto',
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
                            html: '<label>Nombre de contacto:</label> <br> ' +
                                '<input type="text" id="contact" class="form-control" value="'+ contacto +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('contact').value == '') {
                                    return 'Escribe el nombre de contacto...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'contact': document.getElementById("contact").value,
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
                                url: '/',
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

                $('#change_tel1').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var tel1 = @json($cliente[0]->TEL1);

                    swal.mixin({
                        icon: 'question',
                        title: 'Telefono 1',
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
                            html: '<label>Telefono 1:</label> <br> ' +
                                '<input type="number" id="tel1" class="form-control" value="'+ parseInt(tel1.trim()) +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('tel1').value == '') {
                                    return 'Debes escribir un telefono de contacto...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'tel1': document.getElementById("tel1").value,
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
                                url: '/',
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

                $('#change_tel2').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var tel2 = @json($cliente[0]->TEL2);

                    swal.mixin({
                        icon: 'question',
                        title: 'Telefono 2',
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
                            html: '<label>Telefono 2:</label> <br> ' +
                                '<input type="number" id="tel2" class="form-control" value="'+ parseInt(tel2.trim()) +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('tel2').value == '') {
                                    return 'Debes escribir un telefono de contacto...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'tel2': document.getElementById("tel2").value,
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
                                url: '/',
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

                $('#change_cel').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var cel = @json($cliente[0]->CELULAR);

                    swal.mixin({
                        icon: 'question',
                        title: 'Celular',
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
                            html: '<label>Celular:</label> <br> ' +
                                '<input type="number" id="cel" class="form-control" value="'+ parseInt(cel.trim()) +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('cel').value == '') {
                                    return 'Debes escribir un celular de contacto...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'cel': document.getElementById("cel").value,
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
                                url: '/',
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

                $('#change_email_contact').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var email_contact = @json($cliente[0]->CORREO_CONTACTO);

                    swal.mixin({
                        icon: 'question',
                        title: 'E-mail de contacto',
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
                            html: '<label>E-mail de contacto:</label> <br> ' +
                                '<input type="email" id="email_contact" class="form-control" value="'+ email_contact.trim() +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('email_contact').value == '') {
                                    return 'Debes escribir un email de contacto...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'email_contact': document.getElementById("email_contact").value,
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
                                url: '/',
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

                $('#change_email_fact').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var email_fact = @json($cliente[0]->CORREO_FE);

                    swal.mixin({
                        icon: 'question',
                        title: 'E-mail de facturacion',
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
                            html: '<label>E-mail de facturacion:</label> <br> ' +
                                '<input type="email" id="email_fact" class="form-control" value="'+ email_fact.trim() +'" ' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('email_fact').value == '') {
                                    return 'Debes escribir un email de facturacion...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'email_fact': document.getElementById("email_fact").value,
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
                                url: '/',
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

                $('#change_plazo_pago').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);

                    function getOptionsPlazo(){
                        $.ajax({
                            type: "get",
                            url: '/PedidosGetCondicion',
                            success: function (data) {
                                var i = 0;
                                $('#plazo_pago').append('<option value="" >Seleccione...</option>');
                                $(data).each(function (){
                                    $('#plazo_pago').append('<option value="'+ data[i].CODE_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                                    i++
                                });
                            }
                        })
                    }

                    swal.mixin({
                        icon: 'question',
                        title: 'Plazo de pago',
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
                            html: '<label>Plazo de pago:</label> <br> ' +
                                '<select name="plazo_pago" id="plazo_pago" class="form-control">'+ getOptionsPlazo() +'</select>' +
                                '<br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('plazo_pago').value == '') {
                                    return 'Selecciona una opcion...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'plazo_pago': document.getElementById("plazo_pago").value,
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
                                url: '/',
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

                $('#change_descuento').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);
                    var descuento = @json($cliente[0]->DESCUENTO);

                    swal.mixin({
                        icon: 'question',
                        title: 'Descuento',
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
                            html: '<label>Porcentaje de descuento:</label> <br> ' +
                                '<input type="number" id="descuento" class="form-control" value="'+ parseInt(descuento) +'" max="100" min="0" >' +
                                '<br> <br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('descuento').value == '') {
                                    return 'Debes escribir un descuento entre 0 y 100...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'descuento': document.getElementById("descuento").value,
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
                                url: '/',
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

                $('#change_vendedor').on('click',function () {
                    var username = @json(Auth::user()->name);
                    var cliente = @json($cliente[0]->CODIGO_CLIENTE);

                    function getOptionsVendedores(){
                        $.ajax({
                            type: "get",
                            url: '/PedidosGetUsers',
                            success: function (data) {
                                var i = 0;
                                $('#vendedor').append('<option value="" >Seleccione...</option>');
                                $(data).each(function (){
                                    $('#vendedor').append('<option value="'+ data[i].codvendedor +'" >'+ data[i].name +'</option>');
                                    i++
                                });
                            }
                        })
                    }

                    swal.mixin({
                        icon: 'question',
                        title: 'Vendedor',
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
                            html: '<label>Vendedor:</label> <br> ' +
                                '<select name="vendedor" id="vendedor" class="form-control">'+ getOptionsVendedores() +'</select>' +
                                '<br>' +
                                '<label style="text-align: left" >Justificacion:</label> <br>' +
                                '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if (document.getElementById('vendedor').value == '') {
                                    return 'Selecciona una opcion...';
                                }
                                if (document.getElementById('justify').value == '') {
                                    return 'Debes escribir una justificacion...';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'vendedor': document.getElementById("vendedor").value,
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
                                url: '/',
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
        <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>


    @endpush
@stop
