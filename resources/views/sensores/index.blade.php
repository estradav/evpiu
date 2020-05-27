@extends('layouts.architectui')

@section('page_title', 'Sensor de chimenea y gas')

@section('content')
    @can('gestion_ambiental.sensores')
        <div class="main-card mb-3 card">
            <div class="card-header">
                Sensor de chimenea
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="date_chimenea">
                            <div class="input-group-append">
                                <button class="btn btn-success btn-lg btn-block" id="info_chimenea">GENERAR INFORME DE CHIMENEA</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 table-responsive" id="tables_chimenea">

                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-header">
                Sensor de gas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="date_gas">
                            <div class="input-group-append">
                                <button class="btn btn-success btn-lg btn-block" id="info_gas">GENERAR INFORME DE GAS</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 table-responsive" id="tables_gas">

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
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let star_date = moment().format('YYYY-MM-DD'), end_date = moment().format('YYYY-MM-DD');

            moment.locale('es');
            $('input[id="date_chimenea"]').daterangepicker({
                drops: 'down',
                open: 'center',
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },

            }, function(start, end, label) {
                star_date = start.format('YYYY-MM-DD');
                end_date = end.format('YYYY-MM-DD');
            });

            $('#info_chimenea').on('click', function () {
                $('#tables_chimenea').html('');
                $.ajax({
                    url: 'sensores_chimenea',
                    type: 'GET',
                    data: {
                        star_date, end_date
                    },
                    success: function (data) {
                        if(data.length === 0){
                            $('#tables_chimenea').append(`
                                <div class="alert alert-danger" role="alert">
                                    <h5 class="alert-heading">NO SE ENCONTRO INFORMACION!! </h5>
                                    <p>Por favor, verifique que la fecha ingresada es correcta.</p>
                                </div>
                            `);
                        }else{
                            $('#tables_chimenea').append(`
                                <div id="tables" name="tables" style="height: 600px; overflow-y: scroll;"></div>
                            `);
                            for (let i = 0; i < data.length; i++) {
                                $('#tables').append(`
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr class="bg-success text-center">
                                                <th scope="col" colspan="3">`+ data[i]['00:00:00']['fecha'] +`</th>
                                            </tr>
                                            <tr class="bg-success text-center">
                                                <th scope="col">HORA</th>
                                                <th scope="col">PROMEDIO DE ºC INYECTORAS</th>
                                                <th scope="col">PROMEDIO DE ºC HORNO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chimenea_table_body_`+ i +`"  class="text-center"></tbody>
                                        <tfoot>
                                            <tr class="text-center table-success">
                                                <td></td>
                                                <td><b> ºC INYECTORAS</b></td>
                                                <td><b>ºC HORNO</b></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><b>VALOR MAXIMO:</b></td>
                                                <td>`+ data[i]['max_and_min']['max_inyecctora'].toFixed(2) +`</td>
                                                <td>`+ data[i]['max_and_min']['max_horno'].toFixed(2) +`</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><b>VALOR MINIMO:</b></td>
                                                <td>`+ data[i]['max_and_min']['min_inyecctora'].toFixed(2) +`</td>
                                                <td>`+ data[i]['max_and_min']['min_horno'].toFixed(2) +`</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br>
                                `);

                                for (var key in data[i]) {
                                    // skip loop if the property is from prototype
                                    if (!data[i].hasOwnProperty(key)) continue;
                                    if(key === 'max_and_min') continue;

                                    var obj = data[i][key];
                                    var temp_inyec  = obj['temperature_inyecctora'] / obj['items'];
                                    var temp_horn   = obj['temperature_horno'] / obj['items'];


                                    $('#chimenea_table_body_'+ i).append(`
                                        <tr>
                                           <td>`+ obj['time']  +`</td>
                                           <td>`+ temp_inyec.toFixed(2) +`</td>
                                           <td>`+ temp_horn.toFixed(2) +`</td>
                                        </tr>
                                    `);
                                }

                            }
                        }
                    }
                });
            });


            /*  Datepicker and report gas */

            moment.locale('es');
            $('input[id="date_gas"]').daterangepicker({
                drops: 'down',
                open: 'center',
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },

            }, function(start, end, label) {
                star_date = start.format('YYYY-MM-DD');
                end_date = end.format('YYYY-MM-DD');
            });

            $('#info_gas').on('click', function () {
                $('#tables_gas').html('');
                $.ajax({
                    url: 'sensores_gas',
                    type: 'GET',
                    data: {
                        star_date, end_date
                    },
                    success: function (data) {
                        if(data.length === 0) {
                            $('#tables_gas').append(`
                                <div class="alert alert-danger" role="alert">
                                    <h5 class="alert-heading">NO SE ENCONTRO INFORMACION!! </h5>
                                    <p>Por favor, verifique que la fecha ingresada es correcta.</p>
                                </div>
                            `);
                        }else{
                            $('#tables_gas').append(`
                                <div id="tables_ga" name="tables_ga" style="height: 600px; overflow-y: scroll;"></div>
                            `);
                            for (let i = 0; i < data.length; i++) {
                                $('#tables_ga').append(`
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr class="bg-success text-center">
                                                <th scope="col" colspan="3">`+ data[i]['00:00:00']['fecha'] +`</th>
                                            </tr>
                                            <tr class="bg-success text-center">
                                                <th scope="col">HORA</th>
                                                <th scope="col">m3 GASTADOS</th>
                                                <th scope="col">GASTO PROMEDIO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="gas_table_body_`+ i +`"  class="text-center">  </tbody>
                                    </table>
                                    <br>
                                `);

                                for (var key in data[i]) {
                                    // skip loop if the property is from prototype
                                    if (!data[i].hasOwnProperty(key)) continue;

                                    var obj = data[i][key];
                                    var promedio  = obj['lectura'] / obj['items'];

                                    $('#gas_table_body_'+ i).append(`
                                        <tr>
                                           <td>`+ obj['time']  +`</td>
                                           <td>`+ obj['lectura'].toFixed(2) +`</td>
                                           <td>`+ promedio.toFixed(2) +`</td>
                                        </tr>
                                    `);
                                }
                            }
                        }
                    }
                });
            });
        })
    </script>
@endpush
