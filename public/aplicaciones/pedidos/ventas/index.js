$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#table').dataTable({
        ajax: {
            url:'/aplicaciones/pedidos/venta',
        },
        dom: 'Blfrtip',
        columns: [
            {data: 'id', name: 'id', orderable: false, searchable: true},
            {data: 'OrdenCompra', name: 'OrdenCompra', orderable: false, searchable: true},
            {data: 'Ped_MAX', name: 'Ped_MAX', orderable: false, searchable: true},
            {data: 'CodCliente', name: 'CodCliente', orderable: false, searchable: true},
            {data: 'cliente.RAZON_SOCIAL', name: 'cliente.RAZON_SOCIAL', orderable: false, searchable: true},
            {data: 'cliente.PLAZO', name: 'cliente.PLAZO', orderable: false, searchable: false},
            {data: 'Descuento', name: 'Descuento', orderable: false, searchable: false, render: $.fn.dataTable.render.number('', '', 0, '% ')},
            {data: 'Iva', name: 'Iva', orderable: false, searchable: false},
            {data: 'Estado', name: 'Estado', orderable: false, searchable: true},
            {data: 'created_at', name: 'created_at', orderable: false, searchable: false},
            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
        ],
        language: {
            url: '/Spanish.json'
        },
        order: [
            [ 0, "desc" ]
        ],
        rowCallback: function (row, data, index) {
            if (data.Estado == 1) {
                $(row).find('td:eq(8)').html('<span class="badge badge-info">Borrador</span>');
            }
            if (data.Estado == 0) {
                $(row).find('td:eq(8)').html('<span class="badge badge-danger">Anulado Vendedor</span>');
                $("#Reopen").prop('disabled',true);
            }
            if (data.Estado == 2) {
                $(row).find('td:eq(8)').html('<span class="badge badge-primary">Cartera</span>');
            }
            if (data.Estado == 3) {
                $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado Cartera</span>');
            }
            if (data.Estado == 4) {
                $(row).find('td:eq(8)').html('<span class="badge badge-primary">Costos</span>');
            }
            if (data.Estado == 5) {
                $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado Costos</span>');
            }
            if (data.Estado == 6) {
                $(row).find('td:eq(8)').html('<span class="badge badge-primary">Produccion</span>');
            }
            if (data.Estado == 7) {
                $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado Produccion</span>');
            }
            if (data.Estado == 8) {
                $(row).find('td:eq(8)').html('<span class="badge badge-primary">Bodega</span>');
            }
            if (data.Estado == 9) {
                $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado Bodega</span>');
            }
            if (data.Estado == 10) {
                $(row).find('td:eq(8)').html('<span class="badge badge-success">Completado</span>');
            }
            if (data.Estado == 11) {
                $(row).find('td:eq(8)').html('<span class="badge badge-primary">Troqueles</span>');
            }
            if (data.Estado == 12) {
                $(row).find('td:eq(8)').html('<span class="badge badge-warning">Rechazado Troqueles</span>');
            }

            if (data.Iva == 'Y') {
                $(row).find('td:eq(7)').html('<span class="badge badge-success">SI</span>');
            }
            else{
                $(row).find('td:eq(7)').html('<span class="badge badge-danger">NO</span>');
            }


            if (data.Ped_MAX){
                $(row).find('td:eq(2)').html('<span class="badge badge-success">'+ data.Ped_MAX +'</span>');
            }else{
                $(row).find('td:eq(2)').html('<span class="badge badge-danger">N/A</span>');
            }
        }
    });


    $(document).on('draw.dt', '#table', function() {
        $('[data-toggle="dropdown"]').dropdown();
    });




    $(document).on('click', '.promover', function (){
        const id = this.id;
        Swal.fire({
            title: '¿Enviar a cartera?',
            text: "¡Tu pedido sera enviado al area de cartera!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, enviar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/aplicaciones/pedidos/venta/enviar_cartera",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pedido enviado',
                        });
                        $('#table').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: '<b>'+ data.responseText +'</b>' ,
                        });
                    }
                });
            }
        });
    });


    $(document).on('click', '.anular', function () {
        const id = this.id;
        Swal.fire({
            title: '¿Anular pedido?',
            text: "¡Tu pedido sera anulado!, ¿Estas seguro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, anular!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/aplicaciones/pedidos/venta/anular_pedido",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pedido anulado',
                        });
                        $('#table').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: '<b>'+ data.responseText +'</b>' ,
                        });
                    }
                });
            }
        });
    });


    $(document).on('click', '.re_abrir', function () {
        const id = this.id;
        Swal.fire({
            title: '¿Re-abrir pedido?',
            text: "¡El pedido quedarada en estado borrador y podras editarlo o enviarlo al area de cartera",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Re-abrir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/aplicaciones/pedidos/venta/re_abrir_pedido",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pedido abierto',
                        });
                        $('#table').DataTable().ajax.reload();
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: '<b>'+ data.responseText +'</b>' ,
                        });
                    }
                });
            }
        });
    });


    $(document).on('click', '.clonar', function () {
        const id = this.id;
        Swal.fire({
            title: '¿Clonar pedido?',
            text: "Se clonara este pedido y seras enviado a la pantalla de edicion del nuevo pedido",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Clonar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "/aplicaciones/pedidos/venta/clonar_pedido",
                    type: "post",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pedido clonado con exito!',
                            text: 'El numero del nuevo pedido es '+ data + ', en los proximos 5 segundos seras redirigido a la pagina de edicion del nuevo pedido.'
                        });
                        setTimeout(function() {
                            window.location = "/aplicaciones/pedidos/venta/" + data + "/edit"
                        }, 4000);

                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: '<b>'+ data.responseText +'</b>' ,
                        });
                    }
                });
            }
        });
    });
});
