$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#table').DataTable({
        ajax: {
            url: '/aplicaciones/terceros/cliente'
        },
        columns: [
            {data:'CodigoMAX', name:'CodigoMAX'},
            {data:'NombreMAX', name:'NombreMAX'},
            {data:'NITMAX', name:'NITMAX'},
            {data:'EstadoMAX', name:'EstadoMAX', orderable:false, searchable:false},
            {data:'opciones', name:'opciones', orderable:false, searchable:false},
        ],
        language: {
            url: '/Spanish.json'
        },
        rowCallback: function (row, data, index) {
            if(data.estado === 'R'){
                $(row).find('td:eq(3)').html('<label class="text-danger">Retenido</label>');
            }else{
                $(row).find('td:eq(3)').html('<label class="text-success">Liberado</label>');
            }
        }
    });
});
