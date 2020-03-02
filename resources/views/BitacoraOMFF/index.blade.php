@extends('layouts.dashboard')

@section('page_title', 'Bitacora OMFF')

@section('module_title', 'Bitacora OMFF')

@section('subtitle', 'Bitacora de operacion y mantenimiento de fuentes fijas.')

@section('content')
    @can('bitacoraomff')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-responsive table-striped" id="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th style="width: 50%">FECHA DE REGISTRO</th>
                                <th style="width: 50%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade bd-modal-lg" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="infoModalHeader"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="infoModalBody" style="margin-left: 10% !important; margin-right: 10% !important; ">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            td.details-control {
                background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
                cursor: pointer;
            }
            tr.shown td.details-control {
                background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
            }
            .preloader {
                width: 140px;
                height: 140px;
                border: 20px solid #eee;
                border-top: 20px solid #008000;
                border-radius: 50%;
                animation-name: girar;
                animation-duration: 1s;
                animation-iteration-count: infinite;
            }
            @keyframes girar {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(360deg);
                }
            }
            .loading {
                font-size: 30px;
            }

            .loading:after {
                overflow: hidden;
                display: inline-block;
                vertical-align: bottom;
                -webkit-animation: ellipsis steps(4,end) 900ms infinite;
                animation: ellipsis steps(4,end) 900ms infinite;
                content: "\2026"; /* ascii code for the ellipsis character */
                width: 0px;
            }

            @keyframes ellipsis {
                to {
                    width: 1.25em;
                }
            }

            @-webkit-keyframes ellipsis {
                to {
                    width: 1.25em;
                }
            }
            .center {
                margin: auto;
                width: 14%;
                padding: 6px;
            }
        </style>
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                 var table = $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    width:"100%",
                    ajax: {
                        url: '/get_bitacoraomff'
                    },
                    columns: [
                        {data:'date', name:'date', orderable:true, searchable:true},
                        {data:'Opciones', name:'Opciones', orderable:false, searchable:false},
                    ],
                    columnDefs: [
                        {
                            width: "25%",
                            targets: 0
                        }
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
                        aria: {
                            sortAscending: ": Activar para ordenar la columna de manera ascendente",
                            sortDescending: ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                });

                $('body').on('click','.info',function () {
                    var date = this.id;
                    $('#infoModal').modal('show');
                    $('#infoModalHeader').html('<i class="fas fa-sync-alt fa-spin"></i>');
                    $('#infoModalBody').html('<div style="margin-left: 20px" <h1 class="loading"> Cargando Informacion, un momento por favor</h1></div>');
                    $.ajax({
                        url: '/get_details_bitacoraomff',
                        type: 'get',
                        data: {date: date},
                        success: function (data) {
                            $('#infoModalHeader').html(date);
                            $('#infoModalBody').html('');
                            $(data).each(function () {
                                if (data.turno1.length > 0){
                                    var i = 0;
                                    $('#infoModalBody').append('<h2>Turno 6:00 a.m - 2:00 p.m:</h2>' +
                                        '<div class="table-responsive">' +
                                        '<table class="table table-responsive table-striped turno1" id="turno1">' +
                                        '<thead>' +
                                        '<tr>' +
                                        '<th style="width: 15%;">MAQUINA</th>' +
                                        '<th>TB</th>' +
                                        '<th>RZ</th>' +
                                        '<th>VZ</th>' +
                                        '<th>Z</th>' +
                                        '<th>TOTAL</th>' +
                                        '<th>% CO</th>' +
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody id="turno1body"></tbody>' +
                                        '</table>' +
                                        '</div> <br>');

                                    $(data.turno1).each(function () {
                                        var total_lingotes = parseInt(data.turno1[i].tb) + parseInt(data.turno1[i].rz) + parseInt(data.turno1[i].vz) + parseInt(data.turno1[i].z);
                                        var carga_operacion = (parseInt(data.turno1[i].tb) * 25)/ 17 + (parseInt(data.turno1[i].rz) * 50)/ 8.3 + (parseInt(data.turno1[i].vz) * 15)/ 14 + (parseInt(data.turno1[i].z) * 10)/ 3;

                                        $('#turno1body').append('<tr>' +
                                            '<td>'+data.turno1[i].machine +'</td>' +
                                            '<td>'+data.turno1[i].tb +'</td>' +
                                            '<td>'+data.turno1[i].rz +'</td>' +
                                            '<td>'+data.turno1[i].vz +'</td>' +
                                            '<td>'+data.turno1[i].z +'</td>' +
                                            '<td>'+ total_lingotes  +'</td>' +
                                            '<td>'+ carga_operacion.toFixed(2) +' % </td>' +
                                            '</tr>');
                                        i++;
                                    });
                                }else if (data.turno1.length == 0){
                                    $('#infoModalBody').append('<h2>Turno 6:00 a.m - 2:00 p.m:</h2> <br> <div class="alert alert-danger" role="alert">Sin datos registrados..</div>')
                                }

                                if (data.turno2.length > 0){
                                    var i = 0;
                                    $('#infoModalBody').append('<h2>Turno 2:00 p.m - 10:00 p.m:</h2>' +
                                        '<div class="table-responsive">' +
                                        '<table class="table table-responsive table-striped turno2" id="turno2">' +
                                        '<thead>' +
                                        '<tr>' +
                                        '<th style="width: 15%;">MAQUINA</th>' +
                                        '<th>TB</th>' +
                                        '<th>RZ</th>' +
                                        '<th>VZ</th>' +
                                        '<th>Z</th>' +
                                        '<th>TOTAL</th>' +
                                        '<th>% CO</th>' +
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody id="turno2body"></tbody>' +
                                        '</table>' +
                                        '</div> <br>');

                                    $(data.turno2).each(function () {

                                        console.log(data.turno2);
                                        var total_lingotes = parseInt(data.turno2[i].tb) + parseInt(data.turno2[i].rz) + parseInt(data.turno2[i].vz) + parseInt(data.turno2[i].z);
                                        var carga_operacion = (parseInt(data.turno2[i].tb) * 25)/ 17 + (parseInt(data.turno2[i].rz) * 50)/ 8.3 + (parseInt(data.turno2[i].vz) * 15)/ 14 + (parseInt(data.turno2[i].z) * 10)/ 3;

                                        $('#turno2body').append('<tr>' +
                                            '<td>'+data.turno2[i].machine +'</td>' +
                                            '<td>'+data.turno2[i].tb +'</td>' +
                                            '<td>'+data.turno2[i].rz +'</td>' +
                                            '<td>'+data.turno2[i].vz +'</td>' +
                                            '<td>'+data.turno2[i].z +'</td>' +
                                            '<td>'+ total_lingotes  +'</td>' +
                                            '<td>'+ carga_operacion.toFixed(2) +' % </td>' +
                                            '</tr>');
                                        i++;
                                    });
                                }else if (data.turno2.length == 0) {
                                    $('#infoModalBody').append('<h2>Turno 2:00 p.m - 10:00 p.m:</h2> <div class="alert alert-danger" role="alert">Sin datos registrados..</div>')
                                }

                                if (data.turno3.length > 0){
                                    var i = 0;
                                    $('#infoModalBody').append('<h2>Turno 10:00 p.m - 6:00 a.m:</h2>' +
                                        '<div class="table-responsive">' +
                                        '<table class="table table-responsive table-striped turno3" id="turno3">' +
                                        '<thead>' +
                                        '<tr>' +
                                        '<th style="width: 15%;">MAQUINA</th>' +
                                        '<th>TB</th>' +
                                        '<th>RZ</th>' +
                                        '<th>VZ</th>' +
                                        '<th>Z</th>' +
                                        '<th>TOTAL</th>' +
                                        '<th>% CO</th>' +
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody id="turno3body"></tbody>' +
                                        '</table>' +
                                        '</div> <br>');

                                    $(data.turno3).each(function () {

                                        console.log(data.turno3);
                                        var total_lingotes = parseInt(data.turno3[i].tb) + parseInt(data.turno3[i].rz) + parseInt(data.turno3[i].vz) + parseInt(data.turno3[i].z);
                                        var carga_operacion = (parseInt(data.turno3[i].tb) * 25)/ 17 + (parseInt(data.turno3[i].rz) * 50)/ 8.3 + (parseInt(data.turno3[i].vz) * 15)/ 14 + (parseInt(data.turno3[i].z) * 10)/ 3;

                                        $('#turno3body').append('<tr>' +
                                            '<td>'+data.turno3[i].machine +'</td>' +
                                            '<td>'+data.turno3[i].tb +'</td>' +
                                            '<td>'+data.turno3[i].rz +'</td>' +
                                            '<td>'+data.turno3[i].vz +'</td>' +
                                            '<td>'+data.turno3[i].z +'</td>' +
                                            '<td>'+ total_lingotes  +'</td>' +
                                            '<td>'+ carga_operacion.toFixed(2) +' % </td>' +
                                            '</tr>');
                                        i++;
                                    });
                                }else if (data.turno3.length == 0){
                                    $('#infoModalBody').append('<h2>Turno 10:00 p.m - 6:00 a.m:</h2> <div class="alert alert-danger" role="alert">Sin datos registrados..</div>')
                                }
                            });
                            console.log(data)
                        }
                    });
                })
            });
        </script>
    @endpush
@endsection
