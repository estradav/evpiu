@extends('layouts.architectui')

@section('page_title', 'Informes')

@section('module_title', 'Ordenes de Produccion')

@section('subtitle', 'Ordenes de produccion.')

@section('content')
    @can('informes.ordenes_produccion')
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="input-group col-6">
                        <input type="number" class="form-control" name="client" id="start" placeholder="Orden Inicial" aria-label="Cliente...">
                        <input type="number" class="form-control" name="client" id="end" placeholder="Orden Final" aria-label="Cliente...">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm btn-block" type="button" id="search">Buscar</button>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" type="button" id="generate_barcodes">Generar Codigo de barra</button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped" id="table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll" name="selectAll" class="selectAll"></th>
                                <td>ORDEN DE PRODUCCION</td>
                                <td>ACCIONES</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="printableArea" style="display: none">
            <div class="row">
                <div class="col-4">
                    <b>ORDEN:</b> <br>
                    <b>CANTIDAD:</b> <br>
                    <b>ID PIEZA:</b> <br>
                    <b>PEDIDO:</b> <br>
                </div>
                <div class="col-4 text-center">
                    <h2>CONTROL DE PRODUCCION</h2>
                </div>
                <div class="col-4">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Codigos de barras
                <div class="col-md-0 float-right">
                    <button class="btn btn-primary" onclick="printDiv()" >Imprimir</button>
                </div>
            </div>
            <div class="card-body" id="Barcodes">

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
            $(document).ready(function () {
                get_data();
                function get_data(start = '', end = ''){
                    $('#table').DataTable({
                        ajax: {
                            url:'informeordenproduccion_getdata',
                            data:{
                                start:start,
                                end:end
                            }
                        },
                        columns: [
                            {data: 'selectAll', name: 'selectAll', orderable: false, searchable: false },
                            {data: 'ORDNUM_10', name: 'ORDNUM_10', orderable: false, searchable: true},
                            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
                        ],
                        language: {
                                url: '/Spanish.json'
                            },
                            buttons: {
                                copy: "Copiar",
                                print: "Imprimir"
                            },

                            aria: {
                                sortAscending: ": Activar para ordenar la columna de manera ascendente",
                                sortDescending: ": Activar para ordenar la columna de manera descendente"
                            }
                        }
                    });
                }


                $('#search').on('click', function () {
                    var start   = $('#start').val();
                    var end     = $('#end').val();

                    if(start !== ''){
                        $('#table').DataTable().destroy();
                        get_data(start, end);

                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Hubo un error..Vuelve a intentarlo!',
                        });
                    }
                });




                $('body').on('click', '.ImprimirOrden', function () {
                    var selected =  [];
                    selected.push(this.id);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#Barcodes').html('');
                    $.ajax({
                        url:'/informeordenproduccion_barcode',
                        type: 'get',
                        data: {selected:selected},
                        success: function (data) {
                            $('#Barcodes').append(data)
                        }
                    });
                });





                $('#generate_barcodes').on('click',function () {
                    var selected = [];
                    $(".checkboxes").each(function () {
                        if (this.checked) {
                            selected.push(this.id);
                        }
                    });
                    if (selected.length) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $('#Barcodes').html('');
                        $.ajax({
                            cache: false,
                            type: 'get',
                            data: {
                                selected:selected
                            },
                            url: '/informeordenproduccion_barcode',
                            success: function (data) {
                                $('#Barcodes').append(data)

                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Hubo un error..!',
                                });
                            }
                        });
                    } else
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debes seleccionar al menos una orden...!',
                        });
                    return false;
                });


                $("#selectAll").on("click", function() {
                    $(".test").prop("checked", this.checked);
                });

                // if all checkbox are selected, check the selectall checkbox and viceversa
                $(".test").on("click", function() {
                    if ($(".test").length == $(".test:checked").length) {
                        $("#selectAll").prop("checked", true);
                    } else {
                        $("#selectAll").prop("checked", false);
                    }
                });
            });
            function printDiv() {
                var printContents = document.getElementById("Barcodes").innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
@endsection
