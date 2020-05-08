
<div class="modal fade modal-sensory" id="Modal" tabindex="-1" role="dialog" aria-labelledby="modalsensory" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading">Crear o clonar</h4>
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
            <form id="ProductForm" name="ProductForm" class="form-horizontal">
                <div class="modal-body">
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
                                            <input type="number" class="form-control" id="Maestro_Inv" name="Maestro_Inv" placeholder="" value="" maxlength="50" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">Costo/Unid:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Maestro_cos_und" name="Maestro_cos_und" placeholder="" value="" maxlength="50" required>
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
                                            <input type="number" class="form-control" id="Maestro_Niv_Rev" name="Maestro_Niv_Rev" placeholder="" value="" maxlength="5" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Maestro_Tc_Compras" class="col-sm-12 control-label">TC Compras:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Maestro_Tc_Compras" name="Maestro_Tc_Compras" placeholder="" value="" maxlength="50" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Maestro_Tc_Manu" class="col-sm-12 control-label">TC Manufactura:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Maestro_Tc_Manu" name="Maestro_Tc_Manu" placeholder="" value="" maxlength="50" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">Civ de CDU:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Maestro_Civ_Cdu" name="Maestro_Civ_Cdu" placeholder="" value="" maxlength="50" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-12 control-label">Ref CDU:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Maestro_Ref_CDU" name="Maestro_Ref_CDU" placeholder="" value="" maxlength="50" readonly>
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
                                            <input type="number" class="form-control" id="Maestro_Rend" name="Maestro_Rend" placeholder="" value="" maxlength="50" required>
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
                                            <input type="number" class="form-control" id="Planificador_Tc_Crit" name="Planificador_Tc_Crit" placeholder="" value="" maxlength="50" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Planificador_Pdr" class="col-sm-12 control-label">PDR:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Planificador_Pdr" name="Planificador_Pdr" placeholder="" value="" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Planificador_Cdr" class="col-sm-6 control-label">CDR:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Planificador_Cdr" name="Planificador_Cdr" placeholder="" value="" maxlength="50">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Planificador_InvSeg" class="col-sm-12 control-label">Inv. Seguridad:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Planificador_InvSeg" name="Planificador_InvSeg" placeholder="" value="" maxlength="50" required>
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
                                                <input type="number" class="form-control" id="Planificador_CaOr_Prom" name="Planificador_CaOr_Prom" value="" maxlength="50" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_CaOr_Min" class="col-sm-12 control-label">Minima:</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Planificador_CaOr_Min" name="Planificador_CaOr_Min" value="" maxlength="50" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_CaOr_Max" class="col-sm-12 control-label">Maxima:</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Planificador_CaOr_Max" name="Planificador_CaOr_Max" value="" maxlength="50" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Planificador_CaOr_Mult" class="col-sm-12 control-label">Multiple:</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Planificador_CaOr_Mult" name="Planificador_CaOr_Mult" value="" maxlength="50" required="required">
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
                                            <input type="number" class="form-control" id="Inventario_ExcEnt" name="Inventario_ExcEnt"  value="" maxlength="50" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="Inventario_PesProm" class="col-sm-12 control-label">Peso Promedio:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control" id="Inventario_PesProm" name="Inventario_PesProm" value="" maxlength="50" >
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
                                                <input type="number" class="form-control" id="Inventario_DiasVen" name="Inventario_DiasVen" value="" maxlength="50" >
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
                                                <input type="number" class="form-control" id="Inventario_ToleMoney" name="Inventario_ToleMoney" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="Inventario_TolePorc" class="col-sm-12 control-label">Tolerancia (%):</label>
                                            <div class="col-sm-12">
                                                <input type="number" class="form-control" id="Inventario_TolePorc" name="Inventario_TolePorc" value="" maxlength="100" >
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
                </div><!-- end modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-lg" id="saveBtn"  name="saveBtn" value="Crear">Guardar</button>
                    <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- end modal-content -->
    </div><!-- end modal-dialog -->
</div>
