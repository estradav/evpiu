<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Swift_Attachment;
use Swift_Preferences;
use XMLWriter;
use Yajra\DataTables\DataTables;
use SoapClient;

class FeFacturasController extends Controller
{
    public function index(Request $request)
    {
        $fromdate = Carbon::now()->format('Y-m-d 00:00:00');
        $todate = Carbon::now()->format('Y-m-d 23:59:59');

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = DB::connection('MAX')->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero','=','CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha as fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE_FacturasTotalizadas.bruto as bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.ov as ov',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo as motivo',
                        'CIEV_V_FE.codigo_alterno as cod_alter',
                        'CIEV_V_FE_FacturasTotalizadas.subtotal as subtotal',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE.emailcontacto as emailcontacto',
                        'CIEV_V_FE.nombres as nombres',
                        'CIEV_V_FE.apellidos as apellidos',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc', '=', 'CU')
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->whereBetween('fecha', array($request->from_date, $request->to_date))
                    ->get();
            }else {
                $data = DB::connection('MAX')->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero', '=', 'CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha as fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE_FacturasTotalizadas.bruto as bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.ov as ov',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo as motivo',
                        'CIEV_V_FE.codigo_alterno as cod_alter',
                        'CIEV_V_FE_FacturasTotalizadas.subtotal as subtotal',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE.emailcontacto as emailcontacto',
                        'CIEV_V_FE.nombres as nombres',
                        'CIEV_V_FE.apellidos as apellidos',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc', '=', 'CU')
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->whereBetween('fecha', array($fromdate, $todate))
                    ->get();
            }
            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-right">'.'<a href="/fe/'.$row->id.'/edit" class="btn btn-sm" id="edit-fac"><i class="far fa-edit" style="color: #3085d6"></i></a>';
                    $btn = $btn.'<button class="btn btn-sm download-vg" id="'.$row->id.'"><i class="fas fa-file-pdf" style="color: #FF0000"></i></button>'.'</div>';
                    return $btn;
                })
                ->addColumn('selectAll', function($row){
                    $btn = '<input type="checkbox" class="checkboxes test" id="'.$row->id.'" name="'.$row->id.'">';
                    return $btn;
                })
                ->addColumn('EstadoDian',function($row){
                    $div = '<div class="container" style="align-items: center !important; margin-left: 2px; margin-right: 2px"><div class="preloader_datatable"></div>';
                    return $div;
                })
                ->rawColumns(['opciones','selectAll','EstadoDian'])
                ->make(true);
        }
        return view('FacturacionElectronica.Facturas.index');
    }

    public function CrearXml(Request $request)
   {
       $Facturas_Seleccionadas = $request->selected;
       $Facturas_Seleccionadas = json_decode($Facturas_Seleccionadas);

       // Estructura del XML
       $objetoXML = new XMLWriter();
       $objetoXML->openURI("XML/Facturacion_electronica_Facturas.xml");
       $objetoXML->openMemory();
       $objetoXML->setIndent(true);
       $objetoXML->setIndentString("\t");
       $objetoXML->startDocument('1.0', 'utf-8');

       //Elemento Raiz del XML
       $objetoXML->startElement("root");

       foreach ($Facturas_Seleccionadas as $Factura_seleccionada) {
           $NumeroFactura = $Factura_seleccionada->numero;

           $Encabezado_Factura = DB::connection('MAX')->table('CIEV_V_FE')
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
               ->where('CIEV_V_FE.numero', '=', $NumeroFactura)->take(1)->get();

           // esta consulta muestra el detalle de los items de cada factura
           $Items_Factura = DB::connection('MAX')->table('CIEV_V_FE_FacturasDetalladas')
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
               ->where('CIEV_V_FE_FacturasDetalladas.factura', '=', $NumeroFactura)->get();

           $Configuracion = DB::table('fe_configs')->take(1)->get();

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

               ////////////////// CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////
               ///
               if($encabezado->tipo_cliente  == 'EX'){
                   $bruto_factura       = $encabezado->bruto_usd;
                   $subtotal_factura    = $encabezado->bruto_usd;
                   $brutomasiva_factura = number_format($encabezado->bruto_usd,2,'.','');
                   $descuento_factura   = 0;
                   $total_cargos        = number_format($encabezado->fletes_usd,2,'.','') + number_format($encabezado->seguros_usd,2,'.','');
                   $totalpagar          = (number_format($encabezado->bruto_usd,2,'.','')  + $total_cargos);

               }
               else {
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

                if($encabezado->motivo == 27) {$tipo_fac_en = '02';}// exportaciones 27
                else {$tipo_fac_en = '01';}

                // determina si el tipo de operacion

                /*if($tipo_fac_en == 02) {$tipo_operacion = '04';}
                if($tipo_fac_en == 01) {$tipo_operacion = '05';}
                if($encabezado->iva == 0) {$tipo_operacion = '03';}*/

                //Determina si la factura es a contado o a credito

                if($encabezado->dias == 0) {$metodo_pago = 1;}
                else {$metodo_pago = 2;}

                // determina el metodo de pago
                if($metodo_pago == 2)
                { $medio_pago = null;}
                else { $medio_pago = 10;}

                // valida el tipo de documento de identidad
                if ($encabezado->idtipodocumento == 31 )
                {
                    $tipo_documento_ide = 31;
                }
                if ($encabezado->idtipodocumento == 22){
                    $tipo_documento_ide = 42;
                }
                else{
                    $tipo_documento_ide = 13;
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
               if($encabezado->tipo_cliente == 'EX' || $encabezado->tipo_cliente == 'PN' ){
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
               }else if($encabezado->tipo_cliente == 'EX' && $encabezado->fletes_usd != 0 || $encabezado->seguros_usd != 0 ){
                   $objetoXML->startElement("cargos");
                   if (trim($encabezado->fletes_usd) != 0){
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
                   if (trim($encabezado->seguros_usd) != 0 ){
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
               if($encabezado->iva != 0){
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

                   $valor_item = null;
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
                   $precio_unitario = null;
                   ////////////////// CAlCULOS Y VALIDACIONES PARA EL ENCABEZADO DE LAS FACTURAS  ////////////////////////////
                   ///
                   if($encabezado->tipo_cliente  == 'EX'){
                       $subtotal_item = $it->bruto_usd ;
                       $total_valor_item_iva = $subtotal_item * 0.19;
                       $DescuentoPorItem = 0;
                       $valor_item = $it->precioUSD * $it->cantidad;
                       $precio_unitario = $it->precioUSD;

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

                    /*// valida el tipo de cooigo 020 posicion alacelaria o 999 adopcion del contribuyente
                   // valida el id impuesto por item*/

                   if ($it->iva_item != 0) {
                       $id_impuesto = '01';
                   }

                   // porcentaje de impuesto

                   if ($id_impuesto == '01') {$factor = '19';}

                   if ($it->UM == 'UN') {$umed = '94';}
                   else {$umed = 'KGM';}

                   $id_item_iva = null;
                   if ($it->iva_item != null) {
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

                   if (trim($it->posicionarancelaria) != ''){
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
                   /*Fin Dato extra*/

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

               $objetoXML->endElement(); // cierra items
               $objetoXML->endElement();
               $objetoXML->endElement(); // Final del nodo raíz, "documento"
           }
       }
       $objetoXML->endDocument();  // Final del documento
       $cadenaXML = $objetoXML->outputMemory();

       file_put_contents('XML/Facturacion_electronica_Facturas.xml', $cadenaXML);

       return response()->json();
   }

    public function editfactura($numero)
    {
       $var = $numero;
       return view('FacturacionElectronica.Facturas.edit', ["var" => $var] );
    }

    public function config(Request $request)
    {
        if ($request->ajax()){
            $Configuracions = DB::table('fe_configs')->get();
                return response()->json($Configuracions);
        }
        return view('FacturacionElectronica.Configuracion.index');
    }

    public function savefeConfigs(Request $request)
    {
        DB::table('fe_configs')->where('id','=','1')->update([
            'fac_idnumeracion'  => $request->fac_idnumeracion,
            'fac_idambiente'    => $request->fac_idambiente,
            'fac_idreporte'     => $request->fac_idreporte
        ]);
        return response()->json(['ok']);
    }

    public function savefeConfigsNc(Request $request)
    {
        DB::table('fe_configs')->where('id','=','1')->update([
            'nc_idnumeracion'  => $request->nc_idnumeracion,
            'nc_idambiente'    => $request->nc_idambiente,
            'nc_idreporte'     => $request->nc_idreporte
        ]);
        return response()->json(['ok']);
    }

    public function DatosxFactura(Request $request)
    {
        $encabezado =  DB::connection('MAX')->table('CIEV_V_FE')
         ->leftJoin('CIEV_V_FacturasTotalizadas', 'CIEV_V_FE.numero', '=', 'CIEV_V_FacturasTotalizadas.numero')
         ->select('CIEV_V_FE.numero',
             'CIEV_V_FE.notas',
             'CIEV_V_FE.identificacion as nit_cliente',
             'CIEV_V_FE.nombres',
             'CIEV_V_FE.apellidos',
             'CIEV_V_FE.emailcontacto',
             'CIEV_V_FE.direccion',
             'CIEV_V_FE.emailentrega',
             'CIEV_V_FE.digito_verificador',
             'CIEV_V_FE.telefono',
             'CIEV_V_FE.notas',
             'CIEV_V_FE.ciudad',
             'CIEV_V_FE.dpto',
             'CIEV_V_FE.pais',
             'CIEV_V_FacturasTotalizadas.bruto',
             'CIEV_V_FE.codigocliente',
             'CIEV_V_FE.fechadocumento',
             'CIEV_V_FacturasTotalizadas.razonsocial as razon_social',
             'CIEV_V_FacturasTotalizadas.bruto',
             'CIEV_V_FacturasTotalizadas.descuento',
             'CIEV_V_FacturasTotalizadas.subtotal',
             'CIEV_V_FacturasTotalizadas.iva',
             'CIEV_V_FacturasTotalizadas.fletes',
             'CIEV_V_FacturasTotalizadas.seguros',
             'CIEV_V_FacturasTotalizadas.moneda',
             'CIEV_V_FacturasTotalizadas.ov',
             'CIEV_V_FacturasTotalizadas.dias',
             'CIEV_V_FacturasTotalizadas.motivo',
             'CIEV_V_FacturasTotalizadas.descplazo as plazo',
             'CIEV_V_FacturasTotalizadas.descmotivo',
             'CIEV_V_FacturasTotalizadas.tipocliente as tipo_cliente',
             'CIEV_V_FE.nombres','CIEV_V_FE.fechavencimiento',
             'CIEV_V_FE.OC')
         ->where('CIEV_V_FE.numero', '=', $request->numero)->get();

         $detalle = DB::connection('MAX')->table('CIEV_V_FacturasDetalladas')
             ->select('CIEV_V_FacturasDetalladas.factura',
                 'CIEV_V_FacturasDetalladas.descripcionproducto',
                 'CIEV_V_FacturasDetalladas.CodigoProducto',
                 'CIEV_V_FacturasDetalladas.OV',
                 'CIEV_V_FacturasDetalladas.item',
                 'CIEV_V_FacturasDetalladas.cantidad',
                 'CIEV_V_FacturasDetalladas.precio',
                 'CIEV_V_FacturasDetalladas.totalitem',
                 'CIEV_V_FacturasDetalladas.iva as iva_item',
                 'CIEV_V_FacturasDetalladas.valormercancia',
                 'CIEV_V_FacturasDetalladas.descuento',
                 'CIEV_V_FacturasDetalladas.item',
                 'CIEV_V_FacturasDetalladas.UM')
             ->where('CIEV_V_FacturasDetalladas.factura', '=', $request->numero)->get();

         return response()->json(['encabezado' => $encabezado, 'detalle' => $detalle]);
    }

    public function VerCondicionesPago(Request $request)
    {
        if ($request->ajax()){
            $Condicion =  DB::connection('MAX')->table('Code_Master')
                ->where('Code_Master.CDEKEY_36','=','REAS')
                ->get();
        }
        return response()->json($Condicion);
    }

    public function GuardarFacturaEdit(Request $request)
    {
        /* preguntar por reason o condicion de pago en un query */
        $CondicionPago =  DB::connection('MAXP')->table('Code_Master')->where('CDEKEY_36','=','TERM')
        ->where('DAYS_36','=', $request->encabezado[0]['condicionpago'])->select('CODE_36')->get();

        $Numero_de_factura = '00'.$request->encabezado[0]['Numero_factura'];
        $Detalle = $request->Items;
        $ConIVA = [];
        $SinIVA = [];

        foreach($Detalle as $dest){
            if ($dest['iva'] > 0 ){
                $ConIVA[] = $dest;
            }
            else{
                $SinIVA[] = $dest;
            }
        }

        if($ConIVA != null && $SinIVA == null) {
            DB::beginTransaction();
            try {
                DB::connection('MAXP')->table('Invoice_master')
                    ->where('INVCE_31', '=', $Numero_de_factura)
                    ->update([
                        'COMNT1_31' => $request->encabezado[0]['notas'],
                        'REASON_31' => $request->encabezado[0]['motivo'],
                        'TAX1_31'   => $request->encabezado[0]['total_iva'],
                        'LNETOT_31' => $request->encabezado[0]['total_bruto'],
                        'ORDDSC_31' => $request->encabezado[0]['total_descuento'],
                        'UDFKEY_31' => $request->encabezado[0]['total_retencion'],
                        'MSCAMT_31' => $request->encabezado[0]['total_seguro'],
                        'FRTAMT_31' => $request->encabezado[0]['total_flete'],
                        'TAXTOT_31' => $request->encabezado[0]['total_subtotal'],
                        'CUSTPO_31' => $request->encabezado[0]['ordencompra'],
                        'TAXCD1_31' => 'IVA-V19',
                        'TAXABL_31' => 'Y',
                        'TERMS_31'  => $CondicionPago[0]->CODE_36,
                    ]);

                foreach ($ConIVA as $Det) {
                    $limnnum = substr($Det['item'], 0, 2);
                    $delnum = substr($Det['item'], 2, 4);


                    DB::connection('MAXP')->table('Invoice_detail')
                        ->where('INVCE_32', '=', $Numero_de_factura)
                        ->where('LINNUM_32', '=', $limnnum)
                        ->where('DELNUM_32', '=', $delnum)
                        ->where('ORDNUM_32', '=', $Det['ordencompra'])
                        ->update([
                            'PRICE_32'      => $Det['preciounitario'],
                            'TAX1_32'       => $Det['iva'],
                            'TAXCDE1_32'    => 'IVA-V19',
                            'TAXABL_32'     => 'Y'
                        ]);
                }
                DB::commit();
                return response()->json(['Success' => 'Todo Ok']);
            }
            catch (\Exception $e){
                DB::rollback();
                echo json_encode(array(
                    'error' => array(
                        'msg' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'code2' =>$e->getLine(),
                    ),
                ));
            }
        }


        if($ConIVA == null && $SinIVA != null) {
            DB::beginTransaction();
            try {
                DB::connection('MAXP')->table('Invoice_master')
                    ->where('INVCE_31', '=', $Numero_de_factura)
                    ->update([
                        'COMNT1_31' => $request->encabezado[0]['notas'],
                        'REASON_31' => $request->encabezado[0]['motivo'],
                        'TAX1_31'   => $request->encabezado[0]['total_iva'],
                        'LNETOT_31' => $request->encabezado[0]['total_bruto'],
                        'ORDDSC_31' => $request->encabezado[0]['total_descuento'],
                        'UDFKEY_31' => $request->encabezado[0]['total_retencion'],
                        'MSCAMT_31' => $request->encabezado[0]['total_seguro'],
                        'FRTAMT_31' => $request->encabezado[0]['total_flete'],
                        'TAXTOT_31' => $request->encabezado[0]['total_subtotal'],
                        'CUSTPO_31' => $request->encabezado[0]['ordencompra'],
                        'TAXCD1_31' => '',
                        'TAXABL_31' => 'N',
                        'TERMS_31'  => $CondicionPago[0]->CODE_36,
                    ]);

                foreach ($SinIVA as $Det) {
                    $limnnum = substr($Det['item'], 0, 2);
                    $delnum = substr($Det['item'], 2, 4);
                    DB::connection('MAXP')->table('Invoice_detail')
                        ->where('INVCE_32', '=', $Numero_de_factura)
                        ->where('LINNUM_32', '=', $limnnum)
                        ->where('DELNUM_32', '=', $delnum)
                        ->where('ORDNUM_32', '=', $Det['ordencompra'])
                        ->update([
                            'PRICE_32'      => $Det['preciounitario'],
                            'TAX1_32'       => $Det['iva'],
                            'TAXCDE1_32'    => '',
                            'TAXABL_32'     => 'N'
                        ]);
                }
                DB::commit();
                return response()->json(['Success' => 'Todo Ok']);
            }
            catch (\Exception $e){
                DB::rollback();
                echo json_encode(array(
                    'error' => array(
                        'msg' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'code2' =>$e->getLine(),
                    ),
                ));
            }
        }
    }

    public function FacturasWebService(Request $request)
    {
        $Facturas_Seleccionadas = $request->selected;
        $Facturas_Seleccionadas = json_decode($Facturas_Seleccionadas);

        // Estructura del XML
        $resultados = [];
        foreach ($Facturas_Seleccionadas as $Factura_seleccionada) {
            $objetoXML = new XMLWriter();
          //  $objetoXML->openURI("XML/Facturacion_electronica_Facturas.xml");
            $objetoXML->openMemory();
            $objetoXML->setIndent(true);
            $objetoXML->setIndentString("\t");
            $objetoXML->startDocument('1.0', 'utf-8');

            //Elemento Raiz del XML
            $objetoXML->startElement("root");

            $NumeroFactura = $Factura_seleccionada->numero;

            $Encabezado_Factura = DB::connection('MAX')->table('CIEV_V_FE')
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
                ->where('CIEV_V_FE.numero', '=', $NumeroFactura)->take(1)->get();

            // esta consulta muestra el detalle de los items de cada factura
            $Items_Factura = DB::connection('MAX')->table('CIEV_V_FE_FacturasDetalladas')
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
                ->where('CIEV_V_FE_FacturasDetalladas.factura', '=', $NumeroFactura)->get();

            $Configuracion = DB::table('fe_configs')->take(1)->get();

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
                $brutomasiva_factura     =  null;
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

                }
                else {
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

                if($encabezado->motivo == 27) {$tipo_fac_en = '02';}// exportaciones 27
                else {$tipo_fac_en = '01';}

                // determina si el tipo de operacion

             /*   if($tipo_fac_en == 02) {$tipo_operacion = '04';}
                if($tipo_fac_en == 01) {$tipo_operacion = '05';}
                if($encabezado->iva == 0) {$tipo_operacion = '03';}*/

                //Determina si la factura es a contado o a credito

                if($encabezado->dias == 0) {$metodo_pago = 1;}
                else {$metodo_pago = 2;}

                // determina el metodo de pago
                if($metodo_pago == 2)
                { $medio_pago = null;}
                else { $medio_pago = 10;}

                // valida el tipo de documento de identidad
                if ($encabezado->idtipodocumento == 31 )
                {
                    $tipo_documento_ide = 31;
                }
                if ($encabezado->idtipodocumento == 22){
                    $tipo_documento_ide = 42;
                }
                else{
                    $tipo_documento_ide = 13;
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
                if($encabezado->tipo_cliente == 'EX' || $encabezado->tipo_cliente == 'PN' ){
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
                if($encabezado->iva != 0){
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
                    if ($it->iva_item != 0) {
                        $id_impuesto = '01';
                    }

                    // porcentaje de impuesto
                    if ($id_impuesto == '01') {$factor = '19';}

                    if ($it->UM == 'UN') {$umed = '94';}
                    else {$umed = 'KGM';}

                    $id_item_iva = null;
                    if ($it->iva_item != null) {
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

    public function DescargarVersionGrafica(Request $request)
    {
        $Numero_Factura = $request->id;

        if (request()->ajax()) {
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
            $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
            $return = json_decode($return->return);

            $id_factible = $return->data[0]->DT_RowId;

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

    public function EstadoEnvioDianFacturacionElectronica(Request $request)
    {
        $id = $request->id;

        if (request()->ajax()) {
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


        /*$idDocumentoElectronico = DB::table('registro_facturacion_electronica')
            ->where('numero_factura','=',$Numero_Factura)
            ->select('id_factible')->get();

        $login1 = "jacanasv";
        $password = "Menteslocas0906*";
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
            'token'                     => $token,
            'iddocumentoelectronico'    => $idDocumentoElectronico[0]->id_factible,
        );

        $return = $client->obtenerEnvioDian($params);

        $resultados = json_decode($return->return);

        //cerramos sesion
        $params = array(
            'token' => $token
        );
        $logout = $client->cerrarSesion($params);
        $respuesta = json_decode($logout->return);

        return response()->json($resultados);*/
    }

    public function AuditoriaDian(Request $request)
    {
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
            'iddocumentoelectronico'      => 654925
        );

        $return = $client->obtenerTrazaSealMailCliente($params);

        dd($return);
    }

    public function ReenviarFacturas(Request $request)
    {
        $Facturas_Seleccionadas = $request->selected;


        $Archivos_pdf;


        foreach ($Facturas_Seleccionadas as $factura){

            $idDocumentoElectronico = DB::table('registro_facturacion_electronica')
                ->where('numero_factura','=',$factura)
                ->select('id_factible','numero_factura')->get();

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
                'token'                     => $token,
                'iddocumentoelectronico'    => $idDocumentoElectronico[0]->id_factible,
            );

            $Version_grafica = $client->descargarDocumentoElectronico_VersionGrafica($params);
            $Version_xml = $client->descargarDocumentoElectronico_XML($params);

            $Version_grafica = json_decode($Version_grafica->return);
            $Version_xml = json_decode($Version_xml->return);

            $Version_grafica = $Version_grafica->data->salida;



        /*    $nomPdf = '';
            $nomPdf .= "Factura_electronica_".$idDocumentoElectronico[0]->numero_factura.".pdf";
            $nomPdf = (string)$nomPdf;
            $Version_grafica = trim(str_replace('data:application/pdf;base64,', "", $Version_grafica) );
            $Version_grafica = str_replace( ' ', '+', $Version_grafica);
            $decodPdf = base64_decode($Version_grafica);
            file_put_contents($nomPdf, $decodPdf);*/


        /*    $decoded = base64_decode($Version_grafica);
            $file = public_path('Facturacion_electronica/'.$file);
            file_put_contents($file, $decoded);

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $file . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
            }*/

            $decoded = base64_decode($Version_grafica);
            $file = "Factura_electronica_".$idDocumentoElectronico[0]->numero_factura.".pdf";
            $file = public_path('Facturacion_electronica/'.$file);

            file_put_contents($file,$decoded);

            $realpath = '/Facturacion_electronica/'."Factura_electronica_".$idDocumentoElectronico[0]->numero_factura.".pdf";

            $Archivos_pdf = $realpath;


        }



        $subject = "TIENE UNA PROPUESTA PENDIENTE POR APROBAR";
        $for = "strike970124@gmail.com";
          /* Mail::send('mails.Facturacion_Electronica_Mail',$request->all(), function($msj) use($Archivos_pdf, $subject,$for){
            $msj->from("strike970124@gmail.com","Test EV-PIU");
            $msj->subject($subject);
            $msj->to($for);
            foreach($Archivos_pdf as $filePath){
                $msj->attach($filePath);
            }*/
        Swift_Preferences::getInstance()->setCacheType('disk')->setTempDir('/tmp');



        Mail::send('mails.Facturacion_Electronica_Mail',$request->all(), function($msj) use($Archivos_pdf, $subject,$for){
            $msj->to($for);
            $msj->subject($subject);
            $msj->from("strike970124@gmail.com","NombreQueApareceráComoEmisor");
            $msj->attach(Swift_Attachment::fromPath(public_path().$Archivos_pdf,'application/pdf'), array('as' => 'invoice', 'mime' => 'application/pdf'));

        });

    }



}
