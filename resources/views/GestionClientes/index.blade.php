@extends('layouts.dashboard')

@section('page_title', 'Gestion de Terceros')

@section('module_title', 'Gestion de Terceros')

@section('subtitle', 'Este modulo permite Actualizar y Crear Clientes tanto en MAX como en DMS de forma simultanea.')

{{--@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@sto--}}

@section('content')
    @can('gestion_clientes.view')
        <div class="card">
            <div class="card-header">
                Clientes
                <a class="right InfoCustomersTooltip" title="" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Esta tabla muestra los clientes que existen tanto en MAX como en DMS">
                  <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                </a>

                <div class="col-md-0 float-right">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenter" style="align-items: flex-end">
                        <i class="fas fa-user-plus"></i>  Crear Cliente
                    </button>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped CustomerTable" id="CustomerTable">
                        <thead>
                            <tr>
                                <th>Codigo Cliente</th>
                                <th>Razon social</th>
                                <th>Nit/CC</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 ">
                <div class="card">
                    <div class="card-header">
                        Clientes MAX
                        <a class="right InfoCustomersTooltip" title="" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Esta tabla muestra los clientes que solo existen en MAX">
                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped ClientsMax" id="ClientsMax">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Razon social</th>
                                    <th>Nit/CC</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 ">
                <div class="card">
                    <div class="card-header">
                        Clientes DMS
                        <a class="right InfoCustomersTooltip" title="" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Esta tabla muestra los clientes que solo existen en DMS">
                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-striped ClientsDMS" id="ClientsDMS">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Razon social</th>
                                    <th>Nit/CC</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
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

        <div class="modal fade bd-example-modal-xl ModalClient" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="example-advanced-form" action="#">
                            <h3>Cliente</h3>
                            <fieldset>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion del cliente</legend>
                                    <div class="col-sm-3">
                                        <label for="M_nombre">Nombre: *</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Nombre del cliente o razon social">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_nombre" name="M_nombre" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Razon_comercial">Razon comercial:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Nombre como comunmente se conoce a la empresa">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Razon_comercial" name="M_Razon_comercial" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_direccion1">Direccion 1:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Direccion principal del cliente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_direccion1" name="M_direccion1" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_direccion2">Direccion 2:</label>
                                        <input id="M_direccion2" name="M_direccion2" type="text" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="M_Pais">Pais:</label>
                                        <select id="M_Pais" name="M_Pais" class="form-control"></select>
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
                                        <input id="M_Email_contacto" name="M_Email_contacto" type="email" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="M_Email_facturacion">E-mail Facturacion:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Email principal para envio de facturacion electronica">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Email_facturacion" name="M_Email_facturacion" type="email" class="form-control required" onkeyup="this.value=this.value.toUpperCase();">
                                    </div>
                                </div>
                            </fieldset>

                            <h3>Informacion adicional</h3>
                            <fieldset>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion adicional</legend>
                                    <div class="col-sm-3">
                                        <label for="M_Forma_envio">Forma de envio:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Forma en la que sera entregada la mercancia al cliente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_Forma_envio" id="M_Forma_envio" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_FOB">FOB:</label>
                                        <input id="M_FOB" name="M_FOB" type="text" class="form-control required">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Enviar_a:">Enviar a:</label>
                                        <input id="M_Enviar_a" name="M_Enviar_a" type="text" class="form-control required">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Enviar_a_travez_de:">Enviar a travez de:</label>
                                        <input id="M_Enviar_a_travez_de" name="M_Enviar_a_travez_de" type="text" class="form-control required">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Informacion fiscal</legend>
                                    <div class="col-sm-3">
                                        <label for="M_Gravado">Gravado:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Selecciona 'si' si el cliente es responsable de IVA">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_Gravado" id="M_Gravado" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="Y">Si</option>
                                            <option value="N">No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Codigo_fiscal_1">Codigo fiscal 1:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Codigo fiscal (Se puede consultar de MAX)">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Codigo_fiscal_1" name="M_Codigo_fiscal_1" type="number" class="form-control required">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Codigo_fiscal_2">Codigo fiscal 2:</label>
                                        <input id="M_Codigo_fiscal_2" name="M_Codigo_fiscal_2" type="number" class="form-control required">
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Nit_cc">NIT/CC:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Escribe el nit o numero de cedula del cliente y en la casilla siguiente el digito de verificacion">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <div class="input-group">
                                            <input id="M_Nit_cc" name="M_Nit_cc" type="number" class="form-control required" style="width: 60%">
                                            <input id="M_Nit_cc_dg" name="M_Nit_cc_dg" type="number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <legend style="margin-left: 17px !important;">Finanzas</legend>
                                    <div class="col-sm-3">
                                        <label for="M_Plazo">Plazo:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Plazo de pago para las compras">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <select name="M_Plazo" id="M_Plazo" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="M_Porcentaje_descuento">Porcentaje descuento:</label>
                                        <a class="right ModalTooltip" rel="tooltip" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Porcentaje de descuento acordado para el cliente">
                                            <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                                        </a>
                                        <input id="M_Porcentaje_descuento" name="M_Porcentaje_descuento" type="number" class="form-control required">
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
                                        <input id="M_responsable_fe" name="M_responsable_fe" type="text" class="form-control">
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
                                        <input id="M_grupo_economico" name="M_grupo_economico" type="text" class="form-control">
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
                                        <select id="M_Tipo_cliente" name="M_Tipo_cliente" class="form-control"></select>
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
        <style>
            .wizard,
            .tabcontrol {
                display: block;
                width: 100%;
                overflow: hidden;
            }

            .wizard a,
            .tabcontrol a {
                outline: 0;
            }

            .wizard ul,
            .tabcontrol ul {
                list-style: none !important;
                padding: 0;
                margin: 0;
            }

            .wizard ul > li,
            .tabcontrol ul > li {
                display: block;
                padding: 0;
            }


            /* Accessibility */

            .wizard > .steps .current-info,
            .tabcontrol > .steps .current-info {
                position: absolute;
                left: -999em;
            }

            .wizard > .content > .title,
            .tabcontrol > .content > .title {
                position: absolute;
                left: -999em;
            }


            /*
                Wizard
            */

            .wizard > .steps {
                position: relative;
                display: block;
                width: 100%;
            }

            .wizard.vertical > .steps {
                display: inline;
                float: left;
                width: 30%;
            }

            .wizard > .steps .number {
                font-size: 1.429em;
            }

            .wizard > .steps > ul > li {
                width: 25%;
            }

            .wizard > .steps > ul > li,
            .wizard > .actions > ul > li {
                float: left;
            }

            .wizard.vertical > .steps > ul > li {
                float: none;
                width: 100%;
            }

            .wizard > .steps a,
            .wizard > .steps a:hover,
            .wizard > .steps a:active {
                display: block;
                width: auto;
                margin: 0 0.5em 0.5em;
                padding: 1em 1em;
                text-decoration: none;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }

            .wizard > .steps .disabled a,
            .wizard > .steps .disabled a:hover,
            .wizard > .steps .disabled a:active {
                background: #eee;
                color: #aaa;
                cursor: default;
            }

            .wizard > .steps .current a,
            .wizard > .steps .current a:hover,
            .wizard > .steps .current a:active {
                background: #110f2c;
                color: #fff;
                cursor: default;
            }

            .wizard > .steps .done a,
            .wizard > .steps .done a:hover,
            .wizard > .steps .done a:active {
                background: #424d90;
                color: #fff;
            }

            .wizard > .steps .error a,
            .wizard > .steps .error a:hover,
            .wizard > .steps .error a:active {
                background: #8a1f11;
                color: #fff;
            }

            .wizard > .content {
                background: #eee;
                display: block;
                margin: 0.5em;
                min-height: 35em;
                overflow: hidden;
                position: relative;
                width: auto;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }

            .wizard.vertical > .content {
                display: inline;
                float: left;
                margin: 0 2.5% 0.5em 2.5%;
                width: 65%;
            }

            .wizard > .content > .body {
                float: left;
                position: relative;
                width: 95%;
                height: 95%;
                padding: 2.5%;
            }

            .wizard > .content > .body ul {
                list-style: disc !important;
            }

            .wizard > .content > .body ul > li {
                display: list-item;
            }

            .wizard > .content > .body > iframe {
                border: 0 none;
                width: 100%;
                height: 100%;
            }

            .wizard > .content > .body input {
                display: block;
                border: 1px solid #ccc;
            }

            .wizard > .content > .body input[type="checkbox"] {
                display: inline-block;
            }

            .wizard > .content > .body input.error {
                background: rgb(251, 227, 228);
                border: 1px solid #fbc2c4;
                color: #8a1f11;
            }

            .wizard > .content > .body label {
                display: inline-block;
                margin-bottom: 0.5em;
            }

            .wizard > .content > .body label.error {
                color: #8a1f11;
                display: -moz-inline-block;
                margin-left: 0.1em;
            }

            .wizard > .actions {
                position: relative;
                display: block;
                text-align: right;
                width: 100%;
            }

            .wizard.vertical > .actions {
                display: inline;
                float: right;
                margin: 0 2.5%;
                width: 95%;
            }

            .wizard > .actions > ul {
                display: inline-block;
                text-align: right;
            }

            .wizard > .actions > ul > li {
                margin: 0 0.5em;
            }

            .wizard.vertical > .actions > ul > li {
                margin: 0 0 0 1em;
            }

            .wizard > .actions a,
            .wizard > .actions a:hover,
            .wizard > .actions a:active {
                background: #110f2c;
                color: #fff;
                display: block;
                padding: 0.5em 1em;
                text-decoration: none;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
            }

            .wizard > .actions .disabled a,
            .wizard > .actions .disabled a:hover,
            .wizard > .actions .disabled a:active {
                background: #eee;
                color: #aaa;
            }

            .wizard > .loading {}

            .wizard > .loading .spinner {}


            /*
                Tabcontrol
            */

            .tabcontrol > .steps {
                position: relative;
                display: block;
                width: 100%;
            }

            .tabcontrol > .steps > ul {
                position: relative;
                margin: 6px 0 0 0;
                top: 1px;
                z-index: 1;
            }

            .tabcontrol > .steps > ul > li {
                float: left;
                margin: 5px 2px 0 0;
                padding: 1px;
                -webkit-border-top-left-radius: 5px;
                -webkit-border-top-right-radius: 5px;
                -moz-border-radius-topleft: 5px;
                -moz-border-radius-topright: 5px;
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
            }

            .tabcontrol > .steps > ul > li:hover {
                background: #edecec;
                border: 1px solid #bbb;
                padding: 0;
            }

            .tabcontrol > .steps > ul > li.current {
                background: #fff;
                border: 1px solid #bbb;
                border-bottom: 0 none;
                padding: 0 0 1px 0;
                margin-top: 0;
            }

            .tabcontrol > .steps > ul > li > a {
                color: #5f5f5f;
                display: inline-block;
                border: 0 none;
                margin: 0;
                padding: 10px 30px;
                text-decoration: none;
            }

            .tabcontrol > .steps > ul > li > a:hover {
                text-decoration: none;
            }

            .tabcontrol > .steps > ul > li.current > a {
                padding: 15px 30px 10px 30px;
            }

            .tabcontrol > .content {
                position: relative;
                display: inline-block;
                width: 100%;
                height: 35em;
                overflow: hidden;
                border-top: 1px solid #bbb;
                padding-top: 20px;
            }

            .tabcontrol > .content > .body {
                float: left;
                position: absolute;
                width: 95%;
                height: 95%;
                padding: 2.5%;
            }

            .tabcontrol > .content > .body ul {
                list-style: disc !important;
            }

            .tabcontrol > .content > .body ul > li {
                display: list-item;
            }



        </style>

    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar los clientes.
        </div>
    @endcan
    @push('javascript')
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.CustomerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    width:"100%",
                    ajax: {
                        url: '/GestionClientes_Index'
                    },
                    columns: [
                        {data:'CodigoMAX', name:'CodigoMAX'},
                        {data:'NombreMAX', name:'NombreMAX'},
                        {data:'NITMAX', name:'NITMAX'},
                        {data:'EstadoMAX', name:'EstadoMAX', orderable:false, searchable:false},
                        {data:'opciones', name:'opciones', orderable:false, searchable:false},
                    ],
                    columnDefs: [
                        {
                        	width: "25%",
                            targets: 0
                        }
                    ],
                    language: {
                        processing: "Procesando...",
                        search: "Buscar&nbsp;:",
                        lengthMenu: "Mostrar _MENU_ registros",
                        info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                        infoFiltered: "(filtrado de un total de _MAX_ registros)",
                        infoPostFix: "",
                        loadingRecords: "Cargando...",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "Ningún registro disponible en esta tabla :C",
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
                    },
                    rowCallback: function (row, data, index) {
                        if(data.estado == 'R'){
                            $(row).find('td:eq(3)').html('<label class="text-danger">Retenido</label>');
                        }else{
                            $(row).find('td:eq(3)').html('<label class="text-success">Liberado</label>');
                        }
                    }
                });

                $('.InfoCustomersTooltip').tooltip();

                $('.ModalTooltip').tooltip({
                    appendTo: "##exampleModalCenter"
                });



                var form = $("#example-advanced-form");
                $.extend($.validator.messages, {
                    required: "Este campo es obligatorio.",
                    remote: "Por favor, rellena este campo.",
                    email: "Por favor, escribe una dirección de correo válida.",
                    url: "Por favor, escribe una URL válida.",
                    date: "Por favor, escribe una fecha válida.",
                    dateISO: "Por favor, escribe una fecha (ISO) válida.",
                    number: "Por favor, escribe un número válido.",
                    digits: "Por favor, escribe sólo dígitos.",
                    creditcard: "Por favor, escribe un número de tarjeta válido.",
                    equalTo: "Por favor, escribe el mismo valor de nuevo.",
                    extension: "Por favor, escribe un valor con una extensión aceptada.",
                    maxlength: $.validator.format( "Por favor, no escribas más de {0} caracteres." ),
                    minlength: $.validator.format( "Por favor, no escribas menos de {0} caracteres." ),
                    rangelength: $.validator.format( "Por favor, escribe un valor entre {0} y {1} caracteres." ),
                    range: $.validator.format( "Por favor, escribe un valor entre {0} y {1}." ),
                    max: $.validator.format( "Por favor, escribe un valor menor o igual a {0}." ),
                    min: $.validator.format( "Por favor, escribe un valor mayor o igual a {0}." ),
                    nifES: "Por favor, escribe un NIF válido.",
                    nieES: "Por favor, escribe un NIE válido.",
                    cifES: "Por favor, escribe un CIF válido."
                });

                form.steps({
                    labels: {
                    	next: "Siguiente",
                        previous: "Anterior",
                        loading: "Cargando...",
                        finish: "Guardar Cliente"
                    },
                    headerTag: "h3",
                    bodyTag: "fieldset",
                    transitionEffect: "fade",
                    onStepChanging: function (event, currentIndex, newIndex)
                    {
                        // Allways allow previous action even if the current form is not valid!
                        if (currentIndex > newIndex)
                        {
                            return true;
                        }
                        // Forbid next action on "Warning" step if the user is to young
                        if (newIndex === 3 && Number($("#age-2").val()) < 18)
                        {
                            return false;
                        }
                        // Needed in some cases if the user went back (clean up)
                        if (currentIndex < newIndex)
                        {
                            // To remove error styles
                            form.find(".body:eq(" + newIndex + ") label.error").remove();
                            console.log(newIndex);
                            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                        }
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onStepChanged: function (event, currentIndex, priorIndex)
                    {
                        // Used to skip the "Warning" step if the user is old enough.
                        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
                        {
                            form.steps("next");
                        }
                        // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                        if (currentIndex === 2 && priorIndex === 3)
                        {
                            form.steps("previous");
                        }
                    },
                    onFinishing: function (event, currentIndex)
                    {
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    },
                    onFinished: function (event, currentIndex)
                    {
                    	var fob = $('#M_FOB').val();
                        alert('Este es el valor de Fob: '+fob)
                    }
                }).validate({
                    errorPlacement: function errorPlacement(error, element)
                    { element.after(error); },
                    rules: {
                        M_nombre: {
                            required: true,
                            minlength: 4,
                            maxlength: 60,
                        },
                        M_direccion1: {
                        	required: true,
                            minlength: 8,
                            maxlength: 60
                        },
                        M_direccion2: {
                            required: false,
                            minlength: 8,
                            maxlength: 60
                        },
                        M_Codigo_postal: {
                        	required: false,
                            minlength: 4,
                            maxlength: 9
                        },
                        M_Pais: {
                            selectcheck: true
                        },
                        M_Departamento: {
                            selectcheck: true
                        },
                        M_Ciudad: {
                            selectcheck: true
                        },
                        M_Contacto: {
                            required: true,
                            minlength: 4,
                            maxlength: 40,
                        },
                        M_Telefono: {
                            required: true,
                            minlength: 4,
                            maxlength: 20,
                            digits: true
                        },
                        M_Telefono2: {
                            required: false,
                            minlength: 4,
                            maxlength: 20,
                            digits: true
                        },
                        M_Celular: {
                            required: false,
                            minlength: 4,
                            maxlength: 20,
                            digits: true
                        },
                        M_Email_contacto: {
                            Emailcheck: true
                        },
                        M_Email_facturacion: {
                            Emailcheck: true
                        },
                        M_FOB: {
                        	required: false,
                        },
                        M_Porcentaje_descuento: {
                            digits: true,
                            max: 100,
                            min: 0
                        },
                        M_Enviar_a: {
                        	required: false
                        },
                        M_Enviar_a_travez_de: {
                            required: false
                        },
                        M_Codigo_fiscal_1: {
                        	required: true,
                            maxlength: 7,
                            minlength: 3
                        },
                        M_Codigo_fiscal_2: {
                            required: false,
                            maxlength: 7,
                            minlength: 3
                        },
                        M_Nit_cc: {
                        	minlength: 5,
                            required: true
                        },
                        M_Forma_envio: {
                            selectcheck: true
                        },
                        M_Plazo: {
                            selectcheck: true
                        },
                        M_Gravado: {
                            selectcheck: true
                        },
                        M_Moneda: {
                            selectcheck: true
                        },
                        M_Tipo_cliente: {
                            selectcheck: true
                        }

                    },
                    messages:{
                        M_Nit_cc: "",
                        M_Nit_cc_dg: "",
                        acceptTerms: ""
                    },
                    errorElement: 'label',
                    errorLabelContainer: '.errorTxt'
                });
                getPlazo();
                getFormaEnvio();
                function getPlazo(){
                    $.ajax({
                        type: "get",
                        url: 'PedidosGetCondicion',
                        success: function (data) {
                            var i = 0;
                            $('#M_Plazo').append('<option value="" >Seleccione...</option>');
                            $(data).each(function (){
                                $('#M_Plazo').append('<option value="'+ data[i].DESC_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                                i++
                            });
                        }
                    })
                }

                function getFormaEnvio(){
                    $.ajax({
                        type: "get",
                        url: '/FormaEnvio',
                        success: function (data) {
                            var i = 0;
                            $('#M_Forma_envio').append('<option value="" >Seleccione...</option>');
                            $(data).each(function (){
                                $('#M_Forma_envio').append('<option value="'+ data[i].DESC_36.trim() +'" >'+ data[i].DESC_36.trim() +'</option>');
                                i++
                            });
                        }
                    })
                }

                $('#M_correos_copia').select2({
                    createTag: function(term, data) {
                        var value = term.term;
                        if(validateEmail(value)) {
                            return {
                                id: value,
                                text: value

                            };
                        }
                        return null;
                    },
                    placeholder: "Escribe uno o varios email..",
                    tags: true,
                    tokenSeparators: [',', ' ',';'],
                    width: '100%',
                });


                function get_paises(){
                    $.ajax({
                        type: "get",
                        url: '/get_paises',
                        success: function (data) {
                            var i = 0;
                            $('#M_Pais').append('<option value="">Seleccione...</option>');
                            $(data).each(function () {
                                $('#M_Pais').append('<option value="'+data[i].pais +'">'+data[i].descripcion+'</option>');
                                i++;
                            });
                        }
                    })
                }

                get_paises();

                function validateEmail(email) {
                    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                }

                jQuery.validator.addMethod("selectcheck", function(value){
                    return (value != '');
                }, "Por favor, seleciona una opcion.");

                jQuery.validator.addMethod("Emailcheck", function (value) {
                    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(value);
                }, "Por favor, escribe una dirección de correo válida.");

                $('#M_Pais').on( "change", function() {
                    $('#M_Departamento').html('');
                    $('#M_Ciudad').html('');
                    var id_pais = $('#M_Pais').val();
                    $.ajax({
                        type: "get",
                        url: '/get_departamentos',
                        data: {id_pais: id_pais},
                        success: function (data) {
                            var i = 0;
                            $('#M_Departamento').append('<option value="">Seleccione...</option>');
                            $(data).each(function () {
                                $('#M_Departamento').append('<option value="'+data[i].departamento +'">'+data[i].descripcion+'</option>');
                                i++;
                            });
                        }
                    })
                });

                $('#M_Departamento').on("change", function () {
                    $('#M_Ciudad').html('');
                    var id_pais = $('#M_Pais').val();
                    var id_departamento = $('#M_Departamento').val();
                    $.ajax({
                        type: "get",
                        url: '/get_ciudades',
                        data: {
                            id_pais: id_pais,
                            id_departamento: id_departamento
                        },
                        success: function (data) {
                            var i = 0;
                            $('#M_Ciudad').append('<option value="">Seleccione...</option>');
                            $(data).each(function () {
                                $('#M_Ciudad').append('<option value="'+data[i].ciudad +'">'+data[i].descripcion+'</option>');
                                i++;
                            });
                        }
                    })
                });
                tipo_cliente();

                function tipo_cliente() {
                    $.ajax({
                        type: "get",
                        url: '/get_tipo_cliente',
                        success: function (data) {
                            var i = 0;
                            $('#M_Tipo_cliente').append('<option value="">Seleccione...</option>');
                            $(data).each(function () {
                                $('#M_Tipo_cliente').append('<option value="'+data[i].CUSTYP_62 +'">'+data[i].DESC_62+'</option>');
                                i++;
                            });
                        }
                    })
                }
                loadClientesFaltantesDms();

                function IgualarDivs(){
                    var altura_arr = [];
                    $('.igualar').each(function(){
                        var altura = $(this).height();
                        altura_arr.push(altura);
                    });
                    altura_arr.sort(function(a, b){return b-a});
                    $('.igualar').each(function(){
                        $(this).css('height',altura_arr[0]);
                    });
                }

                function loadClientesFaltantesDms()
                {
                    $('.ClientsMax').DataTable({
                        processing: true,
                        serverSide: true,
                        responsive: false,
                        autoWidth: false,
                        width:"100%",
                        ajax: {
                            url: '/ClientesFaltantesDMS'
                        },
                        columns: [
                            {data:'CodigoMAX', name:'CodigoMAX'},
                            {data:'NombreMAX', name:'NombreMAX'},
                            {data:'NITMAX', name:'NITMAX'},
                            {data:'EstadoMAX', name:'EstadoMAX', orderable:false, searchable:false},
                            {data:'opciones', name:'opciones', orderable:false, searchable:false},
                        ],

                        language: {
                            processing: "Procesando...",
                            search: "Buscar&nbsp;:",
                            lengthMenu: "Mostrar _MENU_ registros",
                            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            infoFiltered: "(filtrado de un total de _MAX_ registros)",
                            infoPostFix: "",
                            loadingRecords: "Cargando...",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "Ningún registro disponible en esta tabla :C",
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
                        },
                        rowCallback: function (row, data, index) {
                            if(data.estado == 'R'){
                                $(row).find('td:eq(3)').html('<label class="text-danger">Retenido</label>');
                            }else{
                                $(row).find('td:eq(3)').html('<label class="text-success">Liberado</label>');
                            }
                        }
                    });
                }

                IgualarDivs();


                $('.ModalClient a[rel="tooltip"]')
                    .tooltip({placement: 'right'})
                    .data('tooltip')
                    .tip()
                    .css('z-index',2080);

            });
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
        <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">


        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

        <script src="/jquery-steps/jquery.steps.js"></script>





    @endpush
@stop
