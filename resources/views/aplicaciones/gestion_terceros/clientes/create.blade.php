@extends('layouts.architectui')

@section('page_title', 'Nuevo cliente')

@section('content')
    @can('aplicaciones.gestion_terceros.clientes.create')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-add-user icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Nuevo cliente
                        <div class="page-title-subheading">
                            Formulario para creacion de clientes.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <label class="text-danger"><b>Nota:</b>  Por favor antes de comenzar a crear el cliente, verifique no existe en las plataformas</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Nombre/Razon Social ó NIT</span>
                            </div>
                            <input type="text" class="form-control" id="search_client_max_dms" onclick="select()">
                            <div class="input-group-append">
                                <label class="input-group-text" id="max_status">MAX</label>
                                <label class="input-group-text" id="dms_status">DMS</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form id="create-form" >
                            <h3>Cliente</h3>
                            <fieldset>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion del cliente</legend>
                                    <div class="col-sm-3">
                                        <label for="M_primer_nombre">Primer Nombre: *</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Nombre del cliente o razon social, los campos como segundo nombre, primer apellido y segundo apellido solo aplican para persona natural">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_primer_nombre" name="M_primer_nombre" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_segundo_nombre">Segundo Nombre: </label>
                                        <input id="M_segundo_nombre" name="M_segundo_nombre" type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_primer_apellido">Primer Apellido: </label>
                                        <input id="M_primer_apellido" name="M_primer_apellido" type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_segundo_apellido">Segundo Apellido: </label>
                                        <input id="M_segundo_apellido" name="M_segundo_apellido" type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="M_Razon_comercial">Razon comercial:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Nombre como comunmente se conoce a la empresa">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Razon_comercial" name="M_Razon_comercial" type="text" class="form-control" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="M_direccion1">Direccion 1:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Direccion principal del cliente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_direccion1" name="M_direccion1" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="M_direccion2">Direccion 2:</label>
                                        <input id="M_direccion2" name="M_direccion2" type="text" class="form-control" value="        " onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="M_Pais">Pais:</label>
                                        <select id="M_Pais" name="M_Pais" class="form-control">
                                                <option value="" selected>Seleccione...</option>
                                            @foreach($paises as $pais)
                                                <option value="{{ $pais->pais }}"> {{ $pais->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Departamento">Departamento:</label>
                                        <select id="M_Departamento" name="M_Departamento" class="form-control"></select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Ciudad">Ciudad:</label>
                                        <select id="M_Ciudad" name="M_Ciudad" class="form-control"></select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Codigo_postal">Codigo postal:</label>
                                        <input id="M_Codigo_postal" name="M_Codigo_postal" type="number" class="form-control required" >
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="M_Contacto">Contacto:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Nombre de la persona con la que podemos comunicarnos en el futuro">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Contacto" name="M_Contacto" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Telefono">Telefono:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Telefono fijo de contacto">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Telefono" name="M_Telefono" type="number" class="form-control required">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Telefono2">Telefono 2:</label>
                                        <input id="M_Telefono2" name="M_Telefono2" type="number" class="form-control required">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Celular">Celular:</label>
                                        <input id="M_Celular" name="M_Celular" type="number" class="form-control required">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="M_Email_contacto">E-mail contacto:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Email al que podemos enviar informacion importante">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Email_contacto" name="M_Email_contacto" type="email" class="form-control required" onkeyup="this.value=this.value.toLowerCase();">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="M_Email_facturacion">E-mail Facturacion:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Email principal para envio de facturacion electronica">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Email_facturacion" name="M_Email_facturacion" type="email" class="form-control required" onkeyup="this.value=this.value.toLowerCase();">
                                    </div>
                                </div>
                            </fieldset>

                            <h3>Informacion adicional</h3>
                            <fieldset>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion fiscal</legend>
                                    <div class="col-sm-3">
                                        <label for="M_Gravado">Gravado:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Selecciona 'si' si el cliente es responsable de IVA">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_Gravado" id="M_Gravado" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y">SI</option>
                                            <option value="N">NO</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_vendedor">Vendedor:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Selecciona 'si' si el cliente es responsable de IVA">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_vendedor" id="M_vendedor" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            @foreach($vendedores as $vendedor)
                                                <option value="{{ $vendedor->SLSREP_26 }}">{{ $vendedor->SLSNME_26 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_tipo_doc">Tipo Documento:</label>
                                        <select name="M_tipo_doc" id="M_tipo_doc" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="C">Ceduda de ciudadania</option>
                                            <option value="N">NIT</option>
                                            <option value="E">Cedula de extrangeria</option>
                                            <option value="T">Tarjeta de identidad</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Nit_cc">NIT/CC:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Escribe el nit o numero de cedula del cliente y en la casilla siguiente el digito de verificacion">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <div class="input-group">
                                            <input id="M_Nit_cc" name="M_Nit_cc" type="number" class="form-control required" style="width: 60%">
                                            <input id="M_Nit_cc_dg" name="M_Nit_cc_dg" type="number" class="form-control " readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Finanzas</legend>
                                    <div class="col-sm-3">
                                        <label for="M_Forma_envio">Forma de envio:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Forma en la que sera entregada la mercancia al cliente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_Forma_envio" id="M_Forma_envio" class="form-control">
                                            <option value="">Seleccione...</option>
                                            @foreach($forma_envio as $envio)
                                                <option value="{{ $envio->CODE_36 }}">{{ $envio->DESC_36 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Plazo">Plazo:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Plazo de pago para las compras">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_Plazo" id="M_Plazo" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            @foreach( $plazos as $plazo )
                                                <option value="{{ $plazo->CODE_36 }}">{{ $plazo->DESC_36 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Porcentaje_descuento">Porcentaje descuento:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Porcentaje de descuento acordado para el cliente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Porcentaje_descuento" name="M_Porcentaje_descuento" type="number" class="form-control required" value="0">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_actividad_principal">Actividad principal:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Codigo de la actividad principal del client, esta informacion se puede consultar en el RUT">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_actividad_principal" name="M_actividad_principal" type="number" class="form-control required">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Conceptos DMS</legend>
                                    <div class="col-sm-3">
                                        <label for="M_tipo_tercero_dms">Tipo de tercero:</label>
                                        <select name="M_tipo_tercero_dms" id="M_tipo_tercero_dms" class="form-control">
                                            <option value="">Seleccione...</option>
                                            <option value="1">Cliente</option>
                                            <option value="5">Cliente y Proveedor</option>
                                            <option value="6">Cliente, Proveedor y Usuario</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_tipo_client_dms">Tipo de cliente:</label>
                                        <select name="M_tipo_client_dms" id="M_tipo_client_dms" class="form-control">
                                            <option value="">Seleccione...</option>
                                            <option value="1">Nacional</option>
                                            <option value="3">Exterior</option>
                                            <option value="4">Zona Franca</option>
                                            <option value="2">CI</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_tipo_regimen_dms">Regimen:</label>
                                        <select name="M_tipo_regimen_dms" id="M_tipo_regimen_dms" class="form-control">
                                            <option value="">Seleccione...</option>
                                            <option value="1">Comun</option>
                                            <option value="3">Simplificado</option>
                                            <option value="4">Persona Natural</option>
                                            <option value="2">CI</option>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            <h3>Informacion tributaria</h3>
                            <fieldset>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion tributaria</legend>
                                    <div class="col-sm-3">
                                        <input id="M_rut_entregado" name="M_rut_entregado" type="checkbox" class="custom-checkbox">
                                        <label for="M_rut_entregado">¿RUT Entregado?</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Marca esta casilla si el cliente entrego RUT">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <input id="M_gran_contribuyente" name="M_gran_contribuyente" type="checkbox" class="custom-checkbox">
                                        <label for="M_gran_contribuyente">Gran contribuyente</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Marca esta casilla si el cliente es gran contribuyente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                    </div>
                                    <div class="col-sm-3">
                                        <input id="M_responsable_iva" name="M_responsable_iva" type="checkbox" class="custom-checkbox">
                                        <label for="M_responsable_iva">Responsable IVA</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Marca esta casilla si el cliente es responsable de IVA">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="M_responsable_fe">Responsable FE:</label>
                                        <input id="M_responsable_fe" name="M_responsable_fe" type="text" class="form-control" onkeyup="this.value=this.value.toLowerCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_telefono_fe">Telefono FE:</label>
                                        <input id="M_telefono_fe" name="M_telefono_fe" type="number" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_codigo_ciudad_ext">Codigo de Ciudad Ext.:</label>
                                        <input id="M_codigo_ciudad_ext" name="M_codigo_ciudad_ext" type="text" class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_grupo_economico">Grupo Economico:</label>
                                        <input id="M_grupo_economico" name="M_grupo_economico" type="text" class="form-control" onkeyup="this.value=this.value.toLowerCase();">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="M_Moneda">Moneda:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Moneda en la que se le facturara al cliente 'COP' para ventas nacionales y 'USD' para ventas en el exterior">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select id="M_Moneda" name="M_Moneda" class="form-control">
                                            <option value="">Seleccione...</option>
                                            <option value="USD">USD</option>
                                            <option value="COP">COP</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Tipo_cliente">Tipo Cliente:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Selecciona una opcion dependiento del tipo de cliente registrado ante la DIAN (persona natural, exterior, nacional, etc)">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select id="M_Tipo_cliente" name="M_Tipo_cliente" class="form-control">
                                            <option value="" selected>Selecione...</option>
                                            @foreach($tipo_cliente as $cliente)
                                                <option value="{{ $cliente->CUSTYP_62 }}">{{ $cliente->DESC_62 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="M_correos_copia">Correos Copia:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Correos a los cuales llegara copia de las facturas emitidas electronicamente. los correos pueden ir separados de coma, punto y coma o espacios y deben ser correos validos.">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <br>
                                        <select name="M_correos_copia" id="M_correos_copia" multiple="multiple" class="form-control" style="width: 100%"></select>
                                    </div>
                                </div>
                            </fieldset>

                            <h3>Terminar registro</h3>
                            <fieldset>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion Importante!</legend>
                                    <div class="col-sm-12">
                                        <h3>Los datos ingresados seran guardados en las plataformas MAX y DMS , antes de finalizar verifique que toda la informacion proporcionada es veridica y esta correctamente digilenciada.</h3>
                                        <h3 class="text-danger">¡Alerta: Esta accion no es reversible!</h3>
                                    </div>
                                </div>
                                <input id="acceptTerms" name="acceptTerms" type="checkbox" class="custom-checkbox required"> <label for="acceptTerms-2">He digilenciado la informacion correctamente.</label>
                            </fieldset>
                        </form>
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
    <div class="modal fade" id="direccion_modal" tabindex="-1" role="dialog" aria-labelledby="direccion_modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="tipo_via">Tipo via:*</label>
                                    <select id="tipo_via" name="tipo_via" class="form-control ddr_m">
                                        <option value="" selected>Selecciona...</option>
                                        <option value="AV">Avenida</option>
                                        <option value="CL">Calle</option>
                                        <option value="KR">Carrera</option>
                                        <option value="CIRC">Circular</option>
                                        <option value="DG">Diagonal</option>
                                        <option value="TR">Transversal</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="numero1">Número:*</label>
                                    <input id="numero1" name="numero1" type="number" class="form-control ddr_m" >
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="letra">Letra:</label>
                                    <select name="letra" id="letra" class="form-control ddr_m">
                                        <option value="" selected>Selecciona...</option>
                                        <option value="A">A</option>
                                        <option value="AA">AA</option>
                                        <option value="AC">AC</option>
                                        <option value="AF">AF</option>
                                        <option value="B">B</option>
                                        <option value="BB">BB</option>
                                        <option value="C">C</option>
                                        <option value="CC">CC</option>
                                        <option value="D">D</option>
                                        <option value="DD">DD</option>
                                        <option value="E">E</option>
                                        <option value="EE">EE</option>
                                        <option value="F">F</option>
                                        <option value="FF">FF</option>
                                        <option value="G">G</option>
                                        <option value="GG">GG</option>
                                        <option value="H">H</option>
                                        <option value="HH">HH</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="complemento1">Complemento:</label>
                                    <select id="complemento1" name="complemento1" class="form-control ddr_m">
                                        <option value="" selected>Selecciona...</option>
                                        <option value="ESTE">Este</option>
                                        <option value="NORTE">Norte</option>
                                        <option value="OESTE">Oeste</option>
                                        <option value="SUR">Sur</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="numero2">Numero:*</label>
                                    <input id="numero2" name="numero2" type="number" class="form-control ddr_m">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="letra2">Letra:</label>
                                    <select id="letra2" name="letra2" class="form-control">
                                        <option value="" selected>Selecciona...</option>
                                        <option value="A">A</option>
                                        <option value="AA">AA</option>
                                        <option value="AC">AC</option>
                                        <option value="AF">AF</option>
                                        <option value="B">B</option>
                                        <option value="BB">BB</option>
                                        <option value="C">C</option>
                                        <option value="CC">CC</option>
                                        <option value="D">D</option>
                                        <option value="DD">DD</option>
                                        <option value="E">E</option>
                                        <option value="EE">EE</option>
                                        <option value="F">F</option>
                                        <option value="FF">FF</option>
                                        <option value="G">G</option>
                                        <option value="GG">GG</option>
                                        <option value="H">H</option>
                                        <option value="HH">HH</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="complemento2">Complemento</label>
                                    <select id="complemento2" name="complemento2" class="form-control ddr_m">
                                        <option value="" selected>Selecciona</option>
                                        <option value="ESTE">Este</option>
                                        <option value="NORTE">Norte</option>
                                        <option value="OESTE">Oeste</option>
                                        <option value="SUR">Sur</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="numero3">Numero:*</label>
                                    <input id="numero3" name="numero3" type="number" class="form-control ddr_m">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="complemento3">Complemento</label>
                                    <select id="complemento3" name="complemento3" class="form-control ddr_m">
                                        <option value="" selected>Selecciona...</option>
                                        <option value="APTO">APTO</option>
                                        <option value="BL">BLOQUE</option>
                                        <option value="MZ">MANZANA</option>
                                        <option value="BG">BODEGA</option>
                                        <option value="P">PISO</option>
                                    </select>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <label for="numero4">Numero:*</label>
                                    <input id="numero4" name="numero4" type="number" class="form-control ddr_m">
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <label for="direccion_final">Direccion ingresada:</label>
                                    <input id="direccion_final" name="direccion_final" type="text" class="form-control" readonly="readonly">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add_direccion">Agregar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('jquery-steps/style.css') }}">
@endpush
@push('javascript')
    <script> let Username =  @json( Auth::user()->username );   const form = $("#create-form"); </script>
    <script type="text/javascript" src="{{ asset('aplicaciones/gestion_terceros/clientes/create.js') }}"></script>
    <script type="text/javascript" src="{{ asset('jquery-steps/jquery.steps.min.js') }}"></script>
@endpush


