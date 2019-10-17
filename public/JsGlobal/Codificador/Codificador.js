$(document).ready(function(){
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/CodigosIndex",
            columns: [
                {data: 'codigo', name: 'codigo'},
                {data: 'desc', name: 'desc'},
                {data: 'tp', name: 'tp'},
                {data: 'lin', name: 'lin'},
                {data: 'subl', name: 'subl'},
                {data: 'med', name: 'med'},
                {data: 'car', name: 'car'},
                {data: 'mat', name: 'mat'},
                {data: 'coment', name: 'coment'},
                {data: 'Opciones', name: 'Opciones', orderable: false, searchable: false},
            ],
            language: {
                // traduccion de datatables
                processing: "Procesando...",
                search: "Buscar&nbsp;:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún registro disponible en esta tabla :C",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Ultimo"
                },
                aria: {
                    sortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sortDescending: ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        $('#CrearCodigo').click(function () {
            $('#saveBtn').val("create-codigo");
            $('#Codigo_id').val('');
            $('#CodigoForm').trigger("reset");
            $('#modelHeading').html("Crear Nuevo Codigo");
            $('#Codigomodal').modal('show');
        });

        $('body').on('click', '.editCodigo', function () {

            var codigo_id = $(this).data('id');
            $.get("/ProdCievCodCodigo" +'/' + codigo_id +'/edit', function (data) {
                $('#modelHeading').html("Editar Codigo");
                $('#saveBtn').val("edit-Medida");
                $('#Codigomodal').modal('show');
                $('#medida_id').val(data.id);
                $('#codigo').val(data.codigo);
                $('#descripcion').val(data.descripcion);
                $('#tipoproducto_id').val(data.tipoproducto_id);
                $('#lineas_id').val(data.lineas_id);
                $('#sublineas_id').val(data.sublineas_id);
                $('#medida_id').val(data.medida_id);
                $('#caracteristica_id').val(data.caracteristica_id);
                $('#material_id').val(data.material_id);
                $('#coments').val(data.coments);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            //$(this).html('Guardando...');
            $.ajax({
                data: $('#CodigoForm').serialize(),
                url: "/CodigosPost",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#CodigoForm').trigger("reset");
                    $('#Codigomodal').modal('hide');
                    table.draw();
                    toastr.success("Registro Guardado con Exito!");
                    //   $(this).html('Crear');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Guardar Cambios');
                }
            });
        });

        $('body').on('click', '.deleteCodigo', function () {

            var codigo_id = $(this).data("id");
            if(confirm("¿Esta seguro de Eliminar?")) {
                $.ajax({
                    type: "DELETE",
                    url: "/ProdCievCodCodigo" + '/' + codigo_id,
                    success: function (data) {
                        table.draw();
                        toastr.success("Registro eliminado con exito");
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        toastr.danger("Error al eliminar el registro");
                    }
                });
            }
        });
    });

    $('#tipoproducto_id').on('change', function () {
        var tipoproducto_id = $(this).val();
        if ($.trim(tipoproducto_id) != ''){
            $.get('getlineas',{tipoproducto_id: tipoproducto_id}, function(getlineas) {
                $('#lineas_id').empty();
                $('#sublineas_id').empty();
                $('#caracteristica_id').empty();
                $('#material_id').empty();
                $('#medida_id').empty();

                $('#lineas_id').append("<option value=''>Seleccione una Linea...</option>");
                $('#sublineas_id').append("<option value=''>Seleccione una Sublinea...</option>");
                $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");

                $.each(getlineas, function (index, value) {
                    $('#lineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
            $.get('ctp',{tipoproducto_id: tipoproducto_id}, function(ctp) {
                $('#ctp-g').empty();
                $.each(ctp, function (index, value) {
                    document.getElementById("ctp-g").value=index;
                })
            });
        }
    });

    $('#lineas_id').on('change', function () {
        var lineas_id = $(this).val();
        if ($.trim(lineas_id) != ''){
            $.get('getsublineas',{lineas_id: lineas_id}, function(getsublineas) {
                $('#sublineas_id').empty();
                $('#caracteristica_id').empty();
                $('#material_id').empty();
                $('#medida_id').empty();
                $('#sublineas_id').append("<option value=''>Seleccione una Sublinea...</option>");
                $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");
                $.each(getsublineas, function (index, value) {
                    $('#sublineas_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
            $.get('lns',{lineas_id: lineas_id}, function(lns) {
                $('#lin-g').empty();
                $.each(lns, function (index, value) {
                    document.getElementById("lin-g").value=index;
                    document.getElementById("lin-d").value=value;
                    // $('#codigo')
                })
            });
        }
    });

    $('#sublineas_id').on('change', function () {
        var car_sublineas_id = $(this).val();
        if ($.trim(car_sublineas_id) != ''){
            $.get('getcaracteristica',{car_sublineas_id: car_sublineas_id}, function(getcaracteristica) {
                $('#caracteristica_id').empty();
                $('#caracteristica_id').append("<option value=''>Seleccione una Caracteristica...</option>");
                $.each(getcaracteristica, function (index, value) {
                    $('#caracteristica_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }

        var mat_sublineas_id = $(this).val();
        if ($.trim(mat_sublineas_id) != ''){
            $.get('getmaterial',{mat_sublineas_id: mat_sublineas_id}, function(getmaterial) {
                $('#material_id').empty();
                $('#material_id').append("<option value=''>Seleccione un Material...</option>");
                $.each(getmaterial, function (index, value) {
                    $('#material_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }

        var med_sublineas_id = $(this).val();
        if ($.trim(med_sublineas_id) != ''){
            $.get('getmedida',{med_sublineas_id: med_sublineas_id}, function(getmedida) {
                $('#medida_id').empty();
                $('#medida_id').append("<option value=''>Seleccione una Medida...</option>");
                $.each(getmedida, function (index, value) {
                    $('#medida_id').append("<option value='" + index + "'>"+ value +"</option>");
                })
            });
        }
        $.get('sln',{sublineas_id: med_sublineas_id}, function(sln) {
            $('#sln-g').empty();
            $.each(sln, function (index, value) {
                document.getElementById("sln-g").value=index;
                document.getElementById("sln-d").value=value;
            })
        });

        var material_id = $(this).val();
        if ($.trim(material_id) != '') {
            $.get('mat', {material_id: material_id}, function (mat) {
                $('#mat-g').empty();
                $.each(mat, function (index, value) {
                    document.getElementById("mat-g").value = index;
                    document.getElementById("mat-d").value = value;
                })
            });
        }

        var caracteristica_id = $(this).val();
        if ($.trim(caracteristica_id) != '') {
            $.get('car', {caracteristica_id: caracteristica_id}, function (car) {
                $('#car-d').empty();
                $.each(car, function (index, value) {
                    document.getElementById("car-d").value = value;
                    // $('#codigo')
                })
            });
        }
    });

    $('#medida_id').on('change', function () {
        var medida_id = $(this).val();
        if ($.trim(medida_id) != '') {
            $.get('med', {medida_id: medida_id}, function (med) {
                $('#med-d').empty();
                $.each(med, function (index, value) {
                    document.getElementById("med-d").value = value;
                    // $('#codigo')
                })
            });
        }

        tipoProducto=document.getElementById('ctp-g').value;
        Linea=document.getElementById('lin-g').value;
        Sublinea=document.getElementById('sln-g').value;
        material=document.getElementById('mat-g').value;
        final=tipoProducto+Linea+Sublinea+material;
        document.getElementById('codigo').value=final;

        DLinea=document.getElementById('lin-d').value;
        DSublinea=document.getElementById('sln-d').value;
        Dcaracteristica=document.getElementById('car-d').value;
        Dmaterial=document.getElementById('mat-d').value;
        Dmedida=document.getElementById('med-d').value;

        Dfinal=DLinea+' '+DSublinea+' '+Dcaracteristica+' '+Dmaterial+' '+Dmedida;
        document.getElementById('descripcion').value=Dfinal;
    });
});
