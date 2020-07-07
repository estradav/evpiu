$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#table').dataTable({
        language: {
            url: '/Spanish.json'
        }
    });

    $(document).on('click', '.rechazar', function () {
        let id_val = this.id;
        id_val = id_val.split(',');
        let id = id_val[0];
        let estado = parseInt(id_val[1]);

        if (estado === 2){
            Swal.fire({
                icon: 'question',
                title: '¿Rechazar RC?',
                text: "El RC sera devuelto al vendedor, ¿Esta seguro de continuar?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, rechazar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/aplicaciones/recibos_caja/cambiar_estado',
                        type: 'post',
                        data: {
                            id:id,
                            estado: 4
                        },
                        success:function (data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pedido rechazado',
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

    $(document).on('click', '.aprobar', function () {
        let id_val = this.id;
        id_val = id_val.split(',');
        let id = id_val[0];

        Swal.fire({
            icon: 'question',
            title: '¿Aprobar RC y subir a DMS?',
            html: "Esta accion <b class='text-danger'>NO</b> es reversible, verifique la toda informacion antes de continuar.",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, aprobar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '/aplicaciones/recibos_caja/finalizar_rc',
                    type: 'post',
                    data: {
                        id:id,
                    },
                    success:function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pedido aprobado',
                            text: data,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Aceptar',
                        });
                        //window.location.reload(true);
                    },
                    error: function (data) {
                        console.log(data)
                    }
                });
            }
        });
    });
});
