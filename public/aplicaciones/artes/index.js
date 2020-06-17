$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.dataTable').DataTable({
        ajax: "/aplicaciones/arte",
        scrollY: true,
        order: [
            [8, "desc"]
        ],
        columns: [
            {data: 'idRequerimiento', name: 'idRequerimiento'},
            {data: 'CodigoArte', name: 'idArte', render: function (data, type, row) {
                    return '<a href="javascript:void(0)" class=" btn btn-link btn-sm btnArt" id="' + data + '" >' + data + '</a>';
                }},
            {data: 'Producto', name: 'Producto'},
            {data: 'NombreMaterial', name: 'Material'},
            {data: 'NombreMarca', name: 'NombreMarca'},
            {data: 'NombreVendedor', name: 'Vendedor', orderable: false, searchable: false},
            {data: 'NombreDisenador', name: 'Disenador', orderable: false, searchable: false},
            {data: 'FechaSolicitud', name: 'FechaSolicitud', orderable: false, searchable: false},
            {data: 'FechaCreacion', name: 'FechaCreacion', orderable: false, searchable: false},
            {data: 'CodigoArte', name: 'CodigoArte', visible: false},
        ],
        language: {
            url: "/Spanish.json"
        }
    });

    $(document).on('click', '.btnArt', function() {
        let Art = this.id;
        $('#ViewArtTitle').html('Arte #'+ Art);
        PDFObject.embed("http://192.168.1.12/intranet_ci/assets/Artes/"+Art+".pdf", "#ViewArtPdf");
        $('#ViewArtModal').modal('show');
    });
});
