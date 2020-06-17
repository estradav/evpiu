$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#SaveFacturas').on('click', function () {
        const fac_idnumeracion = $('#fac_idnumeracion').val();
        const fac_idambiente = $('#fac_idambiente').val();
        const fac_idreporte = $('#fac_idreporte').val();

        $.ajax({
            url: "/aplicaciones/facturacion_electronica/configuracions/facturas",
            type: "post",
            data:{
                fac_idnumeracion: fac_idnumeracion,
                fac_idambiente: fac_idambiente,
                fac_idreporte: fac_idreporte
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Informacion actualizada',
                    text: data,
                });
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error en la solicitud',
                    text: data,
                });
            }
        })
    });

    $('#SaveNC').on('click', function () {
        const nc_idnumeracion = $('#nc_idnumeracion').val();
        const nc_idambiente = $('#nc_idambiente').val();
        const nc_idreporte = $('#nc_idreporte').val();

        $.ajax({
            url: "/aplicaciones/facturacion_electronica/configuracions/notas_credito",
            type: "post",
            data:{
                nc_idnumeracion: nc_idnumeracion,
                nc_idambiente: nc_idambiente,
                nc_idreporte: nc_idreporte
            },
            success: function (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'Informacion actualizada',
                    text: data,
                });
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Hubo un error en la solicitud',
                    text: data,
                });
            }
        })
    })
});
