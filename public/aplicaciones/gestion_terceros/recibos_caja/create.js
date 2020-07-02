$(document).ready(function () {
    var nit_cliente;
    var nombre_cliente;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#cliente').autocomplete({
        source: function (request, response) {
            var Product = $("#cliente").val();
            $.ajax({
                url: "/aplicaciones/recibos_caja/buscar_cliente",
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

        select: function (event, ui) {
            $('#consultar').prop("disabled", false);
            nit_cliente = ui.item.nit;
            nombre_cliente = ui.item.value
        },
        minlength: 2
    });

    $('#consultar').on('click', function () {
        if (nit_cliente == null){
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error, por favor consulta nuevamente el cliente',
            });
        }else{
            $.ajax({
                url: "/aplicaciones/recibos_caja/consultar_recibos_cliente",
                method: "get",
                data: {
                    nit: nit_cliente
                },
                success: function (data) {
                    if (data.length === 0){
                        $('#recibos_de_caja_list').html('').append(`
                            <div class="alert alert-success text-center" role="alert">
                               <i class="fas fa-check-double"></i>  No se encontraron facturas con saldos pendientes.
                            </div>
                        `);
                    }else{
                        $('#recibos_de_caja_list').html('').append(`
                            <div class="row justify-content-center">
                                <div class="col-4 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend text-danger">
                                            <span class="input-group-text" id="">FECHA DE PAGO:</span>
                                        </div>
                                        <input type="date" name="fecha_pago" id="fecha_pago" class="form-control" placeholder="Fecha de pago">
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend" style="background-color: white !important; ">
                                            <span class="input-group-text" id="">VALOR PAGADO:</span>
                                        </div>
                                        <input type="number" class="form-control" value="0" id="pagado" name="pagado" min="0" onClick="this.select();">
                                    </div>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend" style="background-color: white !important; ">
                                            <span class="input-group-text" id="">CUENTA:</span>
                                        </div>
                                        <select name="cuenta_pago" id="cuenta_pago" class="form-control">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="11200505">BANCOLOMBIA - xxxxxxx1953</option>
                                            <option value="11200510">BANCOLOMBIA - xxxxxxx9471</option>
                                            <option value="11200515">BANCOLOMBIA - xxxxxxx3587</option>
                                            <option value="11100505">BANCOLOMBIA - xxxxxxx1701</option>
                                            <option value="11100506">BANCOLOMBIA - xxxxxxx2074</option>
                                            <option value="11100506">BANCO OCCIDENTE - xxxxxxx3489</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm table_items" id="table_items" >
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" name="" id="" class="custom-checkbox"></th>
                                            <th>Numero</th>
                                            <th>Saldo</th>
                                            <th>Bruto</th>
                                            <th>% Descuento</th>
                                            <th>Retencion</th>
                                            <th>ReteIVA</th>
                                            <th>ReteICA</th>
                                            <th>Otras deducciones</th>
                                            <th>Otros ingresos</th>
                                            <th>Total</th>
                                            <th>Detalles</th>
                                        </tr>
                                    </thead>
                                    <tbody id="facturas">

                                    </tbody>
                                    <tfoot id="totales">

                                    </tfoot>
                                </table>
                            </div>
                            <br>
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <textarea name="comentarios" id="comentarios" cols="5" rows="3" placeholder="ESCRIBA AQUI LOS COMENTARIOS" class="form-control"></textarea>
                                    </div>
                                </div>
                            <br>
                            <div class="row justify-content-center">
                                <div class="col-4 text-center">
                                    <button class="btn btn-primary btn-lg btn-block" id="guardar_borrador">GUARDAR COMO BORRADOR</button>
                                </div>
                                <div class="col-4 text-center">
                                    <button class="btn btn-primary btn-lg btn-block" id="finalizar">ENVIAR A CARTERA</button>
                                </div>
                            </div>
                        `);
                        const formatter = new Intl.NumberFormat('es-CO', {
                            style: 'currency',
                            currency: 'COP',
                            minimumFractionDigits: 0
                        });

                        var total_cartera = 0;

                        for (let i = 0; i < data.length; i++) {
                            total_cartera = total_cartera + data[i].Saldo;

                            $('#facturas').append(`
                                <tr class="table-secondary">
                                    <th><input type="checkbox" name="check_`+ data[i].numero +`" id="`+ data[i].numero +`" class="custom-checkbox check"></th>
                                    <td>`+ data[i].numero +` <input type="number" style="display: none !important;" class="factura" value="`+ data[i].numero +`"></td>
                                    <td style="text-align: right !important;">`+ formatter.format(data[i].Saldo) +`</td>
                                    <td><input type="number" id="`+ data[i].numero +`" class="form-control bruto_`+ data[i].numero +` bruto" value="`+ data[i].Saldo +`" disabled></td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-secondary descuento_btn_`+ data[i].numero +` descuento_btn" type="button" id="`+ data[i].numero +`" disabled><i class="fas fa-percentage"></i></button>
                                            </div>
                                            <input type="number" id="`+ data[i].numero +`" class="form-control descuento_`+ data[i].numero +` descuento" value="0" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-secondary retencion_btn_`+ data[i].numero +` retencion_btn" type="button" id="`+ data[i].numero +`" disabled><i class="fas fa-calculator"></i></button>
                                            </div>
                                                <input type="number" id="`+ data[i].numero +`" class="form-control retencion_`+ data[i].numero +` retencion" value="0" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-secondary reteiva_btn_`+ data[i].numero +` reteiva_btn" type="button" id="`+ data[i].numero +`" disabled><i class="fas fa-calculator"></i></button>
                                            </div>
                                            <input type="number" id="`+ data[i].numero +`" class="form-control reteiva_`+ data[i].numero +` reteiva" value="0" disabled>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-secondary reteica_btn_`+ data[i].numero +` reteica_btn" type="button" id="`+ data[i].numero +`" disabled><i class="fas fa-calculator"></i></button>
                                            </div>
                                            <input type="number" id="`+ data[i].numero +`" class="form-control reteica_`+ data[i].numero +` reteica" value="0" disabled>
                                        </div>
                                    </td>
                                    <td><input type="number" id="`+ data[i].numero +`" class="form-control otras_dedu_`+ data[i].numero +` otras_dedu" value="0" disabled></td>
                                    <td><input type="number" id="`+ data[i].numero +`" class="form-control otros_ingre_`+ data[i].numero +` otros_ingre" value="0" disabled></td>
                                    <td><input type="number" class="form-control total_`+ data[i].numero +` total" value="0" id="total" name="total" disabled ></td>
                                    <td>
                                         <button class="btn btn-outline-info btn-sm info_documento" id="`+ data[i].numero +`"><i class="fas fa-info-circle"></i> Info</button>
                                    </td>
                                    <td style="display: none !important;">
                                        <input type="number" class="form-control iva_`+ data[i].numero +` iva" value="`+ data[i].iva +`">
                                        <input type="number" class="form-control valor_merc_`+ data[i].numero +`" value="`+ data[i].valor_mercancia +`">
                                        <input type="number" class="form-control desc_merc_`+ data[i].numero +`" value="`+ data[i].descuento_pie +`">
                                    </td>
                                </tr>
                            `);
                        }
                        $('#totales').append(`
                            <tr>
                                <td colspan="2"><b>TOTAL CARTERA: </b></td>
                                <td>`+ formatter.format(total_cartera)+`</td>
                                <td colspan="7" class="text-right"><b>TOTAL LIQUIDADO:</b></td>
                                <td id="total_liquidado">0</td>
                                <td></td>
                            </tr>
                        `);
                    }
                    $('#consultar').attr('disabled', 'disabled');
                },
                error: function (data) {
                    console.log(data);
                }
            })
        }

    });

    function calcular_total_fila(fila, check) {
        const id = fila;
        if (check === true){
            const bruto = $('.bruto_'+id).val();
            const descuento = $('.descuento_'+id).val();
            const retencion = $('.retencion_'+id).val();
            const reteiva = $('.reteiva_'+id).val();
            const reteica = $('.reteica_'+id).val();
            const otras_dedu = $('.otras_dedu_'+id).val();
            const otros_ingre = $('.otros_ingre_'+id).val();

            $('.bruto_'+id).prop('disabled', false);
            $('.descuento_'+id).prop('disabled', false);
            $('.retencion_'+id).prop('disabled', false);
            $('.reteiva_'+id).prop('disabled', false);
            $('.reteica_'+id).prop('disabled', false);
            $('.otras_dedu_'+id).prop('disabled', false);
            $('.otros_ingre_'+id).prop('disabled', false);


            $('.descuento_btn_'+id).prop('disabled', false);
            $('.retencion_btn_'+id).prop('disabled', false);
            $('.reteiva_btn_'+id).prop('disabled', false);
            $('.reteica_btn_'+id).prop('disabled', false);

            $('.total_'+id).val(parseFloat(bruto) - parseFloat(descuento) + parseFloat(retencion) - parseFloat(reteiva) - parseFloat(reteica) - parseFloat(otras_dedu) + parseFloat(otros_ingre));

        }else{
            $('.descuento_'+id).val(0);
            $('.retencion_'+id).val(0);
            $('.reteiva_'+id).val(0);
            $('.reteica_'+id).val(0);
            $('.otras_dedu_'+id).val(0);
            $('.otros_ingre_'+id).val(0);
            $('.total_'+id).val(0);


            $('.bruto_'+id).attr('disabled', 'disabled');
            $('.descuento_'+id).attr('disabled', 'disabled');
            $('.retencion_'+id).attr('disabled', 'disabled');
            $('.reteiva_'+id).attr('disabled', 'disabled');
            $('.reteica_'+id).attr('disabled', 'disabled');
            $('.otras_dedu_'+id).attr('disabled', 'disabled');
            $('.otros_ingre_'+id).attr('disabled', 'disabled');

            $('.descuento_btn_'+id).attr('disabled', 'disabled');
            $('.retencion_btn_'+id).attr('disabled', 'disabled');
            $('.reteiva_btn_'+id).attr('disabled', 'disabled');
            $('.reteica_btn_'+id).attr('disabled', 'disabled');
        }
        sumar_total_tabla();
    }

    var total_liquidado_x;
    function sumar_total_tabla() {
        const formatter = new Intl.NumberFormat('es-CO', {
            style: 'currency',
            currency: 'COP',
            minimumFractionDigits: 0
        });

        var arr = document.getElementsByName('total');
        var tot=0;
        for(let i = 0; i < arr.length; i++){
            if(parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
        total_liquidado_x = tot;
        document.getElementById('total_liquidado').innerHTML = formatter.format(tot);
    }

    $(document).on('click', '.check', function () {
        const fila = this.id;
        if (document.getElementById(this.id).checked === true) {
            calcular_total_fila(fila, true);
            $(this).closest("tr").removeClass('table-secondary');
        } else {
            calcular_total_fila(fila, false);
            $(this).closest("tr").addClass('table-secondary');
        }
    });


    $(document).on('blur', '.bruto', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });

    $(document).on('blur', '.descuento', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });

    $(document).on('blur', '.retencion', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });

    $(document).on('blur', '.reteiva', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });

    $(document).on('blur', '.reteica', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });

    $(document).on('blur', '.otras_dedu', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });

    $(document).on('blur', '.otros_ingre', function () {
        const fila = this.id;
        calcular_total_fila(fila, true);
    });


    $(document).on('click','.reteiva_btn', function () {
        const fila = this.id;
        const iva = $('.iva_' + fila).val();
        const resultado = iva * 15 / 100;

        $('.reteiva_'+fila).val(resultado);
        calcular_total_fila(fila, true);
    });

    $(document).on('click','.reteica_btn', function () {
        const fila = this.id;
        const bruto = $('.valor_merc_' + fila).val();
        const descuento = $('.desc_merc_' + fila).val();
        const resultado = (bruto - descuento) * 2.5 / 100;

        $('.reteica_'+fila).val(resultado);
        calcular_total_fila(fila, true);
    });

    var fila_desc = 0;
    $(document).on('click', '.descuento_btn', function () {
        const fila = this.id;
        $('#calcular_desc_modal').modal('show');
        fila_desc = fila;
    });


    $(document).on('click', '.calcular_descuento', function () {
        const bruto = $('.valor_merc_' + fila_desc).val();
        const porc_desc =  $('#descuento_input_modal').val();
        const resultado = (porc_desc * bruto) / 100;

        $('.descuento_'+fila_desc).val(resultado);
        calcular_total_fila(fila_desc, true);

        $('#calcular_desc_modal').modal('hide');
        $('#descuento_input_modal').val(0);

    });


    $(document).on('click', '.retencion_btn' ,function () {
        const fila = this.id;
        $.ajax({
            url: '/aplicaciones/recibos_caja/consultar_tipo_venta',
            type: 'get',
            data: {
                id:fila
            },
            success: function (data) {
                const bruto = $('.valor_merc_' + fila).val();
                const desc = $('.desc_merc_' + fila).val();
                var resultado = 0;
                if (data[0] === "24"){
                    resultado = (bruto - desc) * 4/100;
                }else{
                    resultado = (bruto - desc) * 2.5/100;
                }
                $('.retencion_'+fila).val(resultado);
                calcular_total_fila(fila, true);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });




    $(document).on('click','#guardar_borrador', function () {
        let valor_pagado = $('#pagado').val();
        valor_pagado = parseFloat(valor_pagado);
        var fecha_pago = $('#fecha_pago').val();
        var comentarios = $('#comentarios').val();
        var cuenta_pago = $('#cuenta_pago').val();

        if (valor_pagado === total_liquidado_x && fecha_pago !== '' && cuenta_pago !== ''){
            const encabezado = {
                cliente: nombre_cliente,
                nit_cliente: nit_cliente,
                total: total_liquidado_x,
                estado: 1,
                fecha_pago: fecha_pago,
                comentarios: comentarios,
                cuenta_pago: cuenta_pago
            };
            const items = [];

            document.querySelectorAll('.table_items tbody tr').forEach(function(e){
                let fila = {
                    factura: e.querySelector('.factura').value,
                    bruto: e.querySelector('.bruto').value,
                    descuento: e.querySelector('.descuento').value,
                    retencion: e.querySelector('.retencion').value,
                    reteiva: e.querySelector('.reteiva').value,
                    reteica: e.querySelector('.reteica').value,
                    otras_dedu: e.querySelector('.otras_dedu').value,
                    otros_ingre: e.querySelector('.otros_ingre').value,
                    total: e.querySelector('.total').value,
                };
                if (fila['total'] > 0)
                    items.push(fila);
            });


            $.ajax({
                url: '/aplicaciones/recibos_caja/guardar_recibo_caja',
                type: 'post',
                data: {
                    encabezado, items
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Recibo de caja creado correctamente!',
                        text: data,
                    });
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hubo un error al crear RC',
                        text: data,
                    });
                    console.log(data)
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'RECIBO DE CAJA CON ERRORES!',
                text: 'Los valores ingresados no coinciden, por favor verifiquelos y intente de nuevo',
            });
        }
    });


    $(document).on('click','#finalizar', function () {
        let valor_pagado = $('#pagado').val();
        valor_pagado = parseFloat(valor_pagado);
        var fecha_pago = $('#fecha_pago').val();
        var comentarios = $('#comentarios').val();
        var cuenta_pago = $('#cuenta_pago').val();


        if (valor_pagado === total_liquidado_x && fecha_pago !== '' && cuenta_pago !== '' ){

            const encabezado = {
                cliente: nombre_cliente,
                nit_cliente: nit_cliente,
                total: total_liquidado_x,
                estado: 2,
                comentarios: comentarios,
                fecha_pago: fecha_pago,
                cuenta_pago: cuenta_pago
            };
            const items = [];

            document.querySelectorAll('.table_items tbody tr').forEach(function(e){
                let fila = {
                    factura: e.querySelector('.factura').value,
                    bruto: e.querySelector('.bruto').value,
                    descuento: e.querySelector('.descuento').value,
                    retencion: e.querySelector('.retencion').value,
                    reteiva: e.querySelector('.reteiva').value,
                    reteica: e.querySelector('.reteica').value,
                    otras_dedu: e.querySelector('.otras_dedu').value,
                    otros_ingre: e.querySelector('.otros_ingre').value,
                    total: e.querySelector('.total').value,

                };
                if (fila['total'] > 0)
                    items.push(fila);
            });

            $.ajax({
                url: '/aplicaciones/recibos_caja/guardar_recibo_caja',
                type: 'post',
                data: {
                    encabezado, items
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Recibo de caja creado correctamente!',
                        text: data,
                    });
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hubo un error al crear RC',
                        text: data,
                    });
                    console.log(data)
                }
            });
        }else{
            Swal.fire({
                icon: 'error',
                title: 'RECIBO DE CAJA CON ERRORES!',
                text: 'Los valores ingresados no coinciden, por favor verifiquelos y intente de nuevo',
            })
        }
    });

    $(document).on('click', '.info_documento', function () {
        let id = this.id;
        $.ajax({
            url: '/aplicaciones/recibos_caja/consultar_documento',
            type: 'get',
            data: {id:id},
            success: function (data) {
                const formatter = new Intl.NumberFormat('es-CO', {
                    style: 'currency',
                    currency: 'COP',
                    minimumFractionDigits: 0
                });

                $('#info_documento_modal_title').html('# '+ id);

                $('#info_documento_modal_table_body').html('').append(`
                    <tr>
                        <th scope="row">Fecha Factura:</th>
                        <td>`+ data.fecha +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Plazo:</th>
                        <td>`+ data.descripcion +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Vencimiento:</th>
                        <td>`+ data.fecha +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Bruto:</th>
                        <td style="text-align: right!important;">`+ formatter.format(data.valor_mercancia) +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Descuento (-):</th>
                        <td style="text-align: right!important;">`+ formatter.format(data.descuento_pie) +`</td>
                    </tr>
                    <tr>
                        <th scope="row">IVA (+):</th>
                        <td style="text-align: right!important;">`+ formatter.format(data.iva) +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Retencion (-):\t</th>
                        <td style="text-align: right!important;">`+ formatter.format(data.retencion) +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Abono (-):</th>
                        <td style="text-align: right!important;"> `+ formatter.format(data.valor_aplicado) +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Subtotal:</th>
                        <td style="text-align: right!important;">`+ formatter.format(data.ValorTotal) +`</td>
                    </tr>
                    <tr>
                        <th scope="row">Vendedor:</th>
                        <td>`+ data.NombreVendedor +`</td>
                    </tr>
                `);
                $('#info_documento_modal').modal('show');
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error al cargar documento',
                    text: data,
                })
            }
        })
    });
});
