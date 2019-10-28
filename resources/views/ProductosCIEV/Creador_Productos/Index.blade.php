@extends('layouts.dashboard')

@section('page_title', 'Creador de Productos')

@section('module_title', 'Creador de Productos')

@section('subtitle', 'Este modulo permite Crear y Clonar productos de MAX.')

{{--@section('breadcrumbs')
    {{ Breadcrumbs::render('Prod_ciev_maestros_lineas') }}
@stop--}}
@section('content')
    @inject('CodigoClase','App\Services\CodigoClase')
    @inject('AlmacenPreferido','App\Services\AlmacenPreferido')
    @inject('Planificador','App\Services\Planificador')
    @inject('CodigoComodidad','App\Services\CodigoComodidad')
    @inject('Comprador','App\Services\Comprador')
    @inject('TipoCuenta','App\Services\TipoCuenta')

    <div class="col-lg-4">
        <div class="form-group">
            <a class="btn btn-primary" href="javascript:void(0)" id="New">Crear ò Clonar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped first data-table table">
                            <thead>
                                <tr>
                                    <th>Numero</th>
                                    <th>Descripcion</th>
                                    <th>Fecha de Creacion</th>
                                    <th>Ultima Actualizacion</th>
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

    <div class="modal fade modal-sensory" id="Modal" tabindex="-1" role="dialog" aria-labelledby="modalsensory" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <label for="name" class="col-sm-6 control-label">Producto Nuevo:</label>
                            <div class="col-sm-12">
                                <input  class="form-control" type="text" name="dest_produc" id="dest_produc" placeholder="Escriba al menos 2 caracteres para Buscar"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <label for="product_name" class="col-sm-6 control-label">Producto a Clonar:</label>
                            <div class="col-sm-12">
                                <input  class="form-control" type="text" name="product_name" id="product_name" placeholder="Escriba al menos 2 caracteres para Buscar"/>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                    <ul class="nav nav-tabs red tabs-3" role="tablist">
                        <li class="nav-item active" role="presentation">
                            <a href="#Maestro" class="nav-link active" aria-controls="Maestro" role="tab" data-toggle="tab">&nbsp;<span>Maestro</span>&nbsp;</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#Ingenieria" class="nav-link" aria-controls="Ingenieria" role="tab" data-toggle="tab">&nbsp;<span>Ingenieria</span>&nbsp;</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#Planificador" class="nav-link" aria-controls="Planificador" role="tab" data-toggle="tab">&nbsp;<span>Planificador</span>&nbsp;</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#Inventario" class="nav-link" aria-controls="Inventario" role="tab" data-toggle="tab">&nbsp;<span>Inventario</span>&nbsp;</a>
                        </li>
                    </ul>
                <div class="modal-body">
                    <form id="ProductForm" name="ProductForm" class="form-horizontal">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="Maestro">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">ID Pieza:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Cod" name="Maestro_Cod" placeholder="" value="" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">Descripcion:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_desc" name="Maestro_desc" placeholder="" value="" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">Tipo de Pieza:</label>
                                            <div class="col-sm-12">
                                                <select id="Maestro_TP" name="Maestro_TP" class="form-control">
                                                    <option value="" selected="selected" >Seleccione...</option>
                                                    <option value="A">A - Pieza Fabricada Control MRP</option>
                                                    <option value="B">B - Pieza Comprada Control MRP</option>
                                                    <option value="C">C - Pieza Fabricada Control PDR</option>
                                                    <option value="D">D - Pieza Comprada Control PDR</option>
                                                    <option value="E">E - Objeto Mantenimiento</option>
                                                    <option value="F">F - Familia de Productos</option>
                                                    <option value="M">M - Pieza de Programada Maestro</option>
                                                    <option value="O">O - Pieza Subcontratada</option>
                                                    <option value="P">P - Ensamble Fantasma</option>
                                                    <option value="R">R - Recurso</option>
                                                    <option value="S">S - Seudo Pieza</option>
                                                    <option value="T">T - Herramienta</option>
                                                    <option value="X">X - Pieza Fabricada a Granel</option>
                                                    <option value="Y">Y - Pienza Comprada a Granel</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Maestro_Comprador" class="col-sm-12 control-label">Comprador:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Comprador" name="Maestro_Comprador">
                                                    @foreach( $Comprador->get() as $index => $Compr)
                                                        <option value="{{ $index }}" {{ old('Maestro_Comprador') == $index ? 'selected' : ''}}>
                                                            {{ trim($index.' - '.$Compr) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-12 control-label">Planificador:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Plan" name="Maestro_Plan">
                                                    @foreach( $Planificador->get() as $index => $Pla_Class)
                                                        <option value="{{ $index }}" {{ old('Maestro_Al_Pref') == $index ? 'selected' : ''}}>
                                                            {{ trim($index.' - '.$Pla_Class) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Maestro_Al_Pref" class="col-sm-12 control-label">Almacen Preferido:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Al_Pref" name="Maestro_Al_Pref">
                                                    @foreach( $AlmacenPreferido->get() as $index => $Al_Pref)
                                                        <option value="{{ $index }}" {{ old('Maestro_Al_Pref') == $index ? 'selected' : ''}}>
                                                            {{ trim($index.' - '.$Al_Pref) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Umd_Ldm" class="col-sm-12 control-label">UMD LDM:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Umd_Ldm" name="Maestro_Umd_Ldm">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="KG">KG - Kilogramos</option>
                                                <option value="UN">UN - Unidad</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Umd_Cos" class="col-sm-12 control-label">UMD Costo:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Umd_Cos" name="Maestro_Umd_Cos">
                                                    <option value="" selected>Seleccione...</option>
                                                    <option value="KG">KG - Kilogramos</option>
                                                    <option value="UN">UN - Unidad</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> {{----}}
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Cod_Clase" class="col-sm-12 control-label">Codigo Clase:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Cod_Clase" name="Maestro_Cod_Clase">
                                                    @foreach( $CodigoClase->get() as $index => $C_Class)
                                                        <option value="{{ $index }}" {{ old('Maestro_Cod_Clase') == $index ? 'selected' : ''}}>
                                                            {{ $index.'-'.$C_Class }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Cod_Com" class="col-sm-12 control-label">Codigo Comodidad:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" id="Maestro_Cod_Com" name="Maestro_Cod_Com">
                                                    @foreach( $CodigoComodidad->get() as $index => $C_Comod)
                                                        <option value="{{ $index }}" {{ old('Maestro_Cod_Com') == $index ? 'selected' : ''}}>
                                                            {{ trim($index.' - '.$C_Comod) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">Inventario:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Inv" name="Maestro_Inv" placeholder="" value="" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-12 control-label">Costo/Unid:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_cos_und" name="Maestro_cos_und" placeholder="" value="" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-12 control-label">Zona:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Zona" name="Maestro_Zona" placeholder="" value=" " maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-12 control-label">Nivel Rev:</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Maestro_Niv_Rev" name="Maestro_Niv_Rev" placeholder="" value="" maxlength="5" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Tc_Compras" class="col-sm-12 control-label">TC Compras:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Tc_Compras" name="Maestro_Tc_Compras" placeholder="" value="" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Tc_Manu" class="col-sm-12 control-label">TC Manufactura:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Tc_Manu" name="Maestro_Tc_Manu" placeholder="" value="" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-12 control-label">Civ de CDU:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Civ_Cdu" name="Maestro_Civ_Cdu" placeholder="" value="" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-12 control-label">Ref CDU:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Ref_CDU" name="Maestro_Ref_CDU" placeholder="" value="" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end tab-pane -->
                            <div role="tabpanel" class="tab-pane" id="Ingenieria">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Ingenieria_NumPln" class="col-sm-6 control-label">Numero de plano:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Ingenieria_NumPln" name="Ingenieria_NumPln" placeholder="" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Maestro_Rend" class="col-sm-12 control-label">Rendimiento (%):</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Maestro_Rend" name="Maestro_Rend" placeholder="" value="" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Ingenieria_desec" class="col-sm-12 control-label">Desecho (%):</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Ingenieria_desec" name="Ingenieria_desec" placeholder="" value="" maxlength="50" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Ingenieria_Est_Ing" class="col-sm-12 control-label">Estado Ingenieria:</label>
                                            <div class="col-sm-12">
                                                <select name="Ingenieria_Est_Ing" id="Ingenieria_Est_Ing" class="form-control">
                                                    <option value="" selected>Seleccione...</option>
                                                    <option value="1">1 - En Proyecto</option>
                                                    <option value="2">2 - En Produccion</option>
                                                    <option value="3">3 - No Definido</option>
                                                    <option value="4">4 - No Definido</option>
                                                    <option value="5">5 - Obsoleto</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Ingenieria_Cbn" class="col-sm-6 control-label">CBN:</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Ingenieria_Cbn" name="Ingenieria_Cbn" placeholder="" value="" maxlength="50" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="Ingenieria_ArcDib" class="col-sm-6 control-label">Archivo Dibujo:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Ingenieria_ArcDib" name="Ingenieria_ArcDib" placeholder="" value="" maxlength="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Contabilidad</legend>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="Contabilidad_TipCuent" class="col-sm-12 control-label">Tipo Cuenta Cont:</label>
                                                <div class="col-sm-12">
                                                    <select class="form-control" name="Contabilidad_TipCuent" id="Contabilidad_TipCuent">
                                                        @foreach( $TipoCuenta->get() as $index => $TipoCue)
                                                            <option value="{{ trim($index) }}" {{ old('Contabilidad_TipCuent') == $index ? 'selected' : ''}}>
                                                                {{ trim($index.' - '.$TipoCue) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div><!-- end tab-pane -->
                            <div role="tabpanel" class="tab-pane" id="Planificador">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_PolOrd" class="col-sm-12 control-label">Politica de Orden:</label>
                                            <div class="col-sm-12">
                                                <select name="Planificador_PolOrd" id="Planificador_PolOrd" class="form-control">
                                                    <option value="" selected>Seleccione...</option>
                                                    <option value="D">D - Discreta</option>
                                                    <option value="F">F - Fija</option>
                                                    <option value="L">L - Lote por Lote</option>
                                                    <option value="O">O - Orden</option>
                                                    <option value="P">P - Periodo</option>
                                                    <option value="R">R - Punto Reorden</option>
                                                    <option value="W">W - Semanal</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_Prg" class="col-sm-6 control-label">Programa:</label>
                                            <div class="col-sm-12">
                                                <select name="Planificador_Prg" id="Planificador_Prg" class="form-control">
                                                    <option value="" selected>Seleccione...</option>
                                                    <option value="R">R - Ruta</option>
                                                    <option value="Q">Q - Cola</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_Tc_Crit" class="col-sm-12 control-label">TC Critico:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Planificador_Tc_Crit" name="Planificador_Tc_Crit" placeholder="" value="" maxlength="50" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_Pdr" class="col-sm-12 control-label">PDR:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Planificador_Pdr" name="Planificador_Pdr" placeholder="" value="" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_Cdr" class="col-sm-6 control-label">CDR:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Planificador_Cdr" name="Planificador_Cdr" placeholder="" value="" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_InvSeg" class="col-sm-12 control-label">Inv. Seguridad:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Planificador_InvSeg" name="Planificador_InvSeg" placeholder="" value="" maxlength="50" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <div class="col-sm-12 custom-control custom-checkbox">
                                                <br>
                                                <input class="form-check-input" type="checkbox" id="Planificador_PlnFirm" name="Planificador_PlnFirm">
                                                <input type="hidden" value="" id="Planificador_PlnFirmVal" name="Planificador_PlnFirmVal" >
                                                <label class="form-check-label" for="Planificador_PlnFirm">Plan Firme</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <div class="col-sm-12 custom-control custom-checkbox">
                                                <br>
                                                <input class="form-check-input" type="checkbox" id="Planificador_Ncnd" name="Planificador_Ncnd">
                                                <input type="hidden" id="Planificador_NcndVal" name="Planificador_NcndVal">
                                                <label class="form-check-label" for="Planificador_Ncnd">NCND</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <div class="col-sm-12 custom-control custom-checkbox">
                                                <input class="form-check-input" type="checkbox" id="Planificador_Rump" name="Planificador_Rump">
                                                <input type="hidden" id="Planificador_RumpVal" name="Planificador_RumpVal">
                                                <label class="form-check-label" for="Planificador_Rump">Rump</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <div class="col-sm-12 custom-control custom-checkbox">
                                                <input class="form-check-input" type="checkbox" id="Planificador_PieCrit" name="Planificador_PieCrit">
                                                <input type="hidden" id="Planificador_PieCritVal" name="Planificador_PieCritVal">
                                                <label class="form-check-label" for="Planificador_PieCrit">Pieza Critica</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Fabricacion</legend>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Fa_TiCi" class="col-sm-12 control-label">Tiempo Ciclo:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Fa_TiCi" name="Planificador_Fa_TiCi" placeholder="" value="" maxlength="50" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Fa_Pl" class="col-sm-12 control-label">Planear:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Fa_Pl" name="Planificador_Fa_Pl" placeholder="" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Fa_Fab" class="col-sm-12 control-label">Fabricar:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Fa_Fab" name="Planificador_Fa_Fab" placeholder="" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Fa_Alm" class="col-sm-12 control-label">Almacenar:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Fa_Alm" name="Planificador_Fa_Alm" placeholder="" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Compras</legend>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Com_TiCi" class="col-sm-12 control-label">Tiempo Ciclo:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Com_TiCi" name="Planificador_Com_TiCi" placeholder="" value=""  required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Com_Pl" class="col-sm-12 control-label">Planear:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Com_Pl" name="Planificador_Com_Pl" placeholder="" value=""  required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Com_Comp" class="col-sm-12 control-label">Comprar:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Com_Comp" name="Planificador_Com_Comp" value=""  required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_Com_Alm" class="col-sm-12 control-label">Almacenar:</label>
                                                <div class="col-sm-12">
                                                    <input type="number" class="form-control" id="Planificador_Com_Alm" name="Planificador_Com_Alm"  value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Cantidad de Orden</legend>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_CaOr_Prom" class="col-sm-12 control-label">Promedio:</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Planificador_CaOr_Prom" name="Planificador_CaOr_Prom" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_CaOr_Min" class="col-sm-12 control-label">Minima:</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Planificador_CaOr_Min" name="Planificador_CaOr_Min" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_CaOr_Max" class="col-sm-12 control-label">Maxima:</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Planificador_CaOr_Max" name="Planificador_CaOr_Max" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Planificador_CaOr_Mult" class="col-sm-12 control-label">Multiple:</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Planificador_CaOr_Mult" name="Planificador_CaOr_Mult" value="" maxlength="50" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div><!-- end tab-pane -->
                            <div role="tabpanel" class="tab-pane" id="Inventario">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <div class="col-sm-12 custom-control custom-checkbox">
                                                <br>
                                                <input class="form-check-input" type="checkbox" id="Inventario_ReqInsp">
                                                <input type="hidden" name="Inventario_ReqInspVal" id="Inventario_ReqInspVal">
                                                <label class="form-check-label" for="Inventario_ReqInsp">Requiere Inspecciòn</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Inventario_ExcEnt" class="col-sm-12 control-label">Exceso Entradas:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Inventario_ExcEnt" name="Inventario_ExcEnt"  value="" maxlength="50" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Inventario_PesProm" class="col-sm-12 control-label">Peso Promedio:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="Inventario_PesProm" name="Inventario_PesProm" value="" maxlength="50" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Inventario_UdmPes" class="col-sm-12 control-label">UDM Peso:</label>
                                            <div class="col-sm-12">
                                                <select class="form-control" name="Inventario_UdmPes" id="Inventario_UdmPes">
                                                    <option value="" selected>Seleccione...</option>
                                                    <option value="UN">UN - Unidad</option>
                                                    <option value="KG">KG - Kilogramo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Seguimiento de Lotes/Serial</legend>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Inventario_DiasVen" class="col-sm-12 control-label">Dias Vence:</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Inventario_DiasVen" name="Inventario_DiasVen" value="" maxlength="50" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <div class="col-sm-12 custom-control custom-checkbox">
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" id="Inventario_CtrLot" name="Inventario_CtrLot">
                                                    <input type="hidden" id="Inventario_CtrLotVal" name="Inventario_CtrLotVal" >
                                                    <label class="form-check-label" for="Inventario_CtrLot">Control lote</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <div class="col-sm-12 custom-control custom-checkbox">
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" id="Inventario_CtrNs" name="Inventario_CtrNs">
                                                    <input type="hidden" id="Inventario_CtrNsVal" name="Inventario_CtrNsVal">
                                                    <label class="form-check-label" for="Inventario_CtrNs">Control N/S</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <div class="col-sm-12 custom-control custom-checkbox">
                                                    <br>
                                                    <input class="form-check-input" type="checkbox" id="Inventario_MultEnt" name="Inventario_MultEnt">
                                                    <input type="hidden" id="Inventario_MultEntVal" name="Inventario_MultEntVal">
                                                    <label class="form-check-label" for="Inventario_MultEnt">Multi Entradas</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <div class="col-sm-12 custom-control custom-checkbox">
                                                    <input class="form-check-input" type="checkbox" id="Inventario_LotCdp" name="Inventario_LotCdp">
                                                    <input type="hidden" id="Inventario_LotCdpVal" name="Inventario_LotCdpVal">
                                                    <label class="form-check-label" for="Inventario_LotCdp">Lote CDP</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-check">
                                                <div class="col-sm-12 custom-control custom-checkbox">
                                                    <input class="form-check-input" type="checkbox" id="Inventario_NsCdp" name="Inventario_NsCdp">
                                                    <input type="hidden" id="Inventario_NsCdpVal" name="Inventario_NsCdpVal">
                                                    <label class="form-check-label" for="Inventario_NsCdp">N/S CDP</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Recuento Ciclico</legend>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-12 control-label">Codigo:</label>
                                                <div class="col-sm-12">
                                                    <select name="Inventario_Re_Cod" id="Inventario_Re_Cod" class="form-control">
                                                        <option value="" selected>Seleccione...</option>
                                                        <option value="N">N - Ninguno</option>
                                                        <option value="D">D - Diario</option>
                                                        <option value="W">W - Semanal</option>
                                                        <option value="M">M - Mensual</option>
                                                        <option value="Q">Q - Trimestral</option>
                                                        <option value="B">B - Semestral</option>
                                                        <option value="A">A - Anual</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Inventario_ToleMoney" class="col-sm-12 control-label">Tolerancia ($):</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Inventario_ToleMoney" name="Inventario_ToleMoney" value="" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="Inventario_TolePorc" class="col-sm-12 control-label">Tolerancia (%):</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="Inventario_TolePorc" name="Inventario_TolePorc" value="" maxlength="50" >
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="CSTTYP_01" id="CSTTYP_01">
                                        <input type="hidden" name="LABOR_01" id="LABOR_01">
                                        <input type="hidden" name="VOH_01" id="VOH_01">
                                        <input type="hidden" name="FOH_01" id="FOH_01">
                                        <input type="hidden" name="QUMMAT_01" id="QUMMAT_01">
                                        <input type="hidden" name="QUMLAB_01" id="QUMLAB_01">
                                        <input type="hidden" name="QUMVOH_01" id="QUMVOH_01">
                                        <input type="hidden" name="HRS_01" id="HRS_01">
                                        <input type="hidden" name="QUMHRS_01" id="QUMHRS_01">
                                        <input type="hidden" name="PURUOM_01" id="PURUOM_01">
                                        <input type="hidden" name="PERDAY_01" id="PERDAY_01">
                                        <input type="hidden" id="ProductOrig" name="ProductOrig">
                                    </div>
                                </fieldset>
                            </div><!-- end tab-pane -->
                        </div>
                        <br>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn"  name="saveBtn" value="Crear">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div><!-- end modal-body -->
            </div><!-- end modal-content -->
        </div><!-- end modal-dialog -->
    </div>
    <style>
        /*Este Style me permite crear un borde cuadradado en los campos fielfset */
        legend.scheduler-border {
            width:inherit; /* Or auto */
            padding:0 10px; /* To give a bit of padding on the left and right */
            border-bottom:none;
        }
    </style>
    <!-- end modal -->

    @push('javascript')
        <script>
            $(document).ready(function() {
                $(function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "/ProductosIndex",
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'desc', name: 'desc'},
                            {data: 'creation', name: 'creation'},
                            {data: 'update', name: 'update'},
                            {data: 'opciones', name: 'opciones', orderable: false, searchable: false},
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
                    jQuery.extend(jQuery.validator.messages, {
                        required: "Este campo es obligatorio.",
                        remote: "Por favor, rellena este campo.",
                        email: "Por favor, escribe una dirección de correo válida",
                        url: "Por favor, escribe una URL válida.",
                        date: "Por favor, escribe una fecha válida.",
                        dateISO: "Por favor, escribe una fecha (ISO) válida.",
                        number: "Por favor, escribe un número entero válido.",
                        digits: "Por favor, escribe sólo dígitos.",
                        creditcard: "Por favor, escribe un número de tarjeta válido.",
                        equalTo: "Por favor, escribe el mismo valor de nuevo.",
                        accept: "Por favor, escribe un valor con una extensión aceptada.",
                        maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
                        minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
                        rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
                        range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
                        max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
                        min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}."),
                        selectcheck: "Por favor seleccione una opcion!"
                    });

                    $("#ProductForm").validate({
                        ignore: "",
                        rules: {
                            Maestro_Cod:{required: true, minlength: 10, maxlength: 10,digits: true},
                            Maestro_desc: "required",
                            Maestro_TP:{selectcheck: true},
                            Maestro_Comprador: {selectcheck: true},
                            Maestro_Plan: {selectcheck: true},
                            Maestro_Al_Pref:{selectcheck: true},
                            Maestro_Umd_Ldm:{selectcheck: true},
                            Maestro_Umd_Cos:{selectcheck: true},
                            Maestro_Cod_Clase:{selectcheck: true},
                            Maestro_Cod_Com:{selectcheck: true},
                            Maestro_cos_und:"required",
                            Maestro_Zona:"required",
                            Maestro_Niv_Rev:"required",
                            Maestro_Rend:{required: true, minlength: 0, maxlength: 100, digits: true},
                            Ingenieria_desec:{required: true, minlength: 0, maxlength: 100, digits: true},
                            Ingenieria_Est_Ing:{selectcheck: true},
                            Ingenieria_Cbn:{required: true, digits: true},
                            Contabilidad_TipCuent:{selectcheck: true},
                            Planificador_PolOrd:{selectcheck: true},
                            Planificador_Prg:{selectcheck: true},
                            Planificador_Tc_Crit:{required: true, digits: true},
                            Planificador_Pdr:{required: true, digits: true},
                            Planificador_Cdr:{required: true, digits: true},
                            Planificador_Fa_Pl:{required: true, digits: true},
                            Planificador_Fa_Fab:{required: true, digits: true},
                            Planificador_Fa_Alm:{required: true, digits: true},
                            Planificador_Com_TiCi:{required: true, digits: true},
                            Planificador_Com_Pl:{required: true, digits: true},
                            Planificador_Com_Comp:{required: true, digits: true },
                            Planificador_Com_Alm:{required: true,digits: true},
                            Planificador_CaOr_Prom:{required: true, digits: true},
                            Planificador_CaOr_Min:{required: true, digits: true},
                            Planificador_CaOr_Max:{required: true, digits: true},
                            Planificador_CaOr_Mult:{required: true, digits: true},
                            Inventario_PesProm:{required: true, digits: true},
                            Inventario_UdmPes:{selectcheck: true },
                            Inventario_Re_Cod:{selectcheck: true },
                            Inventario_ToleMoney:{required: true, digits: true},
                            Inventario_TolePorc:{required: true, minlength: 0, maxlength: 100, digits: true},
                            Ingenieria_NumPln: "required"
                        },


                        highlight: function (element) {
                            // Only validation controls
                            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
                            $('#saveBtn').html('Reintentar');
                        },
                        unhighlight: function (element) {
                            // Only validation controls
                            $(element).closest('.form-control').removeClass('is-invalid');
                        },

                        submitHandler: function (form) {
                            $(this).html('Guardando...');
                            $.ajax({
                                data: $('#ProductForm').serialize(),
                                url: "/SaveProducts",
                                type: "POST",
                                dataType: 'json',
                                success: function (data) {
                                    if (data.hasOwnProperty('error')) {
                                        toastr.error('SQLSTATE[' + data.error.code + ']: ¡El Producto ya existe!');
                                        $('#saveBtn').html('Reintentar');
                                    }
                                    else {
                                        $('#ProductForm').trigger("reset");
                                        $('#Modal').modal('hide');
                                        table.draw();
                                        toastr.success("Registro Guardado con Exito!");
                                        $('#saveBtn').html('Guardar');
                                    }
                                }
                            });
                            return false; // required to block normal submit since you used ajax
                        },
                    });

                    jQuery.validator.addMethod("selectcheck", function(value){
                        return (value != '');
                    }, "Por favor, seleciona una opcion.");

                });

                $('#New').click(function () {
                    $('#saveBtn').val("CreateProduct");
                    $('#linea_id').val('');
                    $('#ProductForm').trigger("reset");

                    $('#modelHeading').html("Crear ò Clonar Producto");
                    $('#Modal').modal('show');
                });

                $("#Planificador_PlnFirmVal").val('N');
                $("#Planificador_PlnFirm").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Planificador_PlnFirmVal").val('Y')
                    }else{
                        $("#Planificador_PlnFirmVal").val('N')
                    }
                });

                $("#Planificador_NcndVal").val('N');
                $("#Planificador_Ncnd").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Planificador_NcndVal").val('Y')
                    }else{
                        $("#Planificador_NcndVal").val('N')
                    }
                });

                $("#Planificador_RumpVal").val('N');
                $("#Planificador_Rump").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Planificador_RumpVal").val('Y')
                    }else{
                        $("#Planificador_RumpVal").val('N')
                    }
                });

                $("#Planificador_PieCritVal").val('N');
                $("#Planificador_PieCrit").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Planificador_PieCritVal").val('Y')
                    }else{
                        $("#Planificador_PieCritVal").val('N')
                    }
                });

                $("#Inventario_ReqInspVal").val('N');
                $("#Inventario_ReqInsp").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Inventario_ReqInspVal").val('Y')
                    }else{
                        $("#Inventario_ReqInspVal").val('N')
                    }
                });

                $("#Inventario_CtrLotVal").val('N');
                $("#Inventario_CtrLot").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Inventario_CtrLotVal").val('Y')
                    }else{
                        $("#Inventario_CtrLotVal").val('N')
                    }
                });

                $("#Inventario_CtrNsVal").val('N');
                $("#Inventario_CtrNs").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Inventario_CtrNsVal").val('Y')
                    }else{
                        $("#Inventario_CtrNsVal").val('N')
                    }
                });

                $("#Inventario_MultEntVal").val('N');
                $("#Inventario_MultEnt").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Inventario_MultEntVal").val('Y')
                    }else{
                        $("#Inventario_MultEntVal").val('N')
                    }
                });

                $("#Inventario_LotCdpVal").val('N');
                $("#Inventario_LotCdp").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Inventario_LotCdpVal").val('Y')
                    }else{
                        $("#Inventario_LotCdpVal").val('N')
                    }
                });

                $("#Inventario_NsCdpVal").val('N');
                $("#Inventario_NsCdp").change(function () {
                    if($(this).prop('checked') == true) {
                        $("#Inventario_NsCdpVal").val('Y')
                    }else{
                        $("#Inventario_NsCdpVal").val('N')
                    }
                });


                $( "#product_name" ).autocomplete({
                    appendTo: "#Modal",
                    source: function(request, response) {
                        var product = $( "#product_name" ).val();
                        $.ajax({
                            url: "/SearchProducts",
                            method: "get",
                            data: {
                              query : product
                            },
                            dataType: "json",
                            success: function(data){
                                var resp = $.map(data,function(obj){
                                    return obj
                                });
                                response(resp);
                            },
                        });
                    },
                    focus: function( event, ui ) {
                        $("#ProductOrig").val([ui.item.id]);
                        $("#Maestro_TP").val([ui.item.t_pieza]);
                        $("#Maestro_Umd_Ldm").val([ui.item.Umd_Ldm]);
                        $("#Maestro_Umd_Cos").val([ui.item.Umd_Cos]);
                        $("#Maestro_Cod_Clase").val([ui.item.Cod_Clase]);
                        $("#Maestro_Al_Pref").val([ui.item.Al_Pref]);
                        $("#Maestro_cos_und").val([ui.item.Cos_Und]);
                        $("#Maestro_Inv").val([ui.item.M_Inv]);
                        $("#Maestro_Zona").val([ui.item.M_Zona]);
                        $("#Maestro_Plan").val([ui.item.M_Planif]);
                        $("#Maestro_Niv_Rev").val([ui.item.Niv_Rev]);
                        $("#Maestro_Cod_Com").val([ui.item.Cod_Comd]);
                        $("#Maestro_Comprador").val([ui.item.M_Compr]);
                        $("#Maestro_Rend").val([ui.item.M_Rend]);
                        $("#Maestro_Tc_Manu").val([ui.item.Tc_Manu]);
                        $("#Maestro_Tc_Compras").val([ui.item.TC_Comp]);

                        /*PESTAÑA INGENIERIA*/
                        $("#Ingenieria_desec").val([ui.item.Ig_PorcDes]);
                        $("#Ingenieria_Est_Ing").val([ui.item.Ig_EstIng]);
                        $("#Ingenieria_Cbn").val([ui.item.Ig_Cbn]);
                        $("#Ingenieria_NumPln").val([ui.item.Ig_NumPln]);

                        /*PESTAÑA PLANIFICADOR*/
                        $("#Planificador_PolOrd").val([ui.item.Pl_PolOrd]);
                        $("#Planificador_Prg").val([ui.item.Pl_Prgm]);
                        $("#Planificador_Tc_Crit").val([ui.item.Pl_TcCrit]);
                        $("#Planificador_Pdr").val([ui.item.Pl_Pdr]);
                        $("#Planificador_Cdr").val([ui.item.Pl_Cdr]);
                        $("#Planificador_InvSeg").val([ui.item.Pl_InvSeg]);
                        $("#Planificador_Fa_TiCi").val([ui.item.Pl_Fb_TiCi]);
                        $("#Planificador_Fa_Pl").val([ui.item.Pl_Fb_Pl]);
                        $("#Planificador_Fa_Fab").val([ui.item.Pl_Fb_Fab]);
                        $("#Planificador_Fa_Alm").val([ui.item.Pl_Fb_Alm]);
                        $("#Planificador_Com_TiCi").val([ui.item.Pl_Com_TiCi]);
                        $("#Planificador_Com_Pl").val([ui.item.Pl_Com_Pl]);
                        $("#Planificador_Com_Comp").val([ui.item.Pl_Com_Comp]);
                        $("#Planificador_Com_Alm").val([ui.item.Pl_Com_Alm]);
                        $("#Planificador_CaOr_Prom").val([ui.item.Pl_CaOrd_Prom]);
                        $("#Planificador_CaOr_Min").val([ui.item.Pl_CaOrd_Min]);
                        $("#Planificador_CaOr_Max").val([ui.item.Pl_CaOrd_Max]);
                        $("#Planificador_CaOr_Mult").val([ui.item.Pl_CaOrd_Mult]);
                        $("#Planificador_PlnFirmVal").val([ui.item.Pl_PlFirm]);
                        $("#Planificador_NcndVal").val([ui.item.Pl_Ncnd]);
                        $("#Planificador_RumpVal").val([ui.item.Pl_Rump]);
                        $("#Planificador_PieCritVal").val([ui.item.Pl_PieCrit]);

                        /* PESTAÑA INVENTARIO*/
                        $("#Inventario_ExcEnt").val([ui.item.Inv_ExcEnt]);
                        $("#Inventario_PesProm").val([ui.item.Inv_Pes_Prom]);
                        $("#Inventario_UdmPes").val([ui.item.Inv_Udm_Pes]);
                        $("#Inventario_DiasVen").val([ui.item.Inv_DiasVen]);
                        $("#Inventario_CtrLot").val([ui.item.Inv_CtrLot]);
                        $("#Inventario_CtrNs").val([ui.item.Inv_CtrNs]);
                        $("#Inventario_MultEnt").val([ui.item.Inv_MultEnt]);
                        $("#Inventario_LotCdp").val([ui.item.Inv_LotCpd]);
                        $("#Inventario_NsCdp").val([ui.item.Inv_NsCdp]);
                        $("#Inventario_Re_Cod").val([ui.item.Inv_ReCod]);
                        $("#Inventario_ToleMoney").val([ui.item.Inv_TolMoney]);
                        $("#Inventario_TolePorc").val([ui.item.Inv_TolPorc]);

                        /* checkbox */
                        $("#Inventario_ReqInspVal").val([ui.item.Inv_ReqInsp]);
                        $("#Inventario_CtrLotVal").val([ui.item.Inv_CtrLot]);
                        $("#Inventario_CtrNsVal").val([ui.item.Inv_CtrNs]);
                        $("#Inventario_MultEntVal").val([ui.item.Inv_MultEnt]);
                        $("#Inventario_LotCdpVal").val([ui.item.Inv_LotCpd]);
                        $("#Inventario_NsCdpVal").val([ui.item.Inv_NsCdp]);

                        /*Pestaña Contabilidad*/
                        $("#Contabilidad_TipCuent").val([ui.item.Cont_TipCuent]);

                        /*Otros campos */
                        $("#CSTTYP_01").val([ui.item.CSTTYP_01]);
                        $("#LABOR_01").val([ui.item.LABOR_01]);
                        $("#VOH_01").val([ui.item.VOH_01]);
                        $("#FOH_01").val([ui.item.FOH_01]);
                        $("#QUMMAT_01").val([ui.item.QUMMAT_01]);
                        $("#QUMLAB_01").val([ui.item.QUMLAB_01]);
                        $("#QUMVOH_01").val([ui.item.QUMVOH_01]);
                        $("#HRS_01").val([ui.item.HRS_01]);
                        $("#QUMHRS_01").val([ui.item.QUMHRS_01]);
                        $("#PURUOM_01").val([ui.item.PURUOM_01]);
                        $("#PERDAY_01").val([ui.item.Pl_Dias_Pe]);

                      return true;
                    },
                    select: function(event, ui)	{
                        $("#ProductOrig").val([ui.item.id]);
                        $("#Maestro_TP").val([ui.item.t_pieza]);
                        $("#Maestro_Umd_Ldm").val([ui.item.Umd_Ldm]);
                        $("#Maestro_Umd_Cos").val([ui.item.Umd_Cos]);
                        $("#Maestro_Cod_Clase").val([ui.item.Cod_Clase]);
                        $("#Maestro_Al_Pref").val([ui.item.Alm_Pref]);
                        $("#Maestro_cos_und").val([ui.item.Cos_Und]);
                        $("#Maestro_Inv").val([ui.item.M_Inv]);
                        $("#Maestro_Zona").val([ui.item.M_Zona]);
                        $("#Maestro_Plan").val([ui.item.M_Planif]);
                        $("#Maestro_Niv_Rev").val([ui.item.Niv_Rev]);
                        $("#Maestro_Cod_Com").val([ui.item.Cod_Comd]);
                        $("#Maestro_Comprador").val([ui.item.M_Compr]);
                        $("#Maestro_Rend").val([ui.item.M_Rend]);
                        $("#Maestro_Tc_Manu").val([ui.item.Tc_Manu]);
                        $("#Maestro_Tc_Compras").val([ui.item.TC_Comp]);

                        /*PESTAÑA INGENIERIA*/
                        $("#Ingenieria_desec").val([ui.item.Ig_PorcDes]);
                        $("#Ingenieria_Est_Ing").val([ui.item.Ig_EstIng]);
                        $("#Ingenieria_Cbn").val([ui.item.Ig_Cbn]);
                        $("#Ingenieria_NumPln").val([ui.item.Ig_NumPln]);

                        /*PESTAÑA PLANIFICADOR*/
                        $("#Planificador_PolOrd").val([ui.item.Pl_PolOrd]);
                        $("#Planificador_Prg").val([ui.item.Pl_Prgm]);
                        $("#Planificador_Tc_Crit").val([ui.item.Pl_TcCrit]);
                        $("#Planificador_Pdr").val([ui.item.Pl_Pdr]);
                        $("#Planificador_Cdr").val([ui.item.Pl_Cdr]);
                        $("#Planificador_InvSeg").val([ui.item.Pl_InvSeg]);
                        $("#Planificador_Fa_TiCi").val([ui.item.Pl_Fb_TiCi]);
                        $("#Planificador_Fa_Pl").val([ui.item.Pl_Fb_Pl]);
                        $("#Planificador_Fa_Fab").val([ui.item.Pl_Fb_Fab]);
                        $("#Planificador_Fa_Alm").val([ui.item.Pl_Fb_Alm]);
                        $("#Planificador_Com_TiCi").val([ui.item.Pl_Com_TiCi]);
                        $("#Planificador_Com_Pl").val([ui.item.Pl_Com_Pl]);
                        $("#Planificador_Com_Comp").val([ui.item.Pl_Com_Comp]);
                        $("#Planificador_Com_Alm").val([ui.item.Pl_Com_Alm]);
                        $("#Planificador_CaOr_Prom").val([ui.item.Pl_CaOrd_Prom]);
                        $("#Planificador_CaOr_Min").val([ui.item.Pl_CaOrd_Min]);
                        $("#Planificador_CaOr_Max").val([ui.item.Pl_CaOrd_Max]);
                        $("#Planificador_CaOr_Mult").val([ui.item.Pl_CaOrd_Mult]);
                        $("#Planificador_PlnFirmVal").val([ui.item.Pl_PlFirm]);
                        $("#Planificador_NcndVal").val([ui.item.Pl_Ncnd]);
                        $("#Planificador_RumpVal").val([ui.item.Pl_Rump]);
                        $("#Planificador_PieCritVal").val([ui.item.Pl_PieCrit]);

                        /**/
                        if([ui.item.Pl_PlFirm] == 'Y'){
                            $("#Planificador_PlnFirm").prop('checked', true);
                        }else{
                            $("#Planificador_PlnFirm").prop('checked', false);
                        }
                        /**/
                        if ([ui.item.Pl_Ncnd] == 'Y'){
                        	$("#Planificador_Ncnd").prop('checked', true);
                        }else{
                            $("#Planificador_Ncnd").prop('checked', false);
                        }
                        /**/
                        if([ui.item.Pl_Rump] == 'Y'){
                        	$("#Planificador_Rump").prop('checked', true);
                        }else{
                            $("#Planificador_Rump").prop('checked', false);
                        }
                        /**/
                        if([ui.item.Pl_PieCrit] == 'Y'){
                        	$("#Planificador_PieCrit").prop('checked', true);
                        }else{
                            $("#Planificador_PieCrit").prop('checked', false);
                        }
                        /**/

                        /* PESTAÑA INVENTARIO*/
                        $("#Inventario_ExcEnt").val([ui.item.Inv_ExcEnt]);
                        $("#Inventario_PesProm").val([ui.item.Inv_Pes_Prom]);
                        $("#Inventario_UdmPes").val([ui.item.Inv_Udm_Pes]);
                        $("#Inventario_DiasVen").val([ui.item.Inv_DiasVen]);

                        if([ui.item.Inv_ReqInsp] == 'Y'){
                            $("#Inventario_ReqInsp").prop('checked', true);

                        }else{
                            $("#Inventario_ReqInsp").prop('checked', false);
                        }

                        if([ui.item.Inv_CtrLot] == 'Y') {
                            $("#Inventario_CtrLot").prop('checked', true);
                        }else{
                            $("#Inventario_CtrLot").prop('checked', false);
                        }

                        if([ui.item.Inv_CtrNs] == 'Y'){
                            $("#Inventario_CtrNs").prop('checked',true);
                        }else{
                            $("#Inventario_CtrNs").prop('checked',false);
                        }

                        if([ui.item.Inv_MultEnt] == 'Y'){
                            $("#Inventario_MultEnt").prop('checked',true);
                        }else{
                            $("#Inventario_MultEnt").prop('checked',false);
                        }

                        if([ui.item.Inv_LotCpd] == 'Y'){
                            $("#Inventario_LotCdp").prop('checked',true);
                        }else{
                            $("#Inventario_LotCdp").prop('checked',false);
                        }

                        if ([ui.item.Inv_NsCdp] == 'Y'){
                            $("#Inventario_NsCdp").prop('checked',true);
                        }else{
                            $("#Inventario_NsCdp").prop('checked',false);
                        }

                        $("#Inventario_Re_Cod").val([ui.item.Inv_ReCod]);
                        $("#Inventario_ToleMoney").val([ui.item.Inv_TolMoney]);
                        $("#Inventario_TolePorc").val([ui.item.Inv_TolPorc]);
                        $("#Inventario_ReqInspVal").val([ui.item.Inv_ReqInsp]);

                        /* checkbox */
                        $("#Inventario_ReqInspVal").val([ui.item.Inv_ReqInsp]);
                        $("#Inventario_CtrLotVal").val([ui.item.Inv_CtrLot]);
                        $("#Inventario_CtrNsVal").val([ui.item.Inv_CtrNs]);
                        $("#Inventario_MultEntVal").val([ui.item.Inv_MultEnt]);
                        $("#Inventario_LotCdpVal").val([ui.item.Inv_LotCpd]);
                        $("#Inventario_NsCdpVal").val([ui.item.Inv_NsCdp]);

                        /*Pestaña Contabilidad*/
                        $("#Contabilidad_TipCuent").val([ui.item.Cont_TipCuent]);

                        /* Otros campos */
                        $("#CSTTYP_01").val([ui.item.CSTTYP_01]);
                        $("#LABOR_01").val([ui.item.LABOR_01]);
                        $("#VOH_01").val([ui.item.VOH_01]);
                        $("#FOH_01").val([ui.item.FOH_01]);
                        $("#QUMMAT_01").val([ui.item.QUMMAT_01]);
                        $("#QUMLAB_01").val([ui.item.QUMLAB_01]);
                        $("#QUMVOH_01").val([ui.item.QUMVOH_01]);
                        $("#HRS_01").val([ui.item.HRS_01]);
                        $("#QUMHRS_01").val([ui.item.QUMHRS_01]);
                        $("#PURUOM_01").val([ui.item.PURUOM_01]);
                        $("#PERDAY_01").val([ui.item.Pl_Dias_Pe]);


                    },
                    minLength: 2
                });

                //Busca el Codigo de Destino
                $( "#dest_produc" ).autocomplete({
                    appendTo: "#Modal",
                    source: function (request, response) {
                        var cod = $("#dest_produc").val();
                        $.ajax({
                            url: "/SearchCodes",
                            method: "get",
                            data: {
                                query: cod
                            },
                            dataType: "json",
                            success: function (data) {
                                var resp = $.map(data, function (obj) {
                                    return obj
                                });
                                response(resp);
                            },
                        });
                    },
                    focus: function( event, ui ) {
                        $("#Maestro_Cod").val([ui.item.codigo]);
                        $("#Maestro_desc").val([ui.item.descripcion]);

                      return true;
                    },

                    select: function(event, ui)	{
                        $("#Maestro_Cod").val([ui.item.codigo]);
                        $("#Maestro_desc").val([ui.item.descripcion]);
                    },
                    minLength: 1
                });

                /*Cada vez que el modal se cierra o guarda un registro , se reinicia y deja todos los campos en blanco*/
                $('#Modal').on('show.bs.modal', function (event) {
                    $("#Modal input").val("");
                    $("#Modal textarea").val("");
                    $("#Modal select").val("");
                    $("#Modal input[type='checkbox']").prop('checked', false).change();
                    $('#saveBtn').html('Guardar');
                    $('.form-control').removeClass('is-invalid');
                    $('.error').remove();
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
    @endpush
@endsection
