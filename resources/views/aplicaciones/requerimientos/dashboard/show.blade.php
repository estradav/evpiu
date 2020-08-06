@extends('layouts.architectui')

@section('page_title', 'Requerimiento '. $data->id)

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
        <input type="hidden" id="id_req" name="id_req" value="{{$data->id}}">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="ain-card mb-3 card igualar_div">
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
                                @if( $data->estado == 0 )
                                    <span class="badge badge-danger">ANULADO VENDEDOR</span>
                                @elseif( $data->estado == 1 )
                                    <span class="badge badge-success">RENDER</span>
                                @elseif( $data->estado == 2 )
                                    <span class="badge badge-warning">PENDIENTE POR REVISAR</span>
                                @elseif( $data->estado == 3 )
                                    <span class="badge badge-success">ASIGNADO</span>
                                @elseif( $data->estado == 4 )
                                    <span class="badge badge-success">INICIADO</span>
                                @elseif( $data->estado == 5 )
                                    <span class="badge badge-success">CERRADO</span>
                                @elseif( $data->estado == 6 )
                                    <span class="badge badge-danger">ANULADO DISEÑO</span>
                                @elseif( $data->estado == 7 )
                                    <span class="badge badge-warning">SIN APROBAR</span>
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
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card igualar_div">
                    <div class="card-header">
                        ARCHIVOS DE SOPORTE
                    </div>
                    <div class="card-body">
                        @if( sizeof($archivos) == 0 )
                            <div class="alert alert-danger text-center" role="alert">
                                <i class="pe-7s-attention pe-4x"></i><br>
                                Aun no se agrega ningun archivo.
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
                                                        <button type="button" class="btn btn-light eliminar_archivo" id="{{ $arch->archivo }}"><i class="fas fa-trash"></i></button>
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
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
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
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                <div class="main-card mb-3 card igualar_div">
                    <div class="card-body">
                        <br>
                        <div class="btn-group special" role="group" aria-label="Basic example">
                            @if (auth()->user()->id == $data->vendedor_id || auth()->user()->can('requerimientos.supervisor_diseno') || auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light subir_archivos_soporte" id="{{ $data->id }}">
                                    <i class="pe-7s-cloud-upload pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Subir archivos</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light subir_archivos_soporte" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-cloud-upload pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Subir archivos</label>
                                </button>
                            @endif

                            @if (auth()->user()->can('requerimientos.supervisor_diseno') || auth()->user()->id == $data->diseñador_id  || auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light enviar_render" id="{{ $data->id }}">
                                    <i class="pe-7s-box2 pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Enviar render</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light enviar_render" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-box2 pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Enviar render</label>
                                </button>
                            @endif

                            @if (auth()->user()->can('requerimientos.supervisor_diseno') ||  auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light cambiar_estado" id="{{ $data->id }}">
                                    <i class="pe-7s-way pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Cambiar estado</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light cambiar_estado" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-way pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Cambiar estado</label>
                                </button>
                            @endif

                            @if (auth()->user()->id == $data->vendedor_id || auth()->user()->can('requerimientos.supervisor_diseno') || auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light anular" id="{{ $data->id }}">
                                    <i class="pe-7s-close-circle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Anular</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light anular" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-close-circle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Anular</label>
                                </button>
                            @endif
                        </div>

                        <div class="btn-group special" role="group" aria-label="Basic example" style="border-radius: 0 !important;">
                            @if (auth()->user()->can('requerimientos.supervisor_diseno') || auth()->user()->id == $data->diseñador_id  || auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light finalizar" id="{{ $data->id }}">
                                    <i class="pe-7s-check pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Finalizar</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light finalizar" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-check pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Finalizar</label>
                                </button>
                            @endif


                            @if (auth()->user()->can('requerimientos.supervisor_diseno') ||  auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light cambiar_disenador" id="{{ $data->id }}">
                                    <i class="pe-7s-shuffle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Cambiar diseñador</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light cambiar_disenador" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-shuffle pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Cambiar diseñador</label>
                                </button>
                            @endif

                            @if (auth()->user()->can('requerimientos.supervisor_diseno') || auth()->user()->can('requerimientos.rendeR') ||  auth()->user()->hasRole('super-admin'))
                                <button class="btn btn-outline-light enviar_diseno" id="{{ $data->id }}">
                                    <i class="pe-7s-paper-plane pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Enviar a diseño</label>
                                </button>
                            @else
                                <button class="btn btn-outline-light enviar_diseno" id="{{ $data->id }}" disabled>
                                    <i class="pe-7s-paper-plane pe-4x icon-gradient bg-plum-plate"></i> <br>
                                    <label class="icon-gradient bg-plum-plate">Enviar a diseño</label>
                                </button>
                            @endif


                            <button class="btn btn-outline-light enviar_comentario" id="{{ $data->id }}">
                                <i class="pe-7s-comment pe-4x icon-gradient bg-plum-plate"></i> <br>
                                <label class="icon-gradient bg-plum-plate">Enviar comentario</label>
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
                                            <th scope="col" class="text-center">
                                                <button class="btn btn-success btn-block btn-sm agregar_propuesta" id="{{ $data->id }}">AGREGAR</button>
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
                                                        <span class="badge badge-warning">Pendiente aprobacion</span>
                                                    @elseif( $p->estado == 3 )
                                                        <span class="badge badge-danger">Rechazada</span>
                                                    @elseif( $p->estado == 4 )
                                                        <span class="badge badge-success">Aprobada</span>
                                                    @elseif( $p->estado == 5 )
                                                        <span class="badge badge-danger">Solicitando planos</span>
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


    <div class="modal fade" id="propuesta_modal" tabindex="-1" role="dialog" aria-labelledby="propuesta_modal" aria-hidden="true" style="overflow-y: scroll;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propuesta_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="propuesta_modal_texto_imprimible" >
                    <div class="wrapper">
                        <section class="invoice" style="text-transform: uppercase">
                            <div class="row text-center">
                                <div class="col-12">
                                    <img src="/img/Logo_v2.png" alt="" style="width: 200px !important;" class="headers">
                                </div>
                                <div class="col-12">
                                    <label style="margin: -1px">CI Estrada Velasquez y Cia SAS</label> <br>
                                    <label style="margin: -1px">CR 55 29 C 14 ZONA IND. DE BELEN, MEDELLIN, TEL 265-66-65</label><br>
                                    <label style="margin: -1px;">Requerimiento: </label> <label id="propuesta_modal_id_req">{{ $data->id }}</label> - <label style="margin: -1px">Propuesta No.: </label>
                                    <label id="propuesta_modal_id"></label>
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
                                        <b>ARTICULO:</b> <span id="propuesta_modal_producto"></span> <br>
                                        <b>RELIEVE:</b> <span id="propuesta_modal_relieve"></span> <br>
                                        <b>MARCA:</b> <span id="propuesta_modal_marca">{{ \App\Marca::find($data->marca_id)->name }}</span> <br>
                                        <b>MEDIDA:</b> <a href="javascript:void(0)" id="propuesta_modal_medida"></a>
                                    </address>
                                </div>
                                <div class="col-sm-6 invoice-col text-left">
                                    <address>
                                        <b>VENDEDOR:</b> <span id="propuesta_modal_vendedor">{{ \App\User::find($data->vendedor_id)->name }}</span> <br>
                                        <b>DISEÑADOR:</b> <span id="propuesta_modal_disenador"> {!! \App\User::find($data->diseñador_id)->name ?? '<span class="badge badge-danger">SIN ASIGNAR</span>' !!}</span> <br>
                                        <b>FECHA:</b> <span id="propuesta_modal_fecha"></span>
                                    </address>
                                </div>

                                <div class="col-sm-12 text-center">
                                    <table style="width: 740px;" heig cellspacing="3" cellpadding="3" border="1">
                                        <tr>
                                            <td>
                                                <b>DIBUJO 2D</b>
                                            </td>
                                            <td>
                                                <b>DIBUJO 3D</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 330px; width: 370px" >
                                                <div class="image-container imagen_2d" id="{{ $data->id }}" style="cursor: pointer">
                                                    <i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                    <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>
                                                </div>
                                            </td>
                                            <td style="height: 330px; width: 370px">
                                                <div class="image-container imagen_3d" id="{{ $data->id }}" style="cursor: pointer">
                                                    <i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                    <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table style="width: 740px;" heig cellspacing="1" cellpadding="2" border="1">
                                        <tr>
                                            <td>
                                                <b>PLANO</b>
                                            </td>
                                            <td>
                                                <b>CARACTERISTICAS</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="height: 330px; width: 370px" >
                                                <div class="image-container plano" id="{{ $data->id }}" style="cursor: pointer">
                                                    <i class="pe-7s-cloud-upload pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                    <label class="icon-gradient bg-plum-plate noprint">Click para subir imagen</label>
                                                </div>
                                            </td>
                                            <td style="height: 330px; width: 370px" >
                                                <div class="image-container comentario" id="{{ $data->id }}" style="cursor: pointer">
                                                    <i class="pe-7s-comment pe-5x icon-gradient bg-plum-plate noprint"></i> <br>
                                                    <label class="icon-gradient bg-plum-plate noprint">Click para agregar detalles</label>
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
                    title: '¿Eliminar archivo?',
                    html: '<b>Debes añadir una justificacion para poder eliminar este archivo</b> ',
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


            $(document).on('click', '.enviar_render', function () {
                const req_id = document.getElementById('id_req').value;

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
                        $.ajax({
                            url: "/aplicaciones/requerimientos/transaccion/enviar_render",
                            type: "post",
                            data: {req_id: req_id},
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
                                    title: 'Anulado!',
                                    text: 'El requerimiento '+ req_id +' ha sido anulado.',
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
                const req_id = document.getElementById('id_req').value;

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
                        $.ajax({
                            type: "post",
                            url: "/aplicaciones/requerimientos/transaccion/enviar_diseno",
                            data: {
                                req_id,
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: 'Finalizado!',
                                    text: 'El requerimiento fue finalizado!.',
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
