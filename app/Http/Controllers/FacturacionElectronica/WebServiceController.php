<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoapClient;
use SoapFault;
use XMLWriter;

class WebServiceController extends Controller
{
    /**
     * Envia un conjunto de facturas al WebService de fenalco
     *
     * @param Request $request
     * @return JsonResponse
     * @throws SoapFault
     */
    public function envio_facturas(Request $request){
        $Facturas_Seleccionadas = $request->selected;
        $Facturas_Seleccionadas = json_decode($Facturas_Seleccionadas);

        // Estructura del XML
        $resultados = [];
        foreach ($Facturas_Seleccionadas as $Factura_seleccionada) {
            $objetoXML = new XMLWriter();
            $objetoXML->openMemory();
            $objetoXML->setIndent(true);
            $objetoXML->setIndentString("\t");
            $objetoXML->startDocument('1.0', 'utf-8');

            //Elemento Raiz del XML
            $objetoXML->startElement("root");

            $NumeroFactura = $Factura_seleccionada->numero;

            $Encabezado_Factura = DB::connection('MAX')
                ->table('CIEV_V_FE')
                ->leftJoin('CIEV_V_FE_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FE_FacturasTotalizadas.numero')
                ->select('CIEV_V_FE.numero',
                    'CIEV_V_FE.notas',
                    'CIEV_V_FE.identificacion as nit_cliente',
                    'CIEV_V_FE.apellidos',
                    'CIEV_V_FE.emailcontacto',
                    'CIEV_V_FE.direccion',
                    'CIEV_V_FE.emailentrega',
                    'CIEV_V_FE.digito_verificador',
                    'CIEV_V_FE.idtipodocumento',
                    'CIEV_V_FE.telefono',
                    'CIEV_V_FE.notas',
                    'CIEV_V_FE.OC',
                    'CIEV_V_FE.codciudad',
                    'CIEV_V_FE.coddpto',
                    'CIEV_V_FE.codigo_alterno',
                    'CIEV_V_FE.codigocliente',
                    'CIEV_V_FE.fechadocumento',
                    'CIEV_V_FE.nombres',
                    'CIEV_V_FE.fechavencimiento',
                    'CIEV_V_FE_FacturasTotalizadas.OV',
                    'CIEV_V_FE_FacturasTotalizadas.bruto',
                    'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                    'CIEV_V_FE_FacturasTotalizadas.descuento',
                    'CIEV_V_FE_FacturasTotalizadas.subtotal',
                    'CIEV_V_FE_FacturasTotalizadas.bruto_usd',
                    'CIEV_V_FE_FacturasTotalizadas.fletes_usd',
                    'CIEV_V_FE_FacturasTotalizadas.seguros_usd',
                    'CIEV_V_FE_FacturasTotalizadas.iva',
                    'CIEV_V_FE_FacturasTotalizadas.fletes',
                    'CIEV_V_FE_FacturasTotalizadas.RTEFTE',
                    'CIEV_V_FE_FacturasTotalizadas.RTEIVA',
                    'CIEV_V_FE_FacturasTotalizadas.seguros',
                    'CIEV_V_FE_FacturasTotalizadas.moneda',
                    'CIEV_V_FE_FacturasTotalizadas.ov',
                    'CIEV_V_FE_FacturasTotalizadas.dias',
                    'CIEV_V_FE_FacturasTotalizadas.motivo',
                    'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                    'CIEV_V_FE_FacturasTotalizadas.descmotivo',
                    'CIEV_V_FE_FacturasTotalizadas.correoscopia',
                    'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                ->where('CIEV_V_FE.numero', '=', $NumeroFactura)
                ->take(1)
                ->get();

            // esta consulta muestra el detalle de los items de cada factura
            $Items_Factura = DB::connection('MAX')
                ->table('CIEV_V_FE_FacturasDetalladas')
                ->select('CIEV_V_FE_FacturasDetalladas.factura',
                    'CIEV_V_FE_FacturasDetalladas.codigoproducto',
                    'CIEV_V_FE_FacturasDetalladas.descripcionproducto',
                    'CIEV_V_FE_FacturasDetalladas.OC',
                    'CIEV_V_FE_FacturasDetalladas.item',
                    'CIEV_V_FE_FacturasDetalladas.cantidad',
                    'CIEV_V_FE_FacturasDetalladas.precio',
                    'CIEV_V_FE_FacturasDetalladas.precioUSD',
                    'CIEV_V_FE_FacturasDetalladas.totalitem',
                    'CIEV_V_FE_FacturasDetalladas.totalitemUSD',
                    'CIEV_V_FE_FacturasDetalladas.iva as iva_item',
                    'CIEV_V_FE_FacturasDetalladas.valormercancia',
                    'CIEV_V_FE_FacturasDetalladas.Desc_Item',
                    'CIEV_V_FE_FacturasDetalladas.UM',
                    'CIEV_V_FE_FacturasDetalladas.base',
                    'CIEV_V_FE_FacturasDetalladas.posicionarancelaria',
                    'CIEV_V_FE_FacturasDetalladas.bruto_usd',
                    'CIEV_V_FE_FacturasDetalladas.fletes_usd',
                    'CIEV_V_FE_FacturasDetalladas.seguros_usd')
                ->where('CIEV_V_FE_FacturasDetalladas.factura', '=', $NumeroFactura)
                ->get();

            $Configuracion = DB::table('fe_configs')
                ->take(1)
                ->get();

            $items_Normales = [];
            $items_Regalo = [];

            foreach ($Items_Factura as $Item_Factura) {
                if ($Item_Factura->totalitem == 0 || $Item_Factura->totalitem < 0){
                    $items_Regalo[] = $Item_Factura;
                }else{
                    $items_Normales[] = $Item_Factura;
                }
            }

            foreach ($Encabezado_Factura as $encabezado) {
                $bruto_factura           = null;
                $subtotal_factura        = null;
                $brutomasiva_factura     = null;
                $descuento_factura       = null;
                $total_cargos            = null;
                $totalpagar              = null;
                $tipo_fac_en             = null;
                $tipo_operacion          = '10';
                $metodo_pago             = null;
                $medio_pago              = null;
                $tipo_documento_ide      = null;
                $correo_entrega          = $encabezado->emailentrega;
                $id_total_impuesto_iva   = null;
                $factor_total            = null;
                $tarifa_unitaria_total   = null;
                $Regalos                 = [];
                $RegalosString           = '';
                $precio_unitario         = null;


                ////////////////// CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////
                if($encabezado->tipo_cliente  == 'EX'){
                    $bruto_factura       = $encabezado->bruto_usd;
                    $subtotal_factura    = $encabezado->bruto_usd;
                    $brutomasiva_factura = number_format($encabezado->bruto_usd,2,'.','');
                    $descuento_factura   = 0;
                    $total_cargos        = number_format($encabezado->fletes_usd,2,'.','') + number_format($encabezado->seguros_usd,2,'.','');
                    $totalpagar          = (number_format($encabezado->bruto_usd,2,'.','')  + $total_cargos);

                } else {
                    $bruto_factura       = $encabezado->bruto;
                    $subtotal_factura    = $encabezado->bruto - $encabezado->descuento;
                    $brutomasiva_factura = number_format($encabezado->bruto,2,'.','') + number_format($encabezado->iva,2,'.','');
                    $descuento_factura   = $encabezado->descuento;
                    $total_cargos        = number_format($encabezado->fletes,2,'.','') + number_format($encabezado->seguros,2,'.','');
                    $totalpagar          = (number_format($encabezado->bruto,2,'.','') - number_format($encabezado->descuento,2,'.','')) + number_format( $encabezado->iva,2,'.','');
                }

                $DescuentoTotalFactura   = ($descuento_factura / $bruto_factura )* 100;
                $total_valor_iva         = $subtotal_factura * 0.19;
                $total_item_valor        = $subtotal_factura + $total_valor_iva;
                //determina si la factura es exportacion o para venta nacional

                if($encabezado->motivo == 27) {
                    $tipo_fac_en = '02';
                }else {
                    $tipo_fac_en = '01';
                }


                if($encabezado->dias == 0) {
                    $metodo_pago = 1;
                }else {
                    $metodo_pago = 2;
                }

                // determina el metodo de pago
                if($metodo_pago == 2) {
                    $medio_pago = null;
                }else {
                    $medio_pago = 10;
                }

                // valida el tipo de documento de identidad
                if ($encabezado->idtipodocumento == 13 ) {
                    $tipo_documento_ide = 13;
                }
                else if ($encabezado->idtipodocumento == 22){
                    $tipo_documento_ide = 42;
                } else{
                    $tipo_documento_ide = 31;
                }


                if ($encabezado->iva != null) {
                    $id_total_impuesto_iva = '01';
                }


                if ($id_total_impuesto_iva == '01'){
                    $factor_total = '19';
                }


                if ($id_total_impuesto_iva == '01'){
                    $tarifa_unitaria_total = '0';
                }


                foreach($items_Regalo as $regalo){
                    $Regalos[] =  trim($regalo->codigoproducto).' '.trim($regalo->descripcionproducto).' '.trim($regalo->cantidad);
                }
                foreach ($Regalos as $itm){
                    $RegalosString .= $itm.' + ';
                }
                ////////////////// FIN CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////

                //Construimos el xlm
                $objetoXML->startElement("documento");    // Se inicia un elemento para cada factura.
                $objetoXML->startElement("idnumeracion");
                $objetoXML->text($Configuracion[0]->fac_idnumeracion); // depende del tipo de documento
                $objetoXML->endElement();


                $objetoXML->startElement("numero");
                $objetoXML->text($encabezado->numero);
                $objetoXML->endElement();

                $objetoXML->startElement("idambiente");
                $objetoXML->text($Configuracion[0]->fac_idambiente);
                $objetoXML->endElement();

                $objetoXML->startElement("idreporte");
                if($encabezado->tipo_cliente == 'EX'){
                    $objetoXML->text('1560'); // sumistrado por fenalco para version grafica
                }else{
                    $objetoXML->text($Configuracion[0]->fac_idreporte); // sumistrado por fenalco para version grafica
                }
                $objetoXML->endElement();


                $objetoXML->startElement("fechadocumento");
                $objetoXML->text($encabezado->fechadocumento);
                $objetoXML->endElement();

                $objetoXML->startElement("fechavencimiento"); // pendiente
                $objetoXML->text($encabezado->fechavencimiento.' '.'00:00:00');
                $objetoXML->endElement();

                $objetoXML->startElement("tipofactura"); // si se omite es factura de venta
                $objetoXML->text($tipo_fac_en);
                $objetoXML->endElement();

                $objetoXML->startElement("tipooperacion"); // si se omite sera una  factura de venta generica
                $objetoXML->text($tipo_operacion);
                $objetoXML->endElement();

                if ($encabezado->tipo_cliente != 'EX'){
                    $objetoXML->startElement("notas"); // ok
                    $objetoXML->text('COMPLEMENTO: '. $RegalosString);
                    $objetoXML->endElement();
                }


                $objetoXML->startElement("fechaimpuestos"); // fecha de pago de impuestos ?
                $objetoXML->text('');
                $objetoXML->endElement();

                $objetoXML->startElement("moneda"); // ok
                $objetoXML->text($encabezado->moneda);
                $objetoXML->endElement();


                if(trim($encabezado->OC)!= '' || trim($encabezado->OC) != null)
                {
                    $objetoXML->startElement("ordendecompra");
                    $objetoXML->startElement("codigo");
                    $objetoXML->text(trim($encabezado->OC));
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
                }


                if(trim($encabezado->OV)!= '' || trim($encabezado->OV) != null){
                    $objetoXML->startElement("ordendedespacho");
                    $objetoXML->startElement("codigo");
                    $objetoXML->text(trim($encabezado->OV));
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
                }


                $objetoXML->startElement("adquiriente"); // falta
                $objetoXML->startElement("idtipopersona"); // falta
                $objetoXML->text('');
                $objetoXML->endElement();
                $objetoXML->startElement("idactividadeconomica");
                $objetoXML->text('');
                $objetoXML->endElement();
                $objetoXML->startElement("nombrecomercial"); // validar con martin
                $objetoXML->text('');
                $objetoXML->endElement();
                $objetoXML->startElement("idciudad"); // codigo de ciudad
                $objetoXML->text( $encabezado->coddpto.$encabezado->codciudad);
                $objetoXML->endElement();
                $objetoXML->startElement("direccion");
                $objetoXML->text($encabezado->direccion);
                $objetoXML->endElement();
                $objetoXML->startElement("codigopostal"); // validando con GIO
                $objetoXML->text('');
                $objetoXML->endElement();
                $objetoXML->startElement("nombres");
                $objetoXML->text($encabezado->nombres);
                $objetoXML->endElement();
                $objetoXML->startElement("apellidos");
                $objetoXML->text($encabezado->apellidos);
                $objetoXML->endElement();
                $objetoXML->startElement("idtipodocumentoidentidad");
                $objetoXML->text($tipo_documento_ide);
                $objetoXML->endElement();
                $objetoXML->startElement("digitoverificacion");
                if($encabezado->tipo_cliente == 'EX' || $encabezado->idtipodocumento == '13' ){
                    $objetoXML->text('');
                }else{
                    $objetoXML->text($encabezado->digito_verificador);
                }
                $objetoXML->endElement();

                $objetoXML->startElement("identificacion");
                $objetoXML->text($encabezado->nit_cliente);
                $objetoXML->endElement();
                $objetoXML->startElement("obligaciones");
                $objetoXML->text('R-99-PN');
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
                $objetoXML->text($encabezado->emailcontacto);
                $objetoXML->endElement();
                $objetoXML->startElement("emailentrega");
                $objetoXML->text($correo_entrega);
                $objetoXML->endElement();
                $objetoXML->startElement("telefono");
                $objetoXML->text(trim($encabezado->telefono));
                $objetoXML->endElement();
                $objetoXML->endElement();


                $objetoXML->startElement("formaspago");
                $objetoXML->startElement("formapago");
                $objetoXML->startElement("idmetodopago");
                $objetoXML->text($metodo_pago);
                $objetoXML->endElement();
                $objetoXML->startElement("idmediopago");
                $objetoXML->text($medio_pago);
                $objetoXML->endElement();
                $objetoXML->startElement("fechavencimiento");
                $objetoXML->text($encabezado->fechavencimiento.' '.'00:00:00');
                $objetoXML->endElement();
                $objetoXML->startElement("identificador");
                $objetoXML->text('');
                $objetoXML->endElement();
                $objetoXML->startElement("dias");
                $objetoXML->text($encabezado->dias);
                $objetoXML->endElement();
                $objetoXML->endElement();
                $objetoXML->endElement();

                if ($encabezado->tipo_cliente != 'EX' &&  $DescuentoTotalFactura !=  0){
                    $objetoXML->startElement("cargos");
                    $objetoXML->startElement("cargo");
                    $objetoXML->startElement("idconcepto");
                    $objetoXML->text('01');
                    $objetoXML->endElement();
                    $objetoXML->startElement("escargo");
                    $objetoXML->text('0');
                    $objetoXML->endElement();
                    $objetoXML->startElement("descripcion");
                    $objetoXML->text('Descuento general');
                    $objetoXML->endElement();
                    $objetoXML->startElement("porcentaje");
                    $objetoXML->text(number_format($DescuentoTotalFactura,2,'.',''));
                    $objetoXML->endElement();
                    $objetoXML->startElement("base");
                    $objetoXML->text($bruto_factura);
                    $objetoXML->endElement();
                    $objetoXML->startElement("valor");
                    $objetoXML->text($descuento_factura);
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }else if($encabezado->tipo_cliente == 'EX' || $encabezado->fletes_usd != 0 || $encabezado->seguros_usd != 0 ){
                    $objetoXML->startElement("cargos");
                    if (trim($encabezado->fletes_usd) != 0 || trim($encabezado->fletes_usd) != null ){
                        $objetoXML->startElement("cargo");
                        $objetoXML->startElement("idconcepto");
                        $objetoXML->text('');
                        $objetoXML->endElement();
                        $objetoXML->startElement("escargo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();
                        $objetoXML->startElement("descripcion");
                        $objetoXML->text('Fletes');
                        $objetoXML->endElement();
                        $objetoXML->startElement("porcentaje");
                        $objetoXML->text(number_format((($encabezado->fletes_usd / $bruto_factura) * 100),2,'.',''));
                        $objetoXML->endElement();
                        $objetoXML->startElement("base");
                        $objetoXML->text($bruto_factura);
                        $objetoXML->endElement();
                        $objetoXML->startElement("valor");
                        $objetoXML->text($encabezado->fletes_usd);
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                    }
                    if (trim($encabezado->seguros_usd) != 0 || trim($encabezado->seguros_usd) != null ){
                        $objetoXML->startElement("cargo");
                        $objetoXML->startElement("idconcepto");
                        $objetoXML->text('');
                        $objetoXML->endElement();
                        $objetoXML->startElement("escargo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();
                        $objetoXML->startElement("descripcion");
                        $objetoXML->text('Seguros');
                        $objetoXML->endElement();
                        $objetoXML->startElement("porcentaje");
                        $objetoXML->text(number_format((($encabezado->seguros_usd / $bruto_factura) * 100),2,'.',''));
                        $objetoXML->endElement();
                        $objetoXML->startElement("base");
                        $objetoXML->text($bruto_factura);
                        $objetoXML->endElement();
                        $objetoXML->startElement("valor");
                        $objetoXML->text($encabezado->seguros_usd);
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                }


                if($encabezado->tipo_cliente != 'EX' && $encabezado->iva != 0) {
                    $objetoXML->startElement("impuestos");
                    $objetoXML->startElement("impuesto");
                    $objetoXML->startElement("idimpuesto");
                    $objetoXML->text($id_total_impuesto_iva);
                    $objetoXML->endElement();
                    $objetoXML->startElement("base");
                    $objetoXML->text(number_format($subtotal_factura, 2, '.', ''));
                    $objetoXML->endElement();
                    $objetoXML->startElement("factor");
                    $objetoXML->text($factor_total);
                    $objetoXML->endElement();
                    $objetoXML->startElement("estarifaunitaria");
                    $objetoXML->text($tarifa_unitaria_total);
                    $objetoXML->endElement();
                    $objetoXML->startElement("valor");
                    $objetoXML->text(number_format(abs($total_valor_iva), 2, '.', ''));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }

                $objetoXML->startElement("totales");
                $objetoXML->startElement("totalbruto");
                $objetoXML->text(number_format($bruto_factura,2,'.',''));
                $objetoXML->endElement();
                $objetoXML->startElement("baseimponible");
                if($encabezado->iva != 0)
                {
                    $objetoXML->text(number_format($subtotal_factura,2,'.',''));
                }else{
                    $objetoXML->text('');
                }
                $objetoXML->endElement();
                $objetoXML->startElement("totalbrutoconimpuestos");
                $objetoXML->text(number_format($brutomasiva_factura,2,'.',''));
                $objetoXML->endElement();
                $objetoXML->startElement("totaldescuento");
                $objetoXML->text(number_format($descuento_factura,2,'.',''));
                $objetoXML->endElement();
                $objetoXML->startElement("totalcargos");
                $objetoXML->text(number_format($total_cargos,2,'.',''));
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

                if($encabezado->correoscopia != null){
                    $objetoXML->startElement("correoscopia");

                    foreach (explode(";",$encabezado->correoscopia) as $Arraycc){
                        $objetoXML->startElement("correocopia");
                        $objetoXML->text($Arraycc);
                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                }


                $objetoXML->startElement("items");

                foreach ($items_Normales as $it) {
                    $subtotal_item = null;
                    $brutomasiva =  null;
                    $descuento_item = null;
                    $valorDescItem = null;
                    $cargos_item    = null;
                    $totalpagar_item    = null;
                    $nombre_estandar = 'EAN13';
                    $id_estandar = 999;
                    $id_impuesto = null;
                    $factor = null;
                    $umed = null;
                    $valor_item = null;
                    $precio_unitario = null;
                    ////////////////// CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////
                    ///
                    if($encabezado->tipo_cliente  == 'EX'){
                        $subtotal_item = $it->bruto_usd ;
                        $total_valor_item_iva = $subtotal_item * 0.19;
                        $DescuentoPorItem = 0;
                        $valor_item = $it->precioUSD * $it->cantidad;
                        $precio_unitario = $it-> precioUSD;
                    }else{
                        $subtotal_item = $it->totalitem - $it->Desc_Item;
                        $total_valor_item_iva = $subtotal_item * 0.19;
                        $valor_item = $it->precio * $it->cantidad;
                        $DescuentoPorItem = ($it->Desc_Item / $valor_item) * 100;
                        $precio_unitario = $it-> precio;
                    }

                    // valida si el item es comprado o se da como regalo
                    $regalo = null;
                    if ($valor_item == 0) {
                        $regalo = 1;
                    } else {
                        $regalo = 0;
                    }

                    // valida el id impuesto por item*/
                    if ($it->iva_item != 0)
                    {
                        $id_impuesto = '01';
                    }


                    // porcentaje de impuesto
                    if ($id_impuesto == '01') {
                        $factor = '19';
                    }


                    if ($it->UM == 'UN') {
                        $umed = '94';
                    }else {
                        $umed = 'KGM';
                    }


                    $id_item_iva = null;
                    if ($it->iva_item != null)
                    {
                        $id_item_iva = '0'.'1';
                    }


                    $factor_total_item = null;
                    if ($id_item_iva == '0'.'1') {
                        $factor_total_item = '19';
                    }


                    $tarifa_item_unitaria = null;
                    if ($id_item_iva == '0'.'1') {
                        $tarifa_item_unitaria = '0';
                    }


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
                    $objetoXML->text(number_format($it->cantidad, 2, '.', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("cantidadporempaque");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("preciounitario");
                    $objetoXML->text(number_format($precio_unitario, 3, '.', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("unidaddemedida");
                    $objetoXML->text($umed);
                    $objetoXML->endElement();

                    if ($encabezado->tipo_cliente == 'EX'){
                        $marca = $it->descripcionproducto;
                        $modelo = $it->codigoproducto;
                    }else{
                        $marca = '';
                        $modelo = '';
                    }

                    $objetoXML->startElement("marca");
                    $objetoXML->text($marca);
                    $objetoXML->endElement();

                    $objetoXML->startElement("modelo");
                    $objetoXML->text($modelo);
                    $objetoXML->endElement();

                    $objetoXML->startElement("codigovendedor");
                    $objetoXML->text(trim($it->codigoproducto));
                    $objetoXML->endElement();

                    $objetoXML->startElement("subcodigovendedor");
                    $objetoXML->text(trim($it->OC));
                    $objetoXML->endElement();

                    $objetoXML->startElement("idmandante");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("regalo");
                    $objetoXML->text(trim($regalo));
                    $objetoXML->endElement();

                    $objetoXML->startElement("totalitem");
                    $objetoXML->text(number_format($valor_item, 2, '.', ''));
                    $objetoXML->endElement();

                    if($valorDescItem != 0){
                        $objetoXML->startElement("cargos");
                        $objetoXML->startElement("cargo");

                        $objetoXML->startElement("idconcepto");
                        $objetoXML->text('01');
                        $objetoXML->endElement();

                        $objetoXML->startElement("escargo");
                        $objetoXML->text('0');
                        $objetoXML->endElement();

                        $objetoXML->startElement("descripcion");
                        $objetoXML->text('Descuento general');
                        $objetoXML->endElement();

                        $objetoXML->startElement("porcentaje");
                        $objetoXML->text(number_format($DescuentoPorItem,2,'.',''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text($valor_item);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text($valorDescItem);
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                        $objetoXML->endElement();
                    }

                    if($encabezado->tipo_cliente != 'EX' && $it->iva_item != 0){
                        $objetoXML->startElement("impuestos");
                        $objetoXML->startElement("impuesto");
                        $objetoXML->startElement("idimpuesto");
                        $objetoXML->text($id_item_iva);
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text(number_format(abs($subtotal_item), 2, '.', ''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("factor");
                        $objetoXML->text($factor_total_item);
                        $objetoXML->endElement();

                        $objetoXML->startElement("estarifaunitaria");
                        $objetoXML->text($tarifa_item_unitaria);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(number_format(abs($total_valor_item_iva), 2, '.', ''));
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                    }

                    if ( trim($it->posicionarancelaria) != ''){
                        $objetoXML->startElement("datosextra");
                        /*COMIENZO DATO EXTRA*/
                        $objetoXML->startElement("datoextra");
                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('PA');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(trim($it->posicionarancelaria));
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                        /*Fin Dato extra*/

                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement(); // cierra item
                }

                $objetoXML->endElement(); // cierra items

                $objetoXML->startElement("datosextra");

                $objetoXML->startElement("datoextra");
                $objetoXML->startElement("tipo");
                $objetoXML->text('1');
                $objetoXML->endElement();
                $objetoXML->startElement("clave");
                $objetoXML->text('CONDICION_PAGO');
                $objetoXML->endElement();
                $objetoXML->startElement("valor");
                $objetoXML->text(trim($encabezado->plazo));
                $objetoXML->endElement();
                $objetoXML->endElement();

                $objetoXML->startElement("datoextra");
                $objetoXML->startElement("tipo");
                $objetoXML->text('1');
                $objetoXML->endElement();
                $objetoXML->startElement("clave");
                $objetoXML->text('CODIGO_CLIENTE');
                $objetoXML->endElement();
                $objetoXML->startElement("valor");
                $objetoXML->text($encabezado->codigocliente);
                $objetoXML->endElement();
                $objetoXML->endElement();

                /*COMIENZO DATO EXTRA*/
                if ($encabezado->RTEFTE){
                    $objetoXML->startElement("datoextra");
                    $objetoXML->startElement("tipo");
                    $objetoXML->text('1');
                    $objetoXML->endElement();
                    $objetoXML->startElement("clave");
                    $objetoXML->text('RTEFTE');
                    $objetoXML->endElement();
                    $objetoXML->startElement("valor");
                    $objetoXML->text(trim($encabezado->RTEFTE));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }
                /*Fin Dato extra*/

                /*COMIENZO DATO EXTRA*/
                if($encabezado->RTEIVA != 0){
                    $objetoXML->startElement("datoextra");
                    $objetoXML->startElement("tipo");
                    $objetoXML->text('1');
                    $objetoXML->endElement();
                    $objetoXML->startElement("clave");
                    $objetoXML->text('RTEIVA');
                    $objetoXML->endElement();
                    $objetoXML->startElement("valor");
                    $objetoXML->text(trim($encabezado->RTEIVA));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }
                if (trim($encabezado->notas) != ''){
                    $objetoXML->startElement("datoextra");

                    $objetoXML->startElement("tipo");
                    $objetoXML->text('1');
                    $objetoXML->endElement();

                    $objetoXML->startElement("clave");
                    $objetoXML->text('NOTAS_DOCUMENTO');
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text(trim($encabezado->notas));
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                }

                $objetoXML->endElement(); // cierra items
                $objetoXML->endElement();
                $objetoXML->endElement(); // Final del nodo raíz, "documento"
            }
            $objetoXML->endDocument();  // Final del documento

            $cadenaXML = $objetoXML->outputMemory();

            $Base_64 = base64_encode($cadenaXML);


            /* se comienza con el web service */
            $login1 = $request->Username;
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new SoapClient($wsdl_url);
            $client->__setLocation($wsdl_url);

            // Inicio de sesion
            $params = array(
                'login'     => $login1,
                'password'  => $password
            );


            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;


            // Lista los  tipos de persona de la DIAN
            $params = array(
                'token'                 => $token,
                'base64XML'             => strval($Base_64),
                'obtenerDatosTecnicos'  => true
            );
            $return = $client->registrarDocumentoElectronico_Generar_FuenteXML($params);


            $resultados[] = json_decode($return->return);

            $params = array(
                'token' => $token
            );

            $logout = $client->cerrarSesion($params);
            //$respuesta = json_decode($logout->return);
        }

        return response()->json($resultados);
    }



    /**
     * Envia un conjunto de notas credito al WebService de fenalco
     *
     * @param Request $request
     * @return JsonResponse
     * @throws SoapFault
     */
    public function envio_notas_credito(Request $request){
        $Notas_credito = $request->selected;
        $Notas_credito = json_decode($Notas_credito);
        $resultados = [];
        foreach ($Notas_credito as $nc) {
            $objetoXML = new    XMLWriter();
            $objetoXML->openURI("NotasCredito.xml");
            $objetoXML->openMemory();
            $objetoXML->setIndent(true);
            $objetoXML->setIndentString("\t");
            $objetoXML->startDocument('1.0', 'utf-8');

            $objetoXML->startElement("root");

            $num = $nc->numero;

            $EncabezadoNc = DB::connection('MAX')->table('CIEV_V_FE')
                ->leftJoin('CIEV_V_FE_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FE_FacturasTotalizadas.numero')
                ->select('CIEV_V_FE.numero',
                    'CIEV_V_FE.notas',
                    'CIEV_V_FE.identificacion as nit_cliente',
                    'CIEV_V_FE.apellidos',
                    'CIEV_V_FE.emailcontacto',
                    'CIEV_V_FE.direccion',
                    'CIEV_V_FE.emailentrega',
                    'CIEV_V_FE.digito_verificador',
                    'CIEV_V_FE.telefono',
                    'CIEV_V_FE.notas',
                    'CIEV_V_FE.coddpto',
                    'CIEV_V_FE.codigocliente',
                    'CIEV_V_FE.fechadocumento',
                    'CIEV_V_FE.codciudad',
                    'CIEV_V_FE.nombres',
                    'CIEV_V_FE.fechavencimiento',
                    'CIEV_V_FE_FacturasTotalizadas.bruto',
                    'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                    'CIEV_V_FE_FacturasTotalizadas.bruto',
                    'CIEV_V_FE_FacturasTotalizadas.descuento',
                    'CIEV_V_FE_FacturasTotalizadas.subtotal',
                    'CIEV_V_FE_FacturasTotalizadas.iva',
                    'CIEV_V_FE_FacturasTotalizadas.fletes',
                    'CIEV_V_FE_FacturasTotalizadas.seguros',
                    'CIEV_V_FE_FacturasTotalizadas.moneda',
                    'CIEV_V_FE_FacturasTotalizadas.OC',
                    'CIEV_V_FE_FacturasTotalizadas.dias',
                    'CIEV_V_FE_FacturasTotalizadas.motivo',
                    'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                    'CIEV_V_FE_FacturasTotalizadas.descmotivo',
                    'CIEV_V_FE_FacturasTotalizadas.correoscopia',
                    'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                ->where('CIEV_V_FE.numero', '=', $num)->take(1)->get();

            // esta consulta muestra el detalle de los items de cada factura
            $DetalleNc = DB::connection('MAX')->table('CIEV_V_FacturasDetalladas')
                ->select('CIEV_V_FacturasDetalladas.factura',
                    'CIEV_V_FacturasDetalladas.codigoproducto',
                    'CIEV_V_FacturasDetalladas.descripcionproducto',
                    'CIEV_V_FacturasDetalladas.OC',
                    'CIEV_V_FacturasDetalladas.item',
                    'CIEV_V_FacturasDetalladas.cantidad',
                    'CIEV_V_FacturasDetalladas.precio',
                    'CIEV_V_FacturasDetalladas.UM',
                    'CIEV_V_FacturasDetalladas.totalitem',
                    'CIEV_V_FacturasDetalladas.iva as iva_item',
                    'CIEV_V_FacturasDetalladas.valormercancia',
                    'CIEV_V_FacturasDetalladas.desc_item as descuento')
                ->where('CIEV_V_FacturasDetalladas.factura', '=', $num)->get();

            $Config = DB::table('fe_configs')->take(1)->get();


            $itemNormales = [];
            $itemRegalo = [];

            foreach ($DetalleNc as $D) {
                if ($D->totalitem == 0 ){
                    $itemRegalo[] = $D;
                }else{
                    $itemNormales[] = $D;
                }
            }

            foreach ($EncabezadoNc as $enc) {
                ////////////////// CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////
                $brutomasiva     =  $enc->bruto + $enc->iva;
                $totalpagar      = ($enc->bruto - $enc->descuento) + $enc->iva;
                $total_cargos    =  $enc->fletes + $enc->seguros;

                //determina si la factura es exportacion o para venta nacional
                $tipo_fac_en = null;
                if ($enc->motivo == 27) {$tipo_fac_en = 02;}// exportaciones 27
                else {$tipo_fac_en = 01;}

                // determina si el tipo de operacion
                $tipo_operacion = null;
                if ($tipo_fac_en == 02) {$tipo_operacion = 04;}
                if ($tipo_fac_en == 01) {$tipo_operacion = 05;}
                if($enc->iva == 0)      {$tipo_operacion =03;}

                //Determina si la factura es a contado o a credito
                $metodo_pago = null;
                if ($enc->dias == 0) {$metodo_pago = 1;}
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

                // valida el estado de envio a la dian


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
                $DescuentoTotalFactura = ($enc->descuento / $enc->bruto )* 100;

                //Construimos el xlm
                $objetoXML->startElement("documento");    // Se inicia un elemento para cada factura.
                $objetoXML->startElement("idnumeracion");
                $objetoXML->text($Config[0]->nc_idnumeracion); // depende del tipo de documento
                $objetoXML->endElement();

                $objetoXML->startElement("numero");
                $objetoXML->text($enc->numero);
                $objetoXML->endElement();

                $objetoXML->startElement("idambiente");
                $objetoXML->text($Config[0]->nc_idambiente);
                $objetoXML->endElement();

                $objetoXML->startElement("idreporte");
                $objetoXML->text($Config[0]->nc_idreporte); // sumistrado por fenalco para version grafica PENDIENTE
                $objetoXML->endElement();


                $objetoXML->startElement("fechadocumento");
                $objetoXML->text($enc->fechadocumento);
                $objetoXML->endElement();

                $objetoXML->startElement("fechavencimiento"); // pendiente
                $objetoXML->text($enc->fechavencimiento);
                $objetoXML->endElement();


                $Regalos = [];
                $RegalosString = '';
                foreach($itemRegalo as $regalo){
                    $Regalos[] =  trim($regalo->codigoproducto).' '.trim($regalo->descripcionproducto).' '.trim($regalo->cantidad);
                }
                foreach ($Regalos as $itm){
                    $RegalosString .= $itm.' + ';
                }

                $objetoXML->startElement("notas"); // ok
                $objetoXML->text('COMPLEMENTO: '. $RegalosString);
                $objetoXML->endElement();


                $objetoXML->startElement("moneda"); // ok
                $objetoXML->text($enc->moneda);
                $objetoXML->endElement();


                $conceptonota = substr($enc->motivo,1);
                $objetoXML->startElement("idconceptonota"); // Tabla 7. Códigos Conceptos Notas Crédito. y Tabla 8. Códigos Conceptos Notas Débito. Solo es obligatorio si <idnumeracion> corresponde a una nota debito o credito
                $objetoXML->text($conceptonota);
                $objetoXML->endElement();

                $objetoXML->startElement("referencias"); // 0..1 Obligatorio cuando se trata de una nota debito o credito. La DIAN ya no permite notas sin referencia a una factura
                $objetoXML->startElement("referencia"); // La DIAN solo acepta referencias a documentos electrónicos, por tanto la referencia debe existir previamente en el sistema
                $objetoXML->startElement("idnumeracion"); // Ya no se acepta referencia a la numeracion por su prefijo
                $objetoXML->text($Config[0]->fac_idnumeracion); // numeracion de facturas se debe cambiar por el que corresponde a notas credito
                $objetoXML->endElement();
                $objetoXML->startElement("numero");
                $objetoXML->text(trim(substr($enc->OC,2))); // numero de factura a la que hace referencia la nota credito
                $objetoXML->endElement();
                $objetoXML->endElement();
                $objetoXML->endElement();


                $objetoXML->startElement("adquiriente"); // falta
                $objetoXML->startElement("idtipopersona"); // falta
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


                $objetoXML->startElement("formapago");
                $objetoXML->startElement("idmetodopago");
                $objetoXML->text($metodo_pago);
                $objetoXML->endElement();
                $objetoXML->startElement("idmediopago");
                $objetoXML->text($medio_pago);
                $objetoXML->endElement();
                $objetoXML->startElement("fechavencimiento");
                $objetoXML->text($enc->fechavencimiento);
                $objetoXML->endElement();
                $objetoXML->startElement("identificador");
                $objetoXML->text('');
                $objetoXML->endElement();
                $objetoXML->startElement("dias");
                $objetoXML->text($enc->dias);
                $objetoXML->endElement();
                $objetoXML->endElement();

                $objetoXML->startElement("cargos");
                $objetoXML->startElement("cargo");
                $objetoXML->startElement("idconcepto");
                $objetoXML->text('01');
                $objetoXML->endElement();
                $objetoXML->startElement("escargo");
                $objetoXML->text('0');
                $objetoXML->endElement();
                $objetoXML->startElement("descripcion");
                $objetoXML->text('Descuento general');
                $objetoXML->endElement();
                $objetoXML->startElement("porcentaje");
                $objetoXML->text(number_format($DescuentoTotalFactura,2,'.',''));
                $objetoXML->endElement();
                $objetoXML->startElement("base");
                $objetoXML->text($enc->bruto);
                $objetoXML->endElement();
                $objetoXML->startElement("valor");
                $objetoXML->text($enc->descuento);
                $objetoXML->endElement();
                $objetoXML->endElement();
                $objetoXML->endElement();


                $objetoXML->startElement("impuestos");
                if($enc->iva == 0 || $enc->tipo_cliente == 'EX')
                {
                    $objetoXML->startElement("impuesto");
                    $objetoXML->startElement("idimpuesto");
                    $objetoXML->text('');
                    $objetoXML->endElement();
                    $objetoXML->startElement("base");
                    $objetoXML->text('');
                    $objetoXML->endElement();
                    $objetoXML->startElement("factor");
                    $objetoXML->text('');
                    $objetoXML->endElement();
                    $objetoXML->startElement("estarifaunitaria");
                    $objetoXML->text('');
                    $objetoXML->endElement();
                    $objetoXML->startElement("valor");
                    $objetoXML->text('');
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }else{
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
                    $objetoXML->text(number_format(abs($total_valor_iva),2,'.',''));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }
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

                if($enc->correoscopia != null){
                    $objetoXML->startElement("correoscopia");

                    foreach (explode(";",$enc->correoscopia) as $Arraycc){
                        $objetoXML->startElement("correocopia");
                        $objetoXML->text($Arraycc);
                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                }


                $objetoXML->startElement("items");

                foreach ($itemNormales as $dNc) {

                    $valor_item = $dNc->precio * $dNc->cantidad;
                    //$impuestos_item = $it->
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
                    $id_impuesto = null;
                    if ( $dNc->iva_item != 0 ){
                        $id_impuesto = '01';
                    }

                    // porcentaje de impuesto
                    $factor = null;
                    if ( $id_impuesto == '01'){
                        $factor = '19';
                    }

                    $umed = null;
                    if ($dNc->UM == 'UN'){
                        $umed = '94';
                    }else{
                        $umed = 'KGM';
                    }

                    ////
                    $id_item_iva = null;
                    if ($dNc->iva_item != null) {
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

                    $subtotal_item = abs($dNc->totalitem) - abs($dNc->descuento);
                    $total_valor_item_iva = $subtotal_item * 0.19;
                    $DescuentoPorItem = ($dNc->descuento / $valor_item) * 100;

                    $objetoXML->startElement("item");

                    $objetoXML->startElement("codigos");
                    $objetoXML->startElement("estandar");
                    $objetoXML->startElement("idestandar");
                    $objetoXML->text($id_estandar);
                    $objetoXML->endElement();
                    $objetoXML->startElement("nombreestandar");
                    $objetoXML->text($nombre_estandar);
                    $objetoXML->endElement();
                    $objetoXML->startElement("codigo");
                    $objetoXML->text(trim($dNc->codigoproducto));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                    $objetoXML->endElement();

                    $objetoXML->startElement("descripcion");
                    $objetoXML->text(trim($dNc->descripcionproducto));
                    $objetoXML->endElement();

                    $objetoXML->startElement("notas");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("cantidad");
                    $objetoXML->text(number_format(abs($dNc->cantidad), 0, '', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("cantidadporempaque");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("preciounitario");
                    $objetoXML->text(number_format(abs($dNc->precio),2,'.',''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("unidaddemedida");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("marca");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("modelo");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("codigovendedor");
                    $objetoXML->text($dNc->codigoproducto);
                    $objetoXML->endElement();

                    $objetoXML->startElement("subcodigovendedor");
                    $objetoXML->text($dNc->OC);
                    $objetoXML->endElement();

                    $objetoXML->startElement("idmandatario");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("regalo");
                    $objetoXML->text(trim($regalo));
                    $objetoXML->endElement();

                    $objetoXML->startElement("totalitem");
                    $objetoXML->text(number_format(abs($valor_item),2,'.',''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("cargos");
                    $objetoXML->startElement("cargo");

                    $objetoXML->startElement("idconcepto");
                    $objetoXML->text('01');
                    $objetoXML->endElement();

                    $objetoXML->startElement("escargo");
                    $objetoXML->text('0');
                    $objetoXML->endElement();

                    $objetoXML->startElement("descripcion");
                    $objetoXML->text('Descuento general');
                    $objetoXML->endElement();

                    $objetoXML->startElement("porcentaje");
                    $objetoXML->text(number_format($DescuentoPorItem,2,'.',''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("base");
                    $objetoXML->text($valor_item);
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text($dNc->descuento);
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                    $objetoXML->endElement();

                    $objetoXML->startElement("impuestos");
                    if($dNc->iva_item == 0 || $dNc->iva_item == null || $dNc->iva_item == '' || $enc->tipo_cliente == 'EX'){
                        $objetoXML->startElement("impuesto");
                        $objetoXML->startElement("idimpuesto");
                        $objetoXML->text('');
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text('');
                        $objetoXML->endElement();

                        $objetoXML->startElement("factor");
                        $objetoXML->text('');
                        $objetoXML->endElement();

                        $objetoXML->startElement("estarifaunitaria");
                        $objetoXML->text('');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text('');
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                    }else{
                        $objetoXML->startElement("impuesto");
                        $objetoXML->startElement("idimpuesto");
                        $objetoXML->text($id_item_iva);
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text(number_format(abs($subtotal_item),2,'.',''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("factor");
                        $objetoXML->text($factor_total_item);
                        $objetoXML->endElement();

                        $objetoXML->startElement("estarifaunitaria");
                        $objetoXML->text($tarifa_item_unitaria);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(number_format(abs($total_valor_item_iva),2,'.',''));
                        $objetoXML->endElement();
                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                    $objetoXML->endElement(); // cierra item
                }
                $objetoXML->endElement(); // cierra items

                $objetoXML->startElement("datosextra");
                if (trim($enc->notas) != ''){
                    $objetoXML->startElement("datoextra");

                    $objetoXML->startElement("tipo");
                    $objetoXML->text('1');
                    $objetoXML->endElement();

                    $objetoXML->startElement("clave");
                    $objetoXML->text('NOTAS_DOCUMENTO');
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text(trim($enc->notas));
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                }


                $objetoXML->endElement();
                $objetoXML->endElement(); // Final del nodo raíz, "documento"
            }


            $objetoXML->endDocument();  // Final del documento

            $cadenaXML = $objetoXML->outputMemory();


            $Base_64 = base64_encode($cadenaXML);


            /* se comienza con el web service */

            $login1 = $request->Username;
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new SoapClient($wsdl_url);
            $client->__setLocation($wsdl_url);

            // Inicio de sesion
            $params = array(
                'login' => $login1,
                'password' => $password
            );


            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;


            // Lista los  tipos de persona de la DIAN
            $params = array(
                'token'                 => $token,
                'base64XML'             => strval($Base_64),
                'obtenerDatosTecnicos'  => true
            );
            $return = $client->registrarDocumentoElectronico_Generar_FuenteXML($params);

            //  $resultados = json_decode($return->return);

            $resultados[] = json_decode($return->return);

            $params = array(
                'token' => $token
            );

            $logout = $client->cerrarSesion($params);
            $respuesta = json_decode($logout->return);

        }
        return response()->json($resultados);
    }



    /**
     * Descarga version grafica desde el web service
     *
     * @param Request $request
     * @return JsonResponse
     * @throws SoapFault
     */
    public function descarga_documento(Request $request){
        $Numero_Factura = $request->id;

        if (request()->ajax()) {
            $login1 = "dcorreah";
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new SoapClient($wsdl_url);
            $client->__setLocation($wsdl_url);

            $params = array(
                'login' => $login1,
                'password' => $password
            );

            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;


            $params = array(
                'token' => $token,
                'idUsuario' => '',
                'idEstadoEnvioCliente' => '',
                'idEstadoEnvioDian' => '',
                'fechaInicial' => '',
                'fechaFinal' => '',
                'fechaInicialReg' => '',
                'fechaFinalReg' => '',
                'idEstadoGeneracion' => '',
                'idTipoDocElectronico' => '',
                'numeroInicial' => $Numero_Factura,
                'numeroFinal' => $Numero_Factura,
                'idnumeracion' => '',
                'estadoAcuse' => '',
                'razonSocial' => '',
                'mulCodEstDian' => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );
            $return = $client->ListarDocumentosElectronicos($params);


            dd($return);

            $return = json_decode($return->return);


            $id_factible = $return->data[0]->DT_RowId;



            $params = array(
                'token'                     => $token,
                'iddocumentoelectronico'    => $id_factible,
            );

            $return = $client->descargarDocumentoElectronico_VersionGrafica($params);




            $resultados = json_decode($return->return);

            //cerramos sesion
            $params = array(
                'token' => $token
            );
            $logout = $client->cerrarSesion($params);
            $respuesta = json_decode($logout->return);

            return response()->json($resultados->data->salida);
        }
    }


    /**
     * Consulta el estado de la factura en la DIAN
     *
     * @param Request $request
     * @return JsonResponse
     * @throws SoapFault
     */
    public function estado_dian(Request $request){
        $id = $request->id;

        if (request()->ajax()) {
            $login1   = "dcorreah";
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new SoapClient($wsdl_url);
            $client->__setLocation($wsdl_url);

            $params = array(
                'login' => $login1,
                'password' => $password
            );

            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;

            $params = array(
                'token' => $token,
                'idEmpresa' => '',
                'idUsuario' => '',
                'idEstadoEnvioCliente' => '',
                'idEstadoEnvioDian' => '',
                'fechaInicial' => '',
                'fechaFinal' => '',
                'fechaInicialReg' => '',
                'fechaFinalReg' => '',
                'idEstadoGeneracion' => '',
                'idTipoDocElectronico' => '',
                'numeroInicial' => $id,
                'numeroFinal' => $id,
                'idnumeracion' => '',
                'estadoAcuse' => '',
                'razonSocial' => '',
                'mulCodEstDian' => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );

            $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
            $return = json_decode($return->return);

            $values = $return->data[0]->descestadoenviodian;

            return response()->json($values);
        }
    }


    /**
     * Listado de decumentos electronicos obtenidos desde
     * el webservice
     *
     * @param Request $request
     * @return JsonResponse
     * @throws SoapFault
     */
    public function listado_documentos(Request $request){
        $fromdate = Carbon::now()->format('Y-m-d');
        $todate = Carbon::now()->format('Y-m-d');

        if (request()->ajax()) {
            if (!empty($request->from_date) || !empty($request->fe_start)) {
                $login1   = "dcorreah";
                $password = "FE2020ev*";
                $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
                $client = new SoapClient($wsdl_url);
                $client->__setLocation($wsdl_url);

                $params = array(
                    'login' => $login1,
                    'password' => $password
                );

                $auth = $client->autenticar($params);
                $respuesta = json_decode($auth->return);

                $token = $respuesta->data->salida;

                $params = array(
                    'token' => $token,
                    'idEmpresa' => '',
                    'idUsuario' => '',
                    'idEstadoEnvioCliente' => '',
                    'idEstadoEnvioDian' => '',
                    'fechaInicial' => strval($request->from_date),
                    'fechaFinal' => strval($request->to_date),
                    'fechaInicialReg' => '',
                    'fechaFinalReg' => '',
                    'idEstadoGeneracion' => '',
                    'idTipoDocElectronico' => $request->type_doc,
                    'numeroInicial' => $request->fe_start,
                    'numeroFinal' => $request->fe_end,
                    'idnumeracion' => '',
                    'estadoAcuse' => '',
                    'razonSocial' => '',
                    'mulCodEstDian' => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
                $return = json_decode($return->return);
                $values = $return->data;


                return response()->json($values);

            } else {
                $login1 = $request->Username;
                $password = "FE2020ev*";
                $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
                $client = new SoapClient($wsdl_url);
                $client->__setLocation($wsdl_url);

                $params = array(
                    'login' => $login1,
                    'password' => $password
                );

                $auth = $client->autenticar($params);
                $respuesta = json_decode($auth->return);
                $token = $respuesta->data->salida;

                $params = array(
                    'token' => $token,
                    'idEmpresa' => '',
                    'idUsuario' => '',
                    'idEstadoEnvioCliente' => '',
                    'idEstadoEnvioDian' => '',
                    'fechaInicial' => $fromdate,
                    'fechaFinal' => $todate,
                    'fechaInicialReg' => '',
                    'fechaFinalReg' => '',
                    'idEstadoGeneracion' => '',
                    'idTipoDocElectronico' => '1',
                    'numeroInicial' => '',
                    'numeroFinal' => '',
                    'idnumeracion' => '',
                    'estadoAcuse' => '',
                    'razonSocial' => '',
                    'mulCodEstDian' => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
                $return = json_decode($return->return);
                $values = $return->data;

                return response()->json($values);
            }
        }
    }


    /**
     * Obtiene la informacion de un documento electronico
     *
     * @param Request $request
     * @return JsonResponse
     * @throws SoapFault
     */
    public function info_documento(Request $request){
        $id = $request->id;

        if (request()->ajax()) {
            $login1   = "dcorreah";
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new SoapClient($wsdl_url);
            $client->__setLocation($wsdl_url);

            $params = array(
                'login' => $login1,
                'password' => $password
            );

            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;

            $params = array(
                'token' => $token,
                'idEmpresa' => '',
                'idUsuario' => '',
                'idEstadoEnvioCliente' => '',
                'idEstadoEnvioDian' => '',
                'fechaInicial' => '',
                'fechaFinal' => '',
                'fechaInicialReg' => '',
                'fechaFinalReg' => '',
                'idEstadoGeneracion' => '',
                'idTipoDocElectronico' => '',
                'numeroInicial' => $id,
                'numeroFinal' => $id,
                'idnumeracion' => '',
                'estadoAcuse' => '',
                'razonSocial' => '',
                'mulCodEstDian' => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );
            $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
            $return = json_decode($return->return);

            $values = $return->data[0];

            return response()->json($values);
        }
    }
}
