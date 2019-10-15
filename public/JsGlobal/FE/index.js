$( function() {
    var from = $( "#fechaInicial" )
            .datepicker({
                dateFormat: "yymmdd 00:00:00",
                changeMonth: true,
                changeYear: false,
                closeText: 'Cerrar',
                prevText: 'Ant',
                nextText: 'Sig',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                weekHeader: 'Sm',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: '',
                showAnim: "drop"
            })
            .on( "change", function() {
                to.datepicker( "option", "minDate", getDate( this ) );
            }),
        to = $( "#fechaFinal" ).datepicker({
            dateFormat: "yymmdd 23:59:59",
            changeMonth: true,
            changeYear: false,
            closeText: 'Cerrar',
            prevText: 'Ant',
            nextText: 'Sig',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
            dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
            weekHeader: 'Sm',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: '',
            showAnim: "drop"
        })
            .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
            });
    function getDate( element ) {
        var date;
        var dateFormat = "yymmdd";
        try {
            date = $.datepicker.parseDate( dateFormat, element.value );
        } catch( error ) {
            date = null;
        }
        return date;
    }
});

$(document).ready(function () {
    $("#tfac").DataTable({
        order: [],
        columns: [
            // permite ordenar columnas y le da el abributo buscar
            {"orderable": false, "searchable": false},
            {"orderable": true, "searchable": true},
            {"orderable": false, "searchable": true},
            {"orderable": false, "searchable": false},
            {"orderable": true, "searchable": true},
            {"orderable": true, "searchable": true},
            {"orderable": true, "searchable": false},
            {"orderable": true, "searchable": true},
            {"orderable": false, "searchable": false},
            {"orderable": false, "searchable": false},
            {"orderable": false, "searchable": false},
            {"orderable": false, "searchable": false},
            {"orderable": true, "searchable": true},
            {"orderable": false, "searchable": false},
        ],

        columnDefs: [
            {
                targets: 0,
            }
        ],

        select: {
            style: 'multi'
        },

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
});

$(document).ready(function () {
    $("#CrearXml").click(function () {
        var selected = [];
        $(".checkboxes").each(function () {
            if (this.checked) {
                var numero = this.id.substring(3,9);
                var factura ={
                    "numero":numero,
                };
                selected.push(factura);
            }
        });
        if (selected.length) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            toastr.info('Un momento por favor...','Generando XML.',{
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "10000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });

            $.ajax({
                cache: false,
                type: 'post',
                dataType: 'json', // importante para que
                data: {selected: JSON.stringify(selected)}, // jQuery convierta el array a JSON
                url: 'fe/xml',
                success: function () {
                    toastr.success("El Archivo XML se ha generado con Exito!.");
                    // preventDefault();  //stop the browser from following

                    window.open('XML/Facturacion_electronica_Facturas.xml');

                }
            });
        } else
            toastr.error("Debes seleccionar al menos una Factura.");
        return false;
    });

});

$("#selectAll").click(function(){
    if($('.checkboxes').attr('disabled')){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'))
    }
   /* else{
        $("input[type=checkbox]").prop('checked', $(this).prop('null'));
    }*/

});


