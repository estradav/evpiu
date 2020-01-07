@extends('layouts.dashboard')

@section('page_title', 'Estadisticas de requerimientos')

@section('title_icon_class','fas fa-tachometer-alt')

@section('module_title', 'Estadisticas de requerimientos')

@section('subtitle', 'Aquí podrás ver diferentes estadísticas y gráficas basadas en los requerimientos gestionados por el area de Diseño grafico.')

@section('content')
    @inject('Usuarios','App\Services\Usuarios')
    @can('dashboard.view')
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Dashboard</h5>
                    <div class="card-body">
                        <canvas id="myChart"></canvas>
                        <label for="chartType">Tipo de grafico</label>
                        <select id="chartType" class="form-control">
                            <option value="line">Line</option>
                            <option value="pie">Pie</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Dashboard</h5>
                    <div class="card-body">
                        <canvas id="Usuarios"></canvas>
                        <label for="chartType">Tipo de grafico</label>
                        <select id="chartType" class="form-control">
                            <option value="line">Line</option>
                            <option value="pie">Pie</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @push('javascript')
        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "/get-user-chart-data",
                    dataType: 'json',
                    contentType: "application/json; charset=utf-8",
                    method: "GET",
                    success: function(data) {
                        var months = data.months;
                        var User_Count_data = data.User_Count_data;
                        var color = ['rgb(66,133,244)', 'rgb(219,68,55)', 'rgb(244,180,0)', 'rgb(15,157,88)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
                        var bordercolor = ['rgb(66,133,244)', 'rgb(219,68,55)', 'rgb(244,180,0)', 'rgb(15,157,88)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'];
                        console.log(data);

                        var chartdata = {
                            labels: months,
                            datasets: [{
                                label: months,
                                backgroundColor: color,
                                borderColor: color,
                                borderWidth: 2,
                                hoverBackgroundColor: color,
                                hoverBorderColor: bordercolor,
                                data: User_Count_data
                            }]
                        };

                        var mostrar = $("#Usuarios");

                        var grafico = new Chart(mostrar, {
                            type: 'bar',
                            data: chartdata,
                            options: {
                                responsive: true,
                            }
                        });
                    },
                    error: function(data) {
                        console.log(data);
                    }
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
    @endpush

@endsection

