@extends('layouts.architectui')

@section('page_title', 'Informes')

@section('module_title', 'Control Entregas')

@section('subtitle', 'Informe de Control de entregas por cliente.')

@section('content')
    @can('informes.inventarios')
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="input-group col-6">
                        <input type="text" class="form-control" name="client" id="client" placeholder="Escriba al menos dos caracteres para comenzar la busqueda..." aria-label="Cliente..." aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="button" id="get_data" disabled style="height: 85% !important; ">OBTENER INFORMACION</button>
                        </div>
                    </div>
                    <div class="input-group col-6">
                        <div class="input-group-prepend" style="height: 85% !important;">
                            <span class="input-group-text" id=""><i class="fas fa-user-tie"></i> &nbsp; Cliente:</span>
                        </div>
                        <input type="text" id="client_name" class="form-control" disabled>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped" id="table">
                        <thead>
                            <tr>
                                <td>CODIGO</td>
                                <td>PRODUCTO</td>
                                <td>CODIGO EV</td>
                                <td>INVENTARIO</td>
                                <td>PROYECCION</td>
                                <td>CANT. COMPROMETIDA</td>
                                <td>CONSUMO</td>
                                <td>TOTAL DISPONIBLE</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
    @push('javascript')
        <script>
            $(document).ready(function() {
                var cod_client = '';

                function get_data_peer_customer(customer = ''){
                    $('#table').DataTable({
                        ajax: {
                            url:'/informecontrolentrega_get',
                            data:{
                                customer:customer,
                            }
                        },
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        language: {
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
                            buttons: {
                                copy: "Copiar",
                                print: "Imprimir"
                            },

                            aria: {
                                sortAscending: ": Activar para ordenar la columna de manera ascendente",
                                sortDescending: ": Activar para ordenar la columna de manera descendente"
                            }
                        },
                        initComplete: function () {
                            $('.buttons-copy').removeClass('dt-button buttons-copy buttons-html5').addClass('buttons-copy btn btn-primary btn-sm').html('<span class="fas fa-copy" data-toggle="tooltip" title="Exportan en excel"/> COPIAR');
                            $('.buttons-csv').removeClass('dt-button buttons-csv buttons-html5').addClass('buttons-csv btn btn-primary btn-sm').html('<span class="fas fa-file-csv" data-toggle="tooltip" title="Exportan en excel"/> CSV');
                            $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass('buttons-excel btn btn-primary btn-sm').html('<span class="fas fa-file-excel" data-toggle="tooltip" title="Exportan en excel"/> EXCEL');
                            $('.buttons-pdf').removeClass('dt-button buttons-pdf buttons-html5').addClass('buttons-pdf btn btn-primary btn-sm').html('<span class="fas fa-file-pdf" data-toggle="tooltip" title="Exportan en excel"/> PDF');
                            $('.buttons-print').removeClass('dt-button buttons-print buttons-html5').addClass('buttons-print btn btn-primary btn-sm').html('<span class="fas fa-print" data-toggle="tooltip" title="Exportan en excel"/> IMPRIMIR');
                        }
                    });
                }




                $("#client" ).autocomplete({
                    source: function (request, response) {
                        var client = $("#client").val();
                        $.ajax({
                            url: "/SearchClients",
                            method: "get",
                            data: {
                                query: client,
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                console.log(data);
                                response(resp);
                            }
                        })
                    },
                    focus: function( event, ui ) {
                        $('#client_name').val([ui.item.value]);
                        return true;
                    },
                    select: function(event, ui)	{
                        $('#client_name').val([ui.item.value]);
                        cod_client = [ui.item.CodigoCliente];
                        $('#get_data').removeAttr('disabled');
                    },
                    minlength: 2
                });

                $('#get_data').on('click', function () {
                    if(cod_client !== '' ){
                        $('#table').DataTable().destroy();
                        get_data_peer_customer(cod_client);

                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hubo un error..Vuelve a intentarlo!',
                        });
                    }
                    $('#client').val('');
                    document.getElementById("get_data").disabled = true;
                });




            });

        </script>

        <link href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>









    @endpush
@endsection
