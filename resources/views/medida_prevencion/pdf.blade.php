<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Informe de medida de prevencion</title>

        <style>
            .center {
                text-align: center !important;
            }

            .center h2, h3, h4 {
                margin-top: 1px;
                margin-bottom: 1px;
            }
            .center img{
                width: 30% !important;
                margin-top: 2%;
                margin-bottom: -1%;
            }
            table{
                width:100%;
                height:auto;
                margin:10px 0 10px 0;
                border-collapse:collapse;
                text-align:center;
                background-color:white;
                color: black;
            }

            table td,th{
                border:1px solid black;
            }



        </style>
    </head>
    <body>
        <div class="center">
            <img src="{{public_path().'/img/Logo_v2.png'}}" alt="">
            <h4>CI ESTRADA VELASQUEZ Y CIA. S.A.S </h4>
            <h4>REPORTE DE MEDIDA DE PREVENCION</h4>
            <h4>{{$fechas}}</h4>
            <br>
            @foreach($data as $key => $d)
                <table class="table table-bordered red-border table-sm">
                    <thead>
                        <tr>
                            <th colspan="4">{{$key}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>FECHA</th>
                            <td>HORA INGRESO</td>
                            <td colspan="2">TEMPERATURAS REGISTRADAS</td>
                        </tr>
                        @for ($i = 0; $i <= sizeof($d)-1; $i++)
                            <tr>
                                <th>{{date('d-m-Y', strtotime($d[$i]->created_at))}}</th>
                                <td>{{$d[$i]->time_enter}}</td>
                                <td colspan="2">
                                    @foreach($d[$i]->temperature as $temp)
                                        {{$temp->temperature.'  '}}
                                    @endforeach
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @endforeach
        </div>
    </body>
</html>
