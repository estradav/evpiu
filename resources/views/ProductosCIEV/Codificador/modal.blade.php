<div class="modal fade bd-example-modal-lg" id="Codigomodal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="CodigoForm" name="CodigoForm" class="form-horizontal">
                <div class="modal-body">
                    <input type="hidden" name="Codigo_id" id="Codigo_id">
                    <input type="hidden" name="ctp-g" id="ctp-g">
                    <input type="hidden" name="lin-g" id="lin-g">
                    <input type="hidden" name="sln-g" id="sln-g">
                    <input type="hidden" name="mat-g" id="mat-g">
                    <input type="hidden" name="lin-d" id="lin-d">
                    <input type="hidden" name="sln-d" id="sln-d">
                    <input type="hidden" name="car-d" id="car-d">
                    <input type="hidden" name="mat-d" id="mat-d">
                    <input type="hidden" name="med-d" id="med-d">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-6 control-label">Codigo:</label>
                                <input type="hidden" name="CodNam" id="CodNam">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="codigo" name="codigo" value="" maxlength="10"  readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-6 control-label">Descripcion:</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-6 control-label">Tipo de Producto:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="tipoproducto_id" id="tipoproducto_id" >
                                        @foreach( $TipoProductos->get() as $index => $TipoProducto)
                                            <option value="{{ $index }}" {{ old('tipoproducto_id') == $index ? 'selected' : ''}}>
                                                {{ $TipoProducto }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Linea:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="lineas_id" id="lineas_id"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-3 control-label">Sublinea:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="sublineas_id" id="sublineas_id"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-6 control-label">Caracteristica:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="caracteristica_id" id="caracteristica_id" ></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-6 control-label">Material:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="material_id" id="material_id"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-6 control-label">Medida:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="medida_id" id="medida_id" ></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-12 control-label">Comentarios:</label>
                                <div class="col-sm-12">
                                    <textarea id="coments" name="coments" placeholder="Comentarios" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-lg" id="saveBtn" value="Crear">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
