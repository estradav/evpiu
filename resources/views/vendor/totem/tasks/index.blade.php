@extends('layouts.architectui')

@section('page_title', 'Tareas programadas')

@section('content')
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary " href="{{route('totem.task.create')}}">Nueva tarea</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped first data-table">
                    <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Conteo</th>
                            <th>Ultima ejecucion</th>
                            <th>Proxima ejecucion</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr>
                            <td><a href="{{ route('totem.task.view', $task)}}">{{ $task->description }}</a></td>
                            <td>{{ $task->average_runtime }}</td>
                            <td>{{ $task->last_ran_at }}</td>
                            <td>{{ $task->upcoming }}</td>
                            <td><a href="{{ route('totem.task.execute', $task)}}" class="btn btn-primary">Ejecutar </a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <div class="col-6">
                <div class="text-left">
                    <a href="{{route('totem.tasks.import')}}" class="btn btn-primary"> Importar</a>
                </div>
            </div>
            <div class="col-6">
                <div class="text-right">
                    <a class="btn btn-primary" href="{{route('totem.tasks.export')}}"> Exportar</a>
                </div>
            </div>
        </div>
    </div>
    @push('javascript')
        <script>
            $(document).ready(function() {
                $('.data-table').DataTable({
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
            } );
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    @endpush
@stop
