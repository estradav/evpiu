$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#nombre_cliente" ).autocomplete({
        source: function (request, response) {
            const query = document.getElementById('nombre_cliente').value;
            $.ajax({
                url: "/aplicaciones/pedidos/venta/info_cliente",
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
        focus: function(event, ui) {
            document.getElementById('cod_cliente').value = ui.item.cod;
            document.getElementById('direccion').value = ui.item.direccion;
            document.getElementById('ciudad').value = ui.item.ciudad;
            document.getElementById('telefono').value = ui.item.telefono;
            document.getElementById('condicion_pago').value = ui.item.plazo;
            document.getElementById('descuento').value = ui.item.descuento;

            return true;
        },
        select: function(event, ui)	{
            document.getElementById('cod_cliente').value = ui.item.cod;
            document.getElementById('direccion').value = ui.item.direccion;
            document.getElementById('ciudad').value = ui.item.ciudad;
            document.getElementById('telefono').value = ui.item.telefono;
            document.getElementById('condicion_pago').value = ui.item.plazo;
            document.getElementById('descuento').value = ui.item.descuento;
        },
        minlength: 2
    });


    let codigo_producto_max = '';
    let descripcion_producto_max = '';

    $("#producto").autocomplete({
        source: function (request, response) {
            const query = document.getElementById('producto').value;
            $.ajax({
                url: "/aplicaciones/pedidos/venta/listar_productos_max",
                method: "get",
                data: {
                    query: query
                },
                dataType: "json",
                success: function (data) {
                    const resp = $.map(data, function (obj) {
                        return obj
                    });
                    response(resp);
                },
                error: function (data) {
                    console.log(data.responseText)
                }
            });
        },
        focus: function (event, ui) {
            codigo_producto_max = ui.item.codigo;
            descripcion_producto_max = ui.item.descripcion;
            document.getElementById('precio_item').value = 0;
            document.getElementById('stock_item').innerHTML = ui.item.stock;

            return true;
        },
        select: function (event, ui) {
            codigo_producto_max = ui.item.codigo;
            descripcion_producto_max = ui.item.descripcion;
            document.getElementById('precio_item').value = 0;
            document.getElementById('stock_item').innerHTML = ui.item.stock;
            document.getElementById('add_info').disabled = false;

        },
        minlength: 2
    });


    $(".arte_item").autocomplete({
        source: function (request, response) {
            const query = document.getElementById('arte_item').value;
            $.ajax({
                url: "/aplicaciones/pedidos/venta/listar_artes",
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
            });
        }
    });

    function calcular_fila() {
        const cantidad = document.getElementById('cantidad_item').value;
        const precio = document.getElementById('precio_item').value;

        return precio * cantidad;
    }


    $(document).on('keyup', '#cantidad_item', function () {
        document.getElementById('total_item').value = calcular_fila();
    });

    $(document).on('keyup', '#precio_item', function () {
        document.getElementById('total_item').value = calcular_fila();
    });


    function calcular_totales() {
        let bruto = 0;
        let subtotal;
        let iva;
        let total;


        /*calculo bruto*/
        var cls = document.getElementById("tabla_items").getElementsByTagName("td");
        for (let i = 0; i < cls.length; i++){
            if(cls[i].className == "item_total"){
                bruto += isNaN(cls[i].innerHTML) ? 0 : parseInt(cls[i].innerHTML);
            }
        }


        /*calculo descuento*/
        var porc_des = document.getElementById('descuento').value;
        let descuento = (porc_des / 100) * bruto;


        /*calculo subtotal*/
        subtotal = bruto - descuento;


        /*calculo iva*/
        if (document.getElementById('iva').value === 'N'){
            iva = 0;
        }else{
            iva = subtotal * 0.19;
        }

        /*total pedido*/
        total = subtotal + iva;
        document.getElementById('total_items_bruto').value = bruto;
        document.getElementById('total_items_descuento').value = descuento;
        document.getElementById('total_items_subtotal').value = subtotal;
        document.getElementById('total_items_iva').value = iva;
        document.getElementById('total_items').value = total;
    }


    $(document).on('change', '#iva', function () {
        calcular_totales()
    });


    $(document).on('keyup', '#descuento', function () {
        calcular_totales()
    });

    let idx = 0;

    $('#add_items_form').validate({
        ignore: "",
        rules: {
            destino_item: {
                select_check: true
            },
            n_r_item: {
                select_check: true
            },
            precio_item: "required",
            cantidad_item: "required"
        },
        errorPlacement: function(error,element) {
            return true;
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $('#tabla_items_body').append(`
                <tr>
                    <td class="item_cod_producto">`+ codigo_producto_max +`</td>
                    <td class="item_cod_client" id="item_cod_client_`+ idx +`"> `+ document.getElementById('cod_cliente_item').value +` </td>
                    <td class="item_descripcion">`+ descripcion_producto_max +`</td>
                    <td class="item_destino" id="item_destino_`+ idx +`">`+ document.getElementById('destino_item').value +`</td>
                    <td class="item_n_r" id="item_nr_`+ idx +`">`+ document.getElementById('n_r_item').value +`</td>
                    <td class="item_arte" id="item_arte_`+ idx +`"><a href="javascript:void(0);" id="`+ document.getElementById('arte_item').value +`" class="ver_arte" name="ver_arte_`+ idx +`">`+ document.getElementById('arte_item').value +`</a></td>
                    <td class="item_marca" id="item_marca_`+ idx +`">`+ document.getElementById('marca_item').value +` </td>
                    <td class="item_notas"  id="item_notas_`+ idx +`">`+ document.getElementById('notas_item').value +`</td>
                    <td class="item_unidad" id="item_unidad_`+ idx +`">`+ document.getElementById('um_item').value +`</td>
                    <td class="item_precio" id="item_precio_`+ idx +`">`+ document.getElementById('precio_item').value +`</td>
                    <td class="item_cantidad" id="item_cantidad_`+ idx +`">`+ document.getElementById('cantidad_item').value +`</td>
                    <td class="item_total" id="item_total_`+ idx +`">`+ document.getElementById('total_item').value +`</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button class="btn btn-info btn-sm editar_item" name="`+ idx +`" id="editar_item_`+ idx +`">
                                 <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-success btn-sm save_item" name="`+ idx +`" id="save_item_`+ idx +`" style="display: none">
                                 <i class="fas fa-save"></i>
                            </button>
                            <a href="javascript:void(0)" data-id="`+ codigo_producto_max +`" class="btn btn-danger btn-sm eliminar_item">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                    <td class="id" style="display: none !important;"></td>
                </tr>
            `);
            idx++;
            document.getElementById('agregar_item').disabled = true;
            document.getElementById('add_info').disabled = true;
            calcular_totales();
            $('#add_items_form').trigger('reset');
            $('#add_info_modal_form').trigger('reset');
            return false;
        }
    });

    $(document).on('click', '.editar_item', function () {
        let no = this.name;
        document.getElementById("editar_item_"+no).style.display = "none";
        document.getElementById("save_item_"+no).style.display = "block";


        const cod_prod_client = document.getElementById("item_cod_client_" + no);
        const destino = document.getElementById("item_destino_" + no);
        const n_r = document.getElementById("item_nr_"+no);
        const arte = document.getElementById("item_arte_"+no);
        const marca = document.getElementById("item_marca_"+no);
        const notas = document.getElementById("item_notas_"+no);
        const unidad = document.getElementById("item_unidad_"+no);
        const cantidad = document.getElementById("item_cantidad_"+no);
        const precio = document.getElementById("item_precio_"+no);



        const cod_prod_client_data = cod_prod_client.innerText;
        const destino_data = destino.innerText;
        const n_r_data = n_r.innerText;
        const arte_data = document.getElementsByName("ver_arte_"+no)[0].innerText;
        const marca_data = marca.innerText;
        const notas_data = notas.innerHTML;
        const unidad_data = unidad.innerHTML;
        const cantidad_data = cantidad.innerHTML;
        const precio_data = precio.innerHTML;



        cod_prod_client.innerHTML = `<input type="text" id="input_cod_prod_client_`+no+`" name="input_cod_prod_client_`+no+`" class="form-control form-control-sm" value="`+ cod_prod_client_data +`">`;

        destino.innerHTML = `
            <select name="input_destino_`+no+`" id="input_destino_`+no+`" class="form-control form-control-sm">
                <option value="Bodega">Bodega</option>
                <option value="Produccion">Produccion</option>
                <option value="Troqueles">Troqueles</option>
            </select>`;
        $('#input_destino_'+no).val(destino_data);

        n_r.innerHTML = `
            <select name="input_nr_`+no+`" id="input_nr_`+no+`" class="form-control form-control-sm">
                <option value="Nuevo">Nuevo</option>
                <option value="Repro">Repro.</option>
            </select>`;
        $('#input_nr_'+no).val(n_r_data);


        arte.innerHTML = `<input type="text" id="arte_item_`+no+`" name="arte_item_`+no+`" class="form-control form-control-sm arte_item" value="`+ arte_data+`">`;

        marca.innerHTML = `<input type="text" id="input_marca_`+no+`" name="input_marca_`+no+`" class="form-control form-control-sm marca_item" value="`+ marca_data+`">`;

        notas.innerHTML = `<input type="text" id="input_notas_`+no+`" name="input_notas_`+no+`" class="form-control form-control-sm" value="`+ notas_data+`">`;


        unidad.innerHTML = `
            <select name="input_unidad_`+no+`" id="input_unidad_`+no+`" class="form-control form-control-sm">
                <option value="Unidad">Unidad</option>
                <option value="Kilos">Kilos</option>
                <option value="Millar">Millar</option>
            </select>`;
        $('#input_unidad_'+no).val(unidad_data);

        cantidad.innerHTML = `<input type="number" id="input_cantidad_`+no+`" name="input_cantidad_`+no+`" class="form-control form-control-sm" value="`+ cantidad_data+`">`;
        precio.innerHTML = `<input type="number" id="input_precio_`+no+`" name="input_precio_`+no+`" class="form-control form-control-sm" value="`+ precio_data +`">`;


        $('.arte_item').autocomplete({
            source: function (request, response) {
                const query =  $('.arte_item').val();
                $.ajax({
                    url: "/aplicaciones/pedidos/venta/listar_artes",
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
                });
            }
        });

        $('.marca_item').autocomplete({
            source: function (request, response) {
                const query = $('.marca_item').val();
                $.ajax({
                    url: "/aplicaciones/pedidos/venta/listar_marcas",
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
                });
            }
        });
    });


    $(document).on('click', '.save_item', function () {
        let no = this.name;

        const cod_prod_client = document.getElementById("input_cod_prod_client_"+no).value;
        const destino = document.getElementById("input_destino_"+no).value;
        const n_r = document.getElementById("input_nr_"+no).value;
        const arte = document.getElementById("arte_item_"+no).value;
        const marca = document.getElementById("input_marca_"+no).value;
        const notas = document.getElementById("input_notas_"+no).value;
        const unidad = document.getElementById("input_unidad_"+no).value;
        const cantidad = document.getElementById("input_cantidad_"+no).value;
        const precio = document.getElementById("input_precio_"+no).value;



        document.getElementById('item_cod_client_' + no).innerHTML = cod_prod_client;
        document.getElementById("item_destino_" + no).innerHTML = destino;
        document.getElementById("item_nr_"+no).innerHTML = n_r;
        document.getElementById("item_arte_"+no).innerHTML = `<a href="javascript:void(0)" class="ver_arte" id="`+ arte +`" name="ver_arte_`+no+`">`+ arte +`</a>`;
        document.getElementById("item_marca_"+no).innerHTML = marca;
        document.getElementById("item_notas_"+no).innerHTML = notas;
        document.getElementById("item_unidad_"+no).innerHTML = unidad;
        document.getElementById("item_cantidad_"+no).innerHTML = cantidad;
        document.getElementById("item_precio_"+no). innerHTML = precio;
        document.getElementById("editar_item_"+no).style.display="block";
        document.getElementById("save_item_"+no).style.display="none";
        document.getElementById("item_total_"+no).innerHTML = precio * cantidad;

        calcular_totales();
    });



    $(document).on('click', '.eliminar_item', function () {
        let id = $(this).parents("tr").find("td").eq(0).html();
        Swal.fire({
            title: '¿Esta seguro de Eliminar?',
            html: "¿Esta seguro de Eliminar  <br>" + "<b>"+ id +"</b>"+ "<br>" + "la lista de items?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $(this).parents("tr").fadeOut("normal", function () {
                    this.remove();
                    calcular_totales();
                });
            }
        });
    });


    $("#form").validate({
        ignore: "",
        rules: {
            nombre_cliente: "required",
            cod_cliente: "required",
            direccion: "required",
            cuidad: "required",
            telefono: "required",
            condicion_pago: {
                select_check: true
            },
            iva: {
                select_check: true
            },
            vendedor: {
                select_check: true
            },
        },
        errorPlacement: function(error,element) {
            return true;
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        }
    });


    $('#crear_pedido').click(function() {
        const form = $("#form").valid();
        if(form === true){
            let items = [];
            const encabezado = {
                vendedor: document.getElementById('vendedor').value,
                nombre_cliente: document.getElementById('nombre_cliente').value,
                cod_cliente: document.getElementById('cod_cliente').value,
                oc: document.getElementById('orden_compra').value,
                direccion: document.getElementById('direccion').value,
                ciudad: document.getElementById('ciudad').value,
                telefono: document.getElementById('telefono').value,
                condicion_pago: document.getElementById('condicion_pago').value,
                notas_generales: document.getElementById('notas_generales').value,
                descuento: document.getElementById('descuento').value,
                tiene_iva: document.getElementById('iva').value,
                total_bruto: document.getElementById('total_items_bruto').value,
                total_descuento: document.getElementById('total_items_descuento').value,
                subtotal: document.getElementById('total_items_subtotal').value,
                total_iva: document.getElementById('total_items_iva').value,
                total_pedido: document.getElementById('total_items').value
            };

            document.querySelectorAll('#tabla_items tbody tr').forEach(function(e){
                let fila = {
                    cod: e.querySelector('.item_cod_producto').innerText,
                    cod_prod_cliente: e.querySelector('.item_cod_client').innerText,
                    producto: e.querySelector('.item_descripcion').innerText,
                    destino: e.querySelector('.item_destino').innerText,
                    n_r: e.querySelector('.item_n_r').innerText,
                    arte: e.querySelector('.item_arte').innerText,
                    marca: e.querySelector('.item_marca').innerText,
                    notas: e.querySelector('.item_notas').innerText,
                    unidad: e.querySelector('.item_unidad').innerText,
                    precio: e.querySelector('.item_precio').innerText,
                    cantidad: e.querySelector('.item_cantidad').innerText,
                    total: e.querySelector('.item_total').innerText,
                };
                items.push(fila);
            });

            $.ajax({
                url: "/aplicaciones/pedidos/venta",
                type: "POST",
                data:{
                    encabezado,
                    items
                },
                dataType: 'json',
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado!',
                        text: data,
                    });
                    setTimeout(function() {
                        window.location.href = '/aplicaciones/pedidos/venta'
                    }, 2000);
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: data.responseText,
                    });
                }
            });
        }else{
            return false;
        }
    });


    $(document).on('click', '.ver_arte', function() {
        const Art = this.id;
        $('#arte_modal_title').html('Arte #'+ Art);
        PDFObject.embed('//192.168.1.12/intranet_ci/assets/Artes/'+Art+'.pdf', '#arte_modal_pdf');
        $('#arte_modal').modal('show');
    });


    $(document).on('click', '#add_info', function (){
        $('#add_info_modal').modal('show');
    });

    $(document).on('click', '#add_info_modal_save', function () {
        const form = $("#add_info_modal_form").valid();

        if(form === true){
            document.getElementById('agregar_item').disabled = false;

            var arte = document.getElementById('add_info_modal_art').value;
            var marca = document.getElementById('add_info_modal_marca').value;
            var cp_cliente = document.getElementById('add_info_modal_cp_client').value;
            var notas = document.getElementById('add_info_modal_notas').value;


            document.getElementById('notas_item').value = notas;
            document.getElementById('arte_item').value = arte;
            document.getElementById('marca_item').value = marca;
            document.getElementById('cod_cliente_item').value = cp_cliente;

            $('#add_info_modal').modal('hide');
        }else{
            return false;
        }
    });

    $('#add_info_modal_form').validate({
        ignore: "",
        rules: {
            add_info_modal_art: "required",
            add_info_modal_marca: "required",
            add_info_modal_cp_client: "required",
        },
        errorPlacement: function(error,element) {
            return true;
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        }
    });




    $('#add_info_modal_art').autocomplete({
        appendTo: '#add_info_modal',
        source: function (request, response) {
            const query = document.getElementById('add_info_modal_art').value;
            $.ajax({
                url: "/aplicaciones/pedidos/venta/listar_artes",
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
            });
        }
    });



    $('#add_info_modal_marca').autocomplete({
        appendTo: '#add_info_modal',
        source: function (request, response) {
            const query = document.getElementById('add_info_modal_marca').value;
            $.ajax({
                url: "/aplicaciones/pedidos/venta/listar_marcas",
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
            });
        }
    });





    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Por favor, rellena este campo.",
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
