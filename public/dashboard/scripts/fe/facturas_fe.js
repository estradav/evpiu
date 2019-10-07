$(document).ready(function() {
    $("#CrearXml").click(function() {
        alert('primer paso');
        var selected = [];

         $(".checkboxes").each(function() {
        //$(":checkbox[id=chk]").each(function() {

            if (this.checked) {
                // agregas cada elemento.
                alert('estoy checkeado'+this.id);
                selected.push($(this).val());
            }
        });
      if (selected.length) {

            $.ajax({
               cache: false,
                type: 'post',
                dataType: 'json', // importante para que
                data: selected, // jQuery convierta el array a JSON
                url: 'fe/xml',
                success: function(data) {
                    alert('XML Generado con Exito!');
                }
            });

            // esto es solo para demostrar el json,
            // con fines didacticos
          //  alert(JSON.stringify(selected));

        } else
            alert('Debes seleccionar al menos una Factura.');

        return false;
    });
});
