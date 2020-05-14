@extends('layouts.architectui')

@section('page_title', 'Administracion medida de prevencion')

@section('content')
    @can('admin_medida_prevencion')
        <div class="main-card mb-3 card">
            <div class="card-body">
                <div class="row">
                   <ul>
                       <li>Ingrese la fecha de inicio y final para generar un informe detallado.</li>
                       <li>Se descarga un archivo en formato PDF con toda la informacion.</li>
                   </ul>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Fecha inicial" id="date">
                            <div class="input-group-append">
                                <button class="btn btn-success btn-lg btn-block" id="download">DESCARGAR INFORME</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-card mb-3 card">
            <div class="card-body">
                <table class="table" id="empleados_table">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">EMPLEADO</th>
                        <th scope="col" class="text-center">ESTADO</th>
                        <th scope="col" class="text-center">ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($registros as $registro)
                        <tr>
                            <td class="text-center">{{ $registro->employee }}</td>
                            <td class="text-center">
                                @if($registro->state == 1)
                                    <span class="badge badge-primary">trabajando</span>
                                @else
                                    <span class="badge badge-success">en casa</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('edit_medida_prevencion.edit', $registro->id) }}" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Ver/Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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
@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#empleados_table').dataTable({
                language: {
                    url: "/Spanish.json"
                }
            });
            let star_date = moment().format('YYYY-MM-DD'), end_date = moment().format('YYYY-MM-DD');

            moment.locale('es');
            $('input[id="date"]').daterangepicker({
                drops: 'down',
                open: 'center',
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },

            }, function(start, end, label) {
                star_date = start.format('YYYY-MM-DD');
                end_date = end.format('YYYY-MM-DD');
            });

            $('#download').on('click',function () {
                $.ajax({
                    cache: false,
                    type: 'POST',
                    url: 'download_informe_medida_prevencion',
                    data: {
                        star_date, end_date
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function (response, status, xhr) {
                        var filename = "";
                        var disposition = xhr.getResponseHeader('Content-Disposition');

                        if (disposition) {
                            var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                            var matches = filenameRegex.exec(disposition);
                            if (matches !== null && matches[1]) filename = matches[1].replace(/['"]/g, '');
                        }
                        var linkelem = document.createElement('a');
                        try {
                            var blob = new Blob([response], { type: 'application/octet-stream' });

                            if (typeof window.navigator.msSaveBlob !== 'undefined') {
                                window.navigator.msSaveBlob(blob, filename);
                            } else {
                                var URL = window.URL || window.webkitURL;
                                var downloadUrl = URL.createObjectURL(blob);

                                if (filename) {
                                    var a = document.createElement("a");

                                    if (typeof a.download === 'undefined') {
                                        window.location = downloadUrl;
                                    } else {
                                        a.href = downloadUrl;
                                        a.download = filename;
                                        document.body.appendChild(a);
                                        a.target = "_blank";
                                        a.click();
                                    }
                                } else {
                                    window.location = downloadUrl;
                                }
                            }
                        } catch (ex) {
                            console.log(ex);
                        }
                    }
                });
            })
        });
    </script>
@endpush
