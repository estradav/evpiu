<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
     * @throws \SoapFault
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


            $encabezado = DB::connection('MAX')
                ->table('CIEV_V_FE')
                ->leftJoin('CIEV_V_FE_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FE_FacturasTotalizadas.numero')
                ->select('CIEV_V_FE.numero', 'CIEV_V_FE.notas', 'CIEV_V_FE.identificacion as nit_cliente', 'CIEV_V_FE.apellidos',
                    'CIEV_V_FE.emailcontacto', 'CIEV_V_FE.direccion', 'CIEV_V_FE.emailentrega', 'CIEV_V_FE.digito_verificador',
                    'CIEV_V_FE.idtipodocumento', 'CIEV_V_FE.telefono', 'CIEV_V_FE.notas', 'CIEV_V_FE.OC', 'CIEV_V_FE.codciudad',
                    'CIEV_V_FE.coddpto', 'CIEV_V_FE.codigo_alterno', 'CIEV_V_FE.codigocliente', 'CIEV_V_FE.fechadocumento',
                    'CIEV_V_FE.nombres', 'CIEV_V_FE.fechavencimiento', 'CIEV_V_FE_FacturasTotalizadas.OV', 'CIEV_V_FE_FacturasTotalizadas.bruto',
                    'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social', 'CIEV_V_FE_FacturasTotalizadas.descuento',
                    'CIEV_V_FE_FacturasTotalizadas.subtotal', 'CIEV_V_FE_FacturasTotalizadas.bruto_usd', 'CIEV_V_FE_FacturasTotalizadas.fletes_usd',
                    'CIEV_V_FE_FacturasTotalizadas.seguros_usd', 'CIEV_V_FE_FacturasTotalizadas.iva', 'CIEV_V_FE_FacturasTotalizadas.fletes',
                    'CIEV_V_FE_FacturasTotalizadas.RTEFTE', 'CIEV_V_FE_FacturasTotalizadas.RTEIVA', 'CIEV_V_FE_FacturasTotalizadas.seguros',
                    'CIEV_V_FE_FacturasTotalizadas.moneda', 'CIEV_V_FE_FacturasTotalizadas.ov', 'CIEV_V_FE_FacturasTotalizadas.dias',
                    'CIEV_V_FE_FacturasTotalizadas.motivo', 'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo', 'CIEV_V_FE_FacturasTotalizadas.descmotivo',
                    'CIEV_V_FE_FacturasTotalizadas.correoscopia', 'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                ->where('CIEV_V_FE.numero', '=', $Factura_seleccionada->numero)
                ->take(1)
                ->get();

            $detalle = DB::connection('MAX')
                ->table('CIEV_V_FE_FacturasDetalladas')
                ->select('factura',
                    'codigoproducto', 'descripcionproducto', 'OC', 'item','Marca',
                    'cantidad', 'precio', 'precioUSD', 'totalitem', 'totalitemUSD',
                    'iva as iva_item', 'valormercancia', 'Desc_Item', 'UM', 'base',
                    'bruto_usd', 'posicionarancelaria', 'fletes_usd', 'seguros_usd', 'ARTE', 'CodProdCliente')
                ->where('CIEV_V_FE_FacturasDetalladas.factura', '=', $Factura_seleccionada->numero)
                ->get();

            $configuracion = DB::table('fe_configs')->first();

            $items_normales = [];
            $items_regalo = [];

            foreach ($detalle as $fila) {
                if ($fila->totalitem == 0 || $fila->totalitem < 0){
                    $items_regalo[] = $fila;
                }else{
                    $items_normales[] = $fila;
                }
            }

            foreach ($encabezado as $enc) {
                $bruto_factura           = null;
                $subtotal_factura        = null;
                $brutomasiva_factura     = null;
                $descuento_factura       = null;
                $total_cargos            = null;
                $total_pagar             = null;
                $tipo_fac_en             = null;
                $tipo_operacion          = '10';
                $metodo_pago             = null;
                $medio_pago              = null;
                $correo_entrega          = $enc->emailentrega;
                $id_total_impuesto_iva   = null;
                $factor_total            = null;
                $tarifa_unitaria_total   = null;


                if($enc->tipo_cliente  == 'EX'){
                    $bruto_factura       = $enc->bruto_usd;
                    $subtotal_factura    = $enc->bruto_usd;
                    $brutomasiva_factura = number_format($enc->bruto_usd,2,'.','');
                    $descuento_factura   = 0;
                    $total_cargos        = number_format($enc->fletes_usd,2,'.','') + number_format($enc->seguros_usd,2,'.','');
                    $totalpagar          = (number_format($enc->bruto_usd,2,'.','')  + $total_cargos);
                }
                else {
                    $bruto_factura       = $enc->bruto;
                    $subtotal_factura    = $enc->bruto - $enc->descuento;
                    $brutomasiva_factura = number_format($enc->bruto,2,'.','') + number_format($enc->iva,2,'.','');
                    $descuento_factura   = $enc->descuento;
                    $total_cargos        = number_format($enc->fletes,2,'.','') + number_format($enc->seguros,2,'.','');
                    $totalpagar          = number_format($enc->bruto,2,'.','') - number_format($enc->descuento,2,'.','') + number_format( $enc->iva,2,'.','');
                }

                $descuento_total_factura = ($descuento_factura / $bruto_factura ) * 100;
                $total_valor_iva         = $subtotal_factura * 0.19;
                $total_item_valor        = $subtotal_factura + $total_valor_iva;


                if($enc->motivo == 27) {
                    $tipo_fac_en = '02';
                } else {
                    $tipo_fac_en = '01';
                }

                if($enc->dias == 0) {
                    $metodo_pago = 1;
                } else {
                    $metodo_pago = 2;
                }

                if($metodo_pago == 2) {
                    $medio_pago = null;
                } else {
                    $medio_pago = 10;
                }



                if ($enc->iva != null) {
                    $id_total_impuesto_iva = '01';
                }

                if ($id_total_impuesto_iva == '01'){
                    $factor_total = '19';
                }

                if ($id_total_impuesto_iva == '01'){
                    $tarifa_unitaria_total = '0';
                }


                $regalos = [];
                foreach($items_regalo as $fila){
                    $regalos[] =  trim($fila->codigoproducto).' '.trim($fila->descripcionproducto).' '.trim($fila->cantidad);
                }
                $regalos = implode('+',$regalos);


                $objetoXML->startElement("documento");

                $objetoXML->startElement("idnumeracion");
                $objetoXML->text($configuracion->fac_idnumeracion);
                $objetoXML->endElement();

                $objetoXML->startElement("numero");
                $objetoXML->text($enc->numero);
                $objetoXML->endElement();

                $objetoXML->startElement("idambiente");
                $objetoXML->text($configuracion->fac_idambiente);
                $objetoXML->endElement();

                $objetoXML->startElement("idreporte");
                if($enc->tipo_cliente == 'EX'){
                    $objetoXML->text('1560'); //mejorar
                }else{
                    $objetoXML->text($configuracion->fac_idreporte);
                }
                $objetoXML->endElement();

                $objetoXML->startElement("fechadocumento");
                $objetoXML->text($enc->fechadocumento);
                $objetoXML->endElement();

                $objetoXML->startElement("fechavencimiento");
                $objetoXML->text($enc->fechavencimiento.' '.'00:00:00');
                $objetoXML->endElement();

                $objetoXML->startElement("tipofactura");
                $objetoXML->text($tipo_fac_en);
                $objetoXML->endElement();

                $objetoXML->startElement("tipooperacion");
                $objetoXML->text($tipo_operacion);
                $objetoXML->endElement();

                if ($enc->tipo_cliente != 'EX'){
                    $objetoXML->startElement("notas");
                    $objetoXML->text('COMPLEMENTO: '.$regalos);
                    $objetoXML->endElement();
                }

                $objetoXML->startElement("fechaimpuestos");
                $objetoXML->text('');
                $objetoXML->endElement();

                $objetoXML->startElement("moneda");
                $objetoXML->text($enc->moneda);
                $objetoXML->endElement();

                if(trim($enc->OC) != '' || trim($enc->OC) != null) {
                    $objetoXML->startElement("ordendecompra");

                    $objetoXML->startElement("codigo");
                    $objetoXML->text(trim($enc->OC));
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


                if(trim($enc->OV) != '' || trim($enc->OV) != null){
                    $objetoXML->startElement("ordendedespacho");

                    $objetoXML->startElement("codigo");
                    $objetoXML->text(trim($enc->OV));
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
                $objetoXML->text($enc->idtipodocumento);
                $objetoXML->endElement();

                $objetoXML->startElement("digitoverificacion");
                if($enc->tipo_cliente == 'EX' || $enc->idtipodocumento == '13' || $enc->idtipodocumento == '42' ){
                    $objetoXML->text('');
                }else{
                    $objetoXML->text($enc->digito_verificador);
                }
                $objetoXML->endElement();

                $objetoXML->startElement("identificacion");
                $objetoXML->text($enc->nit_cliente);
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
                $objetoXML->text($enc->emailcontacto);
                $objetoXML->endElement();

                $objetoXML->startElement("emailentrega");
                $objetoXML->text($correo_entrega);
                $objetoXML->endElement();

                $objetoXML->startElement("telefono");
                $objetoXML->text(trim($enc->telefono));
                $objetoXML->endElement();

                $objetoXML->endElement(); // sobra ?

                $objetoXML->startElement("formaspago");

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

                $objetoXML->endElement();

                if ($enc->tipo_cliente != 'EX' &&  $descuento_total_factura !=  0){
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
                    $objetoXML->text(number_format($descuento_total_factura,2,'.',''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("base");
                    $objetoXML->text($bruto_factura);
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text($descuento_factura);
                    $objetoXML->endElement();

                    $objetoXML->endElement();

                    $objetoXML->endElement();

                }else if($enc->tipo_cliente == 'EX' && $enc->fletes_usd != 0 || $enc->seguros_usd != 0 ){
                    $objetoXML->startElement("cargos");
                    if (trim($enc->fletes_usd) != 0){

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
                        $objetoXML->text(number_format((($enc->fletes_usd / $bruto_factura) * 100),2,'.',''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text($bruto_factura);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text($enc->fletes_usd);
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    if (trim($enc->seguros_usd) != 0  ){
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
                        $objetoXML->text(number_format((($enc->seguros_usd / $bruto_factura) * 100),2,'.',''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text($bruto_factura);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text($enc->seguros_usd);
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                }

                if($enc->tipo_cliente != 'EX' && $enc->iva != 0) {
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
                if($enc->iva != 0){
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

                if($enc->correoscopia != null){
                    $objetoXML->startElement("correoscopia");
                    foreach (explode(";",$enc->correoscopia) as $correos_copia){
                        $objetoXML->startElement("correocopia");
                        $objetoXML->text($correos_copia);
                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                }

                $objetoXML->startElement("items");
                foreach ($items_normales as $item) {
                    $valor_item = null;
                    $subtotal_item = null;
                    $brutomasiva =  null;
                    $descuento_item = null;
                    $valorDescItem = null;
                    $cargos_item    = null;
                    $totalpagar_item    = null;
                    //$nombre_estandar = 'EAN13';
                    $id_estandar = 999;
                    $id_impuesto = null;
                    $factor = null;
                    $umed = null;
                    $precio_unitario = null;

                    if($enc->tipo_cliente  == 'EX'){
                        $subtotal_item = $item->bruto_usd ;
                        $total_valor_item_iva = $subtotal_item * 0.19;
                        $descuento_por_item = 0;
                        $valor_item = $item->precioUSD * $item->cantidad;
                        $precio_unitario = $item->precioUSD;

                    }else{
                        $subtotal_item = $item->totalitem - $item->Desc_Item;
                        $total_valor_item_iva = $subtotal_item * 0.19;
                        $valor_item = $item->precio * $item->cantidad;
                        $valorDescItem = $item->Desc_Item;
                        $descuento_por_item = ($item->Desc_Item / $valor_item) * 100;
                        $precio_unitario = $item-> precio;
                    }

                    $regalo = null;
                    if ($valor_item == 0) {
                        $regalo = 1;
                    } else {
                        $regalo = 0;
                    }


                    if ($item->iva_item != 0) {
                        $id_impuesto = '01';
                    }

                    // porcentaje de impuesto

                    if ($id_impuesto == '01') {
                        $factor = '19';
                    }



                    $id_item_iva = null;
                    if ($item->iva_item != null) {
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
                    $objetoXML->text(trim($item->codigoproducto));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                    $objetoXML->endElement();

                    $objetoXML->startElement("descripcion");
                    $objetoXML->text(trim($item->descripcionproducto));
                    $objetoXML->endElement();

                 /*   $objetoXML->startElement("notas");
                    $objetoXML->text(' ');
                    $objetoXML->endElement();*/

                    $objetoXML->startElement("cantidad");
                    $objetoXML->text(number_format($item->cantidad, 2, '.', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("cantidadporempaque");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("preciounitario");
                    $objetoXML->text(number_format($precio_unitario, 3, '.', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("unidaddemedida");
                    $objetoXML->text($item->UM);
                    $objetoXML->endElement();

                    if ($enc->tipo_cliente == 'EX'){
                        $marca = $item->descripcionproducto;
                        $modelo = $item->codigoproducto;
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
                    $objetoXML->text(trim($item->codigoproducto));
                    $objetoXML->endElement();

                    $objetoXML->startElement("subcodigovendedor");
                    $objetoXML->text(trim($item->OC));
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
                        $objetoXML->text(number_format($descuento_por_item,2,'.',''));
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


                    if($enc->tipo_cliente != 'EX' && $item->iva_item != 0){
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

                    $objetoXML->startElement("datosextra");
                    if (trim($item->posicionarancelaria) != '' && $enc->tipo_cliente == 'EX'){
                        $objetoXML->startElement("datoextra");

                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('PA');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(trim($item->posicionarancelaria));
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    if (trim($item->ARTE) != ''){
                        $objetoXML->startElement("datoextra");

                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('Arte');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(trim($item->ARTE));
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    if (trim($item->Marca) != ''){
                        $objetoXML->startElement("datoextra");

                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('Marca');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(trim($item->Marca));
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    if (trim($item->CodProdCliente) != ''){
                        $objetoXML->startElement("datoextra");

                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('CodProdCliente');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(trim($item->CodProdCliente));
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                   
                    
                    $notas_item = DB::connection('MAX')
                        ->table('CIEV_V_NotasFacturas')
                        ->where('Factura','=', $Factura_seleccionada->numero)
                        ->where('item', '=', $item->item)
                        ->where('TipoNota', '=', 'I')
                        ->pluck('Nota')->toArray();


                    if (sizeof($notas_item) > 0){
                        $notas_array = array();
                        $i = 1;
                        foreach($notas_item as $item){
                            if(trim($item) != ''){
                                array_push($notas_array, 'nota_'.$i.':'.trim($item));
                                $i++;
                            }
                        }
                        $notas = implode(",", $notas_array);

                        $objetoXML->startElement("datoextra");

                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('Notas');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text($notas);
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }
                $objetoXML->endElement(); // cierra item

                $objetoXML->startElement("datosextra");

                $objetoXML->startElement("datoextra");

                $objetoXML->startElement("tipo");
                $objetoXML->text('1');
                $objetoXML->endElement();

                $objetoXML->startElement("clave");
                $objetoXML->text('CONDICION_PAGO');
                $objetoXML->endElement();

                $objetoXML->startElement("valor");
                $objetoXML->text(trim($enc->plazo));
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
                $objetoXML->text($enc->codigocliente);

                $objetoXML->endElement();

                $objetoXML->endElement();


                if ($enc->RTEFTE){
                    $objetoXML->startElement("datoextra");

                    $objetoXML->startElement("tipo");
                    $objetoXML->text('1');
                    $objetoXML->endElement();

                    $objetoXML->startElement("clave");
                    $objetoXML->text('RTEFTE');
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text(trim($enc->RTEFTE));
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                }


                if($enc->RTEIVA != 0){
                    $objetoXML->startElement("datoextra");

                    $objetoXML->startElement("tipo");
                    $objetoXML->text('1');
                    $objetoXML->endElement();

                    $objetoXML->startElement("clave");
                    $objetoXML->text('RTEIVA');
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text(trim($enc->RTEIVA));
                    $objetoXML->endElement();

                    $objetoXML->endElement();
                }

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


                $objetoXML->endElement(); // cierra items

                $objetoXML->endElement();

                $objetoXML->endElement(); // Final del nodo raíz, "documento"
            }
            $objetoXML->endDocument();  // Final del documento

            $cadenaXML = $objetoXML->outputMemory();

            $Base_64 = base64_encode($cadenaXML);


            /* se comienza con el web service */
            $login1 = 'dcorreah';
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new \SoapClient($wsdl_url);
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
     * @throws \SoapFault
     */
    public function envio_notas_credito(Request $request){
        $Notas_credito = $request->selected;
        $Notas_credito = json_decode($Notas_credito);
        $resultados = [];
        foreach ($Notas_credito as $nc) {
            $objetoXML = new    XMLWriter();
            $objetoXML->openURI(public_path()."/notas_credito.xml");
            $objetoXML->openMemory();
            $objetoXML->setIndent(true);
            $objetoXML->setIndentString("\t");
            $objetoXML->startDocument('1.0', 'utf-8');

            $objetoXML->startElement("root");

            $num = $nc->numero;

            $EncabezadoNc = DB::connection('MAX')
                ->table('CIEV_V_FE')
                ->leftJoin('CIEV_V_FE_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FE_FacturasTotalizadas.numero')
                ->select('CIEV_V_FE.numero', 'CIEV_V_FE.notas', 'CIEV_V_FE.identificacion as nit_cliente', 'CIEV_V_FE.apellidos',
                    'CIEV_V_FE.emailcontacto', 'CIEV_V_FE.direccion', 'CIEV_V_FE.emailentrega', 'CIEV_V_FE.digito_verificador',
                    'CIEV_V_FE.idtipodocumento', 'CIEV_V_FE.telefono', 'CIEV_V_FE.notas', 'CIEV_V_FE.OC', 'CIEV_V_FE.codciudad',
                    'CIEV_V_FE.coddpto', 'CIEV_V_FE.codigo_alterno', 'CIEV_V_FE.codigocliente', 'CIEV_V_FE.fechadocumento',
                    'CIEV_V_FE.nombres', 'CIEV_V_FE.fechavencimiento', 'CIEV_V_FE_FacturasTotalizadas.OV', 'CIEV_V_FE_FacturasTotalizadas.bruto',
                    'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social', 'CIEV_V_FE_FacturasTotalizadas.descuento',
                    'CIEV_V_FE_FacturasTotalizadas.subtotal', 'CIEV_V_FE_FacturasTotalizadas.bruto_usd', 'CIEV_V_FE_FacturasTotalizadas.fletes_usd',
                    'CIEV_V_FE_FacturasTotalizadas.seguros_usd', 'CIEV_V_FE_FacturasTotalizadas.iva', 'CIEV_V_FE_FacturasTotalizadas.fletes',
                    'CIEV_V_FE_FacturasTotalizadas.RTEFTE', 'CIEV_V_FE_FacturasTotalizadas.RTEIVA', 'CIEV_V_FE_FacturasTotalizadas.seguros',
                    'CIEV_V_FE_FacturasTotalizadas.moneda', 'CIEV_V_FE_FacturasTotalizadas.ov', 'CIEV_V_FE_FacturasTotalizadas.dias',
                    'CIEV_V_FE_FacturasTotalizadas.motivo', 'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo', 'CIEV_V_FE_FacturasTotalizadas.descmotivo',
                    'CIEV_V_FE_FacturasTotalizadas.correoscopia', 'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                ->where('CIEV_V_FE.numero', '=', $num)
                ->take(1)->get();

            // esta consulta muestra el detalle de los items de cada factura
            $detalle = DB::connection('MAX')
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
                    'CIEV_V_FE_FacturasDetalladas.bruto_usd',
                    'CIEV_V_FE_FacturasDetalladas.posicionarancelaria',
                    'CIEV_V_FE_FacturasDetalladas.fletes_usd',
                    'CIEV_V_FE_FacturasDetalladas.seguros_usd')
                ->where('CIEV_V_FE_FacturasDetalladas.factura', '=', $num)
                ->get();

            $configuracion = DB::table('fe_configs')->first();
            $items_normales = [];
            $items_regalo = [];

            foreach ($detalle as $fila) {
                if (abs($fila->totalitem) == 0 || abs($fila->totalitem) < 0){
                    $items_regalo[] = $fila;
                }else{
                    $items_normales[] = $fila;
                }
            }

            foreach ($EncabezadoNc as $enc) {
                $bruto_factura           = null;
                $subtotal_factura        = null;
                $brutomasiva_factura     = null;
                $descuento_factura       = null;
                $total_cargos            = null;
                $total_pagar             = null;
                $tipo_fac_en             = null;
                $tipo_operacion          = '10';
                $metodo_pago             = null;
                $medio_pago              = null;
                $correo_entrega          = $enc->emailentrega;
                $id_total_impuesto_iva   = null;
                $factor_total            = null;
                $tarifa_unitaria_total   = null;


                if($enc->tipo_cliente  == 'EX'){
                    $bruto_factura       = $enc->bruto_usd;
                    $subtotal_factura    = $enc->bruto_usd;
                    $brutomasiva_factura = number_format($enc->bruto_usd,2,'.','');
                    $descuento_factura   = 0;
                    $total_cargos        = number_format($enc->fletes_usd,2,'.','') + number_format($enc->seguros_usd,2,'.','');
                    $totalpagar          = (number_format($enc->bruto_usd,2,'.','')  + $total_cargos);
                }
                else {
                    $bruto_factura       = $enc->bruto;
                    $subtotal_factura    = $enc->bruto - $enc->descuento;
                    $brutomasiva_factura = number_format($enc->bruto,2,'.','') + number_format($enc->iva,2,'.','');
                    $descuento_factura   = $enc->descuento;
                    $total_cargos        = number_format($enc->fletes,2,'.','') + number_format($enc->seguros,2,'.','');
                    $totalpagar          = number_format($enc->bruto,2,'.','') - number_format($enc->descuento,2,'.','') + number_format( $enc->iva,2,'.','');
                }

                $descuento_total_factura = ($descuento_factura / $bruto_factura ) * 100;
                $total_valor_iva         = $subtotal_factura * 0.19;
                $total_item_valor        = $subtotal_factura + $total_valor_iva;


                if($enc->motivo == 27) {
                    $tipo_fac_en = '02';
                } else {
                    $tipo_fac_en = '01';
                }

                if($enc->dias == 0) {
                    $metodo_pago = 1;
                } else {
                    $metodo_pago = 2;
                }

                if($metodo_pago == 2) {
                    $medio_pago = null;
                } else {
                    $medio_pago = 10;
                }



                if ($enc->iva != null) {
                    $id_total_impuesto_iva = '01';
                }

                if ($id_total_impuesto_iva == '01'){
                    $factor_total = '19';
                }

                if ($id_total_impuesto_iva == '01'){
                    $tarifa_unitaria_total = '0';
                }


                $regalos = [];
                foreach($items_regalo as $fila){
                    $regalos[] =  trim($fila->codigoproducto).' '.trim($fila->descripcionproducto).' '.trim($fila->cantidad);
                }
                $regalos = implode('+',$regalos);


                //Construimos el xlm
                $objetoXML->startElement("documento");    // Se inicia un elemento para cada factura.
                $objetoXML->startElement("idnumeracion");
                $objetoXML->text($configuracion->nc_idnumeracion); // depende del tipo de documento
                $objetoXML->endElement();

                $objetoXML->startElement("numero");
                $objetoXML->text($enc->numero);
                $objetoXML->endElement();

                $objetoXML->startElement("idambiente");
                $objetoXML->text($configuracion->nc_idambiente);
                $objetoXML->endElement();

                $objetoXML->startElement("idreporte");
                $objetoXML->text($enc->tipo_cliente == 'EX' ? $configuracion->nc_exp_id_reporte : $configuracion->nc_idreporte);
                $objetoXML->endElement();


                $objetoXML->startElement("fechadocumento");
                $objetoXML->text($enc->fechadocumento);
                $objetoXML->endElement();

                $objetoXML->startElement("fechavencimiento");
                $objetoXML->text($enc->fechavencimiento);
                $objetoXML->endElement();



                $objetoXML->startElement("notas");
                $objetoXML->text('COMPLEMENTO: '. $regalos);
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
                $objetoXML->text($configuracion->fac_idnumeracion); // numeracion de facturas se debe cambiar por el que corresponde a notas credito
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
                $objetoXML->text($enc->idtipodocumento);
                $objetoXML->endElement();
                $objetoXML->startElement("digitoverificacion");
                if($enc->tipo_cliente == 'EX' || $enc->idtipodocumento == '13' || $enc->idtipodocumento == '42' ){
                    $objetoXML->text('');
                }else{
                    $objetoXML->text($enc->digito_verificador);
                }
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


                if ($enc->tipo_cliente != 'EX' &&  $descuento_total_factura !=  0){
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
                    $objetoXML->text(number_format($descuento_total_factura,2,'.',''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("base");
                    $objetoXML->text($bruto_factura);
                    $objetoXML->endElement();

                    $objetoXML->startElement("valor");
                    $objetoXML->text($descuento_factura);
                    $objetoXML->endElement();

                    $objetoXML->endElement();

                    $objetoXML->endElement();

                }else if($enc->tipo_cliente == 'EX' && $enc->fletes_usd != 0 || $enc->seguros_usd != 0 ){
                    $objetoXML->startElement("cargos");
                    if (trim($enc->fletes_usd) != 0){

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
                        $objetoXML->text(number_format((($enc->fletes_usd / $bruto_factura) * 100),2,'.',''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text($bruto_factura);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text($enc->fletes_usd);
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    if (trim($enc->seguros_usd) != 0  ){
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
                        $objetoXML->text(number_format((($enc->seguros_usd / $bruto_factura) * 100),2,'.',''));
                        $objetoXML->endElement();

                        $objetoXML->startElement("base");
                        $objetoXML->text($bruto_factura);
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text($enc->seguros_usd);
                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
                }


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
                $objetoXML->text(number_format($bruto_factura,2,'.',''));
                $objetoXML->endElement();
                $objetoXML->startElement("baseimponible");
                $objetoXML->text(number_format($subtotal_factura,2,'.',''));
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

                foreach ($items_normales as $item) {

                    $valor_item = null;
                    $subtotal_item = null;
                    $brutomasiva =  null;
                    $descuento_item = null;
                    $valorDescItem = null;
                    $cargos_item    = null;
                    $totalpagar_item    = null;
                    //$nombre_estandar = 'EAN13';
                    $id_estandar = 999;
                    $id_impuesto = null;
                    $factor = null;
                    $umed = null;
                    $precio_unitario = null;

                    if($enc->tipo_cliente  == 'EX'){
                        $subtotal_item =  $item->bruto_usd;
                        $total_valor_item_iva = $subtotal_item * 0.19;
                        $descuento_por_item = 0;
                        $valor_item = $item->precioUSD * $item->cantidad;
                        $precio_unitario = $item->precioUSD;

                    }else{
                        $subtotal_item = $item->totalitem - $item->Desc_Item;
                        $total_valor_item_iva = $subtotal_item * 0.19;
                        $valor_item = $item->precio * $item->cantidad;
                        $valorDescItem = $item->Desc_Item;
                        $descuento_por_item = ($item->Desc_Item / $valor_item) * 100;
                        $precio_unitario = $item-> precio;
                    }

                    $regalo = null;
                    if ($valor_item == 0) {
                        $regalo = 1;
                    } else {
                        $regalo = 0;
                    }


                    if ($item->iva_item != 0) {
                        $id_impuesto = '01';
                    }

                    // porcentaje de impuesto

                    if ($id_impuesto == '01') {
                        $factor = '19';
                    }



                    $id_item_iva = null;
                    if ($item->iva_item != null) {
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
                    $objetoXML->text(trim($item->codigoproducto));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                    $objetoXML->endElement();

                    $objetoXML->startElement("descripcion");
                    $objetoXML->text(trim($item->descripcionproducto));
                    $objetoXML->endElement();

                    $objetoXML->startElement("notas");
                    $objetoXML->text(' ');
                    $objetoXML->endElement();

                    $objetoXML->startElement("cantidad");
                    $objetoXML->text(number_format($item->cantidad, 2, '.', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("cantidadporempaque");
                    $objetoXML->text('');
                    $objetoXML->endElement();

                    $objetoXML->startElement("preciounitario");
                    $objetoXML->text(number_format($precio_unitario, 3, '.', ''));
                    $objetoXML->endElement();

                    $objetoXML->startElement("unidaddemedida");
                    $objetoXML->text($item->UM);
                    $objetoXML->endElement();

                    if ($enc->tipo_cliente == 'EX'){
                        $marca = $item->descripcionproducto;
                        $modelo = $item->codigoproducto;
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
                    $objetoXML->text(trim($item->codigoproducto));
                    $objetoXML->endElement();

                    $objetoXML->startElement("subcodigovendedor");
                    $objetoXML->text(trim($item->OC));
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
                        $objetoXML->text(number_format($descuento_por_item,2,'.',''));
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


                    if($enc->tipo_cliente != 'EX' && $item->iva_item != 0){
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

                    if (trim($item->posicionarancelaria) != '' && $enc->tipo_cliente == 'EX'){
                        $objetoXML->startElement("datosextra");

                        $objetoXML->startElement("datoextra");

                        $objetoXML->startElement("tipo");
                        $objetoXML->text('1');
                        $objetoXML->endElement();

                        $objetoXML->startElement("clave");
                        $objetoXML->text('PA');
                        $objetoXML->endElement();

                        $objetoXML->startElement("valor");
                        $objetoXML->text(trim($item->posicionarancelaria));
                        $objetoXML->endElement();

                        $objetoXML->endElement();

                        $objetoXML->endElement();
                    }
                    $objetoXML->endElement();
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
     * @throws \SoapFault
     */
    public function descarga_documento(Request $request){
        $Numero_Factura = $request->id;

        if (request()->ajax()) {
            $login1 = "dcorreah";
            $password = "FE2020ev*";
            $client = new \SoapClient("https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl",array(
                'soap_version'   => SOAP_1_1,
                'trace' => 1,
                "location" => "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService"));


            $params = array(
                'login' => $login1,
                'password' => $password
            );

            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;

            $params = [
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
                'numeroFinal' => $Numero_Factura ,
                'idnumeracion' => '',
                'estadoAcuse' => '',
                'razonSocial' => '',
                'mulCodEstDian' => '',
                'mulCodEstCliente'  => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            ];


            $return = $client->ListarDocumentosElectronicos($params);
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

            return response()->json($resultados->data->salida, 200);
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
                'mulCodEstCliente'  => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );

            $return = $client->ListarDocumentosElectronicos($params);
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
     * @throws \SoapFault
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
                    'mulCodEstCliente'  => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicos($params);
                $return = json_decode($return->return);
                $values = $return->data;


                return response()->json($values);

            } else {
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
                    'mulCodEstCliente'  => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicos($params);

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
     * @throws \SoapFault
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
                'mulCodEstCliente'  => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );
            $return = $client->ListarDocumentosElectronicos($params);
            $return = json_decode($return->return);

            $values = $return->data[0];

            return response()->json($values);
        }
    }



    public function enviar_documento_electronico(Request $request){
        if ($request->ajax()){
            try {
                $login1 = "dcorreah";
                $password = "FE2020ev*";
                $client = new \SoapClient("https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl",array(
                    'soap_version'   => SOAP_1_1,
                    'trace' => 1,
                    "location" => "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService"));


                $params = array(
                    'login' => $login1,
                    'password' => $password
                );

                $auth = $client->autenticar($params);
                $respuesta = json_decode($auth->return);
                $token = $respuesta->data->salida;

                $params = [
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
                    'numeroInicial' => $request->id,
                    'numeroFinal' => $request->id ,
                    'idnumeracion' => '',
                    'estadoAcuse' => '',
                    'razonSocial' => '',
                    'mulCodEstDian' => '',
                    'mulCodEstCliente'  => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                ];


                $return = $client->ListarDocumentosElectronicos($params);
                $return = json_decode($return->return);
                $id_factible = $return->data[0]->DT_RowId;

                $params = array(
                    'token'                     => $token,
                    'iddocumentoelectronico'    => $id_factible,
                );



                $return = $client->descargarDocumentoElectronico_VersionGrafica($params);
                $resultados = json_decode($return->return);
                $pdf = base64_decode($resultados->data->salida);
                $name_pdf  = $request->id.'.pdf';


                $return = $client->descargarDocumentoElectronico_XML($params);
                $resultados = json_decode($return->return);
                $pdf_xml = base64_decode($resultados->data->salida);
                $name_pdf_xml  = $request->id.'.xml';


                Storage::disk('public')->put('adjuntos/'.$name_pdf, $pdf);
                Storage::disk('public')->put('adjuntos/'.$name_pdf_xml, $pdf_xml);



                $subject = "DOCUMENTO ELECTRONICO";
                Mail::send('mails.facturacion_electronica.documento_electronico',['factura' => $request->id], function($msj) use($request, $subject){
                    $msj->from("info@estradavelasquez.com","REENVIO DOCUMENTO ELECTRONICO");
                    $msj->sender('info@estradavelasquez.com');
                    $msj->subject($subject);
                    $msj->to($request->correos);
                    $msj->cc("dcorrea@estradavelasquez.com");
                    $msj->attach(storage_path("app/public/adjuntos/".$request->id).".pdf");
                    $msj->attach(storage_path("app/public/adjuntos/".$request->id).".xml");
                });

                return response()->json('ok', 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }

        }
    }
}
