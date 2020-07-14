$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('#table').dataTable({
        language: {
            url: '/Spanish.json'
        }
    });


    $(document).on('click', '#nuevo', function () {
        document.getElementById("cod").readOnly = true;
        document.getElementById("mm2").readOnly = true;
        document.getElementById("denominacion").readOnly = true;
        document.getElementById("heading").innerHTML = "Nuevo";
        $('input').closest('.form-control').removeClass('is-invalid');
        $('.error').remove();
        $('#sublinea').empty().append('<option value="">Seleccione... </option>');
        $('#UndMedida').empty().append('<option value="">Seleccione... </option>');
        $('#form').trigger('reset');
        $('#campos').html('');
        $('#modal').modal('show');
    });


    $(document).on('click', '.delete', function () {
        let id = this.id;
        Swal.fire({
            title: '¿Esta seguro de Eliminar?',
            html: "¡Esta accion <b class='text-danger'>NO</b> se puede revertir!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "/aplicaciones/productos/maestros/medida/" + id,
                    success: function () {
                        Swal.fire({
                            title: 'Eliminado!',
                            text: "El registro ha sido eliminado.",
                            icon: 'success',
                        });
                        setTimeout(function() {
                            window.location.reload(true);
                        }, 3000);
                    },
                    error: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: data.responseText
                        })
                    }
                });
            }else{
                result.dismiss === Swal.DismissReason.cancel
            }
        })
    });


    $(document).on('change', '#linea', function () {
        let linea_id = this.value;
        $('#UndMedida').empty();
        $('#campos').html('');
        $.ajax({
            url: '/aplicaciones/productos/maestros/caracteristica/listar_sublineas',
            type: 'get',
            data: {
                linea_id:linea_id
            },
            success: function (data) {
                $('#sublinea').empty();
                $('#sublinea').append('<option value="">Seleccione...</option>');
                for (let i = 0; i < data.length ; i++) {
                    $('#sublinea').append('<option value="'+ data[i].id +'">'+ data[i].name +'</option>')
                }
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    $(document).on('change', '#sublinea', function () {
        let sublineas_id = this.value;
        $('#campos').html('');

        $.ajax({
            url: '/aplicaciones/productos/maestros/medida/listar_cara_y_unidad_medida',
            type: 'get',
            data: {
                sublineas_id: sublineas_id
            },
            success: function (data) {
                $('#UndMedida').empty();
                $('#UndMedida').append('<option value="">Seleccione...</option>');
                for (let i = 0; i < data.unidades_medida.length ; i++) {
                    $('#UndMedida').append('<option value="'+ data.unidades_medida[i].name +'">'+ data.unidades_medida[i].descripcion +'</option>')
                }

                for (let i = 0; i < data.carac_unidades_medida.length; i++) {
                    $('#campos').append(`
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class="col-sm-12" for="`+ data.carac_unidades_medida[i].name +`">`+ data.carac_unidades_medida[i].name +`:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control `+ data.carac_unidades_medida[i].name +`" id="`+ data.carac_unidades_medida[i].name +`" name="`+ data.carac_unidades_medida[i].name +`" >
                                        </div>
                                    </div>
                                </div>
                            `);
                }
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    $(document).on('change', '#UndMedida', function () {
        $.ajax({
            url: '/aplicaciones/productos/maestros/medida/info_calculo_cod',
            type: 'get',
            data: {
                linea: document.getElementById('linea').value,
                sublinea: document.getElementById('sublinea').value
            },
            success: function (data) {
                document.getElementById('cod').value = generar_codigo(data.codigos, data.ultimo);
            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        })
    });


    $(document).on('keyup', '#Diametro', function () {
        var base = document.getElementById('Base');
        var altura = document.getElementById('Altura');

        if(base){
            base.value = 0;
        }
        if (altura){
            altura.value = 0;
        }

        let unidad_medida = document.getElementById('UndMedida').value;
        var diametro = this.value;
        var perforacion = document.getElementById('Perforacion').value;
        var pestana = document.getElementById('Pestaña').value;
        var espesor = document.getElementById('Espesor').value;


        document.getElementById('mm2').value = calcular_mm2(unidad_medida, null, null, diametro, null, null, null);
        document.getElementById('denominacion').value = generar_denominacion(unidad_medida, "", "", diametro, perforacion, pestana, espesor);
    });


    $(document).on('keyup', '#Base', function () {
        var diametro = document.getElementById('Diametro');
        if (diametro){
            diametro.value = 0
        }

        let unidad_medida = document.getElementById('UndMedida').value;
        var base = this.value;
        var altura = document.getElementById('Altura').value;
        var perforacion = document.getElementById('Perforacion').value;
        var pestana = document.getElementById('Pestaña').value;
        var espesor = document.getElementById('Espesor').value;


        document.getElementById('mm2').value = calcular_mm2(unidad_medida, base, altura, null);
        document.getElementById('denominacion').value = generar_denominacion(unidad_medida, base, altura, "", perforacion, pestana, espesor);
    });


    $(document).on('keyup', '#Altura', function () {
        var diametro = document.getElementById('Diametro');
        if (diametro){
            diametro.value = 0
        }

        let unidad_medida = document.getElementById('UndMedida').value;
        var base = document.getElementById('Base').value;
        var altura = this.value;
        var perforacion = document.getElementById('Perforacion').value;
        var pestana = document.getElementById('Pestaña').value;
        var espesor = document.getElementById('Espesor').value;

        document.getElementById('mm2').value = calcular_mm2(unidad_medida, base, altura, null);
        document.getElementById('denominacion').value = generar_denominacion(unidad_medida, base, altura, "", perforacion, pestana, espesor);
    });


    $(document).on('keyup', '#Perforacion', function () {
        let unidad_medida = document.getElementById('UndMedida').value;
        var diametro = document.getElementById('Diametro').value;

        var base = document.getElementById('Base').value;
        var altura = document.getElementById('Altura').value;


        var perforacion = this.value;
        var pestana = document.getElementById('Pestaña').value;
        var espesor = document.getElementById('Espesor').value;

        if (diametro != 0){
            document.getElementById('denominacion').value = generar_denominacion(unidad_medida, "", "", diametro, perforacion, pestana, espesor);
        }else{
            document.getElementById('denominacion').value = generar_denominacion(unidad_medida, base, altura, "", perforacion, pestana, espesor);
        }

    });


    $(document).on('keyup', '#Pestaña', function () {
        let unidad_medida = document.getElementById('UndMedida').value;
        var diametro = document.getElementById('Diametro').value;

        var base = document.getElementById('Base').value;
        var altura = document.getElementById('Altura').value;


        var perforacion = document.getElementById('Perforacion').value;
        var pestana = this.value;
        var espesor = document.getElementById('Espesor').value;

        if (diametro != 0){
            document.getElementById('denominacion').value = generar_denominacion(unidad_medida, "", "", diametro, perforacion, pestana, espesor);
        }else{
            document.getElementById('denominacion').value = generar_denominacion(unidad_medida, base, altura, "", perforacion, pestana, espesor);
        }
    });


    $(document).on('keyup', '#Espesor', function () {
        let unidad_medida = document.getElementById('UndMedida').value;
        var diametro = document.getElementById('Diametro').value;

        var base = document.getElementById('Base').value;
        var altura = document.getElementById('Altura').value;


        var perforacion = document.getElementById('Perforacion').value;
        var pestana = document.getElementById('Pestaña').value;
        var espesor = this.value;

        if (diametro != 0){
            document.getElementById('denominacion').value = generar_denominacion(unidad_medida, "", "", diametro, perforacion, pestana, espesor);
        }else{
            document.getElementById('denominacion').value = generar_denominacion(unidad_medida, base, altura, "", perforacion, pestana, espesor);
        }
    });


    $(document).on('click', '.edit', function () {
        let id = this.id;
        document.getElementById("cod").readOnly = true;
        document.getElementById("mm2").readOnly = true;
        document.getElementById("denominacion").readOnly = true;
        $('#form').trigger('reset');
        $('#campos').html('');

        $.ajax({
            url: "/aplicaciones/productos/maestros/medida/" + id + "/edit",
            type: 'get',
            success: function (data) {
                console.log(data);
                document.getElementById('id').value = data.values.id;
                document.getElementById('cod').value = data.values.cod;
                document.getElementById('mm2').value = data.values.mm2;
                document.getElementById('denominacion').value = data.values.denominacion;
                document.getElementById('linea').value = data.values.med_lineas_id;
                document.getElementById('coments').value = data.values.coments;


                $('#sublinea').append('<option value="">Seleccione...</option>');
                for (let i = 0; i < data.sublineas.length ; i++) {
                    $('#sublinea').append('<option value="'+ data.sublineas[i].id +'">'+ data.sublineas[i].name +'</option>')
                }

                document.getElementById('sublinea').value = data.values.med_sublineas_id;


                const unidades_medida = data.carac_udm.unidades_medida;

                $('#UndMedida').append('<option value="">Seleccione...</option>');
                for (let i = 0; i < unidades_medida.length ; i++) {
                    $('#UndMedida').append('<option value="'+ unidades_medida[i].name +'">'+ unidades_medida[i].descripcion +'</option>')
                }


                const carac_unidades_medida = data.carac_udm.carac_unidades_medida;

                for (let i = 0; i < carac_unidades_medida.length; i++) {
                    $('#campos').append(`
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class="col-sm-12" for="`+ carac_unidades_medida[i].name +`">`+ carac_unidades_medida[i].name +`:</label>
                                        <div class="col-sm-12">
                                            <input type="number" class="form-control `+ carac_unidades_medida[i].name +`" id="`+ carac_unidades_medida[i].name +`" name="`+ carac_unidades_medida[i].name +`" >
                                        </div>
                                    </div>
                                </div>
                            `);
                }

                document.getElementById("UndMedida").value = data.values.undmedida;

                if (data.values.diametro !== null){
                    console.log(document.getElementById("Diametro"));
                    document.getElementById("Diametro").value = parseInt(data.values.diametro);
                }
                if (data.values.base !== null){
                    document.getElementById("Base").value = data.values.base;
                }
                if (data.values.altura !== null){
                    document.getElementById("Altura").value = data.values.altura;
                }
                if (data.values.perforacion !== null){
                    document.getElementById("Perforacion").value = data.values.perforacion;
                }
                if (data.values.espesor !== null){
                    document.getElementById("Espesor").value = data.values.espesor;
                }
                if (data.values.pestana !== null){
                    document.getElementById("Pestaña").value = data.values.pestana;
                }
                $('#modal').modal('show');

            },
            error: function (data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops',
                    text: data.responseText
                });
            }
        });
    });


    /*si el usuario escoge base, por defecto tambien tiene altura  */
    function calcular_mm2(unidad_medida, base, altura, diametro) {
        if(unidad_medida === 'mm'){
            if (diametro !== null){
                const result = Math.floor(diametro * diametro);
                if (result < 150){
                    return 100;
                }else{
                    return result;
                }
            }else if (base !== null && altura !== null){
                const result = Math.floor(base * altura);
                if (result < 150){
                    return 100;
                }else{
                    return result;
                }
            }
        }else if(unidad_medida === 'l'){
            if (diametro !== null){
                let result = ((diametro * 0.64) * (diametro * 0.64)) * 2;
                result = Math.floor(result);
                if (result < 150){
                    return 100;
                }else{
                    return result;
                }
            }else if(base !== null && altura !== null){
                let result = ((base * 0.64) * (altura * 0.64)) * 2;
                result = Math.floor(result);
                if (result < 150){
                    return 100;
                }else{
                    return result;
                }
            }
        }else if(unidad_medida === 'un'){
            if (diametro !== null){
                let result = ((diametro * 25.40) * (diametro * 25.40)) * 2;
                result = Math.floor(result);
                if (result < 150){
                    return 100;
                }else{
                    return result;
                }
            }else if(base !== null && altura !== null){
                let result = ((Base * 25.40) * (Altura * 25.40)) * 2;
                result = Math.floor(result);
                if (result < 150){
                    return 100;
                }else{
                    return result;
                }
            }
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: 'Unidad de medida no valida!'
            });
        }
    }


    function generar_denominacion(unidad_medida, base, altura, diametro, perforacion, pestana, espesor) {
        let string_result = '';
        if (diametro !== ""){
            string_result += string_result + "D:" + diametro;
            if (perforacion !== ""){
                string_result = string_result + " P:" + perforacion;
            }
            if (espesor !== ""){
                string_result = string_result + " E:" + espesor;
            }
            if (pestana !== ""){
                string_result = string_result + " PE:" + pestana;
            }
        }
        else if (base !== "" && altura !== ""){
            string_result += string_result + "B:" + base + " A:" + altura;
            if (perforacion !== ""){
                string_result = string_result + " P:" + perforacion;
            }
            if (espesor !== ""){
                string_result = string_result + " E:" + espesor;
            }
            if (pestana !== ""){
                string_result = string_result + " PE:" + pestana;
            }
        }
        console.log(string_result + unidad_medida);
        return string_result + unidad_medida;
    }



    /**
     * @return {string}
     */
    function generar_codigo(codigos_usados, ultimo_codigo_usado){
        var incremental         = 0;
        var charStringRange     = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        var vectorc             = [];
        var t1                  = 0;
        var numerof             = 0;
        var Codigos_usados      = codigos_usados;
        var Ultimo_codigo_usado = ultimo_codigo_usado;

        for (let f = 0; f < Codigos_usados.length; f++) {
            if (Ultimo_codigo_usado  == Codigos_usados[f] && Codigos_usados[f]){
                const cadena = Codigos_usados[f];
                let text  = cadena.split('').reverse().join('');
                text      = text.split('');

                for (let x = 0; x < 2; x++) {
                    for (var i = 0; i < 36; i++) {
                        if (text[x] == charStringRange[i]) {
                            break;
                        }
                    }
                    numerof += i*Math.pow(36, x);
                }
                vectorc[t1] = numerof;
                t1++;
                numerof = 0;
            }
        }

        let maxvector = Math.max.apply(Math, vectorc); //saca el valor maximo de un arreglo
        if (maxvector >= 0) {
            incremental = maxvector + 1;
        }
        var text = '';
        var incretemp = incremental;
        for (let j = 0; j < 2; j++){
            incretemp = Math.floor(incretemp)/36;
            text += charStringRange.charAt(Math.round((incretemp - Math.floor(incretemp))*36));
        }
        text = text.split('').reverse().join('');

        return text;
    }


    $("#form").validate({
        ignore: "",
        rules: {
            linea:{
                select_check: true
            },
            sublinea:{
                select_check: true
            },
            UndMedida:{
                select_check: true
            },
            cod: {
                minlength: 2,
                maxlength: 2,
                required: true
            },
            denominacion: {
                remote: {
                    url: '/aplicaciones/productos/maestros/medida/validar_denominacion',
                    type: 'POST',
                    data: {
                        linea: function () {
                            return $("#linea").val();
                        },
                        sublinea: function () {
                            return $("#sublinea").val();
                        },
                    },
                    async: true,
                },
                minlength: 2,
                required : true,
            }
        },
        highlight: function (element) {
            $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).closest('.form-control').removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                url: "/aplicaciones/productos/maestros/medida",
                type: "POST",
                data: $('#form').serialize(),
                dataType: 'json',
                success: function (data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado!',
                        text: "El registro ha sido guardado.",
                    });

                    $('#form').trigger("reset");
                    $('#modal').modal('hide');

                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);
                },
                error: function (data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: data.responseText
                    });
                }
            });
        }
    });


    jQuery.extend(jQuery.validator.messages, {
        required: "Este campo es obligatorio.",
        remote: "Este codigo ya existe.",
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


    jQuery.validator.addMethod("select_check", function(value){
        return (value != '');
    }, "Por favor, seleciona una opcion.");
});
