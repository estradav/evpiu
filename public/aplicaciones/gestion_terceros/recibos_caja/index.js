$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#table').dataTable({
        language:{
            url: '/Spanish.json'
        }
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
});
