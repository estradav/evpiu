@extends('layouts.dashboard')

@section('page_title', 'Requerimientos')

@section('module_title', 'Requerimiento #'.$var )

{{--@section('subtitle', 'Modulo de administracion de requerimientos.')--}}
{{--
@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@stop--}}

@section('content')
    @can('requerimientos.view')
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        INFORMACION GENERAL
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <label><b>REQUERIMIENTO #:</b></label>
                                <label>{{ $var }}</label>
                            </div>
                            <div class="col-3">
                                <label><b>FECHA DE SOLICITUD:</b></label>
                                <label id="Fecha_solicitud"></label>
                            </div>
                            <div class="col-3">
                                <label><b>ESTADO:</b></label>
                                <label id="Estado" class="text-primary"></label>
                            </div>
                            <div class="col-3">
                                <label><b>VENDEDOR:</b></label>
                                <label id="Vendedor"></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-3">
                                <label><b>CLIENTE:</b></label>
                                <label id="Cliente"></label>
                            </div>
                            <div class="col-3">
                                <label><b>DISEÑADOR:</b></label>
                                <label id="Diseñador" class="text-danger"></label>
                            </div>
                            <div class="col-3">
                                <label><b>MARCA:</b></label>
                                <label id="Marca"></label>
                            </div>
                            <div class="col-3">
                                <label><b>ARTICULO:</b></label>
                                <label id="Articulo"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        DETALLE REQUERIMIENTO
                    </div>
                    <div class="card-body">
                        <label id="Detalles"></label>
                        <br>
                        <br>
                        <div class="text-center">
                            <button class="btn btn-light newcoment" id="{{ $var }}">ENVIAR UN COMENTARIO</button>
                            <button class="btn btn-light showcoment" id="{{ $var }}">VER COMENTARIOS</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        OPCIONES
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="text-center col-12">
                                <button class="btn btn-light anularreq" id="{{ $var }}">ANULAR REQUERIMIENTO</button>
                                <button class="btn btn-light CambEstreq" id="{{ $var }}">CAMBIAR ESTADO</button>
                                <button class="btn btn-light CambiarDiseñador" id="{{ $var }}">CAMBIAR DISEÑADOR</button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="text-center col-12">
                                <button class="btn btn-light SubirArchiv">SUBIR ARCHIVOS</button>
                                <button class="btn btn-light ">ASIGNAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
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
                                            <th scope="col" class="text-center"><button class="btn btn-success btn-sm AddPropuestaReq"><i class="far fa-plus-square"></i></button></th>
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

        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" id="timelinemodal" name="timelinemodal" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="text-align: right !important; margin-top: 10px; margin-right: 12px">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <b>COMENTARIOS </b>
                            </div>
                            <div class="card-body">
                                <div class="container py-2" id="DetallesComentariosReque">

                                </div>
                            </div>
                            <div class="card-footer text-muted">
                                Comentarios generales
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar requerimientos.
        </div>
    @endcan

    @push('javascript')
        <script>
            $(document).ready(function () {
                var id = @json( $var );
                var Username = @json( Auth::user()->username );

                $('body').on('click','.newcoment',function () {
                    var id = $(this).attr('id');
                    Swal.fire({
                        title: 'Enviar Comentarios',
                        html: '<label for="">Añade comentarios o informacion que pueda ser importante para este requerimiento</label> ',
                        input: 'textarea',
                        icon: 'info',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Guardar!',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        showLoaderOnConfirm: true,
                        allowOutsideClick: () => !Swal.isLoading()
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
                                    user: Username
                                },
                                success: function () {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Guardado!',
                                        text: 'Tu comentario fue enviado con exito!',
                                        confirmButtonText: 'Aceptar',
                                    })
                                }
                            });
                        } else {
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
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
                                        '<h4 class="card-title text-primary">'+ data.Datos[i].usuario +'</h4>' +
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
                                        '<h4 class="card-title text-primary">'+ data.Datos[i].usuario +'</h4>' +
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

                            var tes = 1;

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
                    var id = $(this).attr('id');
                    Swal.fire({
                        title: '¿Esta seguro de querer anular el requerimiento?',
                        text: "¡Esta accion no se puede revertir!",
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
                                     id, Username
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: 'Anulado!',
                                        text: 'El requerimiento '+ id +' ha sido anulado.',
                                        icon: 'success',
                                    });
                                    table.draw();
                                },
                                error: function (data) {
                                    Swal.fire(
                                        'Error al anular!',
                                        'Hubo un error al anular.',
                                        'error'
                                    )
                                }
                            });
                        }else {
                            /* Read more about handling dismissals below */
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });

                function Obtenerdatos(){
                	$.ajax({
                        url:'/RequerimientosComentariosDetalles',
                        type: 'get',
                        data: {
                        	id: id
                        },
                        success: function (data) {
                            $('#Fecha_solicitud').html(data.encabezado[0].updated_at);
                            $('#Cliente').html(data.encabezado[0].cliente);
                            $('#Marca').html(data.encabezado[0].marca);
                            $('#Articulo').html(data.encabezado[0].producto);
                            $('#Detalles').html(data.encabezado[0].informacion);

                            var diseñador = data.encabezado[0].diseñador_id;
                            if(diseñador == null){
                            	$('#Diseñador').html('SIN ASIGNAR').addClass('text-danger');
                            }else{
                                $('#Diseñador').html(diseñador);
                            }
                        }
                    })
                }
                Obtenerdatos();

                var table = $('.table').DataTable({
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
                        {data: 'articulo', name: 'articulo', orderable: false, searchable: false},
                        {data: 'relieve', name: 'relieve', orderable: false, searchable: false},
                        {data: 'estado', name: 'estado', orderable: false, searchable: false},
                        {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false},

                    ],
                    language: {
                        // traduccion de datatables
                        processing: "Procesando...",
                        search: "Buscar&nbsp;:",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                        infoFiltered: "(filtrado de un total de _MAX_ registros)",
                        infoPostFix: "",
                        loadingRecords: "Cargando...",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "No se encontraron propuestas",
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

                $('.CambEstreq').on('click', function () {
                    var id = $(this).attr('id');
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
                            html:'<label>Selecciona una opcion</label> <br> <select name="state" id="state" class="form-control">' +
                              '<option value="" selected>Seleccione...</option>' +
                              '<option value="1">Solicitar plano</option>' +
                              '<option value="1">Por revisar</option>' +
                              '<option value="5">Cerrar</option>' +
                              '</select>' +
                              '<br>' +
                              '<label style="text-align: left" >Justificacion:</label> <br>' +
                              '<textarea name="justify" id="justify" cols="30" rows="5" class="form-control"></textarea>',
                            inputValidator: () => {
                                if(document.getElementById('state').value == ''){
                                    return  'Debes seleccionar una opcion...';
                                }
                            	if(document.getElementById('justify').value == ''){
                            		return 'Debes escribir una justificacion...';
                                }

                            },
                            preConfirm: function () {
                                var array = {
                                    'state' : document.getElementById("state").value,
                                    'justify' : document.getElementById("justify").value,
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
                                    result, id, Username
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
                        }else{
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    })
                });

                $('.CambiarDiseñador').on('click', function () {
                    var id = $(this).attr('id');
                	$.ajax({
                        url: '/ObtenerDiseñadores',
                        tyoe: 'get',
                        success: function (data) {
                            swal.fire({
                                icon: 'question',
                                title: '¿Cambiar diseñador?',
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
                                            result, Username, id
                                        },
                                        success: function () {
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

                                }else{
                                    result.dismiss === Swal.DismissReason.cancel
                                }
                            })
                        }
                    })
                });

                $('.AddPropuestaReq').on('click', function () {
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
                            html:'<form action="" id="FormTest"><label>Articulo:</label><br>' +
                              '<input type="text" class="form-control" id="NewPropArticulo" placeholder="Escribe para buscar un articulo..."><br>' +
                              '<label>Relieve:</label><br>' +
                              '<select name="NewPropRelieve" id="NewPropRelieve" class="form-control">' +
                              '<option value="" selected>Seleccione...</option>' +
                              '<option value="Alto">Alto</option>' +
                              '<option value="Bajo">Bajo</option>' +
                              '<option value="AltoBajo">Alto y bajo</option>' +
                              '<option value="Liso">Liso</option>' +
                              '</select></form>',
                            inputValidator: () => {
                                if(document.getElementById('NewPropArticulo').value == ''){
                                    return  'Todos los campos son obligatorios..';
                                }
                                if(document.getElementById('NewPropRelieve').value == ''){
                                    return 'Seleccione una opcion..';
                                }
                            },
                            preConfirm: function () {
                                var array = {
                                    'Articulo' : document.getElementById("NewPropArticulo").value,
                                    'Relieve' : document.getElementById("NewPropRelieve").value,
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
                                url: '/GuardarPropuestaReq',
                                type: 'post',
                                data: {
                                    result, id, Username
                                },
                                success: function () {
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
                        }else{
                            result.dismiss === Swal.DismissReason.cancel
                        }
                    });
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
                                    console.log(data);
                                    response(resp);
                                }
                            })
                        },
                        minlength: 2
                    });

                });

                $('body').on('click','.Crear3D', function() {
                    var idProp = $(this).attr('id');
                    Swal.fire({
                        title: '3D',
                        text: 'Por favor, seleccione un archivo 3D para esta propuesta',
                        imageUrl: '../../requerimientos/'+'RQ-'+id+'/Propuestas/'+'/PP-'+idProp+'/3D/'+idProp+'.png',
                        imageAlt: '3D',
                        imageHeight: 100,
                        imageWidth: 100,
                        confirmButtonText: 'Subir',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        buttonsStyling: true,
                        showCancelButton: true,
                        input: 'file',
                        onBeforeOpen: () => {
                            $(".swal2-file").change(function () {
                                var reader = new FileReader();
                                reader.readAsDataURL(this.files[0]);
                            });
                        }
                    }).then((file) => {
                        if (file.value) {
                            var formData = new FormData();
                            var file = $('.swal2-file')[0].files[0];
                            formData.append("fileToUpload", file);
                            formData.append("Numero",id);
                            formData.append("Prop",idProp);
                            console.log(formData);
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                method: 'post',
                                url: '/Upload3DReq',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (resp) {
                                    Swal.fire('Subidos', 'Archivo subido con exito!', 'success');
                                },
                                error: function() {
                                    Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                                }
                            })
                        }
                    })
                });

                $('body').on('click','.CrearPlano', function() {
                    var idProp = $(this).attr('id');
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
                        onBeforeOpen: () => {
                            $(".swal2-file").change(function () {
                                var reader = new FileReader();
                                reader.readAsDataURL(this.files[0]);
                            });
                        }
                    }).then((file) => {
                        if (file.value) {
                            var formData = new FormData();
                            var file = $('.swal2-file')[0].files[0];
                            formData.append("fileToUpload", file);
                            formData.append("Numero",id);
                            formData.append("Prop",idProp);
                            console.log(formData);
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                method: 'post',
                                url: '/UploadPlanoReq',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (resp) {
                                    Swal.fire('Subidos', 'Archivo subido con exito!', 'success');
                                },
                                error: function() {
                                    Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                                }
                            })
                        }
                    })
                });

                $('body').on('click','.Crear2D', function () {
                    var idProp = $(this).attr('id');
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
                        onBeforeOpen: () => {
                            $(".swal2-file").change(function () {
                                var reader = new FileReader();
                                reader.readAsDataURL(this.files[0]);
                            });
                        }
                    }).then((file) => {
                        if (file.value) {
                            var formData = new FormData();
                            var file = $('.swal2-file')[0].files[0];
                            formData.append("fileToUpload", file);
                            formData.append("Numero",id);
                            formData.append("Prop", idProp);
                            console.log(formData);
                            $.ajax({
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                method: 'post',
                                url: '/Upload2DReq',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function (resp) {
                                    Swal.fire('Subido', 'Archivo subido con exito!', 'success');
                                },
                                error: function() {
                                    Swal.fire({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                                }
                            })
                        }
                    })
                })



            });
        </script>
        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://adminlte.io/themes/dev/AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    @endpush
@stop
