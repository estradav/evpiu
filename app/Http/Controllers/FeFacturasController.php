<?php

namespace App\Http\Controllers;


use App\FeFacturas;
use App\Http\Requests\FacFeFromRequest;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use XMLWriter;


class FeFacturasController extends Controller
{

    public function index(Request $request)
    {

        $f1 = date( 'Ymd 00:00:00');
        $f2 = date( 'Ymd 23:59:59');

        if (!is_null($request->fechaInicial) && !empty($request->fechaInicial) && !is_null($request->fechaFinal) || !empty($request->fechaFinal))
        { $f1 = $request->fechaInicial;     $f2 = $request->fechaFinal; }

        $facturas = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadas')
            ->leftJoin('CIEV_V_FE','CIEV_V_FacturasTotalizadas.numero','=','CIEV_V_FE.numero')
            ->select('CIEV_V_FacturasTotalizadas.numero','CIEV_V_FacturasTotalizadas.identificacion as nit_cliente',
                'CIEV_V_FacturasTotalizadas.fecha','CIEV_V_FacturasTotalizadas.razonsocial as razon_social',
                'CIEV_V_FacturasTotalizadas.bruto','CIEV_V_FacturasTotalizadas.descuento', 'CIEV_V_FacturasTotalizadas.iva as valor_iva',
                'CIEV_V_FacturasTotalizadas.nomvendedor','CIEV_V_FacturasTotalizadas.ov', 'CIEV_V_FacturasTotalizadas.descplazo as plazo',
                'CIEV_V_FacturasTotalizadas.motivo', 'CIEV_V_FE.codigo_alterno', 'CIEV_V_FacturasTotalizadas.tipocliente as tipo_cliente')
            ->where('CIEV_V_FacturasTotalizadas.tipodoc','=','CU')
            ->whereBetween('CIEV_V_FacturasTotalizadas.fecha', [$f1 , $f2])
            ->orderBy('CIEV_V_FacturasTotalizadas.numero', 'asc')->get();

        return view('FacturacionElectronica.Facturas.index', ["facturas" => $facturas,  "f1" => $f1, "f2" => $f2]);
    }

    public function CrearXml (Request $request)
   {
       $facturasv = $request->selected;
       $facturasv = json_decode($facturasv);


       // Estructura del XML
       $objetoXML = new    XMLWriter();
       $objetoXML->openURI("xml/facturas.xml");
       $objetoXML->openMemory();
       $objetoXML->setIndent(true);
       $objetoXML->setIndentString("\t");
       $objetoXML->startDocument('1.0', 'utf-8');

       //Elemento Raiz del XML
       $objetoXML->startElement("root");

       //Variable para almacenar la salida de la validacion
       $html = '';

       foreach ($facturasv as $fac) {
           $num = $fac->numero;

           $Encabezado = DB::connection('MAX')->table('CIEV_V_FE')
               ->leftJoin('CIEV_V_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FacturasTotalizadas.numero')
               ->select('CIEV_V_FE.numero', 'CIEV_V_FE.notas','CIEV_V_FE.identificacion as nit_cliente','CIEV_V_FE.apellidos',
                   'CIEV_V_FE.emailcontacto','CIEV_V_FE.direccion','CIEV_V_FE.emailentrega','CIEV_V_FE.digito_verificador',
                   'CIEV_V_FE.telefono','CIEV_V_FE.notas','CIEV_V_FE.codciudad','CIEV_V_FE.coddpto','CIEV_V_FE.codigo_alterno',
                   'CIEV_V_FacturasTotalizadas.bruto','CIEV_V_FE.codigocliente','CIEV_V_FE.fechadocumento','CIEV_V_FacturasTotalizadas.razonsocial as razon_social',
                   'CIEV_V_FacturasTotalizadas.bruto','CIEV_V_FacturasTotalizadas.descuento', 'CIEV_V_FacturasTotalizadas.subtotal', 'CIEV_V_FacturasTotalizadas.iva',
                   'CIEV_V_FacturasTotalizadas.fletes','CIEV_V_FacturasTotalizadas.seguros', 'CIEV_V_FacturasTotalizadas.moneda','CIEV_V_FacturasTotalizadas.ov',
                   'CIEV_V_FacturasTotalizadas.dias','CIEV_V_FacturasTotalizadas.motivo','CIEV_V_FacturasTotalizadas.descplazo as plazo','CIEV_V_FacturasTotalizadas.descmotivo',
                   'CIEV_V_FacturasTotalizadas.tipocliente as tipo_cliente','CIEV_V_FE.nombres','CIEV_V_FE.fechavencimiento')
               ->where('CIEV_V_FE.numero', '=', $num)->take(1)->get();

           // esta consulta muestra el detalle de los items de cada factura
           $Detalle = DB::connection('MAX')->table('CIEV_V_FacturasDetalladas')
               ->select('CIEV_V_FacturasDetalladas.factura','CIEV_V_FacturasDetalladas.codigoproducto', 'CIEV_V_FacturasDetalladas.descripcionproducto',
                   'CIEV_V_FacturasDetalladas.OC','CIEV_V_FacturasDetalladas.item','CIEV_V_FacturasDetalladas.cantidad','CIEV_V_FacturasDetalladas.precio',
                   'CIEV_V_FacturasDetalladas.totalitem', 'CIEV_V_FacturasDetalladas.iva as iva_item', 'CIEV_V_FacturasDetalladas.valormercancia',
                   'CIEV_V_FacturasDetalladas.descuento','CIEV_V_FacturasDetalladas.UM','CIEV_V_FacturasDetalladas.base')
               ->where('CIEV_V_FacturasDetalladas.factura', '=', $num)->get();


           foreach ($Encabezado as $enc) {
               ////////////////// CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////
               $brutomasiva     =  $enc->bruto + $enc->iva;
               $totalpagar      = ($enc->bruto - $enc->descuento) + $enc->iva;
               $total_cargos    =  $enc->fletes + $enc->seguros;

               //determina si la factura es exportacion o para venta nacional
                $tipo_fac_en = null;
                if ($enc->motivo == 27) {$tipo_fac_en = '02';}// exportaciones 27
                else {$tipo_fac_en = '01';}

                // determina si el tipo de operacion
                $tipo_operacion = null;
                if ($tipo_fac_en == 02) {$tipo_operacion = 04;}
                if ($tipo_fac_en == 01) {$tipo_operacion = 05;}
                if($enc->iva == 0)      {$tipo_operacion =03;}

                //Determina si la factura es a contado o a credito
               $metodo_pago = null;
                if ($enc->dias == 0) {
                    $metodo_pago = 1;
                }
                else {$metodo_pago = 2;}

                // determina el metodo de pago
               $medio_pago = null;
                if ($metodo_pago == 2) { $medio_pago = null;}
                else{ $medio_pago = 10;}

                // valida el tipo de documento de identidad
               $tipo_documento_ide = null;
                if ($enc->digito_verificador != null )  {$tipo_documento_ide = 31;}
                else{$tipo_documento_ide = 13;}

               // valida si tiene correo de entrega, si no tiene , pone el mismo correo de adquiriente
               $correo_entrega = $enc->emailentrega;
               if ( $correo_entrega == null ) { $correo_entrega = $enc->emailcontacto;}

               // Validacion de impuestos totales por factura



               $id_total_impuesto_iva = null;
               if ($enc->iva != null) {
                   $id_total_impuesto_iva = '01';
               }
               $factor_total = null;
               if ($id_total_impuesto_iva == '01'){
                   $factor_total = '19';
               }
               $tarifa_unitaria_total  = null;
               if ($id_total_impuesto_iva == '01'){
                   $tarifa_unitaria_total = '0';
               }


               $total_valor_iva = $enc->subtotal * 0.19;
               /// para  Rte Fuente
               $total_item_valor = $enc->subtotal + $total_valor_iva;


               ////////////////// FIN CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////

               //Construimos el xlm
               $objetoXML->startElement("documento");    // Se inicia un elemento para cada factura.
               $objetoXML->startElement("idnumeracion");
               $objetoXML->text('2901'); // depende del tipo de documento
               $objetoXML->endElement();

               $objetoXML->startElement("numero");
               $objetoXML->text($enc->numero);
               $objetoXML->endElement();

               $objetoXML->startElement("idambiente");
               $objetoXML->text(2);
               $objetoXML->endElement();

               $objetoXML->startElement("idreporte");
               $objetoXML->text('904'); // sumistrado por fenalco para version grafica
               $objetoXML->endElement();

               $objetoXML->startElement("idestadoenviocliente");
               $objetoXML->text('3');
               $objetoXML->endElement();

               $objetoXML->startElement("idestadoenviodian");
               $objetoXML->text('3');
               $objetoXML->endElement();

               $objetoXML->startElement("fechadocumento");
               $objetoXML->text($enc->fechadocumento);
               $objetoXML->endElement();

               $objetoXML->startElement("fechavencimiento"); // pendiente
               $objetoXML->text($enc->fechavencimiento.' '.'00:00:00');
               $objetoXML->endElement();

               $objetoXML->startElement("tipofactura"); // si se omite es factura de venta
               $objetoXML->text($tipo_fac_en);
               $objetoXML->endElement();

               $objetoXML->startElement("tipooperacion"); // si se omite sera una  factura de venta generica
               $objetoXML->text($tipo_operacion);
               $objetoXML->endElement();

               $objetoXML->startElement("notas"); // ok
               $objetoXML->text($enc->notas);
               $objetoXML->endElement();

               $objetoXML->startElement("fechaimpuestos"); // fecha de pago de impuestos ?
               $objetoXML->text('');
               $objetoXML->endElement();

               $objetoXML->startElement("moneda"); // ok
               $objetoXML->text($enc->moneda);
               $objetoXML->endElement();

               $objetoXML->startElement("cufe"); // Cuando se recibe se compara el valor contra el calculado por el sistema y se lanza error en caso de diferencias
               $objetoXML->text('');
               $objetoXML->endElement();

               $objetoXML->startElement("idconceptonota"); // Tabla 7. Códigos Conceptos Notas Crédito. y Tabla 8. Códigos Conceptos Notas Débito. Solo es obligatorio si <idnumeracion> corresponde a una nota debito o credito
               $objetoXML->text('');
               $objetoXML->endElement();

               $objetoXML->startElement("referencias"); // 0..1 Obligatorio cuando se trata de una nota debito o credito. La DIAN ya no permite notas sin referencia a una factura
               $objetoXML->startElement("referencia"); // La DIAN solo acepta referencias a documentos electrónicos, por tanto la referencia debe existir previamente en el sistema
               $objetoXML->startElement("idnumeracion"); // Ya no se acepta referencia a la numeracion por su prefijo
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("numero");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->endElement();

               $objetoXML->startElement("periodofacturacion"); //  Usable por ejemplo en el pago de servicios publicos
               $objetoXML->startElement('fechainicial'); // En formato YYYY-MM-DD hh:mm:dd
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement('fechafinal'); // En formato YYYY-MM-DD hh:mm:dd
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();

               $objetoXML->startElement("ordencompra");
               $objetoXML->startElement("codigo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("fechageneracion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("base64");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrearchivo");
               $objetoXML->text(' ');
               $objetoXML->endElement();
               $objetoXML->endElement();

               $objetoXML->startElement("constanciarecibido");
               $objetoXML->startElement("codigo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("fechageneracion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("base64");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrearchivo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();

               $objetoXML->startElement("ordendedespacho");
               $objetoXML->startElement("codigo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("fechageneracion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("base64");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrearchivo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();

               /*$objetoXML->startElement("adjuntos");
               $objetoXML->startElement("adjunto");
               $objetoXML->startElement("codigo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idtipoadjunto");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("cufe");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("fechageneracion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("base64");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrearchivo");
               $objetoXML->text(' ');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->endElement();*/


               $objetoXML->startElement("adquiriente"); // falta
               $objetoXML->startElement("idtipopersona"); // falta
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("responsableiva");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idactividadeconomica");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrecomercial"); // validar con martin
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idciudad"); // codigo de ciudad
               $objetoXML->text( $enc->coddpto.$enc->codciudad);
               $objetoXML->endElement();
               $objetoXML->startElement("direccion");
               $objetoXML->text($enc->direccion);
               $objetoXML->endElement();
               $objetoXML->startElement("codigopostal"); // validando con GIO
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombres");
               $objetoXML->text($enc->nombres);
               $objetoXML->endElement();
               $objetoXML->startElement("apellidos");
               $objetoXML->text($enc->apellidos);
               $objetoXML->endElement();
               $objetoXML->startElement("idtipodocumentoidentidad");
               $objetoXML->text($tipo_documento_ide);
               $objetoXML->endElement();
               $objetoXML->startElement("digitoverificacion");
               $objetoXML->text($enc->digito_verificador);
               $objetoXML->endElement();
               $objetoXML->startElement("identificacion");
               $objetoXML->text($enc->nit_cliente);
               $objetoXML->endElement();
               $objetoXML->startElement("obligaciones");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idtiporegimen");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccionfiscal");
               $objetoXML->startElement("idcuidad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("codigopostal");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->startElement("matriculamercantil");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("emailcontacto");
               $objetoXML->text($enc->emailcontacto);
               $objetoXML->endElement();
               $objetoXML->startElement("emailentrega");
               $objetoXML->text($correo_entrega);
               $objetoXML->endElement();
               $objetoXML->startElement("telefono");
               $objetoXML->text(trim($enc->telefono));
               $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("otroautorizado");
               $objetoXML->startElement("idtipopersona");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("ressponsableiva");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idactividadeconomica");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrecomercial");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idciudad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("codigopostal");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombres");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("apellidos");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idtipodocumentoidentidad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("digitoverificacion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("identificacion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("obligaciones");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idtiporegimen");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccionfiscal");
               $objetoXML->startElement("idcuidad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("codigopostal");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->startElement("matriculamercantil");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("emailcontacto");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("emailentrega");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("telefono");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("mandato");
               $objetoXML->startElement("identificador");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("fechacontrato");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("mandantes");
               $objetoXML->startElement("mandante");
               $objetoXML->startElement("idtipopersona");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("ressponsableiva");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idactividadeconomica");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombrecomercial");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idciudad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("codigopostal");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("nombres");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("apellidos");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idtipodocumentoidentidad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("digitoverificacion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("identificacion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("obligaciones");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("idtiporegimen");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccionfiscal");
               $objetoXML->startElement("idcuidad");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("direccion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("codigopostal");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->startElement("matriculamercantil");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("emailcontacto");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("emailentrega");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("telefono");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("formapago");
               $objetoXML->startElement("idmetodopago");
               $objetoXML->text($metodo_pago);
               $objetoXML->endElement();
               $objetoXML->startElement("idmediopago");
               $objetoXML->text($medio_pago);
               $objetoXML->endElement();
               $objetoXML->startElement("fechavencimiento");
               $objetoXML->text($enc->fechavencimiento.' '.'00:00:00');
               $objetoXML->endElement();
               $objetoXML->startElement("identificador");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("dias");
               $objetoXML->text($enc->dias);
               $objetoXML->endElement();
               $objetoXML->endElement();


        /*       $objetoXML->startElement("tasasdecambio");
               $objetoXML->startElement("tasadecambio");
               $objetoXML->startElement("fecha");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("moneda");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("cambiominimo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("tasarepresentativa");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->endElement();*/


               $objetoXML->startElement("anticipos");
               $objetoXML->startElement("anticipo");
               $objetoXML->startElement("identificador");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("valor");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("fecha");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("cargos");
               $objetoXML->startElement("cargo");
               $objetoXML->startElement("idconcepto");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("escargo");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("descripcion");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("porcentaje");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("base");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("valor");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("impuestos");
                   $objetoXML->startElement("impuesto");
                       $objetoXML->startElement("idimpuesto");
                       $objetoXML->text($id_total_impuesto_iva);
                       $objetoXML->endElement();
                       $objetoXML->startElement("base");
                       $objetoXML->text(number_format($enc->subtotal,2,'.',''));
                       $objetoXML->endElement();
                       $objetoXML->startElement("factor");
                       $objetoXML->text($factor_total);
                       $objetoXML->endElement();
                       $objetoXML->startElement("estarifaunitaria");
                       $objetoXML->text($tarifa_unitaria_total);
                       $objetoXML->endElement();
                       $objetoXML->startElement("valor");
                       $objetoXML->text(number_format($total_valor_iva,2,'.',''));
                       $objetoXML->endElement();
                   $objetoXML->endElement();
               $objetoXML->endElement();


               $objetoXML->startElement("totales");
               $objetoXML->startElement("totalbruto");
               $objetoXML->text(number_format($enc->bruto,2,'.',''));
               $objetoXML->endElement();
               $objetoXML->startElement("baseimponible");
               $objetoXML->text(number_format($enc->subtotal,2,'.',''));
               $objetoXML->endElement();
               $objetoXML->startElement("totalbrutoconimpuestos");
               $objetoXML->text(number_format($brutomasiva,2,'.',''));
               $objetoXML->endElement();
               $objetoXML->startElement("totaldescuento");
               $objetoXML->text(number_format($enc->descuento,2,'.',''));
               $objetoXML->endElement();
               $objetoXML->startElement("totalcargos");
               $objetoXML->text($total_cargos);
               $objetoXML->endElement();
               $objetoXML->startElement("totalanticipos");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->startElement("totalapagar");
               $objetoXML->text(number_format($totalpagar,2,'.',''));
               $objetoXML->endElement();
               $objetoXML->startElement("payableroundingamount");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();

              /* $objetoXML->startElement("correoscopia");
               $objetoXML->startElement("correocopia");
               $objetoXML->text('');
               $objetoXML->endElement();
               $objetoXML->endElement();*/

               $objetoXML->startElement("items");

               foreach ($Detalle as $it) {

                   //$impuestos_item = $it->
                   $valor_item = $it->precio * $it->cantidad;
                   // valida si el item es comprado o se da como regalo
                   $regalo = null;
                   if ($valor_item == 0)
                   {$regalo = 1;}
                   else {$regalo = 0;}

                // valida el tipo de codigo 020 posicion alacelaria o 999 adopcion del contribuyente
                   $id_estandar = null;
                   if ($tipo_fac_en == 02)
                   {$id_estandar = '020-999';}
                   else{$id_estandar = 999;}

                 // valida nombre estandar del codigo
                   $nombre_estandar = null;
                   if ($id_estandar <> 999)
                   { $nombre_estandar = null;}
                   else { $nombre_estandar = 'EAN13'; }

                   // valida el id impuesto por item
                   $id_impuesto = null;
                   if ( $it->iva_item != 0 ){
                       $id_impuesto = '01';
                   }

                   // porcentaje de impuesto
                   $factor = null;
                   if ( $id_impuesto == '01'){
                       $factor = '19';
                   }

                   $umed = null;
                   if ($it->UM == 'UN'){
                       $umed = '94';
                   }else{
                       $umed = 'KGM';
                   }

                   ////
                   $id_item_iva = null;
                   if ($it->iva_item != null) {
                       $id_item_iva = '01';
                   }
                   $factor_total_item = null;
                   if ($id_item_iva == '01'){
                       $factor_total_item = '19';
                   }
                   $tarifa_item_unitaria  = null;
                   if ($id_item_iva == '01'){
                       $tarifa_item_unitaria = '0';
                   }

                   $subtotal_item = $it->totalitem - $it->descuento;
                   $total_valor_item_iva = $subtotal_item * 0.19;


                   $objetoXML->startElement("item");

                   $objetoXML->startElement("codigos");
                   $objetoXML->startElement("estandar");
                   $objetoXML->startElement("idestandar");
                   $objetoXML->text($id_estandar);
                   $objetoXML->endElement();
                   $objetoXML->startElement("nombreestandar");
                   $objetoXML->text('');
                   $objetoXML->endElement();
                   $objetoXML->startElement("codigo");
                   $objetoXML->text(trim($it->codigoproducto));
                   $objetoXML->endElement();
                   $objetoXML->endElement();
                   $objetoXML->endElement();

                   $objetoXML->startElement("descripcion");
                   $objetoXML->text(trim($it->descripcionproducto));
                   $objetoXML->endElement();

                   $objetoXML->startElement("notas");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("cantidad");
                   $objetoXML->text(number_format($it->cantidad, 0, '', ''));
                   $objetoXML->endElement();

                   $objetoXML->startElement("cantidadporempaque");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("preciounitario");
                   $objetoXML->text(number_format($it->precio,2,'.',''));
                   $objetoXML->endElement();

                   $objetoXML->startElement("unidaddemedida");
                   $objetoXML->text($umed);
                   $objetoXML->endElement();

                   $objetoXML->startElement("marca");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("modelo");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("codigovendedor");
                   $objetoXML->text(trim($it->codigoproducto));
                   $objetoXML->endElement();

                   $objetoXML->startElement("subcodigovendedor");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("idmandatario");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("regalo");
                   $objetoXML->text(trim($regalo));
                   $objetoXML->endElement();

                   $objetoXML->startElement("totalitem");
                   $objetoXML->text(number_format($valor_item,2,'.',''));
                   $objetoXML->endElement();

                   $objetoXML->startElement("cargos");
                   $objetoXML->startElement("cargo");

                   $objetoXML->startElement("idconcepto");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("escargo");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("descripcion");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("porcentaje");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("base");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("valor");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->endElement();
                   $objetoXML->endElement();

                   $objetoXML->startElement("impuestos");
                       $objetoXML->startElement("impuesto");
                           $objetoXML->startElement("idimpuesto");
                           $objetoXML->text($id_item_iva);
                           $objetoXML->endElement();

                           $objetoXML->startElement("base");
                           $objetoXML->text(number_format($subtotal_item,2,'.',''));
                           $objetoXML->endElement();

                           $objetoXML->startElement("factor");
                           $objetoXML->text($factor_total_item);
                           $objetoXML->endElement();

                           $objetoXML->startElement("estarifaunitaria");
                           $objetoXML->text($tarifa_item_unitaria);
                           $objetoXML->endElement();

                           $objetoXML->startElement("valor");
                           $objetoXML->text(number_format($total_valor_item_iva,2,'.',''));
                           $objetoXML->endElement();
                       $objetoXML->endElement();
                       // RETEFUENTE
                       $objetoXML->startElement("impuesto");
                           $objetoXML->startElement("idimpuesto");
                           $objetoXML->text('');
                           $objetoXML->endElement();

                           $objetoXML->startElement("base");
                           $objetoXML->text('');
                           $objetoXML->endElement();

                           $objetoXML->startElement("factor");
                           $objetoXML->text($factor_total_item);
                           $objetoXML->endElement();

                           $objetoXML->startElement("estarifaunitaria");
                           $objetoXML->text($tarifa_item_unitaria);
                           $objetoXML->endElement();

                           $objetoXML->startElement("valor");
                           $objetoXML->text(number_format($total_valor_item_iva,2,'.',''));
                           $objetoXML->endElement();
                       $objetoXML->endElement();
                   $objetoXML->endElement();


                  /* $objetoXML->startElement("datosextra");
                   $objetoXML->startElement("datoextra");

                   $objetoXML->startElement("clave");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->startElement("valor");
                   $objetoXML->text('');
                   $objetoXML->endElement();

                   $objetoXML->endElement();
                   $objetoXML->endElement();*/

                   $objetoXML->endElement(); // cierra item
               }
               $objetoXML->endElement(); // cierra items
               $objetoXML->endElement(); // Final del nodo raíz, "documento"
           }
       }

       $objetoXML->endDocument();  // Final del documento

       $cadenaXML = $objetoXML->outputMemory();
       file_put_contents('xml/facturas.xml', $cadenaXML);

       return response()->json();
   }

    public function editfactura ($numero)
    {
       $numero_de = $numero;


        $var =  DB::connection('MAX')->table('CIEV_V_FE')
            ->leftJoin('CIEV_V_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FacturasTotalizadas.numero')
            ->select('CIEV_V_FE.numero','CIEV_V_FE.notas','CIEV_V_FE.identificacion as nit_cliente','CIEV_V_FE.nombres',
                'CIEV_V_FE.apellidos','CIEV_V_FE.emailcontacto','CIEV_V_FE.direccion','CIEV_V_FE.emailentrega','CIEV_V_FE.digito_verificador',
                'CIEV_V_FE.telefono','CIEV_V_FE.notas','CIEV_V_FE.Ciudad','CIEV_V_FE.Dpto','CIEV_V_FE.Pais','CIEV_V_FacturasTotalizadas.bruto',
                'CIEV_V_FE.codigocliente','CIEV_V_FE.fechadocumento','CIEV_V_FacturasTotalizadas.razonsocial as razon_social','CIEV_V_FacturasTotalizadas.bruto',
                'CIEV_V_FacturasTotalizadas.descuento','CIEV_V_FacturasTotalizadas.subtotal', 'CIEV_V_FacturasTotalizadas.iva','CIEV_V_FacturasTotalizadas.fletes',
                'CIEV_V_FacturasTotalizadas.seguros','CIEV_V_FacturasTotalizadas.moneda','CIEV_V_FacturasTotalizadas.ov','CIEV_V_FacturasTotalizadas.dias',
                'CIEV_V_FacturasTotalizadas.motivo','CIEV_V_FacturasTotalizadas.descplazo as plazo','CIEV_V_FacturasTotalizadas.descmotivo',
                'CIEV_V_FacturasTotalizadas.tipocliente as tipo_cliente','CIEV_V_FE.nombres','CIEV_V_FE.fechavencimiento')
            ->where('CIEV_V_FE.numero', '=', $numero_de)->take(1)->get();

        $detalle = DB::connection('MAX')->table('CIEV_V_FacturasDetalladas')
            ->select('CIEV_V_FacturasDetalladas.factura', 'CIEV_V_FacturasDetalladas.descripcionproducto','CIEV_V_FacturasDetalladas.CodigoProducto',
                'CIEV_V_FacturasDetalladas.OV','CIEV_V_FacturasDetalladas.item','CIEV_V_FacturasDetalladas.cantidad','CIEV_V_FacturasDetalladas.precio',
                'CIEV_V_FacturasDetalladas.totalitem', 'CIEV_V_FacturasDetalladas.iva as iva_item', 'CIEV_V_FacturasDetalladas.valormercancia',
                'CIEV_V_FacturasDetalladas.descuento','CIEV_V_FacturasDetalladas.item','CIEV_V_FacturasDetalladas.UM')
            ->where('CIEV_V_FacturasDetalladas.factura', '=', $numero_de)->get();


       return view('FacturacionElectronica.Facturas.edit', ["var" => $var,  "detalle" => $detalle] );
    }

    public function updatefactura (FacFeFromRequest $request)
    {
        //
    }



}
