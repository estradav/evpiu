@extends('layouts.dashboard')

@section('page_title', 'Gestion de Terceros')

@section('module_title', 'Gestion de Terceros')

@section('subtitle', 'Este modulo permite Actualizar y Crear Clientes tanto en MAX como en DMS de forma simultanea.')

{{--@section('breadcrumbs')
    {{ Breadcrumbs::render('fact_electr_facturas') }}
@sto--}}

@section('content')
    @can('gestion_clientes.view')
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="NewCustomer">Crear Cliente</button>
           {{-- <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#submitModal">Open modal</button>--}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                Launch demo modal
            </button>
        </div>
        <br>

        <div class="card">
            <div class="card-header">
                Clientes
                <a class="right InfoCustomersTooltip" title="" data-placement="right" data-toggle="tooltip" href="javascript:void(0)" data-original-title="Esta tabla muestra los clientes que existen tanto en max como en DMS">
                  <span style="color: Mediumslateblue;">  <i class="fas fa-info-circle"></i> </span>
                </a>
            </div>
            <div class="card-body">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-responsive table-striped CustomerTable" id="CustomerTable">
                                    <thead>
                                        <tr>
                                            <th>Razon social</th>
                                            <th>NIT</th>
                                            <th>Codigo Cliente</th>
                                            <th>Ciudad</th>
                                            <th>Pais</th>
                                            <th>Estado</th>
                                            <th>Tipo Cliente</th>
                                            <th>Info</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="submitModal" class="multi-step">
        </div>


        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Registrar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="regForm" action="">
                            <!-- One "tab" for each step in the form: -->
                            <div class="tab">
                                <h2>Informacion de facturacion</h2>
                                <br>
                                <label for="">Razon Social:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Razon Social" oninput="this.className = 'form-control'"></p>
                                <label for="">Nit/CC:</label>
                                <p><input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Nit" oninput="this.className = 'form-control'"></p>
                                <label for="">Direccion 1:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Direccion 1" oninput="this.className = 'form-control'"></p>
                                <label for="">Direccion 2:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Direccion 2" oninput="this.className = 'form-control'"></p>
                                <label for="">Codigo Postal:</label>
                                <p><input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Codigo Postal" oninput="this.className = 'form-control'"></p>
                                <label for="">Razon Comercial:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Razon Comercial"></p>
                            </div>

                            <div class="tab">
                                <h2>Informacion de facturacion</h2>
                                <br>
                                <label for="">Pais:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Pais">
                                <label for="">Cuidad:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Ciudad">
                                <label for="">Contacto:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Nombre de Contacto">
                                <label for="">Telefono:</label>
                                <p><input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Telefono">
                                <label for="">Telefono 2:</label>
                                <p><input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Telefono 2">
                                <label for="">E-mail Contacto:</label>
                                <input type="email" class="form-control" id="Modal_Razon_Social" placeholder="E-mail Contacto">
                            </div>


                            <div class="tab">Contact Info:
                                <p><input placeholder="E-mail..." oninput="this.className = ''"></p>
                                <p><input placeholder="Phone..." oninput="this.className = ''"></p>
                            </div>

                            <div class="tab">Birthday:
                                <p><input placeholder="dd" oninput="this.className = ''"></p>
                                <p><input placeholder="mm" oninput="this.className = ''"></p>
                                <p><input placeholder="yyyy" oninput="this.className = ''"></p>
                            </div>

                            <div class="tab">Login Info:
                                <p><input placeholder="Username..." oninput="this.className = ''"></p>
                                <p><input placeholder="Password..." oninput="this.className = ''"></p>
                            </div>


                            <!-- Circles which indicates the steps of the form: -->
                            <div style="text-align:center;margin-top:40px;">
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" id="prevBtn" class="btn btn-primary" onclick="nextPrev(-1)">Anterior</button>
                                <button type="button" id="nextBtn" class="btn btn-primary" onclick="nextPrev(1)">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #regForm {
                background-color: #ffffff;
                margin: 0px auto;
                padding: 10px;
                width: 80%;
                min-width: 300px;
            }

            /* Style the input fields */
            input {
                padding: 10px;
                width: 100%;
                font-size: 17px;
                font-family: Raleway, serif;
                border: 1px solid #aaaaaa;
            }

            /* Mark input boxes that gets an error on validation: */
            input.invalid {
                background-color: #ffdddd;
            }

            /* Hide all steps by default: */
            .tab {
                display: none;
            }

            /* Make circles that indicate the steps of the form: */
            .step {
                height: 15px;
                width: 15px;
                margin: 0 2px;
                background-color: #bbbbbb;
                border: none;
                border-radius: 50%;
                display: inline-block;
                opacity: 0.5;
            }

            /* Mark the active step: */
            .step.active {
                opacity: 1;
            }

            /* Mark the steps that are finished and valid: */
            .step.finish {
                background-color: #4CAF50;
            }
        </style>
    @else
        <div class="alert alert-danger" role="alert">
            No tienes permisos para visualizar los clientes.
        </div>
    @endcan
    @push('javascript')
        <script>

            var currentTab = 0; // Current tab is set to be the first tab (0)
            showTab(currentTab); // Display the current tab

            function showTab(n) {
                // This function will display the specified tab of the form ...
                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";
                // ... and fix the Previous/Next buttons:
                if (n == 0) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "inline";
                }
                if (n == (x.length - 1)) {
                    document.getElementById("nextBtn").innerHTML = "Finalizar";
                } else {
                    document.getElementById("nextBtn").innerHTML = "Siguiente";
                }
                // ... and run a function that displays the correct step indicator:
                fixStepIndicator(n)
            }

            function nextPrev(n) {
                // This function will figure out which tab to display
                var x = document.getElementsByClassName("tab");
                // Exit the function if any field in the current tab is invalid:
                if (n == 1 && !validateForm()) return false;
                // Hide the current tab:
                x[currentTab].style.display = "none";
                // Increase or decrease the current tab by 1:
                currentTab = currentTab + n;
                // if you have reached the end of the form... :
                if (currentTab >= x.length) {
                    //...the form gets submitted:
                    document.getElementById("regForm").submit();
                    return false;
                }
                // Otherwise, display the correct tab:
                showTab(currentTab);
            }

            function validateForm() {
                // This function deals with validation of the form fields
                var x, y, i, valid = true;
                x = document.getElementsByClassName("tab");
                y = x[currentTab].getElementsByTagName("input");
                // A loop that checks every input field in the current tab:
                for (i = 0; i < y.length; i++) {
                    // If a field is empty...
                    if (y[i].value == "") {
                        // add an "invalid" class to the field:
                        y[i].className += " invalid";
                        // and set the current valid status to false:
                        valid = false;
                    }
                }
                // If the valid status is true, mark the step as finished and valid:
                if (valid) {
                    document.getElementsByClassName("step")[currentTab].className += " finish";
                }
                return valid; // return the valid status
            }

            function fixStepIndicator(n) {
                // This function removes the "active" class of all steps...
                var i, x = document.getElementsByClassName("step");
                for (i = 0; i < x.length; i++) {
                    x[i].className = x[i].className.replace(" active", "");
                }
                //... and adds the "active" class to the current step:
                x[n].className += " active";
            }


            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.CustomerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    autoWidth: false,
                    ajax: {
                        url: '/GestionClientes_Index'
                    },
                    columns: [
                        {data: 'razon_social', name:'razon_social'},
                        {data: 'nit', name: 'nit'},
                        {data: 'codigo_cliente', name: 'codigo_cliente'},
                        {data: 'ciudad', name: 'ciudad'},
                        {data: 'pais', name: 'pais'},
                        {data: 'estado', name: 'estado', orderable: false, searchable: false},
                        {data: 'tipo_cliente', name: 'tipo_cliente', orderable: false, searchable: false},
                        {data: 'info', name: 'info', orderable: false, searchable: false},
                        {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
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
                    }
                });

                $('.InfoCustomersTooltip').tooltip();


            });
        </script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
        <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js" ></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.10/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">





    @endpush
@stop
