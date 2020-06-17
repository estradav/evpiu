@extends('layouts.architectui')

@section('page_title','Gestion')

@section('content')
    @can('aplicaciones.facturacion_electronica.gestion.index')
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-diamond icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>Gestion de facturacion electronica
                        <div class="page-title-subheading">
                            Gestion y auditoria de documentos subidos al WebService de fenalco.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="input-group">
                            <input type="text" name="from_date" id="date" class="form-control" placeholder="Fecha inicial" />
                            <input type="number" name="fe_start" id="fe_start" class="form-control" placeholder="Factura Inicia"/>
                            <input type="number" name="fe_end" id="fe_end" class="form-control" placeholder="Factura Final"/>
                            <select name="type_doc" id="type_doc" class="form-control">
                                <option value="1">Factura</option>
                                <option value="2">Nota Debito</option>
                                <option value="3">Nota Credito</option>
                            </select>
                            <div class="btn-group input-group-append">
                                <button class="btn btn-primary" id="filter">
                                    <i class="fas fa-search"></i>
                                    Filtrar
                                </button>
                                <button class="btn btn-primary" id="Auditar">
                                    <i class="fas fa-file-invoice"></i>
                                    <i class="fas fa-check-double"></i>
                                    Auditar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>ID FACTIBLE</th>
                                        <th>FACTURA/NOTA</th>
                                        <th>TIPO</th>
                                        <th>CLIENTE</th>
                                        <th>NIT/CC</th>
                                        <th>F. GENERACION</th>
                                        <th>F. REGISTRO</th>
                                        <th>ESTADO DIAN</th>
                                        <th>ESTADO CLIENTE</th>
                                        <th class="text-center">ACCIONES</th>
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
    @else
        <div class="main-card mb-3 card">
            <div class="card-body text-center">
                <i class="fas fa-exclamation-triangle fa-4x" style="color: red"></i>
                <h3 class="card-title" style="color: red"> ACCESO DENEGADO </h3>
                <h3 class="card-text" style="color: red">No tiene permiso para usar esta aplicación, por favor comuníquese a la ext: 102 o escribanos al correo electrónico: auxsistemas@estradavelasquez.com para obtener acceso.</h3>
            </div>
        </div>
    @endcan
    @push('javascript')
        <script type="text/javascript" src="{{ asset('aplicaciones/facturacion_electronica/gestion/index.js') }}"></script>
    @endpush
@endsection
