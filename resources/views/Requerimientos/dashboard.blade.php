@extends('layouts.architectui')

@section('page_title', 'Estadisticas de requerimientos')

@section('title_icon_class','fas fa-tachometer-alt')

@section('module_title', 'Estadisticas de requerimientos')

@section('subtitle', 'Aquí podrás ver diferentes estadísticas y gráficas basadas en los requerimientos gestionados por el area de Diseño grafico.')

@section('content')
    @inject('Usuarios','App\Services\Usuarios')
    @can('dashboardreq.view')
        <br onload="preload()">
        <div class="form-group">
            <div class="input-group">
                <div class="row input-daterange col-sm-8">
                    <div class="col-sm-3">
                        <input type="text" name="from_date" id="from_date" class="form-control" placeholder="Fecha inicial" readonly />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="to_date" id="to_date" class="form-control" placeholder="Fecha final" readonly />
                    </div>
                    <div>
                        <button type="button" name="filter" id="filter" class="btn btn-primary btn-lg">Filtrar datos</button>
                    </div>
                    <div class="col-2">
                        <button type="button" name="ViewAll" id="ViewAll" class="btn btn-primary btn-lg">Mostrar todo</button>
                    </div>
                </div>
                <div class="col text-right" style="margin-right: 1px">
                    <button id="downloadPdf" class="btn btn-primary btn-lg">Descargar Reporte</button>
                </div>
            </div>
        </div>
        <br>
        <div id="reportPage">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="ReqAsignados"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="Est_Propuestas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="ReqTotals"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none !important;">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table-bordered" id="ReqAsigDisTable">
                        <thead>
                            <tr>
                                <th>Diseñador</th>
                                <th>Requerimientos</th>
                                <th>Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody id="tableAsignados">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div style="display: none !important;">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table-bordered" id="ReqPropEstTable">
                        <thead>
                            <tr>
                                <th>Diseñador</th>
                                <th>Inic</th>
                                <th>%</th>
                                <th>E.apro</th>
                                <th>%</th>
                                <th>Rech</th>
                                <th>%</th>
                                <th>Aprob</th>
                                <th>%</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableEstProp">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div style="display: none !important;">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table-bordered" id="ReqEstTable">
                        <thead>
                            <tr>
                                <th>Solicitados</th>
                                <th>%</th>
                                <th>Finalizados</th>
                                <th>%</th>
                                <th>Rechazados</th>
                                <th>%</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="tableEstReq">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <style>
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
        </style>
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
            function preload() {
                Swal.fire({
                    icon: false,
                    title: 'Cargando informacion, un momento por favor...',
                    html: '<br><div class="container" style="align-items: center !important; margin-left: 150px; margin-right: 150px"><div class="preloader"></div></div>',
                    showConfirmButton: false,
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });
            }

            $(document).ready(function() {
                var from = $( "#from_date" )
                .datepicker({
                    dateFormat: "yy-mm-dd 00:00:00",
                    changeMonth: true,
                    changeYear: true,
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
                    changeYear: true,
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
                RequerimientosAsignados();
                EstadosPropuestas();
                req_totals();

                var Graf_Req_Asign;
                function RequerimientosAsignados (from_date = '', to_date = ''){
                    $.ajax({
                        url: "/req_dash_requerimientosxdiseñador",
                        dataType: 'json',
                        contentType: "application/json; charset=utf-8",
                        method: "GET",
                        data:{from_date:from_date, to_date:to_date},
                        success: function (data) {
                            $('#tableAsignados').html('');
                            var Datos = data.Diseñadores;

                            var i = 0;
                            var ii = 0;
                            var MonthsArray = [];
                            var CountArray = [];
                            var Suma_de_req = 0;

                            $(Datos).each(function () {
                                Suma_de_req = Suma_de_req + Datos[ii].req;
                                ii++;
                            });

                            $(Datos).each(function () {
                                MonthsArray.push(Datos[i].name);
                                CountArray.push(Datos[i].req);
                                var Porc = (Datos[i].req / Suma_de_req) * 100;
                                $('#tableAsignados').append('<tr><td>'+ Datos[i].name +'</td> <td>'+ Datos[i].req +'</td> <td>'+ Porc.toFixed(2) + '%</td></tr>');
                                i++;
                            });

                            var color = ['rgb(66,133,244)','rgb(219,68,55)','rgb(244,180,0)','rgb(15,157,88)','rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)'];
                            var bordercolor = ['rgb(66,133,244)','rgb(219,68,55)','rgb(244,180,0)','rgb(15,157,88)','rgba(153, 102, 255, 1)','rgba(255, 159, 64, 1)'];

                            var chartdata = {
                                labels: MonthsArray,
                                datasets: [{
                                    label: 'Requerimientos',
                                    backgroundColor: color,
                                    borderColor: color,
                                    borderWidth: 1,
                                    hoverBackgroundColor: color,
                                    hoverBorderColor: bordercolor,
                                    data: CountArray
                                }]
                            };

                            var mostrar = $("#ReqAsignados");

                            Graf_Req_Asign = new Chart(mostrar, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        text: 'Requerimientos asignados por diseñador'
                                    },
                                }
                            });
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }

                var graf_prop_est;
                var Total_propuestas = 0;
                function EstadosPropuestas(from_date = '', to_date = ''){
                    $.ajax({
                        url: "/req_dash_Prop_x_Estado",
                        dataType: 'json',
                        contentType: "application/json; charset=utf-8",
                        method: "GET",
                        data:{from_date:from_date, to_date:to_date},
                        success: function (data) {
                            $('#tableEstProp').html('');
                            var Datos = data.Diseñadores;

                            var i = 0;
                            var ii = 0;
                            var MonthsArray = [];
                            var est_iniciado = [];
                            var est_porAprobar = [];
                            var est_rechazadoVend = [];
                            var est_aprobado = [];
                            var est_plano = [];

                            var iniciado = 0;
                            var poraprobar = 0;
                            var rechazado = 0;
                            var aprobado = 0;

                            $(Datos).each(function () {
                                iniciado = iniciado + Datos[ii].est_iniciado;
                                poraprobar = poraprobar + Datos[i].est_porAprobar;
                                rechazado = rechazado + Datos[i].est_rechazadoVend;
                                aprobado = aprobado + Datos[i].est_aprobado;
                                ii++;
                            });
                            Total_propuestas = iniciado + poraprobar + rechazado + aprobado;

                            $(Datos).each(function () {
                                MonthsArray.push(Datos[i].name);
                                est_iniciado.push(Datos[i].est_iniciado);
                                est_porAprobar.push(Datos[i].est_porAprobar);
                                est_rechazadoVend.push(Datos[i].est_rechazadoVend);
                                est_aprobado.push(Datos[i].est_aprobado);
                                est_plano.push(Datos[i].est_plano);
                                var totales_prop = Datos[i].est_iniciado + Datos[i].est_porAprobar + Datos[i].est_rechazadoVend + Datos[i].est_aprobado;
                                var porcIni = (Datos[i].est_iniciado / totales_prop) * 100;
                                var PorcporApro = (Datos[i].est_porAprobar / totales_prop) * 100;
                                var PorcRec = (Datos[i].est_rechazadoVend / totales_prop) * 100;
                                var PorcApro = (Datos[i].est_aprobado / totales_prop) * 100;

                                $('#tableEstProp').append('<tr>' +
                                  '<td>'+Datos[i].name+'</td>' +
                                  '<td>'+Datos[i].est_iniciado+'</td>' +
                                  '<td>'+porcIni.toFixed(2) +'</td>' +
                                  '<td>'+Datos[i].est_porAprobar+'</td>' +
                                  '<td>'+PorcporApro.toFixed(2)+'</td>' +
                                  '<td>'+Datos[i].est_rechazadoVend+'</td>' +
                                  '<td>'+PorcRec.toFixed(2)+'</td>' +
                                  '<td>'+Datos[i].est_aprobado+'</td>' +
                                  '<td>'+PorcApro.toFixed(2)+'</td>' +
                                  '<td>'+totales_prop+'</td>' +
                                  '</tr>');
                                i++;
                            });

                            var chartdata = {
                                labels: MonthsArray,
                                datasets: [
                                	{
                                        label: 'Iniciado',
                                        backgroundColor: 'rgb(66,133,244)',
                                        borderColor: 'rgb(66,133,244)',
                                        borderWidth: 1,
                                        hoverBackgroundColor: 'rgb(66,133,244)',
                                        hoverBorderColor: 'rgb(66,133,244)',
                                        data: est_iniciado
                                    },
                                    {
                                        label: 'Rechazado',
                                        backgroundColor: 'rgb(219,68,55)',
                                        borderColor: 'rgb(219,68,55)',
                                        borderWidth: 1,
                                        hoverBackgroundColor: 'rgb(219,68,55)',
                                        hoverBorderColor: 'rgb(219,68,55)',
                                        data: est_rechazadoVend
                                    },
                                    {
                                        label: 'Enviado Aprobacion',
                                        backgroundColor: 'rgb(244,180,0)',
                                        borderColor: 'rgb(244,180,0)',
                                        borderWidth: 1,
                                        hoverBackgroundColor: 'rgb(244,180,0)',
                                        hoverBorderColor: 'rgb(244,180,0)',
                                        data:  est_porAprobar
                                    },
                                    {
                                        label: 'Aprobado',
                                        backgroundColor: 'rgb(15,157,88)',
                                        borderColor: 'rgb(15,157,88)',
                                        borderWidth: 1,
                                        hoverBackgroundColor: 'rgb(15,157,88)',
                                        hoverBorderColor: 'rgb(15,157,88)',
                                        data: est_aprobado
                                    }
                                ]
                            };
                            var mostrar = $("#Est_Propuestas");
                            graf_prop_est = new Chart(mostrar, {
                                type: 'bar',
                                data: chartdata,
                                options: {
                                    responsive: true,
                                    title: {
                                        display: true,
                                        text: 'Estado de las propuestas por diseñador'
                                    },
                                }
                            });
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }

                var graf_req_totals;
                var Total_Requerimientos;
                function req_totals(from_date = '', to_date = '') {
                    $('#tableEstReq').html('');
                    $.ajax({
                        url: "/req_dash_All_Req",
                        dataType: 'json',
                        contentType: "application/json; charset=utf-8",
                        method: "GET",
                        data: {from_date: from_date, to_date: to_date},
                        success: function (data) {

                           var chartColors = {
                                red: 'rgb(219,68,55)',
                                orange: 'rgb(255, 159, 64)',
                                yellow: 'rgb(255, 205, 86)',
                                green: 'rgb(15,157,88)',
                                blue: 'rgb(66,133,244)',
                                purple: 'rgb(153, 102, 255)',
                                grey: 'rgb(231,233,237)'
                           };
                            var ReqSolicitados = data.ReqSolicitados;
                            var ReqFinalizados = data.ReqFinalizados;
                            var ReqAnulados = data.ReqAnulados;

                            var Total_Solicitados = 0;
                            var Total_Finalizado = 0;
                            var Total_Anulados = 0;



                            var i1 = 0;
                            var ReqSolicitados_mes = [];
                            var ReqSolicitados_cantidad = [];

                            $(ReqSolicitados).each(function () {
                                ReqSolicitados_mes.push(ReqSolicitados[i1].fecha);
                                ReqSolicitados_cantidad.push(ReqSolicitados[i1].cantidad);
                                Total_Solicitados = Total_Solicitados + ReqSolicitados[i1].cantidad;
                                i1++;
                            });


                            var i2 = 0;
                            var ReqFinalizados_mes = [];
                            var ReqFinalizados_cantidad = [];
                            $(ReqFinalizados).each(function () {
                                ReqFinalizados_mes.push(ReqFinalizados[i2].fecha);
                                ReqFinalizados_cantidad.push(ReqFinalizados[i2].cantidad);
                                Total_Finalizado = Total_Finalizado + ReqFinalizados[i2].cantidad;
                                i2++;
                            });


                            var i3 = 0;
                            var ReqAnulados_mes = [];
                            var ReqAnulados_cantidad = [];
                            $(ReqAnulados).each(function () {
                                ReqAnulados_mes.push(ReqAnulados[i3].fecha);
                                ReqAnulados_cantidad.push(ReqAnulados[i3].cantidad);
                                Total_Anulados = Total_Anulados + ReqAnulados[i3].cantidad;
                                i3++;
                            });


                             Total_Requerimientos = Total_Solicitados + Total_Finalizado + Total_Anulados;

                            var PorcReqSolicitados  = (Total_Solicitados / Total_Requerimientos)*100;
                            var PorcReqFinalizados  = (Total_Finalizado / Total_Requerimientos)*100;
                            var PorcReqAnulados     = (Total_Anulados / Total_Requerimientos)*100;

                            $('#tableEstReq').append('<tr>' +
                                '<td>'+Total_Solicitados+'</td>' +
                                '<td>'+PorcReqSolicitados.toFixed(2)+'</td>' +
                                '<td>'+Total_Finalizado+'</td>' +
                                '<td>'+PorcReqFinalizados.toFixed(2)+'</td>' +
                                '<td>'+Total_Anulados+'</td>' +
                                '<td>'+PorcReqAnulados.toFixed(2)+'</td>' +
                                '<td>'+Total_Requerimientos+'</td>' +
                                '</tr>'
                            );

                            var chartdata = {
                                labels: ReqSolicitados_mes,
                                datasets: [
                                	{
                                        label: "Requerimientos Solicitados",
                                        backgroundColor: chartColors.blue,
                                        borderColor: chartColors.blue,
                                        data: ReqSolicitados_cantidad,
                                        fill: false,
                                    },
                                    {
                                        label: "Requerimientos Finalizados",
                                        fill: false,
                                        backgroundColor: chartColors.green,
                                        borderColor: chartColors.green,
                                        data: ReqFinalizados_cantidad,
                                    },
                                    {
                                        label: "Requerimientos Anulados",
                                        fill: false,
                                        backgroundColor: chartColors.red,
                                        borderColor: chartColors.red,
                                        data: ReqAnulados_cantidad,
                                    }
                                ]
                            };

                            var mostrar = $("#ReqTotals");

                            graf_req_totals = new Chart(mostrar, {
                                type: 'line',
                                data: chartdata,
                                options: {
                                    responsive: true,
                                    bezierCurve: true,
                                    title: {
                                        display: true,
                                        text: 'Estado de los requerimientos por mes'
                                    },
                                    tooltips: {
                                        mode: 'label',
                                    },
                                    hover: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                    scales: {
                                        xAxes: [{
                                            display: true,
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Meses'
                                            }
                                        }],
                                        yAxes: [{
                                            display: true,
                                            scaleLabel: {
                                                display: true,
                                                labelString: 'Valores'
                                            }
                                        }]
                                    }
                                }
                            });
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                    sweetAlert.close();
                }

                $('#filter').click(function(){
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    if(from_date != '' &&  to_date != '')
                    {
                        Graf_Req_Asign.destroy();
                        graf_prop_est.destroy();
                        graf_req_totals.destroy();
                        RequerimientosAsignados(from_date, to_date);
                        EstadosPropuestas(from_date,to_date);
                        req_totals(from_date,to_date);
                    }
                    else
                    {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Ambas fechas son requeridas para poder filtrar..!',
                        });
                    }
                });

                $('#ViewAll').click(function () {
                	$('#from_date').val('');
                	$('#to_date').val('');
                    Graf_Req_Asign.destroy();
                    graf_prop_est.destroy();
                    graf_req_totals.destroy();
                    RequerimientosAsignados();
                    EstadosPropuestas();
                    req_totals();
                });

                (function (api, $) { 'use strict'; api.writeText = function (x, y, text, options) { options = options || {};
                var defaults = { align: 'left', width: this.internal.pageSize.width };
                var settings = $.extend({}, defaults, options);
                var fontSize = this.internal.getFontSize();
                var txtWidth = this.getStringUnitWidth(text) * fontSize / this.internal.scaleFactor; if (settings.align === 'center') x += (settings.width - txtWidth) / 2; else if (settings.align === 'right') x += (settings.width - txtWidth);
                this.text(text, x, y); } })(jsPDF.API, jQuery);

                $('#downloadPdf').click(function(event) {

                	var img_enc = new Image(); img_enc.src = '/img/estrada.png';
                    var ReqAsignados = document.getElementById("ReqAsignados").toDataURL("image/png", 1.0);
                    var EstPropDis = document.getElementById("Est_Propuestas").toDataURL("image/png", 1.0);
                    var EstReq  = document.getElementById("ReqTotals").toDataURL("image/png", 1.0);
                    var detalle = '';
                    var detalle_prop = '';
                    var fecha_inicial = $('#from_date').val();
                    var fecha_final = $('#to_date').val();

                    if(fecha_inicial.trim() == '' && fecha_final.trim() == ''){
                        detalle = 'Historico de requerimientos';
                        detalle_prop = 'Historico de propuestas';
                    }else{
                        detalle = 'Reporte comprendido entre el ' + fecha_inicial.substr(0,7) + ' y '+ fecha_final.substr(0,7)
                        detalle_prop = 'Reporte comprendido entre el ' + fecha_inicial.substr(0,7) + ' y '+ fecha_final.substr(0,7)
                    }

                    const pdf = new jsPDF();

                    //Hoja 1
                    pdf.addImage(img_enc,'JPEG', 80, 10, 48, 34,{ align: 'center' });
                    pdf.setFontSize(17);
                    pdf.writeText(0, 55, 'REPORTE DE REQUERIMIENTOS', { align: 'center' });
                    pdf.setFontSize(10);
                    pdf.writeText(0, 60,detalle,{ align: 'center'});
                    pdf.addImage(ReqAsignados, 'JPEG', 20, 65, 164, 82);
                    pdf.writeText(0,160, 'Detalle de requerimientos asignados por diseñador', { align: 'center'});
                    pdf.autoTable({ html: '#ReqAsigDisTable', startY: 165} );

                    pdf.addPage(); //salto de pagina

                    //Hoja 2
                    pdf.addImage(img_enc,'JPEG', 80, 10, 48, 34,{ align: 'center' });
                    pdf.setFontSize(17);
                    pdf.writeText(0, 55, 'REPORTE DE PROPUESTAS', { align: 'center' });
                    pdf.setFontSize(10);
                    pdf.writeText(0, 60,detalle_prop,{ align: 'center'});
                    pdf.addImage(EstPropDis, 'JPEG', 20, 65, 164, 82);
                    pdf.writeText(0,160, 'Detalle del estado de las propuestas por diseñador', { align: 'center'});
                    pdf.writeText(0,165,'TOTAL PROPUESTAS: '+Total_propuestas, { align: 'center'});
                    pdf.autoTable({ html: '#ReqPropEstTable', startY: 170} );

                    pdf.addPage(); //salto de pagina

                    //hoja 3
                    pdf.addImage(img_enc,'JPEG', 80, 10, 48, 34,{ align: 'center' });
                    pdf.setFontSize(17);
                    pdf.writeText(0, 55, 'REPORTE DE REQUERIMIENTOS', { align: 'center' });
                    pdf.setFontSize(10);
                    pdf.writeText(0, 60,detalle,{ align: 'center'});
                    pdf.addImage(EstReq, 'JPEG', 20, 65, 164, 82);
                    pdf.writeText(0,160, 'Detalle del estado de las propuestas por diseñador', { align: 'center'})
                    pdf.writeText(0,165,'TOTAL REQUERIMIENTOS: '+Total_Requerimientos, { align: 'center'});
                    pdf.autoTable({ html: '#ReqEstTable', startY: 170} );

                    pdf.save('Reporte_requerimientos.pdf');
                });
            });
        </script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css"></script>
        <script type="text/css" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
        <script src="https://unpkg.com/jspdf-autotable@3.2.11/dist/jspdf.plugin.autotable.js" ></script>

    @endpush

@endsection

