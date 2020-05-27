@extends('layouts.architectui')

@section('page_title', 'Requerimientos')

@section('module_title', 'Requerimiento #'.$var )

@section('content')
    @inject('Lineas','App\Services\Lineas')
    @can('show_requerimientos.view')
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="ain-card mb-3 card testvisual">
                    <div class="card-header">
                        INFORMACION GENERAL
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label><b>DISEÑADOR:</b></label>
                                <label id="Diseñador" class="text-danger"></label>
                            </div>
                            <div class="col-6">
                                <label><b>ESTADO:</b></label>
                                <label id="Estado" class="text-primary"></label>
                            </div>
                            <div class="col-6">
                                <label><b>VENDEDOR:</b></label>
                                <label id="Vendedor"></label>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <label><b>CLIENTE:</b></label>
                                <label id="Cliente"></label>
                            </div>
                            <div class="col-6">
                                <label><b>MARCA:</b></label>
                                <label id="Marca"></label>
                            </div>
                            <div class="col-6">
                                <label><b>ARTICULO:</b></label>
                                <label id="Articulo"></label>
                            </div>
                            <div class="col-6">
                                <label><b>FECHA DE SOLICITUD:</b></label>
                                <label id="Fecha_solicitud"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card testvisual">
                    <div class="card-header">
                        ARCHIVOS DE SOPORTE
                    </div>
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="col-sm py-2">
                               <div class="row" id="ArchivosDeSoporte">

                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                <div class="main-card mb-3 card testvisual">
                    <div class="card-header">
                        DETALLE REQUERIMIENTO
                    </div>
                    <div class="card-body">
                        <div id="Detalles">

                        </div>
                        <br>
                        <div class="text-center">
                            <button class="btn btn-light newcoment" id="{{ $var }}">ENVIAR UN COMENTARIO</button>
                            <button class="btn btn-light showcoment" id="{{ $var }}">VER COMENTARIOS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                <div class="main-card mb-3 card testvisual">
                    <div class="card-header">
                        OPCIONES
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-center col-13" style="margin-left: 10px; margin-right: 10px">
                                <br>
                                <button class="btn btn-light SubirArchiv" id="{{ $var }}" style="width: 90px; height: 80px;"><i class="fa fa-file"></i>
                                    <br>Subir archivos</button>
                                <button class="btn btn-light EnvRender" id="{{ $var }}" style="width: 90px; height: 80px;"><i class="far fa-paper-plane"></i>
                                    <br>Enviar a render</button>
                                <button class="btn btn-light CambEstreq" id="{{ $var }}" style="width: 90px; height: 80px;"><i class="fas fa-exchange-alt"></i>
                                    <br>Cambiar estado</button>
                                <button class="btn btn-light anularreq" id="{{ $var }}" style="width: 90px; height: 80px;"><i class="fas fa-ban"></i>
                                    <br>Anular</button>
                                <button class="btn btn-light FinalizarReq" id="{{ $var }}" style="width: 90px; height: 80px;"><i class="fas fa-check-double"></i>
                                    <br>Finalizar</button>
                                <button class="btn btn-light CambiarDiseñador" id="{{ $var }}" style="width: 97px; height: 80px; cursor: pointer"><i class="fas fa-exchange-alt"></i>
                                    <br>Cambiar diseñador</button>
                                <button class="btn btn-light EnvDiseño" id="{{ $var }}" style="width: 90px; height: 80px;"><i class="fas fa-pencil-ruler"></i>
                                    <br>Enviar a diseño</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        PROPUESTAS
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table" id="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">ARTICULO</th>
                                            <th scope="col">RELIEVE</th>
                                            <th scope="col">ESTADO</th>
                                            <th scope="col">FECHA CREACION</th>
                                            <th scope="col" class="text-center">
                                                <button class="btn btn-success btn-sm AddPropuestaReq">Agregar</button>
                                            </th>
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

        @section('modal')
            <div class="modal fade bd-example-modal-lg" id="ViewArtModal" tabindex="-1" role="dialog" aria-labelledby="ViewArtModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ViewArtTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="">
                            <div id="ViewArtPdf" style="height:750px;" ></div>
                        </div>
                        <div class="modal-footer" style="text-align: center !important;">
                            <button class="btn btn-primary" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="timelinemodal" name="timelinemodal" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align: right !important; margin-top: 10px; margin-right: 12px">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <br>
                        <div class="col-sm-12">
                            <div class="container py-2" id="DetallesComentariosReque">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-xl" id="PdfView" tabindex="-1" role="dialog" aria-labelledby="PdfView" aria-hidden="true" style="overflow-y: scroll;">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="PdfTitle"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="TextoImprimir" >
                            <div class="wrapper">
                                <section class="invoice" style="text-transform: uppercase">
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <img src="/img/Logo_v2.png" alt="" style="width: 150px !important; height: 109px !important;" class="headers">
                                        </div>
                                        <div class="col-12">
                                            <label style="margin: -1px">CI Estrada Velasquez y Cia SAS</label> <br>
                                            <label style="margin: -1px">CR 55 29 C 14 ZONA IND. DE BELEN, MEDELLIN, TEL 2656665</label><br>
                                            <label style="margin: -1px;">Requerimiento No.: </label> <label id="PDFnumeroreq"></label> - <label style="margin: -1px">Propuesta No.: </label>
                                            <label id="PDFnumeroprop"></label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <label>ESPECIFICACIONES DE DISEÑO</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row invoice-info text-center" style="margin-left: 15%; margin-right: 15%">
                                        <div class="col-sm-6 invoice-col text-left">
                                            <address>
                                                <b>ARTICULO:</b> <label id="PDFarticulo"></label> <br>
                                                <b>RELIEVE:</b> <label id="PDFrelieve"></label> <br>
                                                <b>MARCA:</b> <label id="PDFmarca"></label> <br>
                                                <b>MEDIDA:</b> <a href="javascript:void(0)" id="PDFMedida"></a>
                                            </address>
                                        </div>
                                        <div class="col-sm-6 invoice-col text-left">
                                            <address>
                                                <b>VENDEDOR:</b> <label id="PDFvendedor"></label> <br>
                                                <b>DISEÑADOR:</b> <label id="PDFdiseñador"></label> <br>
                                                <b>FECHA:</b> <label id="PDFfecha"></label>
                                            </address>
                                        </div>

                                        <div class="col-sm-12 text-center">
                                            <table style="width: 740px;" heig cellspacing="3" cellpadding="3" border="1">
                                                <tr>
                                                    <td>
                                                        <b>DIBUJO 2D  <a href="javascript:void(0)" class="Upload2DProp"> <i class="fas fa-file-upload"></i></a></b>
                                                    </td>
                                                    <td>
                                                        <b>DIBUJO 3D  <a href="javascript:void(0)" class="Upload3DProp"> <i class="fas fa-file-upload"></i></a></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 330px; width: 370px" >
                                                        <div class="image-container" id="PDFdibujo2d">

                                                        </div>
                                                    </td>
                                                    <td style="height: 330px; width: 370px">
                                                        <div class="image-container" id="PDFdibujo3d">

                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table style="width: 740px;" heig cellspacing="1" cellpadding="2" border="1">
                                                <tr>
                                                    <td>
                                                        <b>PLANO  <a href="javascript:void(0)" class="UploadPlanoProp"> <i class="fas fa-file-upload"></i></a></b>
                                                    </td>
                                                    <td>
                                                        <b>CARACTERISTICAS <a href="javascript:void(0)" class="Add_Caracteristicas"> <i class="fas fa-comment"></i></a></b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height: 330px; width: 370px" >
                                                        <div id="PDFplano">

                                                        </div>
                                                    </td>
                                                    <td style="height: 330px; width: 370px" >
                                                        <div class="text-center" style="height: 320px; width: 360px" id="PDFcaracteristicas">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="dropdown mr-1">
                                <button type="button" data-toggle="dropdown" id="Opciones_reque" class="btn btn-primary dropdown-toggle">Opciones <span class="caret"></span></button>
                                <div class="dropdown-menu" aria-labelledby="Opciones_reque">
                                    <a class="dropdown-item AprobarProp" href="javascript:void(0);">Aprobar</a>
                                    <a class="dropdown-item RechazarProp" href="javascript:void(0);">Rechazar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item FinalizarProp" href="javascript:void(0);">Finalizar</a>
                                    <a class="dropdown-item CrearMedida" href="javascript:void(0);">Crear Medida</a>
                                    <a class="dropdown-item EnviarParaAprobacion" href="javascript:void(0);">Enviar para aprobacion</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item ImprimirPdf" href="javascript:void(0);">Imprimir</a>
                                </div>
                            </div>

                            <button type="button" class="btn btn-light Cerrar" data-dismiss="modal" id="Cerrar">Cerrar</button>
                            <div class="btn-group" style="display: none !important;">
                                <button type="button" data-toggle="dropdown" id="Opciones_reque" class="btn btn-default dropdown-toggle">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a  href="javascript:void(0)" class="AprobarProp">Aprobar</a></li>
                                    <button type="button" class="btn btn-light AprobarProp">Aprobar</button>
                                    <button type="button" class="btn btn-light RechazarProp">Rechazar</button>
                                    <button type="button" class="btn btn-light FinalizarProp">Finalizar</button>
                                    <button type="button" class="btn btn-light CrearMedida">Crear Medida</button>
                                    <button type="button" class="btn btn-light ImprimirPdf" id="ImprimirPdf">Imprimir</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade bd-example-modal-lg" id="medidamodal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelHeading"> </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="medidaForm" name="medidaForm" class="form-horizontal">
                            <div class="modal-body">
                                <input type="hidden" name="medida_id" id="medida_id">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">Linea:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="med_lineas_id" id="med_lineas_id">
                                                    @foreach ( $Lineas->get() as $index => $Linea)
                                                        <option value="{{ $index }}" {{ old('med_lineas_id') == $index ? 'selected' : ''}}>
                                                            {{ $Linea }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-3 control-label">Sublinea:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="med_sublineas_id" id="med_sublineas_id"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">Codigo:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="cod" name="cod" value=""  onkeyup="this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="mm2" class="col-sm-6 control-label">Milimetros²:</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="mm2" name="mm2" value="" onkeyup="this.value=this.value.toUpperCase();">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="denominacion" class="col-sm-6 control-label">Denominacion:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="denominacion" name="denominacion" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="denominacion" class="col-sm-12 control-label">Unidad Medida:</label>
                                            <div class="col-sm-12">
                                                <select name="UndMedida" id="UndMedida" class="form-control UndMedida">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="campos" name="campos">
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">Comentarios:</label>
                                            <div class="col-sm-12">
                                                <textarea id="coments" name="coments" placeholder="Comentarios" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="saveBtn" value="Crear">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endsection
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
            $(document).ready(function () {

                var altura_arr = [];//CREAMOS UN ARREGLO VACIO
                $('.testvisual').each(function(){//RECORREMOS TODOS LOS CONTENEDORES DE LAS IMAGENES, DEBEN TENER LA MISMA CLASE
                    var altura = $(this).height(); //LES SACAMOS LA ALTURA
                    altura_arr.push(altura);//METEMOS LA ALTURA AL ARREGLO
                });
                altura_arr.sort(function(a, b){return b-a}); //ACOMODAMOS EL ARREGLO EN ORDEN DESCENDENTE
                $('.testvisual').each(function(){//RECORREMOS DE NUEVO LOS CONTENEDORES
                    $(this).css('height',altura_arr[0]);//LES PONEMOS A TODOS LOS CONTENEDORES EL PRIMERO ELEMENTO DE ALTURA DEL ARREGLO, QUE ES EL MAS GRANDE.
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var id = @json( $var );
                var Username = @json( Auth::user()->name );
                var Username_id = @json( Auth::user()->id );
                var Roll = @json( Auth::user()->app_roll );
                var Url = window.location.href;
                var New_reque_Producto;


                $('body').on('click','.newcoment',function () {
                    var id = $(this).attr('id');

                    if(Roll == 'diseñador' && Username == $('#Diseñador').html() || Roll == 'vendedor' && Username == $('#Vendedor').html() || Roll == 'super_diseño' || Roll == 'admin_evpiu'){
                        Swal.fire({
                            title: 'Enviar Comentarios',
                            html: '<label>Añade comentarios o informacion que pueda ser importante para este requerimiento</label>',
                            input: 'textarea',
                            icon: 'info',
                            inputAttributes: {
                                autocapitalize: 'on'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Guardar!',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: () => !Swal.isLoading(),
                            inputValidator: (value) => {
                                return !value && 'No puedes enviar un comentario vacio...'
                            }
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: '/MisRequerimientosAddComent',
                                    data: {
                                        idReq: id,
                                        coments: result.value,
                                        user: Username_id
                                    },
                                    success: function () {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado!',
                                            text: 'Tu comentario fue enviado con exito!',
                                            confirmButtonText: 'Aceptar',
                                        });
                                        table.draw();
                                    }
                                });
                            }else{
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }else {
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error',
                        )
                    }
                });

                $('body').on('click', '.showcoment', function () {
                    var id = $(this).attr('id');
                    $.ajax({
                        type: 'get',
                        url: '/RequerimientosComentariosDetalles',
                        data: {
                            id: id
                        },
                        success: function (data) {
                            var i = 0;
                            $('#InfoCliente').html(data.encabezado[0].cliente);
                            $('#InfoDescripcion').html(data.encabezado[0].producto);
                            $('#InfoInfo').html(data.encabezado[0].informacion);
                            $('#InfoMarca').html(data.encabezado[0].marca);
                            $('#InfoDate').html(data.encabezado[0].created_at);

                            $(data.Datos).each(function () {
                                if (i % 2 == 0)
                                {
                                    $('#DetallesComentariosReque').append('<div class="row no-gutters">' +
                                        '<div class="col-sm"></div>' +
                                        '<div class="col-sm-1 text-center flex-column d-none d-sm-flex">' +
                                        '<div class="row h-50">' +
                                        '<div class="col border-right">&nbsp;</div>' +
                                        '<div class="col">&nbsp;</div>' +
                                        '</div>' +
                                        '<h5 class="m-2">' +
                                        '<span class="badge badge-pill bg-primary-light" style="height: 25px; line-height: 25px; border-radius: 25px ; width: 25px;">&nbsp;</span>' +
                                        '</h5>' +
                                        '<div class="row h-50">' +
                                        '<div class="col border-right">&nbsp;</div>' +
                                        '<div class="col">&nbsp;</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '<div class="col-sm py-2">' +
                                        '<div class="card border-success shadow">' +
                                        '<div class="card-body">' +
                                        '<div class="float-right text-primary small">'+ data.Datos[i].created_at +'</div>' +
                                        '<h4 class="card-title text-primary">'+ data.Datos[i].name +'</h4>' +
                                        '<p class="card-text">'+ data.Datos[i].descripcion +'</p>' +
                                        '</div></div>' +
                                        '</div></div>'
                                    )
                                }
                                else{
                                    $('#DetallesComentariosReque').append('<div class="row no-gutters">' +
                                        '<div class="col-sm py-2">' +
                                        '<div class="card border-success shadow">' +
                                        '<div class="card-body">' +
                                        '<div class="float-right text-primary small">'+ data.Datos[i].created_at +'</div>' +
                                        '<h4 class="card-title text-primary">'+ data.Datos[i].name +'</h4>' +
                                        '<p class="card-text">'+ data.Datos[i].descripcion +'</p>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '<div class="col-sm-1 text-center flex-column d-none d-sm-flex">' +
                                        '<div class="row h-50">' +
                                        '<div class="col border-right">&nbsp;</div><' +
                                        'div class="col">&nbsp;</div>' +
                                        '</div>' +
                                        '<h5 class="m-2">' +
                                        '<span class="badge badge-pill bg-primary-light" style="height: 25px; line-height: 25px; border-radius: 25px ; width: 25px;">&nbsp;</span>' +
                                        '</h5>' +
                                        '<div class="row h-50">' +
                                        '<div class="col border-right">&nbsp;</div>' +
                                        '<div class="col">&nbsp;</div>' +
                                        '</div>' +
                                        '</div>' +
                                        '<div class="col-sm">' +
                                        '</div></div>'
                                    )
                                }
                                i++;
                            });

                            if(data.propuestas.length == 0){
                                $('#PropuestasDiv').append('<div class="alert alert-danger" role="alert">ESTE REQUERIMIENTO AUN NO TIENE PROPUESTAS...</div>');

                            }else{
                                var ii = 0;
                                $(data.propuestas).each(function () {
                                    ii++;
                                });
                            }
                            $('#timelinemodal').modal('show');
                        }
                    })
                });

                $('#timelinemodal').on('hide.bs.modal', function () {
                    $('#DetallesComentariosReque').html('');
                });

                $('body').on('click','.anularreq',function () {
                	if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'vendedor' && Username == $('#Vendedor').html()){
                        var id = $(this).attr('id');
                        Swal.fire({
                            title: '¿Esta seguro de anular el requerimiento?',
                            text: "¡Esta accion solo la puede revertir el supervisor o un administrador!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, anular!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: "/MisRequerimientosAnular",
                                    data: {
                                        id, Username, Username_id
                                    },
                                    success: function () {
                                        Obtenerdatos();
                                        Swal.fire({
                                            title: 'Anulado!',
                                            text: 'El requerimiento '+ id +' ha sido anulado.',
                                            icon: 'success',
                                        });
                                        table.draw();
                                    },
                                    error: function () {
                                        Swal.fire(
                                            'Error al anular!',
                                            'Hubo un error al anular.',
                                            'error'
                                        )
                                    }
                                });
                            }else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        });
                    }
                	else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                var Nombre_vendedor = '';

                function Obtenerdatos(){
                    Swal.fire({
                        icon: false,
                        title: 'Cargando informacion, un momento por favor...',
                        html: '<br><div class="container" style="align-items: center !important; margin-left: 150px; margin-right: 150px"><div class="preloader"></div></div>',
                        showConfirmButton: false,
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                	$.ajax({
                        url:'/RequerimientosComentariosDetalles',
                        type: 'get',
                        data: {
                        	id: id
                        },
                        success: function (data) {
                            $('#Fecha_solicitud').html(data.encabezado[0].created_at);
                            $('#Cliente').html(data.encabezado[0].cliente);
                            $('#Marca').html(data.encabezado[0].marca);
                            $('#Articulo').html(data.encabezado[0].producto);
                            $('#Estado').html(data.encabezado[0].estado);
                            $('#Vendedor').html(data.vendedor_id[0].name);

                            Nombre_vendedor = data.vendedor_id[0].name;
                            var diseñador = null;
                            if(data.diseñador_id == null){
                                diseñador = null;
                            }
                            else{
                                diseñador =data.diseñador_id[0].name
                            }
                            var estado = data.encabezado[0].estado;

                            if(data.encabezado[0].informacion == null){
                                $('#Detalles').append('<div class="alert alert-danger" role="alert">No se agrego ningun detalle para este requerimiento</div>');
                            }else{
                                $('#Detalles').append('<label> <label for="">'+data.encabezado[0].informacion+'</label><br>')
                            }

                            if(diseñador == null){
                                $('#Diseñador').removeClass('text-success');
                            	$('#Diseñador').html('SIN ASIGNAR').addClass('text-danger');
                            }else{
                                $('#Diseñador').removeClass('text-danger');
                                $('#Diseñador').html(diseñador).addClass('text-success');
                            }

                            if(estado == 0){
                                $('#Estado').removeClass('text-success');
                                $('#Estado').html('ANULADO VENDEDOR').addClass('text-danger');
                            }

                            if(estado == 1){
                                $('#Estado').removeClass('text-danger');
                                $('#Estado').html('RENDER').addClass('text-success');
                            }

                            if(estado == 2){
                                $('#Estado').removeClass('text-danger');
                                $('#Estado').html('PENDIENTE POR REVISAR').addClass('text-success');
                            }

                            if(estado == 3){
                                $('#Estado').removeClass('text-danger');
                                $('#Estado').html('ASIGNADO').addClass('text-success');
                            }

                            if(estado == 4){
                                $('#Estado').removeClass('text-danger');
                                $('#Estado').html('INICIADO').addClass('text-success');
                            }

                            if(estado == 5){
                                $('#Estado').removeClass('text-success');
                                $('#Estado').html('CERRADO').addClass('text-danger');
                            }

                            if(estado == 6){
                                $('#Estado').removeClass('text-success');
                                $('#Estado').html('ANULADO DISEÑO').addClass('text-danger');
                            }

                            if(estado == 7){
                                $('#Estado').removeClass('text-success');
                                $('#Estado').html('SIN APROBAR').addClass('text-danger');
                            }

                            $('#ArchivosDeSoporte').html('');
                            ObtenerArchivosRequerimiento();
                        }
                    })
                }

                Obtenerdatos();

                var table;

                function loadtable(){
                    table = $('.table').DataTable({
                        processing: false,
                        serverSide: false,
                        searching: false,
                        paginate: false,
                        bInfo: false,
                        ajax: {
                            url: '/ListaPropuestaReq',
                            data: {id: id}
                        },
                        columns: [
                            {data: 'id', name: 'id', orderable: false, searchable: false},
                            {data: 'descripcion', name: 'descripcion', orderable: false, searchable: false},
                            {data: 'relieve', name: 'relieve', orderable: false, searchable: false},
                            {data: 'estado', name: 'estado', orderable: false, searchable: false},
                            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
                        ],
                        columnDefs: [{
                        	className: "text-center",
                            targets: [ 5 ]
                        }],
                        language: {
                           url: '/Spanish.json'
                        },
                        rowCallback: function( row, data, index ) {
                            if (data.estado == 1) {
                                $(row).find('td:eq(3)').html('Propuesta Creada');
                            }
                            if (data.estado == 2) {
                                $(row).find('td:eq(3)').html('Enviado aprobacion');
                            }
                            if (data.estado == 3) {
                                $(row).find('td:eq(3)').html('Rechazado vendedor');
                            }
                            if (data.estado == 4) {
                                $(row).find('td:eq(3)').html('Aprobado vendedor');
                            }
                            if (data.estado == 5) {
                                $(row).find('td:eq(3)').html('En solicitud de planos');
                            }
                        }
                    });
                }

                $('.CambEstreq').on('click', function () {
                    var id = $(this).attr('id');
                    if(Roll == 'super_diseño' || Roll == 'admin_evpiu'){
                        swal.mixin({
                            icon: 'question',
                            text: 'Selecciona una opcion',
                            title: '¿Cambiar estado del requerimiento?',
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: true,
                            input: 'text',
                        }).queue([
                            {
                                html: '<label>Selecciona una opcion</label> <br> <select name="state" id="state" class="form-control">' +
                                    '<option value="" selected>Seleccione...</option>' +
                                    '<option value="2">Por revisar</option>' +
                                    '<option value="3">Asignado</option>' +
                                    '<option value="5">Finalizado</option>' +
                                    '<option value="6">Anulado diseño</option>' +
                                    '<option value="7">Sin aprobar</option>' +
                                    '</select>' +
                                    '<br>' +
                                    '<label style="text-align: left" >Justificacion:</label> <br>' +
                                    '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                                inputValidator: () => {
                                    if (document.getElementById('state').value == '') {
                                        return 'Debes seleccionar una opcion...';
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
                                        result, id, Username_id
                                    },
                                    success: function () {
                                        $('#Detalles').html('');
                                        Obtenerdatos();
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
                    }else {
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('.CambiarDiseñador').on('click', function () {
                    var id = $(this).attr('id');

                    if(Roll == 'super_diseño' || Roll == 'admin_evpiu'){
                        $.ajax({
                            url: '/ObtenerDiseñadores',
                            tyoe: 'get',
                            success: function (data) {
                                swal.fire({
                                    icon: 'question',
                                    title: 'Asignar o cambiar diseñador',
                                    text: 'Seleccione el diseñador al que se le sera asignado este requerimiento',
                                    input: 'select',
                                    confirmButtonText: 'Aceptar',
                                    cancelButtonText: 'Cancelar',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    buttonsStyling: true,
                                    showCancelButton: true,
                                    inputOptions: data,
                                    inputPlaceholder: 'Seleccione...',
                                    inputValidator: function (value) {
                                        if (value == '') {
                                            return 'Debes seleccionar una opcion...'
                                        }
                                    },
                                    preConfirm: function (value) {
                                        return value;
                                    },
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/CambiarDiseñadorRequeEd',
                                            type: 'post',
                                            data: {
                                                result, Username_id, id
                                            },
                                            success: function () {
                                                $('#Detalles').html('');
                                                Obtenerdatos();
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Guardardo',
                                                    text: 'Diseñador cambiado con exito!',
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
                            }
                        })
                    }else {
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('.AddPropuestaReq').on('click', function () {
                    if(Roll == 'diseñador' && Username == $('#Diseñador').html() || Roll == 'super_diseño' || Roll == 'admin_evpiu'){
                        swal.mixin({
                            icon: 'info',
                            text: 'Selecciona una opcion',
                            title: 'Crear una nueva propuesta',
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: true,
                            input: 'text',
                        }).queue([
                            {
                                html: '<form action="" id="FormTest"><label>Articulo:</label><br>' +
                                    '<input type="text" class="form-control" id="NewPropArticulo" placeholder="Escribe para buscar un articulo..."><br>' +
                                    '<input type="hidden" class="form-control" id="NewPropArticuloDesc">' +
                                    '<label>Relieve:</label><br>' +
                                    '<select name="NewPropRelieve" id="NewPropRelieve" class="form-control">' +
                                    '<option value="" selected>Seleccione...</option>' +
                                    '<option value="Alto">Alto</option>' +
                                    '<option value="Bajo">Bajo</option>' +
                                    '<option value="Alto/Bajo">Alto/Bajo</option>' +
                                    '<option value="Liso">Liso</option>' +
                                    '</select></form>',
                                inputValidator: () => {
                                    if (document.getElementById('NewPropArticulo').value == '') {
                                        return 'Todos los campos son obligatorios..';
                                    }
                                    if (document.getElementById('NewPropRelieve').value == '') {
                                        return 'Seleccione una opcion..';
                                    }
                                },
                                preConfirm: function () {
                                    var array = {
                                        'Articulo': document.getElementById("NewPropArticulo").value,
                                        'Cod_Art':  document.getElementById("NewPropArticuloDesc").value,
                                        'Relieve': document.getElementById("NewPropRelieve").value,
                                    };
                                    return array;
                                },
                                onBeforeOpen: function (dom) {
                                    swal.getInput().style.display = 'none';
                                }
                            },
                        ]).then((result) => {
                            if (result.value) {
                            	var medida = result.value[0].Articulo;
                                medida = medida.split(" ");
                            	medida = medida[4];

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    url: '/GuardarPropuestaReq',
                                    type: 'post',
                                    data: {
                                        result, id, Username_id, Nombre_vendedor, medida, New_reque_Producto
                                    },
                                    success: function () {
                                        $('.table').DataTable().destroy();
                                        loadtable();
                                        table.draw();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardardo',
                                            text: 'Propuesta guardada con exito!',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Aceptar',
                                        });
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
                        });
                    }else {
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                    $(document).find( "#NewPropArticulo" ).autocomplete({
                        appendTo: $(".swal2-popup"),
                        source: function (request, response) {
                            var Product = $("#NewPropArticulo").val();
                            $.ajax({
                                url: "/RequerimientosSearchProductsMax",
                                method: "get",
                                data: {
                                    query: Product,
                                },
                                dataType: "json",
                                success: function (data) {
                                    var resp = $.map(data, function (obj) {
                                        return obj
                                    });
                                    response(resp);
                                }
                            })
                        },
                        focus: function (event, ui) {
                            $('#NewPropArticuloDesc').val([ui.item.Cod_Art]);
                            New_reque_Producto = ui.item.id

                            return true;
                        },
                        select: function (event, ui) {
                            $('#NewPropArticuloDesc').val([ui.item.Cod_Art]);
                            New_reque_Producto = ui.item.id
                        },
                        minlength: 2
                    });
                });

                $('body').on('click','.Upload3DProp', function() {
                	if(Roll == 'admin_evpiu' || Roll == 'render' || Roll == 'super_diseño'){
                        var idProp = Prop;
                        Swal.fire({
                            title: '3D',
                            text: 'Por favor, seleccione un archivo 3D para esta propuesta',
                            icon: 'info',
                            confirmButtonText: 'Subir',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: true,
                            input: 'file',
                            inputAttributes: {
                                accept: 'image/*'
                            },
                            onBeforeOpen: () => {
                                $(".swal2-file").change(function () {
                                    var reader = new FileReader();
                                    reader.readAsDataURL(this.files[0]);
                                });
                            },
                            inputValidator: (value) => {
                                return !value && 'Debes seleccionar un archivo'
                            }
                        }).then((file) => {
                            if (file.value) {
                                var formData = new FormData();
                                var file = $('.swal2-file')[0].files[0];
                                formData.append("fileToUpload", file);
                                formData.append("Numero",id);
                                formData.append("Prop",idProp);
                                formData.append("Usuario",Username_id);
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    method: 'post',
                                    url: '/Upload3DReq',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (data) {
                                        $('#PDFdibujo3d').html('');
                                        $('#PDFdibujo3d').append('<img src="../../'+ data.url + data.archivo + '" style="height: 240px; width: 331px">');
                                        Swal.fire('Subidos', 'Archivo subido con exito!', 'success');
                                    },
                                    error: function() {
                                        Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                                    }
                                })
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }

                });

                $('body').on('click','.UploadPlanoProp', function() {
                    if(Roll == 'admin_evpiu' || Roll == 'plano' || Roll == 'super_diseño') {
                        var idProp = Prop;
                        Swal.fire({
                            icon: 'info',
                            title: 'Plano',
                            text: 'Por favor, seleccione un plano para esta propuestas',
                            confirmButtonText: 'Subir',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: true,
                            input: 'file',
                            inputAttributes: {
                                accept: 'image/*'
                            },
                            onBeforeOpen: () => {
                                $(".swal2-file").change(function () {
                                    var reader = new FileReader();
                                    reader.readAsDataURL(this.files[0]);
                                });
                            },
                            inputValidator: (value) => {
                                return !value && 'Debes seleccionar un archivo'
                            }
                        }).then((file) => {
                            if (file.value) {
                                var formData = new FormData();
                                var file = $('.swal2-file')[0].files[0];
                                formData.append("fileToUpload", file);
                                formData.append("Numero", id);
                                formData.append("Prop", idProp);
                                formData.append("Usuario", Username_id);
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    method: 'post',
                                    url: '/UploadPlanoReq',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (data) {
                                        $('#PDFplano').html('');

                                        if(data.archivo.substr(-3) == 'png'){
                                            $('#PDFplano').append('<img src="../../'+ data.url + data.archivo + '" style="height: 240px; width: 331px">')
                                        }
                                        else{
                                            $('#PDFplano').append('<a href="javascript:void(0)" id="'+data.archivo+'" class="VerPlanoPdfMod" ><i class="far fa-file-pdf fa-10x"></i><br><b><label for="">Clic para ver</label></b></a>');
                                        }
                                        Swal.fire('Subidos', 'Archivo subido con exito!', 'success');
                                    },
                                    error: function () {
                                        Swal.fire({type: 'error', title: 'Oops...', text: 'Something went wrong!'})
                                    }
                                })
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('body').on('click','.Upload2DProp', function () {
                	if(Roll == 'admin_evpiu' || Roll == 'diseñador' && Username == $('#Diseñador').html() || Roll == 'super_diseño'){
                        var idProp = Prop;
                        Swal.fire({
                            icon: 'info',
                            title: '2D',
                            text: 'Por favor, seleccione un archivo 2D para esta propuestas',
                            confirmButtonText: 'Subir',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: true,
                            input: 'file',
                            inputAttributes: {
                                accept: 'image/*'
                            },
                            onBeforeOpen: () => {
                                $(".swal2-file").change(function () {
                                    var reader = new FileReader();
                                    reader.readAsDataURL(this.files[0]);
                                });
                            },
                            inputValidator: (value) => {
                                return !value && 'Debes seleccionar un archivo'
                            }
                        }).then((file) => {
                            if (file.value) {
                                var formData = new FormData();
                                var file = $('.swal2-file')[0].files[0];
                                formData.append("fileToUpload", file);
                                formData.append("Numero",id);
                                formData.append("Prop", idProp);
                                formData.append("Usuario",Username_id);
                                $.ajax({
                                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    method: 'post',
                                    url: '/Upload2DReq',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (data) {
                                        $('#PDFdibujo2d').html('');
                                        $('#PDFdibujo2d').append('<img src="../../'+ data.url + data.archivo + '" style="height: 240px; width: 331px">');
                                        Swal.fire('Subido', 'Archivo subido con exito!', 'success');
                                    },
                                    error: function() {
                                        Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                                    }
                                })
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('body').on('click','.SubirArchiv', function () {
                    if(Roll == 'super_diseño' || Roll == 'admin_evpiu' || Roll == 'vendedor' && Username == $('#Vendedor').html()){
                        Swal.fire({
                            icon: 'info',
                            title: 'Soportes',
                            text: 'Por favor, seleccione los archivos de soporte para este requerimiento',
                            confirmButtonText: 'Subir',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: true,
                            input: 'file',
                            inputAttributes: {
                                multiple: 'multiple',
                                accept: 'image/*,application/pdf,application/msword'
                            },
                            onBeforeOpen: () => {
                                $(".swal2-file").change(function () {
                                    var reader = new FileReader();
                                });
                            },
                            inputValidator: (value) => {
                                return !value && 'Debes seleccionar al menos un archivo'
                            }
                        }).then((file) => {
                            if (file.value) {
                                var formData = new FormData();
                                var ins = $('.swal2-file')[0].files.length;
                                var file = $('.swal2-file')[0].files;

                                /*este for es necesario para la subida de archivos multiples*/
                                for (var x = 0; x < ins; x++) {
                                    formData.append("fileToUpload[]", file[x]);
                                }
                                formData.append("Numero", id);
                                formData.append("Usuario", Username_id);

                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    method: 'post',
                                    url: '/UploadfilesSupport',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function (resp) {
                                        $('#ArchivosDeSoporte').html('');
                                        ObtenerArchivosRequerimiento();
                                        Swal.fire('Subido', 'Archivo subido con exito!', 'success');
                                    },
                                    error: function () {
                                        Swal.fire({type: 'error', title: 'Oops...', text: 'Something went wrong!'})
                                    }
                                })
                            }
                        })
                    }else {
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                function ObtenerArchivosRequerimiento() {
                    $.ajax({
                        url: '/ImagesRequerimiento',
                        type: 'get',
                        data: {
                        	id: id
                        },
                        success: function (data) {
                        	var i = 0;
                        	if(data[i] == null){
                                $('#ArchivosDeSoporte').append('<div class="alert alert-danger text-center" role="alert">Aun no se ha añadido ningun archivo</div>');
                            }
                        	else if(Roll == 'admin_evpiu' || Roll == 'vendedor' && Username == $('#Vendedor').html() ) {
                                $(data).each(function () {
                                    $('#ArchivosDeSoporte').append('<div class="col-sm-4">'+
                                        '<a href="javascript:void(0)" id="'+data[i].archivo+'" class="ViewImgReq">'+data[i].archivo+'</a> '+'</div>');
                                    i++;
                                })
                            }
                        	else{
                                $(data).each(function () {
                                    $('#ArchivosDeSoporte').append('<div class="col-sm-4">'+
                                        '<a href="javascript:void(0)" id="'+data[i].archivo+'" class="ViewImgReq">'+data[i].archivo+'</a> ' +
                                        ' <a href="javascript:void(0)" id="'+data[i].archivo+'" class="DeleteImgReq">' +
                                        '<i class="fas fa-trash"></i></a>'+'</div>');
                                    i++;
                                })

                            }
                            sweetAlert.close();
                        }
                    })
                }

                $('body').on('click','.ViewImgReq',function () {
                	var file = $(this).attr('id');

                	if(file.substr(-3) == 'png' || file.substr(-3) == 'jpg' || file.substr(-3) == 'gif'){
                        Swal.fire({
                            imageUrl: '../../requerimientos/'+'RQ-'+id+'/soportes/'+file,
                            imageAlt: 'A tall image',
                            confirmButtonText: 'Cerrar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            buttonsStyling: true,
                            showCancelButton: false,
                        })
                    }else{
                        $('#ViewArtTitle').html('Ver PDF');
                        PDFObject.embed('../../requerimientos/'+'RQ-'+id+'/soportes/'+file, '#ViewArtPdf');
                        $('#ViewArtModal').modal('show');
                    }
                });

                var Prop;
                var Codigo_base_propuesta = null;
                var Descripcion_Producto = null;
                var Value_Marca = null;
                $('body').on('click','.VerPropuest', function () {
                    Prop = $(this).attr('id');
                	$.ajax({
                        url: '/DatosPropuestaPDF',
                        type: 'get',
                        data: {
                        	Req: id,
                            Prop: Prop
                        },
                        success: function (data) {
                            $('#PDFnumeroreq').html(id);
                            $('#PDFnumeroprop').html(Prop);
                            $('#PDFarticulo').html(data.propuesta[0].articulo);
                            $('#PDFrelieve').html(data.propuesta[0].relieve);
                            Codigo_base_propuesta =  data.propuesta[0].codigo_base;
                            Descripcion_Producto = data.propuesta[0].articulo;
                            Value_Marca = data.encabezado[0].marca;
                            Value_Marca = Value_Marca.substr(0,1);
                            $('#PDFmarca').html(data.encabezado[0].marca);
                            $('#PDFMedida').html(data.propuesta[0].medida);
                            $('#PDFvendedor').html(data.vendedor_id[0].name);
                            $('#PDFdiseñador').html(data.diseñador_id[0].name);
                            $('#PDFfecha').html(data.encabezado[0].created_at);
                            $('#PDFcaracteristicas').append('<br><label>'+ data.propuesta[0].caracteristicas+'</label>');
                            var i = 0;
                            $(data.archivos).each(function () {
                                if(data.archivos[i].tipo == '2D'){
                                    $('#PDFdibujo2d').append('<img src="../../'+ data.archivos[i].url + data.archivos[i].archivo + '" style="height: 240px; width: 331px">')
                                }
                                if(data.archivos[i].tipo == '3D'){
                                    $('#PDFdibujo3d').append('<img src="../../'+ data.archivos[i].url + data.archivos[i].archivo + '" style="height: 240px; width: 331px">')
                                }
                                if(data.archivos[i].tipo == 'plano' && data.archivos[i].archivo.substr(-3) == 'png'){
                                    $('#PDFplano').append('<img src="../../'+ data.archivos[i].url + data.archivos[i].archivo + '" style="height: 240px; width: 331px">')
                                }
                                if(data.archivos[i].tipo == 'plano' && data.archivos[i].archivo.substr(-3) == 'pdf') {
                                    $('#PDFplano').append('<a href="javascript:void(0)" id="'+data.archivos[i].archivo+'" class="VerPlanoPdfMod" ><i class="far fa-file-pdf fa-10x"></i><br><b><label for="">Clic para ver</label></b></a>');
                                }
                               i++;
                            })
                        }
                    });
                    $('#PdfView').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                });

                loadtable();

                function imprimirElemento(elemento) {
                    var ventana =  window.open('Print','','width=900');
                    ventana.document.write('<html><head><title>' + document.title + '</title>');
                    ventana.document.write('<link rel="stylesheet" href="http://evpiu.test/dashboard/styles/app.css">' +
                        ' <link rel="stylesheet" href="http://evpiu.test/dashboard/styles/main.css">');
                    ventana.document.write('</head><body >');
                    ventana.document.write(elemento.innerHTML);
                    ventana.document.write('</body></html>');
                    ventana.document.close();
                    ventana.focus();
                    ventana.onload = function() {
                        ventana.print();
                        ventana.close();
                    };
                    return true;
                }

                document.querySelector("#ImprimirPdf").addEventListener("click", function() {
                    var div = document.querySelector("#TextoImprimir");
                    imprimirElemento(div);
                });

                $('body').on('click','.DeleteImgReq', function () {
                    if(Roll == 'admin_evpiu' || Roll == 'vendedor' && Username == $('#Vendedor').html()) {
                        var file = $(this).attr('id');
                        Swal.fire({
                            title: '¿Eliminar archivo?',
                            html: '<label for="">Añade una justificacion para eliminar este archivo</label> ',
                            input: 'textarea',
                            icon: 'question',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Si, eliminar!',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: () => !Swal.isLoading(),
                            inputValidator: (value) => {
                                return !value && 'Debes escribir una justificacion para poder eliminar el archivo'
                            }
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: '/DeleteFileFromPropuesta',
                                    data: {
                                        idReq: id,
                                        file: file,
                                        coments: result.value,
                                        user: Username
                                    },
                                    success: function () {
                                        $('#ArchivosDeSoporte').html('');
                                        ObtenerArchivosRequerimiento();
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Eliminado!',
                                            text: 'El archivo fue eliminado con exito!',
                                            confirmButtonText: 'Aceptar',
                                        })
                                    }
                                });
                            } else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('.AprobarProp').on('click',function () {
                	if(Roll == 'admin_evpiu' || Roll == 'vendedor' && Username == $('#Vendedor').html()){
                        Swal.fire({
                            title: '¿Aprobar esta propuesta?',
                            text: "¡Revise toda la informacion antes de Continuar..!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, aprobar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: "/AprobarPropuesta",
                                    data: {
                                        id, Username_id, Prop
                                    },
                                    success: function (data) {
                                        $('.table').DataTable().destroy();
                                        loadtable();
                                        table.draw();
                                        Swal.fire({
                                            title: 'Aprobado!',
                                            text: 'La propuesta fue aprobada con exito!.',
                                            icon: 'success',
                                        });
                                        table.draw();
                                    },
                                    error: function (data) {
                                        Swal.fire(
                                            'Error al aprobar!',
                                            'Hubo un error al aprobar la propuesta.',
                                            'error'
                                        )
                                    }
                                });
                            }else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('.RechazarProp').on('click', function () {
                	if(Roll == 'admin_evpiu' || Roll == 'vendedor' && Username == $('#Vendedor').html()){
                        Swal.fire({
                            title: '¿Rechazar esta propuesta?',
                            text: "¡Revise toda la informacion antes de Continuar..!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, rechazar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: "/RechazarPropuesta",
                                    data: {
                                        id, Username, Prop
                                    },
                                    success: function (data) {
                                        $('.table').DataTable().destroy();
                                        loadtable();
                                        table.draw();
                                        Swal.fire({
                                            title: 'Rechazado!',
                                            text: 'La propuesta fue rechazada!.',
                                            icon: 'success',
                                        });
                                    },
                                    error: function (data) {
                                        Swal.fire(
                                            'Error!',
                                            'Hubo un error al rechazar la propuesta.',
                                            'error'
                                        )
                                    }
                                });
                            }else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('body').on('click','.VerPlanoPdfMod',function () {
                    $('#PdfView').modal('hide');
                    var file = $(this).attr('id');
                    $('#ViewArtTitle').html('Ver PDF');
                    PDFObject.embed('../../requerimientos/'+'RQ-'+id+'/propuestas/PP-'+Prop+'/Plano/'+file, '#ViewArtPdf');
                    $('#ViewArtModal').modal('show');
                });

                $('#PdfView').on('hide.bs.modal', function () {
                    $('#PDFnumeroreq').html('');
                    $('#PDFnumeroprop').html('');
                    $('#PDFarticulo').html('');
                    $('#PDFrelieve').html('');
                    $('#PDFmarca').html('');
                    $('#PDFvendedor').html('');
                    $('#PDFdiseñador').html('');
                    $('#PDFfecha').html('');
                    $('#PDFdibujo2d').html('');
                    $('#PDFdibujo3d').html('');
                    $('#PDFplano').html('');
                    $('#PDFcaracteristicas').html('');
                });

                $('.FinalizarReq').on('click', function () {
                    if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'vendedor' && Username == $('#Vendedor').html()){

                    	$.ajax({
                            type: "get",
                            url: "/ValidarEstadoPropuestasFR",
                            data: {
                            	id: id
                            },
                            success: function (data) {
                                if(data.cant_prop == 0){
                                    Swal.fire(
                                        '¡Error!',
                                        'No puedes finalizar un requerimiento que no tiene propuestas.',
                                        'error'
                                    )
                                }
                                else if(data.cant_prop_rec_apr != 0){
                                    Swal.fire(
                                        '¡Error!',
                                        'Para poder finalizar este requerimiento todas las propuestas deben estar Finalizadas o Rechazadas.',
                                        'error'
                                    )
                                }else{
                                    Swal.fire({
                                        title: '¿Finalizar este Requerimiento?',
                                        text: "¡Revise toda la informacion antes de Continuar..!",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si, finalizar!',
                                        cancelButtonText: 'Cancelar'
                                    }).then((result) => {
                                        if (result.value) {
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                type: "post",
                                                url: "/RechazarPropuesta",
                                                data: {
                                                    id, Username, Prop
                                                },
                                                success: function (data) {
                                                    Obtenerdatos();
                                                    Swal.fire({
                                                        title: 'Finalizado!',
                                                        text: 'El requerimiento fue finalizado!.',
                                                        icon: 'success',
                                                    });
                                                    table.draw();
                                                },
                                                error: function (data) {
                                                    Swal.fire(
                                                        'Error!',
                                                        'Hubo un error al rechazar la propuesta.',
                                                        'error'
                                                    )
                                                }
                                            });
                                        }else {
                                            result.dismiss === Swal.DismissReason.cancel
                                        }
                                    })
                                }
                            },
                            error: function () {
                                Swal.fire(
                                    '¡Error!',
                                    'Hubo un error, por favor ponte en contacto con un administrador.',
                                    'error'
                                )
                            }
                        });
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('.EnvRender').on('click', function () {
                    if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'diseñador' && Username == $('#Vendedor').html()){
                        $.ajax({
                            type: 'get',
                            url: '/ComprobarRender',
                            data: {
                                id: id
                            },
                            success: function (data) {
                                if(data[0].render == 1 && data[0].estado == 4){
                                    Swal.fire({
                                        title: '¿Enviar a renderizar?',
                                        text: "¡Este requerimiento sera enviado al area de renderizado..!",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si, enviar!',
                                        cancelButtonText: 'Cancelar'
                                    }).then((result) => {
                                        if (result.value) {
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                type: "post",
                                                url: "/EnviarRender",
                                                data: {id: id},
                                                success: function () {
                                                    Obtenerdatos();
                                                    Swal.fire({
                                                        title: 'Enviado!',
                                                        text: 'El requerimiento fue enviado a renderizar!.',
                                                        icon: 'success',
                                                    });
                                                    table.draw();
                                                },
                                                error: function (data) {
                                                    Swal.fire(
                                                        'Error!',
                                                        'Hubo un error al enviar.',
                                                        'error'
                                                    )
                                                }
                                            });
                                        }else {
                                            result.dismiss === Swal.DismissReason.cancel
                                        }
                                    })
                                }else if(data[0].render == 0 && data[0].estado == 4){
                                    Swal.fire({
                                        title: '¿Esta seguro de enviar a renderizar?',
                                        html: "El vendedor que creo este requerimiento no definio que debia llevar renderizado. <br>   ¿Esta seguro que desea continuar..?",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Estoy seguro, enviar!',
                                        cancelButtonText: 'Cancelar'
                                    }).then((result) => {
                                        if (result.value) {
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                type: "post",
                                                url: "/EnviarRender",
                                                data: {
                                                    id: id
                                                },
                                                success: function () {
                                                    Obtenerdatos();
                                                    Swal.fire({
                                                        title: 'Enviado!',
                                                        text: 'El requerimiento fue enviado a renderizar!.',
                                                        icon: 'success',
                                                    });
                                                    table.draw();
                                                },
                                                error: function (data) {
                                                    Swal.fire(
                                                        'Error!',
                                                        'Hubo un error al enviar.',
                                                        'error'
                                                    )
                                                }
                                            });
                                        }else {
                                            result.dismiss === Swal.DismissReason.cancel
                                        }
                                    })
                                }else{
                                    Swal.fire(
                                        'Error!',
                                        'No puedes enviar a renderizar un requerimiento si ya esta en estado "en render" o esta en un estado diferente a iniciado.',
                                        'error'
                                    )
                                }
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                var CodigoArte = null;

                $('.FinalizarProp').on('click',function () {
                    if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'diseñador' && Username == $('#Diseñador').html()){
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        ObtenerTodosLosArtes();
                        $.ajax({
                            type: 'get',
                            url: '/ComprobarEstadoPropuesta',
                            data: {Prop: Prop},
                            success: function (data) {
                                if(data[0].estado == 4){
                                    Swal.fire({
                                        title: '¿Esta seguro de finalizar esta propuesta?',
                                        html: "Se creará un nuevo arte y producto, esta acción es irreversible <br> ¿Esta seguro de continuar?",
                                        icon: 'question',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Estoy seguro',
                                        cancelButtonText: 'Cancelar'
                                    }).then((result) => {
                                        if (result.value) {
                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $.ajax({
                                                type: "post",
                                                url: "/FinalizaPropuesta",
                                                data: {
                                                    id, Prop, Username, CodigoArte
                                                },
                                                success: function () {
                                                    Swal.fire({
                                                        title: 'Enviado!',
                                                        text: 'La propuesta fue finalizada con exito!.',
                                                        icon: 'success',
                                                    });
                                                    table.draw();
                                                },
                                                error: function (data) {
                                                    Swal.fire(
                                                        'Error!',
                                                        'Hubo un error al enviar.',
                                                        'error'
                                                    )
                                                }
                                            });
                                        }else {
                                            result.dismiss === Swal.DismissReason.cancel
                                        }
                                    })
                                }else{
                                    Swal.fire(
                                        'Error!',
                                        'Solo puedes finalizar propuestas aprobadas por el vendedor.',
                                        'error'
                                    )
                                }
                            },
                            error: function () {
                                //
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('#PDFMedida').on('click', function () {
                    if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'diseñador' && Username == $('#Diseñador').html()) {
                        $.ajax({
                            url: '/ObtenerMediasPorCodigoBase',
                            tyoe: 'get',
                            data: {
                                Codigo_base_propuesta: Codigo_base_propuesta
                            },
                            success: function (data) {
                                swal.fire({
                                    icon: 'question',
                                    title: '¿Cambiar Medida?',
                                    text: 'Seleccione una medida',
                                    input: 'select',
                                    confirmButtonText: 'Aceptar',
                                    cancelButtonText: 'Cancelar',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    buttonsStyling: true,
                                    showCancelButton: true,
                                    inputOptions: data,
                                    inputPlaceholder: 'Seleccione...',
                                    inputValidator: function (value) {
                                        if (value == '') {
                                            return 'Debes seleccionar una opcion...'
                                        }
                                    },
                                    preConfirm: function (value) {
                                        return value;
                                    },
                                }).then((result) => {
                                    if (result.value) {
                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });
                                        $.ajax({
                                            url: '/CambiarMedidaPropuesta',
                                            type: 'post',
                                            data: {
                                                result, Prop, Descripcion_Producto
                                            },
                                            success: function (data) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Guardardo',
                                                    text: 'Medida cambiada con exito!',
                                                    confirmButtonColor: '#3085d6',
                                                    confirmButtonText: 'Aceptar',
                                                });
                                                $('#PDFMedida').html(data.medida);
                                                $('#PDFarticulo').html(data.producto);
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
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('.CrearMedida').click(function () {
                    $('#saveBtn').val("create-medida");
                    $('#medida_id').val('');
                    $('#medidaForm').trigger("reset");
                    $('#modelHeading').html("Nuevo");
                    $('#medidamodal').modal('show');
                    document.getElementById("cod").readOnly = true;
                    document.getElementById("mm2").readOnly = true;
                    document.getElementById("denominacion").readOnly = true;
                });

                $('#med_lineas_id').on('change', function () {
                    var lineas_id = $(this).val();
                    if ($.trim(lineas_id) != ''){
                    	$.ajax({
                            type: 'get',
                            url: '/getsublineas',
                            data: {
                                lineas_id: lineas_id
                            },
                            success: function (data) {
                                $('#med_sublineas_id').empty();
                                $('#med_sublineas_id').append("<option value=''>Seleccionar una sublinea</option>");
                                $.each(data, function (index, value) {
                                    $('#med_sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                                })
                            }
                        });
                    }
                });

                $('#med_sublineas_id').on('change', function () {
                    var sublineas_id = $(this).val();
                    $('#campos').html('');
                    if ($.trim(sublineas_id) != ''){

                        $.ajax({
                            type: 'get',
                            url: '/getCaractUnidadMedidas',
                            data: {
                                sublineas_id: sublineas_id
                            },
                            success: function (data) {
                                $('#campos').append("<div class='col-sm-6'> <div class='form-group'>" +
                                    "<label for='"+ data +"' class='col-sm-6 control-label'>"+ data +":</label>" +
                                    "<div class='col-sm-12'>" +
                                    "<input type='text' class='form-control "+ data +"' id='"+ data +"' name='"+ data +"' value='' onkeyup='this.value=this.value.toUpperCase();'>" +
                                    "</div></div></div>"
                                );

                            }
                        });

                        $.ajax({
                            type: 'get',
                            url: '/getUnidadMedidasMed',
                            data: {
                                Sub_id: sublineas_id
                            },
                            success: function (data) {
                                $('#UndMedida').empty();
                                $('#UndMedida').append("<option value=''>Seleccionar una Medida...</option>");
                                $.each(data, function (index, value) {
                                    $('#UndMedida').append("<option value='" + index + "'>"+ value +"</option>")

                                })
                            }
                        });
                    }
                });

                jQuery.extend(jQuery.validator.messages, {
                    required: "Este campo es obligatorio.",
                    remote: "Este codigo ya existe.",
                    email: "Por favor, escribe una dirección de correo válida",
                    url: "Por favor, escribe una URL válida.",
                    date: "Por favor, escribe una fecha válida.",
                    dateISO: "Por favor, escribe una fecha (ISO) válida.",
                    number: "Por favor, escribe un número entero válido.",
                    digits: "Por favor, escribe sólo dígitos.",
                    creditcard: "Por favor, escribe un número de tarjeta válido.",
                    equalTo: "Por favor, escribe el mismo valor de nuevo.",
                    accept: "Por favor, escribe un valor con una extensión aceptada.",
                    maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
                    minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
                    rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
                    range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
                    max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
                    min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
                    selectcheck: "Por favor seleccione una opcion!"
                });

                jQuery.validator.addMethod("selectcheck", function(value){
                    return (value != '');
                }, "Por favor, seleciona una opcion.");

                $("#medidaForm").validate({
                    ignore: "",
                    rules: {
                        med_lineas_id:{
                            selectcheck: true
                        },
                        med_sublineas_id:{
                            selectcheck: true
                        },
                        cod: {
                            remote: {
                                url: '/GetUniqueCodMed',
                                type: 'POST',
                                async: false,
                            },
                            minlength: 2,
                            maxlength: 2,
                            required: true
                        },
                        denominacion: "required",
                    },
                    highlight: function (element) {
                        // Only validation controls
                        $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                    },
                    unhighlight: function (element) {
                        // Only validation controls
                        $(element).closest('.form-control').removeClass('is-invalid');
                    },
                    submitHandler: function (form) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            data: $('#medidaForm').serialize(),
                            url: "/MedidasPost",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#medidaForm').trigger("reset");
                                $('#medidamodal').modal('hide');
                                table.draw();
                                toastr.success("Registro Guardado con Exito!");
                            },
                            error: function (data) {
                                $('#saveBtn').html('Guardar Cambios');
                            }
                        });
                    }
                });

                $('#medidamodal').on('show.bs.modal', function (event) {
                    $('#saveBtn').html('Guardar');
                    $('.form-control').removeClass('is-invalid');
                    $('.error').remove();
                    $('#campos').html('');

                });

                function calcular(){

                    var diametro = $('#Diametro').val();
                    var Umedida = $('#UndMedida').val();
                    var Altura = $('#Altura').val();
                    var Base = $('#Base').val();
                    var resultado = 0;
                    var sub;
                    var totalMayor;
                    var totalMenor;

                    if (diametro != null && Umedida == 'mm'){
                        resultado =  Math.floor(diametro * diametro);
                        sub = resultado.toString().substr(-2);
                        totalMayor = (resultado - sub) + 100;
                        totalMenor = resultado - sub;

                        if (resultado < 100){
                            $('#mm2').val(100);
                        }
                        if (resultado > 100 && sub < 50){
                            $('#mm2').val(totalMenor);
                        }
                        if (resultado > 100 && sub > 50){
                            $('#mm2').val(totalMayor);
                        }
                    }

                    if (diametro != null && Umedida == 'l'){
                        var suma2 = ((diametro * 0.64) * (diametro * 0.64)) * 2 ;
                        resultado = Math.floor(suma2);
                        sub = resultado.toString().substr(-2);
                        totalMayor = (resultado - sub) + 100;
                        totalMenor = resultado - sub;

                        if (resultado < 100){
                            $('#mm2').val(100);
                        }
                        if (resultado > 100 && sub < 50){
                            $('#mm2').val(totalMenor);
                        }
                        if (resultado > 100 && sub > 50){
                            $('#mm2').val(totalMayor);
                        }
                    }

                    if (diametro != null && Umedida == 'un'){
                        var suma3 = ((diametro * 25.40) * (diametro * 25.40)) * 2 ;
                        resultado = Math.floor(suma3);
                        sub = resultado.toString().substr(-2);
                        totalMayor = (resultado - sub) + 100;
                        totalMenor = resultado - sub;

                        if (resultado < 100){
                            $('#mm2').val(100);
                        }
                        if (resultado > 100 && sub < 50){
                            $('#mm2').val(totalMenor);
                        }
                        if (resultado > 100 && sub > 50){
                            $('#mm2').val(totalMayor);
                        }
                    }


                    if (Altura != null  && Base != null &&  diametro == null && Umedida == 'mm'){
                        resultado =  Math.floor(Base * Altura);
                        sub = resultado.toString().substr(-2);
                        totalMayor = (resultado - sub) + 100;
                        totalMenor = resultado - sub;

                        if (resultado < 100){
                            $('#mm2').val(100);
                        }
                        if (resultado > 100 && sub < 50){
                            $('#mm2').val(totalMenor);
                        }
                        if (resultado > 100 && sub > 50){
                            $('#mm2').val(totalMayor);
                        }
                    }

                    if (Altura != null  && Base != null &&  diametro == null && Umedida == 'l'){
                        var suma5 = ((Base * 0.64) * (Altura * 0.64)) * 2;
                        resultado = Math.floor(suma5);
                        sub = resultado.toString().substr(-2);
                        totalMayor = (resultado - sub) + 100;
                        totalMenor = resultado - sub;

                        if (resultado < 100){
                            $('#mm2').val(100);
                        }
                        if (resultado > 100 && sub < 50){
                            $('#mm2').val(totalMenor);
                        }
                        if (resultado > 100 && sub > 50){
                            $('#mm2').val(totalMayor);
                        }
                    }

                    if (Altura != null  && Base != null &&  diametro == null && Umedida == 'un'){
                        var suma6 = ((Base * 25.40) * (Altura * 25.40)) * 2;
                        resultado = Math.floor(suma6);
                        sub = resultado.toString().substr(-2);
                        totalMayor = (resultado - sub) + 100;
                        totalMenor = resultado - sub;

                        if (resultado < 100){
                            $('#mm2').val(100);
                        }
                        if (resultado > 100 && sub < 50){
                            $('#mm2').val(totalMenor);
                        }
                        if (resultado > 100 && sub > 50){
                            $('#mm2').val(totalMayor);
                        }
                    }
                }

                function denominacion(){
                    var Diametro = $('#Diametro').val();
                    var Perforacion = $('#Perforacion').val();
                    var Lado = $('#Lado').val();
                    var Espesor = $('#Espesor').val();

                    var Base = $('#Base').val();
                    var Altura = $('#Altura').val();
                    var Pestaña = $('#Pestaña').val();
                    var medida = $('#UndMedida').val();

                    var D = null;
                    var B = null;

                    /*DIAMETRO*/
                    if (Diametro != null && Base == null && Altura == null){
                        D = 'D:'+Diametro +medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO PERFORACION*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion != null){
                        D = 'D:'+Diametro+'P:'+Perforacion+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO PERFORACION LADO*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado != null){
                        D = 'D:'+Diametro+'P:'+Perforacion+'L:'+Lado+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO PERFORACION LADO ESPESOR*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado != null && Espesor != null){
                        D = 'D:'+Diametro+'P:'+Perforacion+'L:'+Lado+'E:'+Espesor+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO PERFORACION LADO ESPESOR PESTAÑA*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado != null && Espesor != null && Pestaña != null){
                        D = 'D:'+Diametro+'P:'+Perforacion+'L:'+Lado+'E:'+Espesor+'PS:'+Pestaña+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO LADO */
                    if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado != null && Espesor == null){
                        D = 'D:'+Diametro+'L:'+Lado+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO LADO ESPESOR*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado != null && Espesor != null){
                        D = 'D:'+Diametro+'L:'+Lado+'E:'+Espesor+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO LADO ESPESOR PESTAÑA*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado != null && Espesor != null && Pestaña != null){
                        D = 'D:'+Diametro+'L:'+Lado+'E:'+Espesor+'PS:'+Pestaña+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO ESPESOR*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado == null && Espesor != null){
                        D = 'D:'+Diametro+'E:'+Espesor+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO ESPESOR PESTAÑA*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado == null && Espesor != null && Pestaña != null){
                        D = 'D:'+Diametro+'E:'+Espesor+'PS:'+Pestaña+medida;
                    }

                    /*DIAMETRO PESTAÑA*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion == null && Lado == null && Espesor == null && Pestaña != null){
                        D = 'D:'+Diametro+'PS:'+Pestaña+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO PERFORACION ESPESOR*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado == null && Espesor != null && Pestaña == null){
                        D = 'D:'+Diametro+'P:'+Perforacion+'PS:'+Espesor+medida;
                        $('#denominacion').val(D);
                    }

                    /*DIAMETRO PERFORACION ESPESOR  PESTAÑA*/
                    if (Diametro != null && Base == null && Altura == null && Perforacion != null && Lado == null && Espesor != null && Pestaña != null){
                        D = 'D:'+Diametro+'P:'+Perforacion+'E:'+Espesor+'PS:'+Pestaña+medida;
                        $('#denominacion').val(D);
                    }

                    if (Diametro == null && Base != null && Altura != null){
                        B = 'B:'+Base+'A:'+Altura+medida;
                        $('#denominacion').val(B);
                    }

                    if (Diametro == null && Base != null && Altura != null && Espesor != null){
                        B = 'B:'+Base+'A:'+Altura+'E:'+Espesor+medida;
                        $('#denominacion').val(B);
                    }

                    if (Diametro == null && Base != null && Altura != null && Espesor != null && Pestaña != null){
                        B = 'B:'+Base+'A:'+Altura+'E:'+Espesor+'PS:'+Pestaña+medida;
                        $('#denominacion').val(B);
                    }

                    if (Diametro == null && Base != null && Altura != null && Espesor == null && Pestaña != null){
                        B = 'B:'+Base+'A:'+Altura+'PS:'+Pestaña+medida;
                        $('#denominacion').val(B);
                    }
                }

                $('body').on("keyup",'.Base', function(){
                    calcular();
                    denominacion();
                });

                $('body').on("keyup",'.Altura', function(){
                    calcular();
                    denominacion();
                });

                $('body').on("keyup",'.Diametro', function(){
                    calcular();
                    denominacion();
                });

                $('body').on("keyup",'.Perforacion', function(){
                    denominacion();
                });

                $('body').on("keyup",'.Pestaña', function(){
                    denominacion();
                });

                $('body').on("change",'.UndMedida', function(){
                    ObtenerCodid();
                    denominacion();
                    calcular();
                });

                var datos;

                function ObtenerDatos(){
                    jQuery.ajax({
                        url: "/sublineasUltimoId",
                        type: "get",
                        dataType: 'json',
                        success: function (data) {
                            datos = [data][0];
                            OriginalValue();
                        },
                    });
                }

                var codID;

                function ObtenerCodid(){
                    jQuery.ajax({
                        url: "/UltimoCodId",
                        type: "get",
                        dataType: 'json',
                        success: function (data) {
                            codID = [data][0];
                            ObtenerDatos();
                        },
                    });
                }

                function OriginalValue(){
                    var incremental     = 0;
                    var charStringRange = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    var vectorc         = [];
                    var t1              = 0;
                    var numerof         = 0;
                    var OriginalProductCodes =  datos;
                    var OriginalProductCodes2 = codID;

                    for (var f = 0; f < OriginalProductCodes.length; f++) {

                        if (OriginalProductCodes2  == OriginalProductCodes[f] && OriginalProductCodes[f]){
                            var cadena = OriginalProductCodes[f];

                            var text2  = cadena.split('').reverse().join('');
                            text2      = text2.split('');

                            for (var v2 = 0; v2 < 2; v2++) {
                                for (var i = 0; i < 36; i++) {
                                    if (text2[v2] == charStringRange[i]) {
                                        break;
                                    }
                                }
                                numerof += i*Math.pow(36,v2);
                            }
                            vectorc[t1] = numerof;
                            t1++;
                            numerof = 0;
                        }
                    }

                    maxvector = Math.max.apply(Math,vectorc); //saca el valor maximo de un arreglo
                    if (maxvector >= 0) {
                        incremental = maxvector + 1;
                    }
                    var text = '';
                    var incretemp = incremental;
                    for (var i = 0; i < 2; i++){
                        incretemp = Math.floor(incretemp)/36;
                        text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp))*36));
                    }
                    text = text.split('').reverse().join('');
                    $('#cod').val(text);
                }

                $('#Opciones_reque').dropdown();

                $('.EnviarParaAprobacion').on('click', function () {
                    if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'diseñador' && Username == $('#Diseñador').html()){
                        var id = $(this).attr('id');
                        Swal.fire({
                            title: '¿Enviar a aprobar?',
                            text: "¡Esta propuesta sera enviada al vendedor para su aprobacion!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, enviar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: 'post',
                                    url: '/EnviarAprobarPropuesta',
                                    data:{ Prop, Nombre_vendedor, Username, Url, id},
                                    success: function (data) {
                                        $('.table').DataTable().destroy();
                                        loadtable();
                                        table.draw();
                                        Swal.fire({
                                            title: 'Completado!',
                                            text: 'Propuesta enviada con exito.',
                                            icon: 'success',
                                        });
                                    },
                                    error: function () {
                                        Swal.fire(
                                            'Error al aprobar!',
                                            'Hubo un error al aprobar.',
                                            'error'
                                        )
                                    }
                                });
                            }else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        });
                    }
                    else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                var All_Artes;
                var Ultimo;

                function ObtenerTodosLosArtes(){
                    jQuery.ajax({
                        url: "/ObtenerArtes",
                        type: "get",
                        dataType: 'json',
                        data: {Value_Marca: Value_Marca},
                        success: function (data) {
                            All_Artes = [data][0];
                            Ultimo = All_Artes[All_Artes.length -1]
                            GenerarConsecutivo();
                        },
                    });
                }

                function GenerarConsecutivo(){
                    var incremental             = 0;
                    var charStringRange         = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                    var vectorc                 = [];
                    var t1                      = 0;
                    var numerof                 = 0;
                    var OriginalProductCodes    = All_Artes;
                    var OriginalProductCodes2   = Ultimo;


                    for (var f = 0; f < OriginalProductCodes.length; f++) {
                        if (OriginalProductCodes2  == OriginalProductCodes[f] && OriginalProductCodes[f]){
                            var cadena = OriginalProductCodes[f];
                            var text2  = cadena.split('').reverse().join('');
                            text2      = text2.split('');

                            for (var v2 = 0; v2 < 5; v2++) {
                                for (var i = 0; i < 36; i++) {
                                    if (text2[v2] == charStringRange[i]) {
                                        break;
                                    }
                                }
                                numerof += i*Math.pow(36,v2);
                            }
                            vectorc[t1] = numerof;
                            t1++;
                            numerof = 0;
                        }
                    }

                    maxvector = Math.max.apply(Math,vectorc); //saca el valor maximo de un arreglo
                    if (maxvector >= 0) {
                        incremental = maxvector + 1;
                    }
                    var text = '';
                    var incretemp = incremental;
                    for (var i = 0; i < 5; i++){
                        incretemp = Math.floor(incretemp)/36;
                        text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp))*36));
                    }
                    text = text.split('').reverse().join('');
                    CodigoArte = Value_Marca+text;
                }

                $('body').on('click','.Add_Caracteristicas', function () {
                    if(Roll == 'admin_evpiu' || Roll == 'super_diseño' || Roll == 'diseñador' && Username == $('#Diseñador').html()) {
                        Swal.fire({
                            title: 'Caracteristicas',
                            html: '<label>Escribe informacion inportante para esta propuesta, la informacion, si habia informacion guardada sera reemplazada por la informacion que ingreses a continuacion</label>',
                            input: 'textarea',
                            icon: 'info',
                            inputAttributes: {
                                autocapitalize: 'off'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Guardar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            showLoaderOnConfirm: true,
                            allowOutsideClick: () => !Swal.isLoading(),
                            inputValidator: (value) => {
                                return !value && 'Por favor, escribe algo antes de guardar...'
                            }
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: '/AgregarCaracteristicaPropuesta',
                                    data: {
                                        prop: Prop,
                                        coments: result.value,
                                    },
                                    success: function (data) {
                                        $('#PDFcaracteristicas').html('');
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Guardado!',
                                            text: 'las caracteristicas fueron guardadas con exito!',
                                            confirmButtonText: 'Aceptar',
                                        });
                                        $('#PDFcaracteristicas').append('<br><label>' + data + '</label>')
                                    }
                                });
                            } else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });

                $('#PdfView').on('shown.bs.modal', function() {
                    $(document).off('focusin.modal');
                });

                $('.EnvDiseño').on('click',function () {
                    if(Roll == 'admin_evpiu' || Roll == 'render') {
                        Swal.fire({
                            title: '¿Enviar a diseño?',
                            text: "¡Recuerda enviar a diseño solo cuando hayas terminado el render de todas las propuestas..!",
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Enviar!',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.value) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                $.ajax({
                                    type: "post",
                                    url: "/EnviaraDiseño",
                                    data: {
                                        id, Username_id
                                    },
                                    success: function (data) {
                                        Obtenerdatos();
                                        Swal.fire({
                                            title: 'Finalizado!',
                                            text: 'El requerimiento fue finalizado!.',
                                            icon: 'success',
                                        });
                                        table.draw();
                                    },
                                    error: function (data) {
                                        Swal.fire(
                                            'Error!',
                                            'Hubo un error al rechazar la propuesta.',
                                            'error'
                                        )
                                    }
                                });
                            } else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }else{
                        Swal.fire(
                            '¡Error!',
                            'No tienes permisos suficientes para realizar esta accion.',
                            'error'
                        )
                    }
                });


            });
        </script>
    @endpush
@stop
