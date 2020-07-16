<div class="modal fade" id="modal_clonador" tabindex="-1" role="dialog" aria-labelledby="modal_clonador" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                Crear / Clonar productos
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br>

            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">PRODUCTO NUEVO</span>
                            </div>
                            <input type="text" class="form-control" id="producto_nuevo" aria-label="producto_nuevo" placeholder="Escriba al menos 2 caracteres para buscar" onClick="this.select();"/>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">PRODUCTO A CLONAR</span>
                            </div>
                            <input type="text" class="form-control" id="producto_clonar" aria-label="producto_clonar" placeholder="Escriba al menos 2 caracteres para buscar" onClick="this.select();"/>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="col-sm-12 card-header card-header-tab-animation">
                <ul class="nav nav-justified" role="tablist">
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
            </div>
            <form id="clonador_form" name="clonador_form" class="form-horizontal">
                <div class="modal-body">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="Maestro">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">ID Pieza</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_id_pieza" aria-label="maestro_id_pieza" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Descripcion</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_descripcion" aria-label="maestro_id_pieza" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Tipo pieza</span>
                                            </div>
                                            <select id="maestro_tipo_pieza" name="maestro_tipo_pieza" class="form-control">
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
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comprador</span>
                                            </div>
                                            <select class="form-control" id="maestro_comprador" name="maestro_comprador">
                                                <option value="" selected="selected" >Seleccione...</option>
                                                @foreach( $compradores as $comprador )
                                                      <option value="{{ $comprador->id }}"> {{ trim($comprador->id.' - '.$comprador->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Planificador</span>
                                            </div>
                                            <select class="form-control" id="maestro_planificador" name="maestro_planificador">
                                                <option value="" selected="selected" >Seleccione...</option>
                                                @foreach( $planificadores as $planificador )
                                                    <option value="{{ $planificador->id }}"> {{ trim($planificador->id.' - '.$planificador->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Almacen preferido</span>
                                            </div>
                                            <select class="form-control" id="maestro_almacen_preferido" name="maestro_almacen_preferido">
                                                <option value="" selected="selected" >Seleccione...</option>
                                                @foreach( $almacen_preferido as $ap )
                                                    <option value="{{ trim($ap->id) }}"> {{ trim($ap->id).' - '. trim($ap->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">UMD LDM</span>
                                            </div>
                                            <select class="form-control" id="maestro_umd_ldm" name="maestro_umd_ldm">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="KG">KG - Kilogramos</option>
                                                <option value="UN">UN - Unidad</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">UMD costo</span>
                                            </div>
                                            <select class="form-control" id="maestro_umd_costo" name="maestro_umd_costo">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="KG">KG - Kilogramos</option>
                                                <option value="UN">UN - Unidad</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cod clase</span>
                                            </div>
                                            <select class="form-control" id="maestro_codigo_clase" name="maestro_codigo_clase">
                                                <option value="" selected>Seleccione...</option>
                                                 @foreach( $codigo_clase as $cc)
                                                     <option value="{{ $cc->id }}">{{ $cc->id.'-'.$cc->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Cod comodidad</span>
                                            </div>
                                            <select class="form-control" id="maestro_codigo_comodidad" name="maestro_codigo_comodidad">
                                                <option value="" selected>Seleccione...</option>
                                                @foreach( $codigo_comodidad as $cc)
                                                    <option value="{{ $cc->id }}">{{ $cc->id }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Inventario</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_inventario" aria-label="maestro_inventario" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Costo unit</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_costo_unit" aria-label="maestro_costo_unit"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Zona</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_zona" aria-label="maestro_zona"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Nivel rev</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_nivel_rev" aria-label="maestro_nivel_rev"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">TC Compras</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_tc_compras" aria-label="maestro_tc_compras"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">TC Manufactura</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_tc_manufactura" aria-label="maestro_tc_manufactura"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Civ de CDU</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_civ_cdu" aria-label="maestro_civ_cdu" disabled=""/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Ref CDU</span>
                                            </div>
                                            <input type="text" class="form-control" id="maestro_ref_cdu" aria-label="maestro_ref_cdu" disabled/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end tab-pane -->
                        <div role="tabpanel" class="tab-pane" id="Ingenieria">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Numero de plano</span>
                                            </div>
                                            <input type="text" class="form-control" id="ingenieria_numero_plano" aria-label="ingenieria_numero_plano"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percentage"></i>&nbsp; Rendimiento</span>
                                            </div>
                                            <input type="number" class="form-control" id="ingenieria_rendimiento" aria-label="ingenieria_rendimiento"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percentage"></i>&nbsp; Desecho</span>
                                            </div>
                                            <input type="number" class="form-control" id="ingenieria_desecho" aria-label="ingenieria_desecho"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Estado</span>
                                            </div>
                                            <select name="ingenieria_estado_ingenieria" id="ingenieria_estado_ingenieria" class="form-control">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="1">1 - En Proyecto</option>
                                                <option value="2">2 - En Produccion</option>
                                                <option value="3">3 - No Definido</option>
                                                <option value="4">4 - No Definido</option>
                                                <option value="5">5 - Obsoleto</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">CBN</span>
                                            </div>
                                            <input type="number" class="form-control" id="ingenieria_cbn" aria-label="ingenieria_cbn"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Archivo dibujo</span>
                                            </div>
                                            <input type="text" class="form-control" id="ingenieria_archivo_dibujo" aria-label="ingenieria_archivo_dibujo" disabled/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <fieldset class="border p-2">
                                    <legend class="scheduler-border">Contabilidad</legend>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Tipo cuenta contable</span>
                                                </div>
                                                <select class="form-control" name="contabilidad_tipo_cuenta_contable" id="contabilidad_tipo_cuenta_contable">
                                                    <option value="">Seleccione...</option>
                                                    @foreach( $tipo_cuenta as $tp)
                                                        <option value="{{ trim($tp->id) }}">{{ trim($tp->id).' - '.trim($tp->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div><!-- end tab-pane -->
                        <div role="tabpanel" class="tab-pane" id="Planificador">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Politica de orden</span>
                                            </div>
                                            <select name="planificador_politica_orden" id="planificador_politica_orden" class="form-control">
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
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Programa</span>
                                            </div>
                                            <select name="planificador_programa" id="planificador_programa" class="form-control">
                                                <option value="" selected>Seleccione...</option>
                                                <option value="R">R - Ruta</option>
                                                <option value="Q">Q - Cola</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">TC critico</span>
                                            </div>
                                            <input type="number" class="form-control" id="planificador_tc_critico" aria-label="planificador_tc_critico"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">PDR</span>
                                            </div>
                                            <input type="number" class="form-control" id="planificador_pdr" aria-label="planificador_pdr"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">CDR</span>
                                            </div>
                                            <input type="number" class="form-control" id="planificador_cdr" aria-label="planificador_cdr"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Inventario seguridad</span>
                                            </div>
                                            <input type="number" class="form-control" id="planificador_inventario_seguridad" aria-label="planificador_cdr"/>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="planificador_plan_firme" aria-label="planificador_plan_firme">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="Plan firme" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="planificador_ncnd" aria-label="planificador_ncnd">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="NCND" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="planificador_rump" aria-label="planificador_rump">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="RUMP" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="planificador_pieza_critica" aria-label="planificador_pieza_critica">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="Pieza critica" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <fieldset class="border p-2">
                                <legend class="scheduler-border">Fabricacion</legend>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Tiempo ciclo</span>
                                            </div>
                                            <input type="number" class="form-control" id="fabricacion_tiempo_ciclo" aria-label="fabricacion_tiempo_ciclo"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Planear</span>
                                            </div>
                                            <input type="number" class="form-control" id="fabricacion_planear" aria-label="fabricacion_planear"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Fabricar</span>
                                            </div>
                                            <input type="number" class="form-control" id="fabricacion_fabricar" aria-label="fabricacion_fabricar"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Almacenar</span>
                                            </div>
                                            <input type="number" class="form-control" id="fabricacion_almacenar" aria-label="fabricacion_almacenar"/>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <br>
                            <fieldset class="border p-2">
                                <legend class="scheduler-border">Compras</legend>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Tiempo Ciclo</span>
                                            </div>
                                            <input type="number" class="form-control" id="compras_tiempo_ciclo" aria-label="compras_tiempo_ciclo"/>
                                        </div>

                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Planear</span>
                                            </div>
                                            <input type="number" class="form-control" id="compras_planear" aria-label="compras_planear"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Comprar</span>
                                            </div>
                                            <input type="number" class="form-control" id="compras_comprar" aria-label="compras_comprar"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Almacenar</span>
                                            </div>
                                            <input type="number" class="form-control" id="compras_almacenar" aria-label="compras_almacenar"/>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <br>
                            <fieldset class="border p-2">
                                <legend class="scheduler-border">Cantidad de Orden</legend>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Promedio</span>
                                            </div>
                                            <input type="number" class="form-control" id="cantidad_orden_promedio" aria-label="cantidad_orden_promedio"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Minima</span>
                                            </div>
                                            <input type="number" class="form-control" id="cantidad_orden_minima" aria-label="cantidad_orden_minima"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Maxima</span>
                                            </div>
                                            <input type="number" class="form-control" id="cantidad_orden_maxima" aria-label="cantidad_orden_maxima"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Multiple</span>
                                            </div>
                                            <input type="number" class="form-control" id="cantidad_orden_multiple" aria-label="cantidad_orden_multiple"/>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div><!-- end tab-pane -->
                        <div role="tabpanel" class="tab-pane" id="Inventario">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" id="inventario_requiere_inspeccion" aria-label="inventario_requiere_inspeccion">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" value="Requiere inspecciòn" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Exceso entradas</span>
                                        </div>
                                        <input type="number" class="form-control" id="inventario_exceso_entrada" aria-label="inventario_exceso_entrada"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Peso promedio</span>
                                        </div>
                                        <input type="number" class="form-control" id="inventario_peso_promedio" aria-label="inventario_peso_promedio"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">UDM Peso</span>
                                        </div>
                                        <select class="form-control" name="inventario_udm_peso" id="inventario_udm_peso">
                                            <option value="" selected>Seleccione...</option>
                                            <option value="UN">UN - Unidad</option>
                                            <option value="KG">KG - Kilogramo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <fieldset class="border p-2">
                                <legend class="scheduler-border">Seguimiento de Lotes/Serial</legend>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Dias vence</span>
                                            </div>
                                            <input type="number" class="form-control" id="seguimiento_lote_dias_vence" aria-label="seguimiento_lote_dias_vence"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="seguimiento_lote_control_lote" aria-label="seguimiento_lote_control_lote">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="Control lote" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="seguimiento_lote_control_ns" aria-label="seguimiento_lote_control_ns">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="Control N/S" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="seguimiento_lote_multi_entradas" aria-label="seguimiento_lote_multi_entradas">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="Multi entradas" disabled>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="seguimiento_lote_lote_cdp" aria-label="seguimiento_lote_lote_cdp">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="Lote CDP" disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <input type="checkbox" id="seguimiento_lote_ns_cdp" aria-label="seguimiento_lote_ns_cdp">
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" value="N/S CDP" disabled>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <br>
                            <fieldset class="border p-2">
                                <legend class="scheduler-border">Recuento Ciclico</legend>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Codigo</span>
                                            </div>
                                            <select name="Inventario_Re_Cod" id="recuento_ciclico_codigo" class="form-control">
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
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Tolerancia (<i class="fas fa-dollar-sign"></i>)</span>
                                            </div>
                                            <input type="number" class="form-control" id="recuento_ciclico_tolerancia" aria-label="recuento_ciclico_tolerancia"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Tolerancia (<i class="fas fa-percentage"></i>)</span>
                                            </div>
                                            <input type="number" class="form-control" id="recuento_ciclico_tolerancia_porcentaje" aria-label="recuento_ciclico_tolerancia_porcentaje"/>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div><!-- end tab-pane -->
                    </div>
                </div><!-- end modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div><!-- end modal-content -->
    </div><!-- end modal-dialog -->
</div>
