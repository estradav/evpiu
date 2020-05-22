@extends('layouts.architectui')

@section('page_title', 'Sensor de chimenea y gas')

@section('content')
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
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let star_date = moment().format('DD-MM-YY'), end_date = moment().format('DD-MM-YY');

            /*  Datepicker and report Chimenea */

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
                star_date = start.format('DD-MM-YY');
                end_date = end.format('DD-MM-YY');
            });

            $('#info_chimenea').on('click', function () {
                $.ajax({
                    url: 'sensores_chimenea',
                    type: 'GET',
                    data: {
                        star_date, end_date
                    },
                    success: function (data) {
                        console.log(data);
                        for (let i = 0; i < data.length; i++) {
                            for (var key in data[i]) {
                                // skip loop if the property is from prototype
                                if (!data[i].hasOwnProperty(key)) continue;

                                var obj = data[i][key];

                                console.log(obj['time']);

                                $('#tables_chimenea').append(`
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-success text-center">
                                                <th scope="col">HORA</th>
                                                <th scope="col">PROMEDIO DE ºC INYECTORAS</th>
                                                <th scope="col">PROMEDIO DE ºC HORNO</th>
                                            </tr>
                                        </thead>
                                        <tbody id="chimenea_table_body" class="text-center">
                                              <tr>
                                                  <td>`+ obj['time']  +`</td>
                                                  <td></td>
                                                  <td></td>
                                              </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-center table-success">
                                                <td></td>
                                                <td><b> ºC INYECTORAS</b></td>
                                                <td><b>ºC HORNO</b></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><b>VALOR MAXIMO:</b></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td><b>VALOR MINIMO:</b></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <br>
                                `)
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
                star_date = start.format('DD-MM-YY');
                end_date = end.format('DD-MM-YY');
            });

            $('#info_gas').on('click', function () {
                alert(star_date+' - '+ end_date);
            });


        })
    </script>
@endpush
