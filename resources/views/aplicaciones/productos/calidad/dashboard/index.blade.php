@extends('layouts.architectui')

@section('page_title', 'Informes calidad')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'aplicaciones_calidad_dashboard' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.calidad.dashboard')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-check icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Informes calidad
                        <div class="page-title-subheading">
                            Informes bimestrales
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h4 class="text-center">Por favor seleccione el año y el bimestre a generar informe</h4>
                        <div class="row justify-content-center">

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <select name="year" id="year" class="form-control">
                                    <option value="2020">2020</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                <select name="bimester" id="bimester" class="form-control">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="1-2">Enero - Febrero</option>
                                    <option value="3-4">Marzo - Abril</option>
                                    <option value="5-6">Mayo - Junio</option>
                                    <option value="7-8">Julio - Agosto</option>
                                    <option value="9-10">Septiembre - Octubre</option>
                                    <option value="11-12">Noviembre - Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <button class="btn btn-block btn-primary" id="consulta">CONSULTAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body" id="result_search">
                        <div class="alert alert-info text-center" role="alert">
                            <h4 class="alert-heading text-center">
                                <i class="fas fa-info-circle fa-3x"></i> <br>
                                <b>Por favor, realice una busqueda para ver la informacion..!</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection



@push('javascript')
    <script type="text/javascript" src="{{ asset('librerias_javascript/chart.js/dist/Chart.min.js') }}"></script>


    <script type="text/javascript">
        $(document).ready(function () {

            $(document).on('click', '#consulta', function (){
                let year = document.getElementById('year').value;
                let bimester = document.getElementById('bimester').value;

                if (year && bimester){
                    $('#result_search').html('').append(`
                        <div class="row justify-content-center">
                            <div id="loader"></div>
                        </div>
                        <h4 class="text-center">Recuperando informacion, un momento por favor...</h4>
                    `);

                    $.ajax({
                        url: '/aplicaciones/productos/calidad/dashboard/consultar_bimestre',
                        type: 'get',
                        data: {
                            year: year,
                            bimester: bimester
                        },
                        success: function (data) {
                            $('#result_search').html('').append(`
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <canvas id="repeat_causes" width="400" height="200"></canvas>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <canvas id="non_conforming_quantity" width="400" height="200"></canvas>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <canvas id="recurring_cause" width="400" height="200"></canvas>
                                    </div>
                                </div>
                           `);


                            const labels_causes = Object.keys(data.causes);
                            const labels_inspections_centers  = Object.keys(data.inspections_centers);

                            const repeat_causes = [];

                            const conforming_quantity = [];
                            const non_conforming_quantity = [];
                            const quantity_inspected = [];


                            for (const [index, [key, value]] of Object.entries(Object.entries(data.causes))) {
                                repeat_causes.push(value[0].cause_quantity);
                            }


                            for (const [index, [key, value]] of Object.entries(Object.entries(data.inspections_centers))) {
                                repeat_causes.push(value[0].center_quantity);
                                conforming_quantity.push(value[0].conforming_quantity);
                                non_conforming_quantity.push(value[0].non_conforming_quantity);
                                quantity_inspected.push(value[0].quantity_inspected);
                            }




                            const ctx1 = document.getElementById('repeat_causes').getContext('2d');
                            const ctx2 = document.getElementById('non_conforming_quantity').getContext('2d');



                            new Chart(ctx1, {
                                type: 'bar',
                                data: {
                                    labels: labels_causes,
                                    datasets: [{
                                        label: 'NUMERO DE VECES QUE SE REPITE LA CAUSA',
                                        data: repeat_causes,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });


                            new Chart(ctx2, {
                                type: 'bar',
                                data: {
                                    labels: labels_inspections_centers,
                                    datasets: [{
                                        label: 'CANTIDAD INSPECCIONADA',
                                        labelcolor: '',
                                        data: quantity_inspected,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1,
                                        order: 1

                                    },
                                    {
                                        label: 'CANTIDAD CONFORME',
                                        data: conforming_quantity,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1,
                                        order: 1

                                    },
                                    {
                                        label: 'CANTIDAD NO CONFORME',
                                        data: non_conforming_quantity,
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.2)',
                                            'rgba(54, 162, 235, 0.2)',
                                            'rgba(255, 206, 86, 0.2)',
                                            'rgba(75, 192, 192, 0.2)',
                                            'rgba(153, 102, 255, 0.2)',
                                            'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(255, 206, 86, 1)',
                                            'rgba(75, 192, 192, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ],
                                        borderWidth: 1,
                                        order: 2
                                    }]
                                },
                                options: {
                                    title: {
                                        display: true,
                                        text: 'CANTIDADES POR CENTRO DE TRABAJO'
                                    },
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true
                                            }
                                        }]
                                    }
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, err){
                            console.log('text status '+textStatus+', err '+err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                            });
                        }
                    })

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Por favor selecciona un año y un bimestre para obtener la informacion',
                    });
                }

            });


        });
    </script>
@endpush


@push('styles')
    <style>
        #loader-wrapper {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }
        #loader {
            display: block;
            position: relative;
            top: 50%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #3498db;

            -webkit-animation: spin 2s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 2s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #e74c3c;

            -webkit-animation: spin 3s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 3s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #f9c922;

            -webkit-animation: spin 1.5s linear infinite; /* Chrome, Opera 15+, Safari 5+ */
            animation: spin 1.5s linear infinite; /* Chrome, Firefox 16+, IE 10+, Opera */
        }

        @-webkit-keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }
        @keyframes spin {
            0%   {
                -webkit-transform: rotate(0deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);  /* IE 9 */
                transform: rotate(0deg);  /* Firefox 16+, IE 10+, Opera */
            }
            100% {
                -webkit-transform: rotate(360deg);  /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);  /* IE 9 */
                transform: rotate(360deg);  /* Firefox 16+, IE 10+, Opera */
            }
        }
    </style>

    <style type="text/css" href="{{ asset('librerias_javascript/chart.js/dist/Chart.min.css') }}"> </style>
@endpush
