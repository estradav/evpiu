@extends('layouts.architectui')

@section('page_title', 'Gestion de Terceros')

@section('content')
   <div class="card">
       <div class="card-header">
           Creacion de clientes
       </div>
       <div class="card-body">
           <div class="col-12">
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
           <br>
           <form id="example-advanced-form" >
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
                           </select>
                       </div>
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

    @push('javascript')
        <script>
            $(document).ready(function () {
                var Username =  @json(Auth::user()->username);
                var form = $("#example-advanced-form");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
                        if (currentIndex > newIndex)
                        {   return true;    }
                        if (newIndex === 3 && Number($("#age-2").val()) < 18)
                        {   return false;   }

                        if (currentIndex < newIndex)
                        {
                            form.find(".body:eq(" + newIndex + ") label.error").remove();
                            console.log(newIndex);
                            form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                        }
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();
                    },
                    onStepChanged: function (event, currentIndex, priorIndex)
                    {
                        if (currentIndex === 2 && Number($("#age-2").val()) >= 18)
                        {   form.steps("next"); }
                        if (currentIndex === 2 && priorIndex === 3)
                        {   form.steps("previous"); }
                    },
                    onFinishing: function (event, currentIndex)
                    {
                        form.validate().settings.ignore = ":disabled";
                        return form.valid();
                    },
                    onFinished: function (event, currentIndex)
                    {
                        var data_form = $('#example-advanced-form').serializeArray();
                        var correos_copia = {
                            name: "Correos_copia", value:  $('#M_correos_copia').val()
                        };

                        var pais = {
                            name: 'pais', value: $('select[name="M_Pais"] option:selected').text()
                        };

                        var departamento = {
                            name: 'departamento', value: $('select[name="M_Departamento"] option:selected').text()
                        };

                        var ciudad = {
                            name: 'ciudad', value: $('select[name="M_Ciudad"] option:selected').text()
                        };

                        var username = {
                            name: 'username', value: Username
                        };

                        data_form.push(correos_copia);
                        data_form.push(pais);
                        data_form.push(departamento);
                        data_form.push(ciudad);
                        data_form.push(username);

                        $.ajax({
                            url: 'save_new_customer',
                            type: 'post',
                            data: data_form,
                            success: function () {
                                $('#exampleModalCenter').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Guardardo',
                                    text: 'El cliente fue creado con exito!',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                });
                                $('#example-advanced-form').trigger("reset");
                            },
                            error: function (data) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.errors,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Aceptar',
                                })
                            }
                        })
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
                        M_tipo_doc: {
                            selectcheck: true
                        },
                        M_tipo_tercero_dms: {
                            selectcheck: true
                        },
                        M_tipo_client_dms: {
                            selectcheck: true
                        },
                        M_tipo_regimen_dms: {
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
                        M_Porcentaje_descuento: {
                            digits: true,
                            max: 100,
                            min: 0
                        },
                        M_actividad_principal: {
                            required: false,
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
                get_paises();
                tipo_cliente();
                getOptionsVendedores();

                function getPlazo(){
                    $.ajax({
                        type: "get",
                        url: 'PedidosGetCondicion',
                        success: function (data) {
                            $('#M_Plazo').append('<option value="" >Seleccione...</option>');
                            for (let j = 0; j <= data.length -1 ; j++) {
                                $('#M_Plazo').append('<option value="'+ data[j].CODE_36.trim() +'" >'+ data[j].DESC_36.trim() +'</option>');
                            }
                        }
                    })
                }

                function getFormaEnvio(){
                    $.ajax({
                        type: "get",
                        url: '/FormaEnvio',
                        success: function (data) {
                            $('#M_Forma_envio').append('<option value="" >Seleccione...</option>');
                            for (let j = 0; j <= data.length -1 ; j++) {
                                $('#M_Forma_envio').append('<option value="'+ data[j].CODE_36.trim() +'" >'+ data[j].DESC_36.trim() +'</option>');
                            }
                        }
                    })
                }

                function tipo_cliente() {
                    $.ajax({
                        type: "get",
                        url: '/get_tipo_cliente',
                        success: function (data) {
                            $('#M_Tipo_cliente').append('<option value="">Seleccione...</option>');
                            for (let j = 0; j <= data.length -1 ; j++) {
                                $('#M_Tipo_cliente').append('<option value="'+data[j].CUSTYP_62 +'">'+data[j].DESC_62+'</option>');
                            }
                        }
                    })
                }

                function get_paises(){
                    $.ajax({
                        type: "get",
                        url: '/get_paises',
                        success: function (data) {
                            console.log(data);
                            $('#M_Pais').append('<option value="">Seleccione...</option>');
                            for (let j = 0; j <= data.length; j++) {
                                $('#M_Pais').append('<option value="'+data[j].pais +'">'+data[j].descripcion+'</option>');
                            }
                        }
                    })
                }

                function validateEmail(email) {
                    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                }

                function getOptionsVendedores(){
                    $.ajax({
                        type: "get",
                        url: '/get_sellerlist',
                        success: function (data) {
                            $('#M_vendedor').append('<option value="" >Seleccione...</option>');
                            for (let j = 0; j <= data.length -1; j++) {
                                $('#M_vendedor').append('<option value="'+ data[j].SLSREP_26.trim() +'" >'+ data[j].SLSNME_26.trim() +'</option>');
                            }
                        }
                    })
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
                            $('#M_Departamento').append('<option value="">Seleccione...</option>');
                            for (let j = 0; j <= data.length -1 ; j++) {
                                $('#M_Departamento').append('<option value="'+data[j].departamento +'">'+data[j].descripcion+'</option>');
                            }
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
                            id_pais: id_pais, id_departamento: id_departamento
                        },
                        success: function (data) {
                            $('#M_Ciudad').append('<option value="">Seleccione...</option>');
                            for (let j = 0; j <= data.length -1; j++) {
                                $('#M_Ciudad').append('<option value="'+data[j].ciudad +'">'+data[j].descripcion+'</option>');
                            }
                        }
                    })
                });

                $('#M_correos_copia').select2({
                    createTag: function(term, data) {
                        const value = term.term;
                        if(validateEmail(value)) {
                            return {
                                id: value, text: value
                            };
                        }
                        return null;
                    },
                    placeholder: "Escribe uno o varios email..",
                    tags: true,
                    tokenSeparators: [',', ' ',';'],
                    width: '100%',
                });

                $('#M_Nit_cc').on('blur',function () {
                    calcular();
                });

                function  calcularDigitoVerificacion ( myNit )  {
                    var vpri, x, y, z;

                    myNit = myNit.replace ( /\s/g, "" ) ; // Espacios
                    myNit = myNit.replace ( /,/g,  "" ) ; // Comas
                    myNit = myNit.replace ( /\./g, "" ) ; // Puntos
                    myNit = myNit.replace ( /-/g,  "" ) ; // Guiones

                    if  ( isNaN ( myNit ) )  {
                        return "" ;
                    }

                    vpri = new Array(16) ;
                    z = myNit.length ;

                    vpri[1]  =  3 ;
                    vpri[2]  =  7 ;
                    vpri[3]  = 13 ;
                    vpri[4]  = 17 ;
                    vpri[5]  = 19 ;
                    vpri[6]  = 23 ;
                    vpri[7]  = 29 ;
                    vpri[8]  = 37 ;
                    vpri[9]  = 41 ;
                    vpri[10] = 43 ;
                    vpri[11] = 47 ;
                    vpri[12] = 53 ;
                    vpri[13] = 59 ;
                    vpri[14] = 67 ;
                    vpri[15] = 71 ;

                    x = 0 ;
                    y = 0 ;
                    for  ( var i = 0; i < z; i++ )  {
                        y = ( myNit.substr (i, 1 ) ) ;
                        x += ( y * vpri [z-i] ) ;
                    }
                    y = x % 11 ;
                    return ( y > 1 ) ? 11 - y : y ;
                }

                function calcular() {
                    let nit = document.getElementById("M_Nit_cc").value;
                    let isNitValid = nit >>> 0 === parseFloat(nit) ? true : false;

                    if ( isNitValid ) {
                        let inputDigVerificacion = document.getElementById("M_Nit_cc_dg");
                        inputDigVerificacion.value = calcularDigitoVerificacion(nit);
                    }
                }

                $('#search_client_max_dms').keyup(function () {
                    var datos = this.value;

                    $.ajax({
                        url:'/clientes/search_client',
                        type:'get',
                        data: {
                           query: datos
                        },
                        success:function (data) {
                            console.log(data)
                            if(data.max >= 1 ){
                                document.getElementById('max_status').className="input-group-text text-success";
                            }else{
                                document.getElementById('max_status').className="input-group-text text-danger";
                            }
                            if(data.dms >= 1){
                                document.getElementById('dms_status').className="input-group-text text-success";
                            }else{
                                document.getElementById('dms_status').className="input-group-text text-danger";
                            }
                        }
                    })
                });
            });
        </script>
        <script src="/jquery-steps/jquery.steps.js"></script>
        <script src="/jquery-steps/jquery.steps.min.js"> </script>
        <link rel="stylesheet" href="/jquery-steps/style.css">
    @endpush
@endsection
