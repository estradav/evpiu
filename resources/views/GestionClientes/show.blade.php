@extends('layouts.dashboard')

@section('page_title', 'Cliente: ')



@section('content')
    @can('gestion_clientes.show')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile igualar">
                            <h3 class="profile-username text-center"><i class="fas fa-sync fa-spin"></i></h3>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Facturas</b> <a class="float-right" id="total_facturas"><i class="fas fa-sync fa-spin"></i></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Notas Credito</b> <a class="float-right" id="total_notas"><i class="fas fa-sync fa-spin"></i></a>
                                </li>

                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Localización</strong>
                            <p class="text-muted" id="localizacion" name="localizacion"></p>
                            <div class="pace  pace-inactive pace-inactive">
                                <div class="pace-activity"></div>
                            </div>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Notas</strong>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
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
                                        <div class="user-block">

                                        </div>
                                        <!-- /.user-block -->
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <b>NOMBRE:</b> <label for=""></label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>RAZON SOCIAL:</b> <label> TENNIS EN REORGANIZACION</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>NIT/CC:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>CODIGO CLIENTE:</b>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>DIRECCION 1:</b> <label >KR 50 B # 79 A 16</label>
                                                </div>
                                                <div class="col-sm-6">
                                                    <b>DIRECCION 2:</b> <label >KR 50 B # 79 A 16</label>
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
                        <div class="card-body ">
                            <h3 class="profile-username text-center">Dashboard</h3>
                            <hr>


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
                var altura_arr = [];
                $('.igualar').each(function(){
                    var altura = $(this).height();
                    altura_arr.push(altura);
                });
                altura_arr.sort(function(a, b){return b-a});
                $('.igualar').each(function(){
                    $(this).css('height',altura_arr[0]);
                });
            });

            function load() {
                $.ajax({
                    url: '',
                    type: '',
                    data: '',
                    success: function (data) {

                    },
                    error: function () {

                    }
                })
            }
        </script>

    @endpush
@stop
