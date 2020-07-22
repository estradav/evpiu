$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let star_date = moment().format('YYYY-MM-DD 00:00:00'), end_date = moment().format('YYYY-MM-DD 23:59:59');
    moment.locale('es');


    $('#table').dataTable({
        language:{
            url: '/Spanish.json'
        },
        columns: [
            { "orderable": false, "searchable": true },
            { "orderable": true, "searchable": true },
            { "orderable": true, "searchable": true },
            { "orderable": true, "searchable": true },
            { "orderable": true, "searchable": false },
            { "orderable": true, "searchable": false },
            { "orderable": false, "searchable": false },
            { "orderable": false, "searchable": false },
            { "orderable": false, "searchable": false },
            { "orderable": false, "searchable": false },
        ],
        order: [
            [ 0, "desc" ]
        ]
    });


    $(document).on('click', '.cartera', function () {
        let id_val = this.id;
        id_val = id_val.split(',');

        let id = id_val[0];
        let estado = parseInt(id_val[1]);

        if (estado === 1 || estado === 4){
            Swal.fire({
                icon: 'question',
                title: '¿Enviar a cartera?',
                html: "Una vez enviado el RC a cartera no podra editarlo. <br> ¿Desea continuar?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, enviar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/aplicaciones/recibos_caja/cambiar_estado',
                        type: 'post',
                        data: {
                            id:id,
                            estado: 2
                        },
                        success:function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Enviado a cartera',
                                text: data,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                            });
                            window.location.reload(true);
                        },
                        error: function (data) {
                            console.log(data)
                        }
                    });
                }
            });
        }else if (estado === 2){
            Swal.fire({
                icon: 'error',
                title: 'RC en cartera',
                text: 'Este RC ya fue enviado a cartera',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            });

        }else if (estado === 3){
            Swal.fire({
                icon: 'error',
                title: 'RC finalizado',
                text: 'Este RC ya fue validado por cartera y subido a DMS',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'RC anulado',
                text: 'Solo puedes enviar RC a cartera si esta en estado Borrador',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            });
        }
    });


    $(document).on('click', '.anular', function () {
        let id_val = this.id;
        id_val = id_val.split(',');

        let id = id_val[0];
        let estado = parseInt(id_val[1]);

        if (estado === 1 || estado === 4){
            Swal.fire({
                icon: 'question',
                title: '¿Anular?',
                text: "¿Esta seguro de anular este RC?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, anular!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/aplicaciones/recibos_caja/cambiar_estado',
                        type: 'post',
                        data: {
                            id:id,
                            estado: 0
                        },
                        success:function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Enviado a cartera',
                                text: data,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                            });
                            window.location.reload(true);
                        },
                        error: function (data) {
                            console.log(data)
                        }
                    });
                }
            });
        }else if (estado === 2){
            Swal.fire({
                icon: 'error',
                title: 'RC en cartera',
                text: 'Este RC ya fue enviado a cartera y no puede ser anulado',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            });

        }else if (estado === 3){
            Swal.fire({
                icon: 'error',
                title: 'RC finalizado',
                text: 'Este RC ya fue validado por cartera y subido a DMS y no puede ser anulado',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'RC anulado',
                text: 'Este RC ya esta anulado',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
            });
        }
    });


    $(document).on('click', '.ver', function () {
        const id = this.id;
        console.log(id);
        $.ajax({
            url: '/aplicaciones/recibos_caja/consultar_recibo',
            type: 'get',
            data: { id: id },
            success: function (data) {
                const enc = data.enc;
                const det = data.det;
                const formatter = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 0
                });

                $('#ver_modal_title').html('').html('RC # '+id);

                $('#ver_modal_body').html('').append(`
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                    <b>CLIENTE:</b>
                                    `+ enc.customer +`
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                                    <b>NIT:</b>
                                    `+ enc.nit +`
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                                    <b>FECHA CREACION:</b>
                                    `+ enc.created_at +`
                                </div>
                                <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
                                    <b>TOTAL RC:</b>
                                    `+ formatter.format(enc.total )+`
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NUMERO</th>
                                        <th scope="col">BRUTO</th>
                                        <th scope="col">DESCUENTO</th>
                                        <th scope="col">RETENCION</th>
                                        <th scope="col">RETEIVA</th>
                                        <th scope="col">RETEICA</th>
                                        <th scope="col">OTRAS DEDUCCIONES</th>
                                        <th scope="col">OTROS INGRESOS</th>
                                        <th scope="col">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="table_itm">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8 text-center" >
                            <b> COMENTARIOS:</b> <br>
                            `+ enc.comments +`
                        </div>
                    </div>
                `);

                for (let i = 0; i < det.length; i++) {
                    $('#table_itm').append(`
                        <tr>
                            <td>`+ det[i].invoice +`</td>
                            <td>`+ formatter.format(det[i].bruto) +`</td>
                            <td>`+ formatter.format(det[i].descuento) +`</td>
                            <td>`+ formatter.format(det[i].retencion) +`</td>
                            <td>`+ formatter.format(det[i].reteiva) +`</td>
                            <td>`+ formatter.format(det[i].reteica) +`</td>
                            <td>`+ formatter.format(det[i].otras_deduc) +`</td>
                            <td>`+ formatter.format(det[i].otros_ingre) +`</td>
                            <td>`+ formatter.format(det[i].total) +`</td>
                        </tr>
                    `);
                }
                $('#ver_modal').modal('show');
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al obtener datos',
                    text: data,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar',
                });
            }
        });
    });

    $('input[id="rc_valores_filter"]').daterangepicker({
        drops: 'down',
        open: 'center',
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
            'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
    }, function(start, end, label) {
        star_date = start.format('YYYY-MM-DD 00:00:00');
        end_date = end.format('YYYY-MM-DD 23:59:59');
    });


    const formatter = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2
    });


    $(document).on('click', '#filtrar_rc', function () {
        $.ajax({
            url: '/aplicaciones/recibos_caja/datos_rc_informe',
            type: 'get',
            data: {
                star_date: star_date,
                end_date: end_date
            },
            success: function (data) {
                if (data.rc.length === 0){
                    $('#data_datos_rc_informe').empty().append(`
                        <div class="alert alert-danger text-center" role="alert">
                           <i class="fas fa-times"></i>  No se encontro informacion con el rango de fechas seleccionado.
                        </div>
                    `);
                }else{
                    $('#data_datos_rc_informe').empty().append(`
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">CLIENTE</th>
                                    <th scope="col">RC EVPIU</th>
                                    <th scope="col">RC DMS</th>
                                    <th scope="col">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody id="data_datos_rc_informe_table">
                            </tbody>
                        </table>
                    `);

                    function rc_formater(rc){
                        if (!rc){
                            return '';
                        }else{
                            return rc;
                        }
                    }

                    for (let i = 0; i < data.rc.length; i++) {
                        $('#data_datos_rc_informe_table').append(`
                            <tr>
                                <td>`+ data.rc[i].customer +`</td>
                                <td>`+ data.rc[i].id +`</td>
                                <td>`+ rc_formater(data.rc[i].rc_dms) +`</td>
                                <td>`+ formatter.format(data.rc[i].total) +`</td>
                            </tr>
                        `);
                    }

                    $('#data_datos_rc_informe_table').append(`
                        <tr class="table-success">
                            <th colspan="2">ACUMULADO TOTAL</th>
                            <th colspan="2">`+ formatter.format(data.total) +`</th>
                        </tr>
                    `);
                }
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });
});
