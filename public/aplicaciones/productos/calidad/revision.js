$(document).ready(function (){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#search_button', function () {
        let production_order = document.getElementById('search').value;


        if (production_order !== ''){
            $('#result_search').html('').append(`
                <div id="loader-wrapper">
                    <div id="loader"></div>
                </div>
                <h4 class="text-center">Recuperando informacion, un momento por favor...</h4>
            `);



            $.ajax({
                url: '/aplicaciones/productos/calidad/revision/consultar_op',
                type: 'get',
                data: {
                    production_order: production_order
                },
                success: function (data) {
                    if (!data.data_max){
                        $('#result_search').html('').append(`
                            <div class="alert alert-warning text-center" role="alert">
                                <h4 class="alert-heading text-center">
                                    <i class="fas fa-exclamation-triangle fa-4x"></i><br>
                                    <b>¡No se encontro infomacion!</b>
                                </h4>
                                <h5>Por favor verifique que el numero de la orden de produccion sea correcto!</h5>
                            </div>
                        `);
                    }else{
                        $('#result_search').html('').append(`
                            <div class="row justify-content-center mb-2">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <h5 class="text-center"><b> ORDER DE PRODUCCION</b></h5>
                                    <h5 class="text-center"><b>`+ production_order +`</b></h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <h6><b>PIEZA: </b>`+ data.data_max.PRTNUM_14 +`</h6>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <h6><b>DESCRIPCION: </b>`+ data.data_max.PMDES1_01 +`</h6>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <h6><b>ORDEN VENTA: </b>`+ data.data_max.OV +`</h6>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3">
                                    <h6><b>ARTE: </b> <a href="javascript:void(0)" class="ver_arte" id="`+ data.data_max.UDFREF_10 +`">`+ data.data_max.UDFREF_10 +`</a></h6>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div id="accordion" class="accordion">

                                    </div>
                                </div>
                            </div>
                        `);




                        for (let i = 0; i < data.centros.length; i++) {

                            $('.accordion').append(`
                                <h3>`+ data.centros[i] +` - `+ get_description(data.centros[i]) +`</h3>
                                <div>
                                    <button class="btn btn-success btn-sm add_review" id="`+ production_order +`" name="`+ data.centros[i] +`"> <i class="fas fa-plus-circle"></i> Agregar</button>
                                    <hr>
                                    <div class="table-resposive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">CANT. INSPECCIONADA</th>
                                                    <th scope="col">CANT. CONFORME</th>
                                                    <th scope="col">CANT. NO CONFORME</th>
                                                    <th scope="col">OPERARIO</th>
                                                    <th scope="col">INSPECTOR</th>
                                                    <th scope="col">ACCIONES</th>
                                                </tr>
                                            </thead>
                                            <tbody id="`+ data.centros[i] +`">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            `);

                            let centro = data.centros[i];


                            if (data.registros[centro]){
                                for (let j = 0; j < data.registros[centro].length; j++) {
                                    $('#'+centro+'').append(`
                                        <tr>
                                            <td>`+ data.registros[centro][j].quantity_inspected +`</td>
                                            <td>`+ data.registros[centro][j].conforming_quantity +`</td>
                                            <td>`+ data.registros[centro][j].non_conforming_quantity +`</td>
                                            <td>`+ data.registros[centro][j].operator.name +`</td>
                                            <td>`+ data.registros[centro][j].inspector.name +`</td>
                                            <td>
                                                <button type="button" class="btn btn-secondary info_review" id="`+ data.registros[centro][j].id +`">Info</button>
                                            </td>
                                        </tr>
                                    `);
                                }
                            }else{
                                $('#'+centro+'').append(`
                                    <tr>
                                        <td colspan="6" class="text-center">Aun no se registran revisiones en este centro de trabajo!</td>
                                    </tr>
                                `);
                            }

                        }
                    }

                    $( "#accordion" ).accordion({
                        collapsible: true
                    });

                },
                error: function(jqXHR, textStatus, err){
                    console.log('text status '+textStatus+', err '+err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Aceptar',
                    })
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '¡Debes escribir el numero de la orden de produccion..!',
            });
        }
    });


    function get_description(string){
        var theResponse = null;

        $.ajax({
            url: '/aplicaciones/productos/calidad/revision/consultar_descripcion_centro_trabajo',
            type: 'get',
            async: false,
            data: {
                string: string
            },
            success: function(respText) {
                theResponse = respText;
            },
            error: function (data){
                console.log('error');
                return result
            }
        });
        return theResponse;
    }


    $(document).on('click', '.add_review', function (){
        let production_order = this.id;
        let center = this.name;
        document.getElementById('new_review_modal_title').innerText = center + ' - ' + get_description(center);
        document.getElementById('production_order').value = production_order+'0000';
        document.getElementById('center').value = center;
        $('#new_review_modal').modal('show');
    });


    $('#new_review_modal_form').validate({
        ignore: "",
        rules: {
            quantity_inspected: {
                required: true,
                digits: true,
                min: 1,
            },
            conforming_quantity: {
                required: true,
                digits: true,
                min: 1,
            },
            non_conforming_quantity: {
                required: true,
                digits: true,
                min: 1,
            },
            cause: {
                select_check: true
            },
            operator_id: {
                select_check: true
            },
            non_compliant_treatment: {
                required: true
            },
            action: {
                required: true
            },
            observation: {
                required: true
            },
            center: {
                select_check: true
            }
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                url: '/aplicaciones/productos/calidad/revision/guardar',
                type: 'post',
                data: $('#new_review_modal_form').serialize(),
                dataType: 'json',
                success:function (data){
                    $('#new_review_modal_form').trigger('reset');
                    $('#new_review_modal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Completado!',
                        text: data
                    });
                    $('#search_button').click();
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data.responseText
                    });
                }
            });
        }
    });


    $(document).on('click', '.info_review', function (){
        let id = this.id;
        $.ajax({
            url: '/aplicaciones/productos/calidad/revision/info_review',
            type: 'get',
            data: {
                id: id
            },
            success: function (data) {
                document.getElementById('review_info_modal_title').innerText = 'Info revision';

                $('#review_info_modal_body').html('').append(`
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">OPERARIO</span> <br>
                            <span class="text-muted">`+ data.operator.name +`</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">INSPECTOR</span> <br>
                            <span class="text-muted">`+ data.inspector.name +`</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">CANT. INSPECCIONADA</span> <br>
                            <span class="text-muted">`+ data.quantity_inspected +`</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">CANT. CONFORME</span> <br>
                            <span class="text-muted">`+ data.conforming_quantity +`</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">CANT. NO CONFORME</span> <br>
                            <span class="text-muted">`+ data.non_conforming_quantity +`</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">CAUSA</span> <br>
                            <span class="text-muted">`+ data.cause +`</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">TRATAMIENTO A LA NO CONFORMIDAD</span> <br>
                            <span class="text-muted">`+ data.non_compliant_treatment +`</span>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                            <span class="badge badge-secondary">ACCION TOMADA</span> <br>
                            <span class="text-muted">`+ data.action +`</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <span class="badge badge-secondary">OBSERVACIONES</span> <br>
                            <span class="text-muted">`+ data.observation +`</span>
                        </div>
                    </div>
               `);
                $('#review_info_modal').modal('show');

            },
            error: function(jqXHR, textStatus, err){
                console.log('text status '+textStatus+', err '+err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: err,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                })
            }
        });

    });


    $(document).on('click', '.ver_arte', function() {
        let Art = this.id;
        $('#ViewArtTitle').html('Arte #'+ Art);
        PDFObject.embed("http://192.168.1.12/intranet_ci/assets/Artes/"+Art+".pdf", "#ViewArtPdf");
        $('#ViewArtModal').modal('show');
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


    jQuery.validator.addMethod("select_check", function(value){
        return (value != '');
    }, "Por favor, seleciona una opcion.");
});
