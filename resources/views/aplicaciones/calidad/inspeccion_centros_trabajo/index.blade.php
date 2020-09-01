@extends('layouts.architectui')

@section('page_title', 'Control de calidad')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'aplicaciones_calidad_revision' ]) !!}
@endsection

@section('content')
    @can('aplicaciones.calidad.revision')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-check icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Calidad
                        <div class="page-title-subheading">
                            Control de calidad
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="input-group">
                                    <input type="text" class="form-control" aria-label="search" aria-describedby="search" id="search" name="search">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary btn-block" type="button" id="search_button">CONSULTAR OP</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card card">
                    <div class="card-body" id="result_search">
                        <div class="alert alert-info text-center" role="alert">
                            <h4 class="alert-heading text-center">
                                <i class="fas fa-info-circle fa-3x"></i> <br>
                                <b>Por favor, realice una busqueda para ver la informacion..!</b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
@endsection

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function (){
            $(document).on('click', '#search_button', function () {
                let production_order = document.getElementById('search').value;

                if (production_order !== ''){
                    $.ajax({
                        url: '/aplicaciones/calidad/revision/consultar_op',
                        type: 'get',
                        data: {
                            production_order: production_order
                        },
                        success: function (data) {
                            if (data.length === 0){
                                $('#result_search').html('').append(`
                                    <div class="alert alert-warning text-center" role="alert">
                                        <h4 class="alert-heading text-center">
                                            <i class="fas fa-exclamation-triangle fa-4x"></i><br>
                                            <b>¡No se encontro infomacion!</b>
                                        </h4>
                                        <h5>Por favor verifique que el numero de la orden de produccion sea correcto!</h5>
                                    </div>
                                `);
                            }else{

                            }
                        },
                        error: function(jqXHR, textStatus, err){
                            console.log('text status '+textStatus+', err '+err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Aceptar',
                            })
                        }
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Debes escribir el numero de la orden de produccion..!',
                    });
                }
            });
        });
    </script>
@endpush
