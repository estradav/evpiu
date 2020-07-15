<div class="modal fade" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="heading"> </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" name="form" class="form-horizontal">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="codigo" class="col-sm-6 control-label">Codigo:</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="codigo" name="codigo" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="descripcion" class="col-sm-6 control-label">Descripcion:</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tipo_producto" class="col-sm-6 control-label">Tipo de Producto:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="tipo_producto" id="tipo_producto" >
                                        <option value="" selected>Seleccione... </option>
                                        @foreach( $tipo_productos as $tp)
                                            <option value="{{ $tp->id }}"> {{ $tp->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="linea" class="col-sm-3 control-label">Linea:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="linea" id="linea">
                                        <option value="" selected>Seleccione... </option>
                                        @foreach( $lineas as $l)
                                            <option value="{{ $l->id }}"> {{ $l->name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sublinea" class="col-sm-3 control-label">Sublinea:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="sublinea" id="sublinea"></select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="caracteristica" class="col-sm-6 control-label">Caracteristica:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="caracteristica" id="caracteristica">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="material" class="col-sm-6 control-label">Material:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="material" id="material">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="medida" class="col-sm-6 control-label">Medida:</label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="medida" id="medida">

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="coments" class="col-sm-12 control-label">Comentarios:</label>
                                <div class="col-sm-12">
                                    <textarea id="coments" name="coments" placeholder="Comentarios" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-lg" id="guardar">Guardar</button>
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
