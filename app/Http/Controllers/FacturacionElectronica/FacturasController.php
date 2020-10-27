<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use SoapClient;
use XMLWriter;
use Yajra\DataTables\DataTables;
use App\Models\facturacion_electronica\facturas\Encabezado;

class FacturasController extends Controller
{
    /**
     * Muestra una lista de faturas.
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request){

        $from_date  = Carbon::now()->format('Y-m-d 00:00:00');
        $to_date    = Carbon::now()->format('Y-m-d 23:59:59');

        if (request()->wantsJson()) {
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
                    ->whereBetween('fecha', array($request->from_date, $request->to_date))
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc', '=', 'CU')
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get();
            }else{
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
                    ->whereBetween('fecha', array($from_date, $to_date))
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc', '=', 'CU')
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get();
            }
            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-right">'.'<a href="/aplicaciones/facturacion_electronica/factura/'.$row->id.'/edit" class="btn btn-sm" id="edit-fac"><i class="fas fa-edit" style="color: #3085d6"></i></a>';
                    $btn = $btn.'<button class="btn btn-sm download-vg" id="'.$row->id.'"><i class="fas fa-file-pdf" style="color: #FF0000"></i></button>';
                    $btn = $btn. '<button class="btn btn-sm details-control"><i class="fas fa-info" style="color: #00dc94"></i></button> </div>';
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
        return view('aplicaciones.facturacion_electronica.facturas.index');
    }


    /**
     * Generacion de archivos XML actualmente v3.0.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generar_archivo_xml(Request $request){

        $facturas_seleccionadas = $request->selected;
        $facturas_seleccionadas = json_decode($facturas_seleccionadas);

        $objetoXML = new XMLWriter();
        $objetoXML->openURI("factura_electronica.xml");
        $objetoXML->openMemory();
        $objetoXML->setIndent(true);
        $objetoXML->setIndentString("\t");
        $objetoXML->startDocument('1.0', 'utf-8');

        $objetoXML->startElement("root");

        foreach ($facturas_seleccionadas as $factura) {

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
                ->where('CIEV_V_FE.numero', '=', $factura->numero)
                ->take(1)
                ->get();

            $detalle = DB::connection('MAX')
                ->table('CIEV_V_FE_FacturasDetalladas')
                ->select('factura',
                    'codigoproducto', 'descripcionproducto', 'OC', 'item','Marca',
                    'cantidad', 'precio', 'precioUSD', 'totalitem', 'totalitemUSD',
                    'iva as iva_item', 'valormercancia', 'Desc_Item', 'UM', 'base',
                    'bruto_usd', 'posicionarancelaria', 'fletes_usd', 'seguros_usd', 'ARTE')
                ->where('factura', '=', $factura->numero)
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
                    if (trim($item->posicionarancelaria) != ''){
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
                    $notas_item = DB::connection('MAX')
                        ->table('CIEV_V_NotasFacturas')
                        ->where('Factura','=', $factura->numero)
                        ->where('item', '=', $item->item)
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
        }
        $objetoXML->endDocument();// Final del documento
        $cadenaXML = $objetoXML->outputMemory();

        file_put_contents('factura_electronica.xml', $cadenaXML);

        return response()->json('terminado');
    }


    /**
     * Vista para la edicion de factura.
     *
     * @param $numero_factura
     * @return Factory|RedirectResponse|View
     * @throws \SoapFault
     */
    public function edit($numero_factura){

        try {
            $factura = Encabezado::where('NUMERO', '=', $numero_factura)
            ->with('detalle', 'cliente')
            ->first();

            $motivos = DB::connection('MAXP')
                ->table('Code_Master')
                ->where('CDEKEY_36','=','REAS')
                ->get();

            $condicion_pago = DB::connection('MAXP')
                ->table('Code_Master')
                ->where('Code_Master.CDEKEY_36','=','TERM')
                ->get();

            return view('aplicaciones.facturacion_electronica.facturas.edit',
                compact('factura', 'motivos', 'condicion_pago'));

        }catch (Exception $e){
          dd($e);
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }


    /**
     * Guarda factura previamente editada.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function guardar_factura_edit(Request $request){
        if ($request->ajax()){
            $num_factura = '00'.$request->encabezado['factura'];
            $items = $request->items;

            DB::connection('MAXP')->beginTransaction();
            try {
                if ($request->encabezado['iva'] > 0){
                    DB::connection('MAXP')
                        ->table('Invoice_master')
                        ->where('INVCE_31', '=', $num_factura)
                        ->update([
                            'COMNT1_31' => $request->encabezado['notas'] ?? " ",
                            'REASON_31' => $request->encabezado['motivo'],
                            'TAX1_31'   => $request->encabezado['iva'],
                            'LNETOT_31' => $request->encabezado['bruto'],
                            'ORDDSC_31' => $request->encabezado['descuento'],
                            'UDFKEY_31' => $request->encabezado['retencion'],
                            'MSCAMT_31' => $request->encabezado['seguro'],
                            'FRTAMT_31' => $request->encabezado['flete'],
                            'TAXTOT_31' => $request->encabezado['subtotal'],
                            'CUSTPO_31' => $request->encabezado['oc'],
                            'TAXCD1_31' => 'IVA-V19',
                            'TAXABL_31' => 'Y',
                            'TERMS_31'  => $request->encabezado['condicion_pago'],
                        ]);

                    foreach ($items as $item){
                        $id_reg = $item['id_reg'];
                        $id_reg = explode('-', $id_reg);
                        $limnnum = substr($id_reg[2], 0, 2);
                        $delnum = substr($id_reg[2], 2, 4);

                        DB::connection('MAXP')
                            ->table('Invoice_detail')
                            ->where('INVCE_32', '=', $num_factura)
                            ->where('LINNUM_32', '=', $limnnum)
                            ->where('DELNUM_32', '=', $delnum)
                            ->where('ORDNUM_32', '=', $request->encabezado['ov'])
                            ->update([
                                'PRICE_32'      => floatval($item['precio_uni']),
                                'TAX1_32'       => floatval($item['iva_item']),
                                'TAXCDE1_32'    => 'IVA-V19',
                                'TAXABL_32'     => 'Y'
                            ]);
                    }
                }else{
                    DB::connection('MAXP')
                        ->table('Invoice_master')
                        ->where('INVCE_31', '=', $num_factura)
                        ->update([
                            'COMNT1_31' => $request->encabezado['notas'],
                            'REASON_31' => $request->encabezado['motivo'],
                            'TAX1_31'   => $request->encabezado['iva'],
                            'LNETOT_31' => $request->encabezado['bruto'],
                            'ORDDSC_31' => $request->encabezado['descuento'],
                            'UDFKEY_31' => $request->encabezado['retencion'],
                            'MSCAMT_31' => $request->encabezado['seguro'],
                            'FRTAMT_31' => $request->encabezado['flete'],
                            'TAXTOT_31' => $request->encabezado['subtotal'],
                            'CUSTPO_31' => $request->encabezado['oc'],
                            'TAXCD1_31' => '',
                            'TAXABL_31' => 'N',
                            'TERMS_31'  => $request->encabezado['condicion_pago'],
                        ]);

                    foreach ($items as $item){
                        $id_reg = $item['id_reg'];
                        $id_reg = explode('-', $id_reg);
                        $limnnum = substr($id_reg[2], 0, 2);
                        $delnum = substr($id_reg[2], 2, 4);

                        DB::connection('MAXP')
                            ->table('Invoice_detail')
                            ->where('INVCE_32', '=', $num_factura)
                            ->where('LINNUM_32', '=', $limnnum)
                            ->where('DELNUM_32', '=', $delnum)
                            ->where('ORDNUM_32', '=', $request->encabezado['oc'])
                            ->update([
                                'PRICE_32'      => $item['precio_uni'],
                                'TAX1_32'       => $item['iva_item'],
                                'TAXCDE1_32'    => '',
                                'TAXABL_32'     => 'N'
                            ]);
                    }
                }
                 $fac_max = DB::connection('MAXP')
                     ->table('Invoice_master')
                     ->where('INVCE_31', '=', $num_factura)
                     ->get('TAX1_31')
                     ->first();


                /*Si se agrega iva o se actualiza */
                if($request->encabezado['iva'] > 0  &&  $request->encabezado['iva'] != $fac_max){
                    $doc = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->get();


                    $registro_iva = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('ACCOUNT_58','=','24080507') /* 53*/
                        ->get();


                    $detalle = DB::connection('MAXP')
                        ->table('Invoice_detail')
                        ->where('INVCE_32', '=', $num_factura)
                        ->first();


                    DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('MAXGL_58','=','DACCTREC A')
                        ->update([
                            'DEBIT_58'      =>  $request->encabezado['total_factura'],
                            'ORDEBIT_58'    =>  $request->encabezado['total_factura'],
                        ]);


                    if (sizeof($registro_iva) === 0){
                        DB::connection('MAXP')
                            ->table('Work_General_Ledger')
                            ->insert([
                                'TNXDTE_58'         =>  $request->encabezado['fecha_factura'],
                                'FILL01_58'         =>  ' ',
                                'ACCOUNT_58'        =>  '24080507',
                                'POSTDTE_58'        =>  $request->encabezado['fecha_factura'],
                                'FILL02_58'         =>  ' ',
                                'FROM_58'           =>  'AR',
                                'BATCH_58'          =>  $doc[0]->BATCH_58, /* CONSULTARLO  CON DOC ID*/
                                'RECNUM_58'         =>  intval($doc->max('RECNUM_58')) + 1,  /* CONSULTAR CONSCUTIVO  DEL DOC ID*/
                                'TYPE_58'           =>  'D',
                                'MAXGL_58'          =>  'XIVA-V19',
                                'TNXCDE_58'         =>  '2',
                                'ORDER_58'          =>  $request->encabezado['ov'].$detalle->LINNUM_32.$detalle->DELNUM_32, /* NUMERO ORDEN DE VENTA MAS EL ITEM*/
                                'OPRSEQ_58'         =>  '0000',
                                'DOCID_58'          =>  $num_factura,
                                'CUSTVENID_58'      =>  $request->encabezado['codigo_cliente'],
                                'USRNAM_58'         =>  Auth::user()->username,
                                'POSTED_58'         =>  '2',
                                'UPDATED_58'        =>  'Y',
                                'DEBIT_58'          =>  '0',
                                'CREDIT_58'         =>  $request->encabezado['iva'],
                                'REFDES_58'         =>  ' ',
                                'INVCE_58'          =>  ' ',
                                'FOB_58'            =>  ' ',
                                'SHPVIA_58'         =>  ' ',
                                'TERMS_58'          =>  ' ',
                                'DISC_58'           =>  '0',
                                'DAYS_58'           =>  '000',
                                'DISCDY_58'         =>  '0',
                                'DAYOMN_58'         =>  '0',
                                'MAXBATCH_58'       =>  $doc[0]->MAXBATCH_58, /* CONSULTARLO  CON DOC ID*/
                                'USER_58'           =>  ' ',
                                'EXCRTE_58'         =>  '1',
                                'FIXVAR_58'         =>  ' ',
                                'CURR_58'           =>  ' ',
                                'MCOMP_58'          =>  ' ',
                                'MSITE_58'          =>  ' ',
                                'UDFKEY_58'         =>  ' ',
                                'UDFREF_58'         =>  $request->encabezado['bruto'], /* VALOR BRUTO DE LA FACTURA*/
                                'GOODS_58'          =>  $request->encabezado['bruto'],/* VALOR BRUTO DE LA FACTURA*/
                                'ORDEBIT_58'        =>  '0',
                                'ORCREDIT_58'       =>  $request->encabezado['iva'],
                                'XDFINT_58'         =>  '0',
                                'XDFFLT_58'         =>  '0',
                                'XDFBOL_58'         =>  ' ',
                                'XDFDTE_58'         =>  null,
                                'XDFTXT_58'         =>  ' ',
                                'FILLER_58'         =>  ' ',
                                'Createdby'         =>  Auth::user()->username,
                                'CreationDate'      =>  Carbon::now(),
                                'ModifiedBy'        =>  Auth::user()->username,
                                'ModificationDate'  =>  Carbon::now(),
                                'CLASS_58'          =>  ' ',
                                'TNXID_58'          =>  '0'
                            ]);
                    }else{
                        DB::connection('MAXP')
                            ->table('Work_General_Ledger')
                            ->where('DOCID_58', '=', $num_factura)
                            ->where('ACCOUNT_58','=','24080507')
                            ->update([
                                'CREDIT_58'         =>  $request->encabezado['iva'],
                                'UDFREF_58'         =>  $request->encabezado['bruto'], /* VALOR BRUTO DE LA FACTURA*/
                                'GOODS_58'          =>  $request->encabezado['bruto'],/* VALOR BRUTO DE LA FACTURA*/
                                'ORCREDIT_58'       =>  $request->encabezado['iva'],
                                'ModifiedBy'        =>  Auth::user()->username,
                                'ModificationDate'  =>  Carbon::now(),
                            ]);
                    }
                }elseif ($request->encabezado['iva'] == 0){
                    $registro_iva = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('ACCOUNT_58','=','24080507')
                        ->get();

                    if (sizeof($registro_iva) > 0){
                        DB::connection('MAXP')
                            ->table('Work_General_Ledger')
                            ->where('DOCID_58', '=', $num_factura)
                            ->where('ACCOUNT_58','=','24080507')
                            ->delete();
                    }
                }


                if ($request->encabezado['descuento'] > 0 ){
                    $doc = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->get();

                    $doc_account = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('ACCOUNT_58', 'like', '41%')
                        ->first();

                    $registro_descuento = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('ACCOUNT_58','=',$doc_account->ACCOUNT_58)
                        ->where('MAXGL_58','=','DDISCACT A')
                        ->get();


                    $detalle = DB::connection('MAXP')
                        ->table('Invoice_detail')
                        ->where('INVCE_32', '=', $num_factura)
                        ->first();

                    if (sizeof($registro_descuento) == 0){
                        DB::connection('MAXP')
                            ->table('Work_General_Ledger')
                            ->insert([
                                'TNXDTE_58'         =>  $request->encabezado['fecha_factura'],
                                'FILL01_58'         =>  ' ',
                                'ACCOUNT_58'        =>  $doc_account->ACCOUNT_58,
                                'POSTDTE_58'        =>  $request->encabezado['fecha_factura'],
                                'FILL02_58'         =>  ' ',
                                'FROM_58'           =>  'AR',
                                'BATCH_58'          =>  $doc[0]->BATCH_58, /* CONSULTARLO  CON DOC ID*/
                                'RECNUM_58'         =>  intval($doc->max('RECNUM_58')) + 1,  /* CONSULTAR CONSCUTIVO  DEL DOC ID*/
                                'TYPE_58'           =>  'D',
                                'MAXGL_58'          =>  'DDISCACT A',
                                'TNXCDE_58'         =>  '0',
                                'ORDER_58'          =>  $request->encabezado['ov'].$detalle->LINNUM_32.$detalle->DELNUM_32, /* NUMERO ORDEN DE VENTA MAS EL ITEM*/
                                'OPRSEQ_58'         =>  '0000',
                                'DOCID_58'          =>  $num_factura,
                                'CUSTVENID_58'      =>  $request->encabezado['codigo_cliente'],
                                'USRNAM_58'         =>  Auth::user()->username,
                                'POSTED_58'         =>  '2',
                                'UPDATED_58'        =>  'Y',
                                'DEBIT_58'          =>  $request->encabezado['descuento'],
                                'CREDIT_58'         =>  '0',
                                'REFDES_58'         =>  ' ',
                                'INVCE_58'          =>  ' ',
                                'FOB_58'            =>  ' ',
                                'SHPVIA_58'         =>  ' ',
                                'TERMS_58'          =>  ' ',
                                'DISC_58'           =>  '0',
                                'DAYS_58'           =>  '000',
                                'DISCDY_58'         =>  '0',
                                'DAYOMN_58'         =>  '0',
                                'MAXBATCH_58'       =>  $doc[0]->MAXBATCH_58, /* CONSULTARLO  CON DOC ID*/
                                'USER_58'           =>  ' ',
                                'EXCRTE_58'         =>  '1',
                                'FIXVAR_58'         =>  ' ',
                                'CURR_58'           =>  ' ',
                                'MCOMP_58'          =>  ' ',
                                'MSITE_58'          =>  ' ',
                                'UDFKEY_58'         =>  ' ',
                                'UDFREF_58'         =>  $request->encabezado['bruto'], /* VALOR BRUTO DE LA FACTURA*/
                                'GOODS_58'          =>  $request->encabezado['bruto'],/* VALOR BRUTO DE LA FACTURA*/
                                'ORDEBIT_58'        =>  $request->encabezado['descuento'],
                                'ORCREDIT_58'       =>  '0',
                                'XDFINT_58'         =>  '0',
                                'XDFFLT_58'         =>  '0',
                                'XDFBOL_58'         =>  ' ',
                                'XDFDTE_58'         =>  null,
                                'XDFTXT_58'         =>  ' ',
                                'FILLER_58'         =>  ' ',
                                'Createdby'         =>  Auth::user()->username,
                                'CreationDate'      =>  Carbon::now(),
                                'ModifiedBy'        =>  Auth::user()->username,
                                'ModificationDate'  =>  Carbon::now(),
                                'CLASS_58'          =>  ' ',
                                'TNXID_58'          =>  '0'
                            ]);
                    }else{
                        DB::connection('MAXP')
                            ->table('Work_General_Ledger')
                            ->where('DOCID_58', '=', $num_factura)
                            ->where('ACCOUNT_58','=',$doc_account->ACCOUNT_58)
                            ->where('MAXGL_58','=','DDISCACT A')
                            ->update([
                                'DEBIT_58'          =>  $request->encabezado['descuento'],
                                'UDFREF_58'         =>  $request->encabezado['bruto'], /* VALOR BRUTO DE LA FACTURA*/
                                'GOODS_58'          =>  $request->encabezado['bruto'],/* VALOR BRUTO DE LA FACTURA*/
                                'ORDEBIT_58'        =>  $request->encabezado['descuento'],
                                'ModifiedBy'        =>  Auth::user()->username,
                                'ModificationDate'  =>  Carbon::now(),
                            ]);
                    }
                }elseif ($request->encabezado['descuento'] == 0){
                    $doc_account = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('ACCOUNT_58', 'like', '41%')
                        ->first();

                    $registro_descuento = DB::connection('MAXP')
                        ->table('Work_General_Ledger')
                        ->where('DOCID_58', '=', $num_factura)
                        ->where('ACCOUNT_58','=',$doc_account->ACCOUNT_58)
                        ->get();


                    if (sizeof($registro_descuento) > 0){
                        DB::connection('MAXP')
                            ->table('Work_General_Ledger')
                            ->where('DOCID_58', '=', $num_factura)
                            ->where('ACCOUNT_58','=',$doc_account->ACCOUNT_58)
                            ->delete();
                    }
                }

                DB::connection('MAXP')->commit();
                return response()->json('Documento actualizado!', 200);
            }catch (Exception $e){
                DB::connection('MAXP')->rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Calcula la retencion en la fuente.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function calcular_retencion(Request $request){
        if ($request->ajax()){
            try {
                $date = Carbon::parse($request->fecha)->format("Y");
                $tipo_cliente = $request->tc;
                $motivo = $request->motivo;
                $iva = $request->iva;
                $subtotal = $request->subtotal;

                if ($motivo == 24){
                    $parametros_rte = DB::table('parametros_retenciones')
                        ->where('año','=', $date)
                        ->where('tipo_retencion', '=','serv')
                        ->first();
                }else{
                    $parametros_rte = DB::table('parametros_retenciones')
                        ->where('año','=', $date)
                        ->where('tipo_retencion', '=','prod')
                        ->first();
                }

                $resultado= 0;
                if ($motivo == 24 && $tipo_cliente == "RC" || $tipo_cliente == "CI" && $iva > 0 && $subtotal > $parametros_rte->base){

                    $resultado = $subtotal * 4/100;

                }elseif ($tipo_cliente == "RC" || $tipo_cliente == "CI" && $iva > 0 && $subtotal > $parametros_rte->base){
                    $resultado = $subtotal * 2.5/100;
                }else{
                    $resultado = 0;
                }

                return response()->json($resultado, 200);
            }catch (Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



}
