$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    sumar_total_tabla();

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


    $(document).on('click','#guardar', function () {
        let valor_pagado = $('#pagado').val();
        valor_pagado = parseFloat(valor_pagado);
        var fecha_pago = $('#fecha_pago').val();
        var comentarios = $('#comentarios').val();
        var cuenta_pago = $('#cuenta_pago').val();

        if (valor_pagado === total_liquidado_x && fecha_pago !== '' && cuenta_pago !== ''){

            const encabezado = {
                total: total_liquidado_x,
                comentarios: comentarios,
                id_rc: id_rc,
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
                    id_itm: e.querySelector('.id_itm').value

                };
                if (fila['total'] > 0)
                    items.push(fila);
            });

            $.ajax({
                url: '/aplicaciones/recibos_caja/guardar_recibo_caja_edit',
                type: 'post',
                data: {
                    encabezado, items
                },
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'RC guardado con exito!',
                        text: data,
                    })
                },
                error: function (data) {
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
