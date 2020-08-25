$(document).ready(function () {
    const formatter = new Intl.NumberFormat('es-CO',{
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 2,
    });

    const formatter2 = new Intl.NumberFormat('es-CO',{
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
    });


    $(document).on('click', '.ver_pdf', function () {
        let id = this.id;
        $.ajax({
            type: "get",
            url: "/aplicaciones/pedidos/venta/ver_pedido_pdf",
            data: {id: id},
            dataType: "json",
            success: function (data) {
                document.getElementById('pdf_titulo').innerText = 'Pedido '+data.encabezado['id'];
                document.getElementById('pdf_cliente').innerText = data.encabezado['NombreCliente'];
                document.getElementById('pdf_fecha').innerText = data.encabezado['created_at'];
                document.getElementById('pdf_codigo_cliente').innerText = data.encabezado['CodCliente'];
                document.getElementById('pdf_ciudad').innerText = data.encabezado['Ciudad'];
                document.getElementById('pdf_direccion').innerText = data.encabezado['DireccionCliente'];
                document.getElementById('pdf_telefono').innerText = data.encabezado['Telefono'];
                document.getElementById('pdf_numero_pedido').innerText = data.encabezado['id'];
                document.getElementById('pdf_oc').innerText = data.encabezado['OrdenCompra'];
                document.getElementById('pdf_vendedor').innerText = data.encabezado['NombreVendedor'];
                document.getElementById('pdf_condicion_pago').innerText = data.encabezado['CondicionPago'];
                document.getElementById('pdf_notas_generales').innerText = data.encabezado['Notas'];

                /*TOTALES*/
                document.getElementById('pdf_bruto_pedido').innerText = formatter2.format(Math.round(data.encabezado['Bruto']));
                document.getElementById('pdf_descuento_pedido').innerText = formatter2.format(Math.round(data.encabezado['TotalDescuento']));
                document.getElementById('pdf_subtotal_pedido').innerText = formatter2.format(Math.round(data.encabezado['TotalSubtotal']));
                document.getElementById('pdf_iva_pedido').innerText = formatter2.format(Math.round(data.encabezado['TotalIVA']));
                document.getElementById('pdf_total_pedido').innerText = formatter2.format(Math.round(data.encabezado['TotalPedido']));



                if (data.encabezado['Estado'] == 1){
                    document.getElementById("ProgressPed").style.width = "10%";
                    document.getElementById('ProgressPed').innerHTML = "10%";
                    document.getElementById('ProgressPed').classList.add("bg-success");
                }


                if (data.encabezado['Estado'] == 2 && data.encabezado['Cartera'] == 2){
                    document.getElementById("ProgressPed").style.width = "25%";
                    document.getElementById('ProgressPed').innerHTML = "25%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color = "green";
                    document.getElementById("ProgressPed").classList.add("bg-success");
                }


                if(data.encabezado['Estado'] == 3 && data.encabezado['Cartera'] == 3){
                    document.getElementById("ProgressPed").style.width = "30%";
                    document.getElementById('ProgressPed').innerHTML = "30%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color = "green";
                    document.getElementById("ProgressPed").classList.add("bg-danger");
                }


                if(data.encabezado['Estado'] == 2 && data.encabezado['Cartera'] == 3.1){
                    document.getElementById("ProgressPed").style.width="30%";
                    document.getElementById('ProgressPed').innerHTML = "30%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-warning");
                }


                if(data.encabezado['Estado'] == 2 && data.encabezado['Cartera'] == 3.2){
                    document.getElementById("ProgressPed").style.width = "30%";
                    document.getElementById('ProgressPed').innerHTML = "30%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color = "green";
                    document.getElementById("ProgressPed").classList.add("bg-warning");

                }


                if(data.encabezado['Estado'] == 4 && data.encabezado['Costos'] == 4){
                    document.getElementById("ProgressPed").style.width="50%";
                    document.getElementById('ProgressPed').innerHTML = "50%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-success");
                }


                if(data.encabezado['Estado'] == 5 && data.encabezado['Costos'] == 5){
                    document.getElementById("ProgressPed").style.width="50%";
                    document.getElementById('ProgressPed').innerHTML = "50%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-danger");
                }


                if(data.encabezado['Estado'] == 6 && data.encabezado['Produccion'] == 6 ){
                    document.getElementById("ProgressPed").style.width="75%";
                    document.getElementById('ProgressPed').innerHTML = "75%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById('ProgProduccion').classList.add("active");
                    document.getElementById("StepProduccion").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-success");
                }


                if(data.encabezado['Estado'] == 7 && data.encabezado['Produccion'] == 7 ){
                    document.getElementById("ProgressPed").style.width="75%";
                    document.getElementById('ProgressPed').innerHTML = "75%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById('ProgProduccion').classList.add("active");
                    document.getElementById("StepProduccion").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-danger");
                }


                if(data.encabezado['Estado'] == 8 && data.encabezado['Bodega'] == 8){
                    document.getElementById("ProgressPed").style.width="90%";
                    document.getElementById('ProgressPed').innerHTML = "90%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById('ProgProduccion').classList.add("active");
                    document.getElementById("StepProduccion").style.color="green";
                    document.getElementById('ProgBodega').classList.add("active");
                    document.getElementById("StepBodega").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-success");
                }


                if(data.encabezado['Estado'] == 9 && data.encabezado['Bodega'] == 9){
                    document.getElementById("ProgressPed").style.width="90%";
                    document.getElementById('ProgressPed').innerHTML = "90%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById('ProgProduccion').classList.add("active");
                    document.getElementById("StepProduccion").style.color="green";
                    document.getElementById('ProgBodega').classList.add("active");
                    document.getElementById("StepBodega").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-success");
                }

                if(data.encabezado['Estado'] == 10){
                    document.getElementById("ProgressPed").style.width="100%";
                    document.getElementById('ProgressPed').innerHTML = "100%";
                    document.getElementById('ProgCartera').classList.add("active");
                    document.getElementById("StepCartera").style.color="green";
                    document.getElementById('ProgCostos').classList.add("active");
                    document.getElementById("StepCostos").style.color="green";
                    document.getElementById('ProgProduccion').classList.add("active");
                    document.getElementById("StepProduccion").style.color="green";
                    document.getElementById('ProgBodega').classList.add("active");
                    document.getElementById("StepBodega").style.color="green";
                    document.getElementById("ProgressPed").classList.add("bg-success");
                }

                function format_destino (destino){
                    if (destino == 1){
                        return 'Produccion'
                    } else if (destino == 2){
                        return 'Bodega'
                    }else{
                        return 'Troqueles'
                    }
                }


                function format_arte(arte) {
                    if (arte){
                        return '<a href="javascript:void(0);" class="ver_arte" id="'+ arte +'">'+ arte +'</a>';
                    }else{
                        return '';
                    }
                }

                function format_notas(notas) {
                    if (notas){
                        return notas;
                    }else{
                        return '';
                    }
                }

                for (let i = 0; i < data.detalle.length; i++) {
                    $('#items_pedido').append('<tr>' +
                        '<td style="text-align: center">'+ data.detalle[i].CodigoProducto +'</td>' +
                        '<td style="text-align: center">'+ data.detalle[i].Descripcion +'</td>' +
                        '<td style="text-align: center">'+ format_destino(data.detalle[i].Destino) +'</td>' +
                        '<td style="text-align: center">'+ data.detalle[i].R_N +'</td>' +
                        '<td style="text-align: center">'+ format_arte(data.detalle[i].Arte)  + '</td>' +
                        '<td style="text-align: center">'+ format_notas(data.detalle[i].Notas) +'</td>' +
                        '<td style="text-align: center">'+ data.detalle[i].Unidad +'</td>' +
                        '<td style="text-align: right">'+ data.detalle[i].Cantidad +'</td>' +
                        '<td style="text-align: right">'+ formatter.format(data.detalle[i].Precio) +'</td>' +
                        '<td style="text-align: right">'+ formatter2.format(data.detalle[i].Total) +'</td>' +
                        '</tr>'
                    );
                }


                $('#ver_pdf').modal({
                    backdrop: 'static',
                    keyboard: false,
                });


                function imprimirElemento(elemento) {
                    const ventana = window.open('Print', '', 'width=900');
                    ventana.document.write('<html lang="es"><head><title>' + document.title + '</title>');
                    ventana.document.write('<link rel="stylesheet" href="/bootstrap.min.css">');
                    ventana.document.write('</head><body>');
                    ventana.document.write('<div class="container ml-1 mr-1">'+elemento.innerHTML+'</div>');
                    ventana.document.write('</body></html>');
                    ventana.document.close();
                    ventana.focus();
                    ventana.onload = function() {
                        ventana.print();
                        ventana.close();
                    };
                    return true;
                }


                document.querySelector("#imprimir_pdf").addEventListener("click", function() {
                    const div = document.querySelector("#texto_imprimible");
                    imprimirElemento(div);
                });


                $(document).on('click', '#cerrar', function () {
                    $('#items_pedido').html('');
                    document.getElementById("ProgressPed").style.width="0%";
                    document.getElementById('ProgressPed').innerHTML = '0%';
                    document.getElementById('ProgCartera').classList.remove('active');
                    document.getElementById("StepCartera").style.color="black";
                    document.getElementById('ProgCostos').classList.remove('active');
                    document.getElementById("StepCostos").style.color="black";
                    document.getElementById('ProgProduccion').classList.remove('active');
                    document.getElementById("StepProduccion").style.color="black";
                    document.getElementById('ProgBodega').classList.remove('active');
                    document.getElementById("StepBodega").style.color="black";
                    document.getElementById('ProgressPed').classList.remove('bg-success');
                    document.getElementById('ProgressPed').classList.remove('bg-warning');
                    document.getElementById('ProgressPed').classList.remove('bg-danger');
                });


                $(document).on('click', '.StepCartera', function (){
                    let id = document.getElementById('pdf_numero_pedido').innerText;
                    $.ajax({
                        url: "/aplicaciones/pedidos/venta/info_area",
                        type: "get",
                        data: {
                            id: id,
                            area: 'cartera'
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: data.icon,
                                title: data.estado,
                                html: data.detalle,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar'
                            });
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: '<b>'+ data.responseText +'</b>' ,
                            });
                        }
                    });
                });


                $(document).on('click', '.StepCostos', function () {
                    let id = document.getElementById('pdf_numero_pedido').innerText;
                    $.ajax({
                        url: "/aplicaciones/pedidos/venta/info_area",
                        type: "get",
                        data: {
                            id: id,
                            area: 'costos'
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: data.icon,
                                title: data.estado,
                                html: data.detalle,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar'
                            });
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: '<b>'+ data.responseText +'</b>' ,
                            });
                        }
                    });
                });


                $(document).on('click', '.StepProduccion', function() {
                    let id = document.getElementById('pdf_numero_pedido').innerText;
                    $.ajax({
                        url: "/aplicaciones/pedidos/venta/info_area",
                        type: "get",
                        data: {
                            id: id,
                            area: 'produccion'
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: data.icon,
                                title: data.estado,
                                html: data.detalle,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar'
                            });
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: '<b>'+ data.responseText +'</b>' ,
                            });
                        }
                    });
                });


                $(document).on('click', '.StepBodega', function() {
                    let id = document.getElementById('pdf_numero_pedido').innerText;
                    $.ajax({
                        url: "/aplicaciones/pedidos/venta/info_area",
                        type: "get",
                        data: {
                            id: id,
                            area: 'bodega'
                        },
                        success: function (data) {
                            Swal.fire({
                                icon: data.icon,
                                title: data.estado,
                                html: data.detalle,
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Aceptar',
                                cancelButtonText: 'Cancelar'
                            });
                        },
                        error: function (data) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: '<b>'+ data.responseText +'</b>' ,
                            });
                        }
                    });
                });


                $(document).on('click', '.ver_arte', function() {
                    const Art = this.id;
                    $('#arte_modal_title').html('Arte #'+ Art);
                    PDFObject.embed('//192.168.1.12/intranet_ci/assets/Artes/'+Art+'.pdf', '#arte_modal_pdf');
                    $('#arte_modal').modal('show');
                });
            }
        })
    });
});
