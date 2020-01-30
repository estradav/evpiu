 $(document).ready(function() {
        $('.modal').MultiStep({
            title:'Nuevo Cliente',
        	data:[{
                label:'Informacion de Facturacion',
        		content:`
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Razon Social:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Razon Social"> 
                            </div>
                            <div class="col-6">
                                <label for="">Nit/CC:</label>
                                <input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Nit"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                             <div class="col-6">
                                <label for="">Direccion 1:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Direccion 1"> 
                             </div>
                             <div class="col-6">
                                <label for="">Codigo Postal:</label>
                                <input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Codigo Postal"> 
                             </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Direccion 2:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Direccion 2"> 
                            </div>
                            <div class="col-6">
                                <label for="">Razon Comercial:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Razon Comercial"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Pais:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Pais"> 
                            </div>
                            <div class="col-6">
                                <label for="">Cuidad:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Ciudad"> 
                            </div>
                        </div>
                         <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Contacto:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Nombre de Contacto"> 
                            </div>
                            <div class="col-6">
                                <label for="">Telefono:</label>
                                <input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Telefono"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Telefono 2:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Telefono 2"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">E-mail Contacto:</label>
                                <input type="email" class="form-control" id="Modal_Razon_Social" placeholder="E-mail Contacto"> 
                            </div>
                            <div class="col-6">
                                <label for="">E-mail Facturacion:</label>
                                <input type="email" class="form-control" id="Modal_Razon_Social" placeholder="E-mail Facturacion"> 
                            </div>
                        </div>
                    </div>
                `,
        	},{
                label: 'Informacion de Envios',
        		content:`
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Forma de Envio:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Razon Social"> 
                            </div>
                            <div class="col-6">
                                <label for="">FOP:</label>
                                <input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Nit"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Enviar A:</label>
                                <input type="text" class="form-control" id="Modal_Razon_Social" placeholder="Enviar A"> 
                            </div>
                            <div class="col-6">
                                <label for="">Enviar a traves de:</label>
                                <input type="number" class="form-control" id="Modal_Razon_Social" placeholder="Enviar a traves de"> 
                            </div>
                        </div>
                    </div>
                `,
        	},{
                label: 'Informacion Fiscal',
        		content:`
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Gravado:</label>
                                <select name="" id="" class="form-control">
                                    <option value="Y">Si</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="">Codigo Fiscal 1:</label>
                                <input type="text" class="form-control" id="Cod" placeholder="Codigo Fiscal 1"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Codigo Fiscal 2:</label>
                                <input type="text" class="form-control" id="Cod" placeholder="Codigo Fiscal 2"> 
                            </div>
                        </div>
                    </div>
                `,
        	},{
                label: 'Finanzas',
        		content:`
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Codigo Plazos:</label>
                                <input type="text" class="form-control" id="Cod" placeholder="Codigo Fiscal 1"> 
                            </div>
                            <div class="col-6">
                                <label for="">Codigo Fiscal 1:</label>
                                <input type="text" class="form-control" id="Cod" placeholder="Codigo Fiscal 1"> 
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="">Codigo Fiscal 2:</label>
                                <input type="text" class="form-control" id="Cod" placeholder="Codigo Fiscal 2"> 
                            </div>
                        </div>
                    </div>
                `,
        	}],
            final:'Esta Seguro?',
            finalLabel:'Completar',
            modalSize:'lg',
            prevText:'Anterior',
            skipText:'Omitir',
            nextText:'Siguiente',
            finishText:'Terminar',
            onClose:function(data) {
                console.log(data)

            },

            onDestroy:function($elem) {

            }


        });
    });
