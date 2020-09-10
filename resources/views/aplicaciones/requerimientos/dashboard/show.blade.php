@extends('layouts.architectui')

@section('page_title', 'Requerimiento ')

@section('content')
    @can('aplicaciones.requerimientos.ventas.show')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-paint icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Requerimiento {{ $data->id }}
                        <div class="page-title-subheading">
                            Gestion de requerimiento
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="id_req" name="id_req" value="{{ $data->id }}">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card igualar_div">
                    <div class="card-header">
                        INFORMACION GENERAL
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <b>DISEÑADOR(A):</b>
                                {!! \App\User::find($data->diseñador_id)->name ?? '<span class="badge badge-danger">SIN ASIGNAR</span>' !!}
                            </div>
                            <div class="col-6">
                                <b>ESTADO:</b>
                                @if ( $data->estado == 0 )
                                    <span class="badge badge-danger">Anulado</span>
                                @elseif( $data->estado == 1 )
                                    <span class="badge badge-primary">Pendiente revision</span>
                                @elseif( $data->estado == 2 )
                                    <span class="badge badge-info">Asignado</span>
                                @elseif( $data->estado == 3 )
                                    <span class="badge badge-success">Iniciado</span>
                                @elseif( $data->estado == 4 )
                                    <span class="badge badge-success">Finalizado</span>
                                @elseif( $data->estado == 5 )
                                    <span class="badge badge-danger">Anulado diseño</span>
                                @elseif( $data->estado == 6 )
                                    <span class="badge badge-warning">Rechazado</span>
                                @endif
                            </div>
                            <div class="col-6">
                                <b>VENDEDOR(A):</b>
                                {{ \App\User::find($data->vendedor_id)->name }}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <b>CLIENTE:</b>
                                {{ $data->cliente }}
                            </div>
                            <div class="col-6">
                                <b>MARCA:</b>
                                {{ \App\Marca::find($data->marca_id)->name }}
                            </div>
                            <div class="col-6">
                                <b>ARTICULO:</b>
                                {{ \App\CodCodigo::find($data->producto_id)->descripcion }}
                            </div>
                            <div class="col-6">
                                <b>FECHA DE SOLICITUD:</b>
                                {{  \Carbon\Carbon::createFromTimeString($data->created_at)->format('Y-m-d g:i A') }}
                            </div>
                        </div>
                        <hr>
                        <div class="row justify-content-center">
                            <div class="col-12">
                                <b>DETALLE REQUERIMIENTO</b>
                            </div>
                            <div class="col-12">
                                {{ $data->informacion }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 ">
                <div class="main-card mb-3 card igualar_div">
                    <div class="card-body" style="overflow-y: scroll; height: 300px !important;">
                        <div class="container py-2">
                            @foreach ( $transacciones as $trans )
                                @if( $trans->usuario_id == \Illuminate\Support\Facades\Auth::user()->id)
                                    <div class="row no-gutters">
                                        <div class="col-sm"></div>
                                        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                                            <div class="row h-50">
                                                <div class="col border-right">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div>
                                            <h5 class="m-2">
                                                <span class="badge badge-pill badge-primary" style="height: 20px; line-height: 20px; border-radius: 20px ; width: 20px;">&nbsp;</span>
                                            </h5>
                                            <div class="row h-50">
                                                <div class="col border-right">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div class="col-sm py-2">
                                            <div class="card border-success shadow">
                                                <div class="card-body">
                                                    <div class="float-right text-primary small">{{ \Carbon\Carbon::createFromTimeString($trans->created_at)->format('Y-m-d g:i A') }}</div>
                                                    <h5 class="card-title text-primary">{{ \App\User::find($trans->usuario_id)->name }}</h5>
                                                    <p class="card-text">{{ $trans->descripcion }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row no-gutters">
                                        <div class="col-sm py-2">
                                            <div class="card border-success shadow">
                                                <div class="card-body">
                                                    <div class="float-right text-primary small">{{ \Carbon\Carbon::createFromTimeString($trans->created_at)->format('Y-m-d g:i A') }}</div>
                                                    <h5 class="card-title text-primary">{{ \App\User::find($trans->usuario_id)->name }}</h5>
                                                    <p class="card-text">{{ $trans->descripcion }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                                            <div class="row h-50">
                                                <div class="col border-right">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div>
                                            <h5 class="m-2">
                                                <span class="badge badge-pill badge-primary" style="height: 20px; line-height: 20px; border-radius: 20px ; width: 20px;">&nbsp;</span>
                                            </h5>
                                            <div class="row h-50">
                                                <div class="col border-right">&nbsp;</div>
                                                <div class="col">&nbsp;</div>
                                            </div>
                                        </div>
                                        <div class="col-sm"></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card igualar_div">
                    <div class="card-header">
                        ARCHIVOS DE SOPORTE
                    </div>
                    <div class="card-body">
                        @if( sizeof($archivos) == 0 )
                            <div class="alert alert-danger text-center uk-height" role="alert">
                                <div class="mt-3 mb-3">
                                    <i class="pe-7s-attention pe-5x"></i><br>
                                    <label>NO SE HA AGREGADO NINGUN ARCHIVO.</label>
                                </div>
                            </div>
                        @else
                            <div class="table-responsive-md" style="overflow-y: scroll">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                    @foreach ( $archivos as $arch )
                                        <tr>
                                            <td>{{ $arch->archivo }}</td>
                                            <td>
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-light ver_archivo" id="{{ $arch->archivo }}"><i class="fas fa-eye"></i></button>
                                                    @can('aplicaciones.requerimientos.vendedor')
                                                        <button type="button" class="btn btn-light eliminar_archivo" id="{{ $arch->archivo }}"><i class="fas fa-trash"></i></button>
                                                    @endcan
                                                    <a href="{{ route('transaccion.descargar.soporte', ['id' => $data->id , 'file' => $arch->archivo]) }}" class="btn btn-light descargar_archivo" id="{{ $arch->archivo }}"><i class="fas fa-download"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="btn-group special" role="group" aria-label="Basic example">
                            @canany(['requerimientos.supervisor_diseno','aplicaciones.requerimientos.vendedor'])
                                <button class="btn btn-outline-light subir_archivos_soporte" id="{{ $data->id }}">
                                    <i class="pe-7s-cloud-upload pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <b class="icon-gradient bg-plum-plate">Subir archivos</b>
                                </button>
                            @endcan

                            @can('requerimientos.supervisor_diseno')
                                <button class="btn btn-outline-light cambiar_estado" id="{{ $data->id }}">
                                    <i class="pe-7s-way pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <b class="icon-gradient bg-plum-plate">Cambiar estado</b>
                                </button>
                            @endcan

                            @canany(['requerimientos.supervisor_diseno','aplicaciones.requerimientos.vendedor'])
                                <button class="btn btn-outline-light anular" id="{{ $data->id }}">
                                    <i class="pe-7s-close-circle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <b class="icon-gradient bg-plum-plate">Anular</b>
                                </button>
                            @endcan

                            @canany(['requerimientos.supervisor_diseno','aplicaciones.requerimientos.disenador'])
                                <button class="btn btn-outline-light finalizar" id="{{ $data->id }}">
                                    <i class="pe-7s-check pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <b class="icon-gradient bg-plum-plate">Finalizar</b>
                                </button>
                            @endcan


                            @can('requerimientos.supervisor_diseno')
                                <button class="btn btn-outline-light cambiar_disenador" id="{{ $data->id }}">
                                    <i class="pe-7s-shuffle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <b class="icon-gradient bg-plum-plate">Cambiar/asignar diseñador</b>
                                </button>
                            @endcan


                            <button class="btn btn-outline-light enviar_comentario" id="{{ $data->id }}">
                                <i class="pe-7s-comment pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Enviar comentario</b>
                            </button>
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
                                <table class="table table-bordered table-sm" id="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">ARTICULO</th>
                                            <th scope="col">RELIEVE</th>
                                            <th scope="col">ESTADO</th>
                                            <th scope="col">FECHA CREACION</th>
                                            <th scope="col" class="justify-content-center">
                                                @can('aplicaciones.requerimientos.disenador')
                                                    <button class="btn btn-success btn-block btn-sm agregar_propuesta" id="{{ $data->id }}">AGREGAR</button>
                                                @endcan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $propuestas as $p )
                                            <tr>
                                                <td>{{ $p->id }}</td>
                                                <td>{{ \App\CodCodigo::find($p->articulo)->descripcion  }}</td>
                                                <td>{{ $p->relieve }}</td>
                                                <td>
                                                    @if( $p->estado == 1 )
                                                        <span class="badge badge-primary">Propuesta creada</span>
                                                    @elseif( $p->estado == 2 )
                                                        <span class="badge badge-success">Iniciada</span>
                                                    @elseif( $p->estado == 3 )
                                                        <span class="badge badge-info">Solicitud de plano</span>
                                                    @elseif( $p->estado == 4 )
                                                        <span class="badge badge-info">Solicitud de render</span>
                                                    @elseif( $p->estado == 5 )
                                                        <span class="badge badge-warning">Pendiente aprobacion</span>
                                                    @elseif( $p->estado == 6 )
                                                        <span class="badge badge-success">Aprobada</span>
                                                    @elseif( $p->estado == 7 )
                                                        <span class="badge badge-danger">Rechazada</span>
                                                    @elseif( $p->estado == 8 )
                                                        <span class="badge badge-danger">Anulado</span>
                                                    @elseif( $p->estado == 9 )
                                                        <span class="badge badge-success">Finalizada</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::createFromTimeString($p->created_at)->format('Y-m-d g:i A').' ('. \Carbon\Carbon::createFromTimeString($p->created_at)->diffForHumans() .')' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-light btn-sm btn-block ver_propuesta" id="{{ $p->id }}">
                                                        <i class="fas fa-eye"></i> VER
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@section('modal')
    <div class="modal fade" id="pdf_modal" tabindex="-1" role="dialog" aria-labelledby="pdf_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Visor de pdf</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="">
                    <div id="pdf_modal_body" style="height:750px;" ></div>
                </div>
                <div class="modal-footer" style="text-align: center !important;">
                    <button class="btn btn-primary" data-dismiss="modal" id="CloseViewArt">Aceptar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="propuesta_modal" role="dialog" aria-labelledby="propuesta_modal" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propuesta_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="wrapper" id="propuesta_modal_texto_imprimible">
                        <div style="text-transform: uppercase">
                            <div class="row text-center">
                                <div class="col-12">
                                    <img src="/img/Logo_v2.png" alt="" style="width: 200px !important;">
                                </div>
                                <div class="col-12">
                                    <span>CI Estrada Velasquez y Cia SAS</span> <br>
                                    <span>CR 55 29 C 14 ZONA IND. DE BELEN, MEDELLIN, TEL 265-66-65</span><br>
                                    <span>Requerimiento: </span> <span id="propuesta_modal_id_req">{{ $data->id }}</span> - <span>Propuesta No.: </span>
                                    <span id="propuesta_modal_id"></span>
                                </div>
                            </div>
                            <br>
                            <div class="row text-center">
                                <div class="col-12">
                                    <span>ESPECIFICACIONES DE DISEÑO</span>
                                </div>
                            </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-sm-4 text-left">
                                    <address>
                                        <b>ARTICULO:</b> <span id="propuesta_modal_producto"></span> <br>
                                        <b>RELIEVE:</b> <span id="propuesta_modal_relieve"></span> <br>
                                        <b>MARCA:</b> <span id="propuesta_modal_marca">{{ \App\Marca::find($data->marca_id)->name }}</span> <br>
                                        <b>MEDIDA:</b> <a href="javascript:void(0)" id="propuesta_modal_medida"></a>
                                    </address>
                                </div>
                                <div class="col-sm-4 text-left">
                                    <address>
                                        <b>VENDEDOR:</b> <span id="propuesta_modal_vendedor">{{ \App\User::find($data->vendedor_id)->name }}</span> <br>
                                        <b>DISEÑADOR:</b> <span id="propuesta_modal_disenador"> {!! \App\User::find($data->diseñador_id)->name ?? '<span class="badge badge-danger">SIN ASIGNAR</span>' !!}</span> <br>
                                        <b>FECHA:</b> <span id="propuesta_modal_fecha"></span><br>
                                        <b>PESO:</b> <span id="propuesta_modal_peso"></span> @can('aplicaciones.requerimientos.render') <a href="javascript:void(0)" id="propuesta_modal_peso_edit"><i class="fas fa-edit"></i></a> @endcan
                                    </address>
                                </div>

                                <div class="col-sm-10 text-center">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">DIBUJO 2D</th>
                                                    <th scope="col">DIBUJO 3D</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        @can('aplicaciones.requerimientos.disenador')
                                                            <div class="image-container imagen_2d" id="{{ $data->id }}"  style="cursor: pointer">
                                                                <i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                                <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>
                                                            </div>
                                                        @else
                                                            <div class="image-container imagen_2d">
                                                                <i class="pe-7s-close-circle pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                                <label class="icon-gradient bg-plum-plate noprint">Aun no se agrega ninguna imagen</label>
                                                            </div>
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        @can('aplicaciones.requerimientos.render')
                                                            <div class="image-container imagen_3d" id="{{ $data->id }}" style="cursor: pointer">
                                                                <i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                                <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>
                                                            </div>
                                                        @else
                                                            <div class="image-container imagen_3d">
                                                                <i class="pe-7s-close-circle pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                                <label class="icon-gradient bg-plum-plate noprint">Aun no se agrega ninguna imagen</label>
                                                            </div>
                                                        @endcan
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="col">PLANO</th>
                                                    <th scope="col">CARACTERISTICAS</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        @can('aplicaciones.requerimientos.plano')
                                                            <div class="image-container plano" id="{{ $data->id }}" style="cursor: pointer">
                                                                <i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                                <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>
                                                            </div>
                                                        @else
                                                            <div class="image-container">
                                                                <i class="pe-7s-close-circle pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                                <label class="icon-gradient bg-plum-plate noprint">Aun no se agrega ninguna imagen</label>
                                                            </div>
                                                        @endcan
                                                    </td>
                                                    <td>
                                                        <div class="image-container comentario" id="{{ $data->id }}" style="cursor: pointer">
                                                            <i class="pe-7s-comment pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                            <label class="icon-gradient bg-plum-plate noprint">Click para agregar detalles</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group btn-block" role="group" aria-label="...">
                        @can('aplicaciones.requerimientos.vendedor')
                            <button class="btn btn-outline-light aprobar_propuesta">
                                <i class="pe-7s-check pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Aprobar</b>
                            </button>


                            <button class="btn btn-outline-light rechazar_propuesta">
                                <i class="pe-7s-close-circle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Rechazar</b>
                            </button>
                        @endcan

                        @canany(['requerimientos.supervisor_diseno','aplicaciones.requerimientos.disenador'])
                            <button class="btn btn-outline-light finalizar_propuesta">
                                <i class="pe-7s-gleam pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Finalizar</b>
                            </button>

                            <button class="btn btn-outline-light enviar_aprobar">
                                <i class="pe-7s-note2 pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Enviar a aprobar</b>
                            </button>

                            <button class="btn btn-outline-light solicitar_render">
                                <i class="pe-7s-box2 pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Solicitar render</b>
                            </button>

                            <button class="btn btn-outline-light solicitar_plano">
                                <i class="pe-7s-vector pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Solicitar plano</b>
                            </button>

                            <button class="btn btn-outline-light crear_medida">
                                <i class="pe-7s-tools pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Crear medida</b>
                            </button>
                        @endcan

                        @canany(['requerimientos.supervisor_diseno', 'aplicaciones.requerimientos.render', 'aplicaciones.requerimientos.plano'])
                            <button class="btn btn-outline-light enviar_diseno">
                                <i class="pe-7s-paper-plane pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <b class="icon-gradient bg-plum-plate">Enviar a diseño</b>
                            </button>
                        @endcan

                        <button class="btn btn-outline-light imprimir_propuesta">
                            <i class="pe-7s-print pe-4x icon-gradient bg-plum-plate"></i> <br>
                            <b class="icon-gradient bg-plum-plate">Imprimir</b>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            const altura_arr = [];

            $('.igualar_div').each(function(){
                const altura = $(this).height();
                altura_arr.push(altura);
            });

            altura_arr.sort(function(a, b){return b-a});
            $('.igualar_div').each(function(){
                $(this).css('height',altura_arr[0]);
            });


            $(document).on('click', '.ver_archivo', function () {
                const file = this.id;
                const req_id = document.getElementById('id_req').value;



                if(file.substr(-3) === 'png' || file.substr(-3) === 'jpg' || file.substr(-3) === 'gif'){
                    Swal.fire({
                        imageUrl: '/requerimientos/'+'RQ-'+req_id+'/soportes/'+file,
                        imageAlt: 'Imagen',
                        confirmButtonText: 'Cerrar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        buttonsStyling: true,
                        showCancelButton: false,
                    });
                }else{
                    PDFObject.embed('/requerimientos/'+'RQ-'+req_id+'/soportes/'+file, '#pdf_modal_body');
                    $('#pdf_modal').modal('show');
                }
            });


            $(document).on('click', '.eliminar_archivo', function () {
                const file = this.id;
                const req_id = document.getElementById('id_req').value;

                Swal.fire({
                    icon: 'question',
                    title: '¿Eliminar archivo?',
                    html: '<b>Debes añadir una justificacion para poder eliminar este archivo</b> ',
                    input: 'textarea',
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
                        return !value && 'No dejes ningun campo en blanco'
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: '/aplicaciones/requerimientos/transaccion/eliminar_archivo',
                            data: {
                                req_id: req_id,
                                file: file,
                                coments: result.value
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado!',
                                    text: data,
                                    confirmButtonText: 'Aceptar',
                                })
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: data.responseText
                                });
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });



            $(document).on('click', '.subir_archivos_soporte', function () {
                const req_id = document.getElementById('id_req').value;

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
                        accept: 'image/*, application/pdf'
                    },
                    onBeforeOpen: () => {
                        $(".swal2-file").change(function () {
                            const reader = new FileReader();
                        });
                    },
                    inputValidator: (value) => {
                        return !value && 'Debes seleccionar al menos un archivo'
                    }
                }).then((file) => {
                    if (file.value) {
                        const formData = new FormData();
                        const ins = $('.swal2-file')[0].files.length;
                        const file = $('.swal2-file')[0].files;

                        /*este for es necesario para la subida de archivos multiples*/
                        for (let x = 0; x < ins; x++) {
                            formData.append("fileToUpload[]", file[x]);
                        }
                        formData.append("req_id", req_id);

                        $.ajax({
                            url: '/aplicaciones/requerimientos/transaccion/subir_archivos_soporte',
                            method: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Archivo(s) subido(s) con exito!',
                                    text: data,
                                    confirmButtonText: 'Aceptar',
                                });

                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: data.responseText
                                });
                            }
                        })
                    }
                })
            });


            $(document).on('click', '.solicitar_render', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    title: '¿Enviar a renderizar?',
                    text: "¡Esta propuesta sera enviada al area de render y no estara disponible durante esta gestion",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, enviar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/aplicaciones/requerimientos/transaccion/enviar_render",
                            type: "post",
                            data: {prop_id: prop_id, req_id: req_id},
                            success: function (data) {
                                Swal.fire({
                                    title: 'Enviado!',
                                    text: data,
                                    icon: 'success',
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.solicitar_plano', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    title: '¿Solicitar plano?',
                    text: "¡Esta propuesta sera enviada al area de planos y no estara disponible durante esta gestion",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, enviar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/aplicaciones/requerimientos/transaccion/solicitar_plano",
                            type: "post",
                            data: {prop_id: prop_id, req_id: req_id},
                            success: function (data) {
                                Swal.fire({
                                    title: 'Enviado!',
                                    text: data,
                                    icon: 'success',
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });



            $(document).on('click', '.cambiar_estado', function () {
                const req_id = document.getElementById('id_req').value;

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
                        html: '<label>Selecciona una opcion</label> <br> <select name="estado_req" id="estado_req" class="form-control">' +
                            '<option value="" selected>Seleccione...</option>' +
                            '<option value="2">Por revisar</option>' +
                            '<option value="3">Asignado</option>' +
                            '<option value="5">Finalizado</option>' +
                            '<option value="6">Anulado diseño</option>' +
                            '<option value="7">Sin aprobar</option>' +
                            '</select>' +
                            '<br>' +
                            '<label style="text-align: left" >Justificacion:</label> <br>' +
                            '<textarea name="justificacion" id="justificacion" cols="30" rows="5" class="form-control"></textarea>',
                        inputValidator: () => {
                            if (document.getElementById('estado_req').value == '') {
                                return 'Debes seleccionar una opcion...';
                            }
                            if (document.getElementById('justificacion').value == '') {
                                return 'Debes escribir una justificacion...';
                            }
                        },
                        preConfirm: function () {
                            const array = {
                                'estado_req': document.getElementById("estado_req").value,
                                'justificacion': document.getElementById("justificacion").value,
                            };
                            return array;
                        },
                        onBeforeOpen: function (dom) {
                            swal.getInput().style.display = 'none';
                        }
                    },
                ]).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/aplicaciones/requerimientos/transaccion/cambiar_estado',
                            type: 'post',
                            data: {
                                result, req_id
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardardo',
                                    text: data,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                })
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.anular', function () {
                const req_id = document.getElementById('id_req').value;

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
                        $.ajax({
                            type: "post",
                            url: "/aplicaciones/requerimientos/transaccion/anular",
                            data: {
                                req_id,
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Anulado!',
                                    text: 'El requerimiento ha sido anulado.',
                                });

                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);

                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: data.responseText
                                });
                            }
                        });
                    }else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.finalizar', function () {
                const req_id = document.getElementById('id_req').value;

                Swal.fire({
                    title: '¿Finalizar este requerimiento?',
                    text: "¡Revise toda la informacion antes de Continuar..!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, finalizar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: "/aplicaciones/requerimientos/transaccion/finalizar",
                            data: {
                                req_id,
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: 'Finalizado!',
                                    text: 'El requerimiento ha sido finalizado!.',
                                    icon: 'success',
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.cambiar_disenador', function () {
                const req_id = document.getElementById('id_req').value;

                $.ajax({
                    url: '/aplicaciones/requerimientos/transaccion/listar_disenadores',
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
                                $.ajax({
                                    url: '/aplicaciones/requerimientos/transaccion/cambiar_disenador',
                                    type: 'post',
                                    data: {
                                        req_id,result
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
                                    error: function (data) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops',
                                            html: data.responseText
                                        });
                                    }
                                });
                            } else {
                                result.dismiss === Swal.DismissReason.cancel
                            }
                        })
                    }
                })
            });


            $(document).on('click', '.enviar_diseno', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    title: '¿Enviar a diseño?',
                    text: "¡La propuesta sera enviada al areda de diseño..!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Enviar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: "/aplicaciones/requerimientos/transaccion/enviar_diseno",
                            data: {
                                req_id, prop_id
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: 'Finalizado!',
                                    text: 'la propuesta fue enviada a diseño!.',
                                    icon: 'success',
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.enviar_comentario', function () {
                const req_id = document.getElementById('id_req').value;

                Swal.fire({
                    icon: 'info',
                    title: 'Enviar Comentarios',
                    html: '<label>Añade comentarios o informacion que pueda ser importante para este requerimiento</label>',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'on'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    inputValidator: (value) => {
                        return !value && 'No puedes enviar un comentario vacio...'
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: '/aplicaciones/requerimientos/transaccion/agregar_comentario',
                            data: {
                                req_id: req_id,
                                coments: result.value,
                            },
                            success: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardado!',
                                    text: 'Tu comentario fue enviado con exito!',
                                    confirmButtonText: 'Aceptar',
                                });

                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }else{
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.agregar_propuesta', function () {
                const req_id = document.getElementById('id_req').value;
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
                        html: '<form action="" id="form"><label>Articulo:</label><br>' +
                            '<input type="text" class="form-control" id="producto" placeholder="Escribe para buscar un articulo..."><br>' +
                            '<input type="hidden" class="form-control" id="producto_descripcion">' +
                            '<input type="hidden" class="form-control" id="producto_id">' +
                            '<input type="hidden" class="form-control" id="producto_cod">' +
                            '<label>Relieve:</label><br>' +
                            '<select name="relieve" id="relieve" class="form-control">' +
                            '<option value="" selected>Seleccione...</option>' +
                            '<option value="Alto">Alto</option>' +
                            '<option value="Bajo">Bajo</option>' +
                            '<option value="Alto/Bajo">Alto/Bajo</option>' +
                            '<option value="Liso">Liso</option>' +
                            '</select></form>',
                        inputValidator: () => {
                            if (document.getElementById('producto').value == '') {
                                return 'Todos los campos son obligatorios..';
                            }
                            if (document.getElementById('relieve').value == '') {
                                return 'Seleccione una opcion..';
                            }
                        },
                        preConfirm: function () {
                            return {
                                'producto_id': document.getElementById('producto_id').value,
                                'producto': document.getElementById("producto").value,
                                'producto_cod': document.getElementById("producto_cod").value,
                                'relieve': document.getElementById("relieve").value,
                            };
                        },
                        onBeforeOpen: function (dom) {
                            swal.getInput().style.display = 'none';
                        }
                    },
                ]).then((result) => {
                    if (result.value) {
                        let medida = result.value[0].producto;
                        medida = medida.split(" ");
                        medida = medida[4];


                        $.ajax({
                            url: '/aplicaciones/requerimientos/transaccion/agregar_propuesta',
                            type: 'post',
                            data: {
                                result, req_id, medida,
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardardo',
                                    text: 'Propuesta guardada con exito!',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                });

                $(document).find( "#producto" ).autocomplete({
                    appendTo: $(".swal2-popup"),
                    source: function (request, response) {
                        const query = document.getElementById('producto').value;
                        $.ajax({
                            url: "/aplicaciones/requerimientos/transaccion/listar_productos",
                            method: "get",
                            data: {
                                query: query,
                            },
                            dataType: "json",
                            success: function (data) {
                                const resp = $.map(data, function (obj) {
                                    return obj
                                });
                                response(resp);
                            }
                        })
                    },
                    focus: function (event, ui) {
                        document.getElementById('producto_id').value = ui.item.id;
                        document.getElementById('producto_descripcion').value = ui.item.value
                        document.getElementById("producto_cod").value = ui.item.codigo

                        return true;
                    },
                    select: function (event, ui) {
                        document.getElementById('producto_id').value = ui.item.id;
                        document.getElementById('producto_descripcion').value = ui.item.value
                        document.getElementById("producto_cod").value = ui.item.codigo
                    },
                    minlength: 2
                });
            });


            $(document).on('click', '.ver_propuesta', function () {
                $('.imagen_2d').html('').append('<i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br> <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>');
                $('.imagen_3d').html('').append('<i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br> <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>');
                $('.plano').html('').append('<i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br> <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>');

                let id = this.id;
                $.ajax({
                    url: '/aplicaciones/requerimientos/transaccion/obtener_datos_propuesta',
                    type: 'get',
                    data: {
                        id: id,
                    },
                    success:function (data) {
                        console.log(data);
                        document.getElementById('propuesta_modal_title').innerHTML = 'Propuesta '+ data.propuesta.id;
                        document.getElementById('propuesta_modal_producto').innerHTML = data.propuesta.articulo;
                        document.getElementById('propuesta_modal_relieve').innerHTML = data.propuesta.relieve;
                        document.getElementById('propuesta_modal_medida').innerHTML = data.propuesta.medida;
                        document.getElementById('propuesta_modal_fecha').innerHTML = data.propuesta.fecha;
                        document.getElementById('propuesta_modal_id').innerText = data.propuesta.id

                        if(data.archivos.length > 0){
                            for (let i = 0; i < data.archivos.length; i++) {
                                if(data.archivos[i].tipo === '2D' && data.archivos[i].archivo){
                                    $('.imagen_2d').html('').append('<img src="'+ data.archivos[i].url + data.archivos[i].archivo + '" style="height: 240px; width: 331px" alt="img">');
                                }
                                if(data.archivos[i].tipo === '3D'){
                                    $('.imagen_3d').html('').append('<img src="'+ data.archivos[i].url + data.archivos[i].archivo + '" style="height: 240px; width: 331px" alt="img">');
                                }
                                if(data.archivos[i].tipo === 'plano'){
                                    $('.plano').html('').append('<img src="'+ data.archivos[i].url + data.archivos[i].archivo + '" style="height: 240px; width: 331px" alt="img">')
                                }
                            }
                        }

                        if(data.propuesta.caracteristicas){
                            $('.comentario').html('').append('<br><label>'+data.propuesta.caracteristicas+'</label>')
                        }else{
                            $('.comentario').html('').append('<i class="pe-7s-comment pe-5x icon-gradient bg-plum-plate noprint"></i> <br> <label class="icon-gradient bg-plum-plate noprint">Click para agregar detalles</label>')
                        }



                        $('#propuesta_modal').modal('show');
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            html: data.responseText
                        });
                    }
                });
            });


            $(document).on('click', '.imagen_2d' , function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;
                Swal.fire({
                    icon: 'info',
                    title: '2D',
                    text: 'Por favor, seleccione un archivo 2D',
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
                            const reader = new FileReader();
                            reader.readAsDataURL(this.files[0]);
                        });
                    },
                    inputValidator: (value) => {
                        return !value && 'Debes seleccionar un archivo'
                    }
                }).then((file) => {
                    if (file.value) {
                        const formData = new FormData();
                        const file = $('.swal2-file')[0].files[0];
                        formData.append("fileToUpload", file);
                        formData.append("prop_id",prop_id);
                        formData.append("req_id", req_id);

                        $.ajax({
                            url: '/aplicaciones/requerimientos/transaccion/subir_archivo_2d',
                            method: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('.imagen_2d').html('').append('<img src="'+ data.url + data.archivo + '" style="height: 240px; width: 331px" alt="img">');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Archivo guardado',
                                    text: 'Archivo subido con exito!'
                                });
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        })
                    }
                })
            });


            $(document).on('click', '.imagen_3d' , function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    icon: 'info',
                    title: '3D',
                    text: 'Por favor, seleccione un archivo 3D',
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
                            const reader = new FileReader();
                            reader.readAsDataURL(this.files[0]);
                        });
                    },
                    inputValidator: (value) => {
                        return !value && 'Debes seleccionar un archivo'
                    }
                }).then((file) => {
                    if (file.value) {
                        const formData = new FormData();
                        const file = $('.swal2-file')[0].files[0];
                        formData.append("fileToUpload", file);
                        formData.append("prop_id",prop_id);
                        formData.append("req_id", req_id);

                        $.ajax({
                            url: '/aplicaciones/requerimientos/transaccion/subir_archivo_3d',
                            method: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('.imagen_3d').html('').append('<img src="'+ data.url + data.archivo + '" style="height: 240px; width: 331px" alt="img">');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Archivo guardado',
                                    text: 'Archivo subido con exito!'
                                });
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }
                })
            });


            $(document).on('click', '.plano', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    icon: 'info',
                    title: 'Plano',
                    text: 'Por favor, seleccione una imagen del plano',
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
                            const reader = new FileReader();
                            reader.readAsDataURL(this.files[0]);
                        });
                    },
                    inputValidator: (value) => {
                        return !value && 'Debes seleccionar un archivo'
                    }
                }).then((file) => {
                    if (file.value) {
                        const formData = new FormData();
                        const file = $('.swal2-file')[0].files[0];
                        formData.append("fileToUpload", file);
                        formData.append("prop_id",prop_id);
                        formData.append("req_id", req_id);

                        $.ajax({
                            url: '/aplicaciones/requerimientos/transaccion/subir_archivo_plano',
                            method: 'post',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('.plano').html('').append('<img src="'+ data.url + data.archivo + '" style="height: 240px; width: 331px" alt="img">');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Archivo guardado',
                                    text: 'Archivo subido con exito!'
                                });
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }
                });
            });




            $(document).on('click', '.comentario', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    icon: 'info',
                    title: 'Caracteristicas',
                    html: '<label>Escribe informacion importante para esta propuesta, si habia datos guardados seran reemplazados por la informacion que ingreses a continuacion</label>',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    inputValidator: (value) => {
                        return !value && 'Por favor, escribe algo antes de guardar...'
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: '/aplicaciones/requerimientos/transaccion/agregar_comentario_propuesta',
                            data: {
                                req_id: req_id,
                                prop_id: prop_id,
                                coments: result.value
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardado!',
                                    text: 'las caracteristicas fueron guardadas con exito!',
                                    confirmButtonText: 'Aceptar',
                                });
                                $('.comentario').html('').append('<br> <label>'+ data +'</label>');
                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on('click', '.aprobar_propuesta', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;

                Swal.fire({
                    title: '¿Aprobar esta propuesta?',
                    text: "¡Revise toda la informacion antes de continuar..!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, aprobar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: "/aplicaciones/requerimientos/transaccion/aprobar_propuesta",
                            data: {
                                prop_id, req_id
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Aprobado!',
                                    text: data,
                                });

                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);

                            },
                            error: function(data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    html: data.responseText
                                });
                            }
                        });
                    }else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            });


            $(document).on ('click', '.rechazar_propuesta', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;
                Swal.fire({
                    icon: 'question',
                    title: '¿Rechazar propuesta?',
                    html: '<b>Por favor, escribe el motivo del rechazo</b> ',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Si, rechazar!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    inputValidator: (value) => {
                        return !value && 'No dejes ningun campo en blanco'
                    }
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "post",
                            url: '/aplicaciones/requerimientos/transaccion/rechazar_propuesta',
                            data: {
                                req_id: req_id,
                                prop_id: prop_id,
                                coments: result.value
                            },
                            success: function (data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Rechazado!',
                                    text: data,
                                });
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: data.responseText
                                });
                            }
                        });
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                });
            });


            $(document).on('click', '.enviar_aprobar', function () {
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                let req_id = document.getElementById('id_req').value;
                Swal.fire({
                    title: '¿Enviar a aprobar?',
                    text: "¡Esta propuesta sera enviada al vendedor para su revision y aprobacion!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, enviar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: 'post',
                            url: '/aplicaciones/requerimientos/transaccion/enviar_aprobar_propuesta',
                            data:{ req_id, prop_id},
                            success: function (data) {
                                Swal.fire({
                                    title: 'Completado!',
                                    text: 'Propuesta enviada con exito.',
                                    icon: 'success',
                                });
                                setTimeout(function() {
                                    window.location.reload(true)
                                }, 2000);
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops',
                                    text: data.responseText
                                });
                            }
                        });
                    }else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                });
            });


            $(document).on('click', '.finalizar_propuesta', function () {
                let req_id = document.getElementById('id_req').value;
                let prop_id = document.getElementById('propuesta_modal_id').innerText;
                $.ajax({
                    type: 'get',
                    url: '/aplicaciones/requerimientos/transaccion/comprobar_estado_propuesta',
                    data: {prop_id: prop_id, req_id: req_id},
                    success: function (data) {
                        if(data.estado === 6){
                            const codigo_arte = generar_codigo_arte(data.lista_artes, data.ultimo_arte, data.letra_marca);
                            Swal.fire({
                                title: '¿Finalizar propuesta?',
                                html: "Se creará un nuevo producto y su respectivo arte, esta acción es irreversible. <br> ¿Esta segur@ de continuar?",
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Estoy segur@!',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.value) {
                                    $.ajax({
                                        type: "post",
                                        url: "/aplicaciones/requerimientos/transaccion/finalizar_propuesta",
                                        data: {
                                            req_id, prop_id, codigo_arte
                                        },
                                        success: function () {
                                            $('#propuesta_modal').modal('hide');
                                            Swal.fire({
                                                title: 'Terminado!',
                                                text: 'La propuesta fue finalizada con exito!.',
                                                icon: 'success',
                                            });

                                            setTimeout(function() {
                                                window.location.reload(true)
                                            }, 2000);
                                        },
                                        error: function (data) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops',
                                                text: data.responseText
                                            });
                                        }
                                    });
                                }else {
                                    result.dismiss === Swal.DismissReason.cancel
                                }
                            })
                        }else{
                            Swal.fire(
                                'Oops!',
                                'Solo puedes finalizar propuestas aprobadas por el vendedor.',
                                'error'
                            )
                        }
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: data.responseText
                        });
                    }
                })
            });



            function generar_codigo_arte(lista_artes, ultimo_arte, letra_arte){
                let i;
                let incremental = 0;
                const charStringRange = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                const vectorc = [];
                let t1 = 0;
                let numerof = 0;
                const OriginalProductCodes = lista_artes;

                for (let f = 0; f < OriginalProductCodes.length; f++) {
                    if (ultimo_arte  === OriginalProductCodes[f] && OriginalProductCodes[f]){
                        const cadena = OriginalProductCodes[f];
                        let text2 = cadena.split('').reverse().join('');
                        text2      = text2.split('');

                        for (let v2 = 0; v2 < 5; v2++) {
                            for (i = 0; i < 36; i++) {
                                if (text2[v2] === charStringRange[i]) {
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
                const maxvector = Math.max.apply(Math, vectorc);

                if (maxvector >= 0) {
                    incremental = maxvector + 1;
                }
                let text = '';
                let incretemp = incremental;

                for (let i = 0; i < 5; i++) {
                    incretemp = Math.floor(incretemp) / 36;
                    text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp)) * 36));
                }

                text = text.split('').reverse().join('');
                return letra_arte + text;
            }





















            $(document).on('click', '.imprimir_propuesta', function () {
                const div = document.querySelector("#propuesta_modal_texto_imprimible");
                const ventana = window.open('Print', '', 'width=900');
                ventana.document.write(`
                    <html lang="es">
                        <head>
                            <title>`+ document.title +`</title>
                            <link rel="stylesheet" href="/bootstrap.min.css">
                            <style> .noprint, .noprint *
                                {
                                    display: none !important;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="container ml-1 mr-1">
                                 `+ div.innerHTML +`
                            </div>
                        </body>
                    </html>
                `);
                ventana.document.close();
                ventana.focus();
                ventana.onload = function() {
                    ventana.print();
                    ventana.close();
                };
                return true;
            });

            $('#table').dataTable({
                paging: false,
                searching: false,
                language: {
                    url: '/Spanish.json'
                },
                columns: [
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                    { "orderable": false, "searchable": false },
                ]
            });

            $('.dropdown-toggle').dropdown()
        });
    </script>

@endpush

@push('styles')
    <style>
        .btn-group.special {
            display: flex;
        }

        .special .btn {
            flex: 1;
            border-radius: 0;
        }

    </style>
@endpush
