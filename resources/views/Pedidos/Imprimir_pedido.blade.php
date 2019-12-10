<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pedido | evpiu</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->


    <link rel="stylesheet" href="https://adminlte.io/themes/dev/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://adminlte.io/themes/dev/AdminLTE/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <section class="invoice">
        <div class="row">
            <div class="col-12">
                <h2 class="page-header">
                    <img src="/img/Logo_v2.png" alt="" style="width: 195px !important; height: 142px !important;" class="headers">
                    <small class="float-right">Fecha: 22-11-2019 {{--{{ $encabezado[0]->created_at}}--}}</small>
                </h2>
            </div>
        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>CI Estrada Velasquez y CIA. SAS</strong><br>
                    <b>NIT:</b> 890926617-8 <br>
                    <b>Telefono:</b> 265-66-65<br>
                    <b>Email:</b> Comercial@estradavelasquez.com <br>
                    <b>Direccion:</b> KR 55 # 29 C 14 <br>
                    Zona Industrial de belen
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>Cliente: </strong><br>
                    <b>Codigo Cliente:</b>  <br>
                    <b>Ciudad:</b> <br>
                    <b>Direccion:</b> <br>
                    <b>Telefono:</b>
                </address>
            </div>
            <div class="col-sm-4 invoice-col">
                <b>Pedido #: 007612</b> <br>
                <b>Orden Compra:</b> <br>
                <b>Condicion de pago:</b> <br>
                <b>Vendedor: </b>: 968-34567
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Notas</th>
                        <th>Unidad</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Call of Duty</td>
                        <td>El snort testosterone trophy driving gloves </td>
                        <td>UN</td>
                        <td>20</td>
                        <td>$64.50</td>
                        <th>$900.000</th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Valor Bruto</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>92.000</td>
                        <td>10.000</td>
                        <td>82.000</td>
                        <td>13.000</td>
                        <td>130.000</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <strong>NOTAS GENERALES:</strong><br>
            </div>
        </div>
    </section>
</div>

<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/adminlte.min.js"></script>
<script src="https://adminlte.io/themes/dev/AdminLTE/dist/js/demo.js"></script>
</body>
</html>
