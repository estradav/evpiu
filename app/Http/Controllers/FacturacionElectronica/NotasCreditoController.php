<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use XMLWriter;
use Yajra\DataTables\DataTables;

class NotasCreditoController extends Controller
{

    /**
     * Muestra una lista de notas credito
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        $fromdate = Carbon::now()->format('Y-m-d 00:00:00');
        $todate = Carbon::now()->format('Y-m-d 23:59:59');

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = DB::connection('MAX')
                    ->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero', '=', 'CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE_FacturasTotalizadas.bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.OC as OC',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente',
                        'CIEV_V_FE.codigo_alterno as cod_alter',
                        'CIEV_V_FE.emailcontacto as emailcontacto',
                        'CIEV_V_FE.nombres as nombres'
                    )
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc','=','CR')
                    ->whereBetween('fecha', array($request->from_date, $request->to_date))
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get();
            }else {
                $data = DB::connection('MAX')
                    ->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero', '=', 'CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE_FacturasTotalizadas.bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.OC',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente',
                        'CIEV_V_FE.codigo_alterno as cod_alter',
                        'CIEV_V_FE.emailcontacto as emailcontacto',
                        'CIEV_V_FE.nombres as nombres'

                    )
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc','=','CR')
                    ->whereBetween('fecha', array($fromdate, $todate))
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get();
            }
            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/nc/'.$row->id.'/edit" class="btn btn-sm btn-outline-light" id="edit-fac"><i class="fas fa-edit" style="color: #3085d6"></i></a>';
                    $btn = $btn.'<button class="btn btn-sm btn-outline-light download-vg" id="'.$row->id.'"><i class="fas fa-file-pdf" style="color: #FF0000"></i></button>';
                    $btn = $btn.'<button class="btn btn-sm details-control"><i class="fas fa-info" style="color: #00dc94"></i></button> </div>';
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
        return view('aplicaciones.facturacion_electronica.notas_credito.index');
    }


    /**
     * Genera archivo xml para nota credito
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function generar_archivo_xml(Request $request){
        $Notas_credito = $request->selected;
        $Notas_credito = json_decode($Notas_credito);

        $objetoXML = new XMLWriter();
        $objetoXML->openURI(public_path()."/notas_credito.xml");
        $objetoXML->openMemory();
        $objetoXML->setIndent(true);
        $objetoXML->setIndentString("\t");
        $objetoXML->startDocument('1.0', 'utf-8');

        $objetoXML->startElement("root");

        foreach ($Notas_credito as $nc) {
            $num = $nc->numero;

            $EncabezadoNc = DB::connection('MAX')->table('CIEV_V_FE')
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
                ->where('CIEV_V_FE.numero', '=', $num)->take(1)->get();

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



                if($enc->iva > 0 || $enc->tipo_cliente != 'EX') {
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
                    $objetoXML->text(number_format(abs($total_valor_iva),2,'.',''));
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                    $objetoXML->endElement();
                }



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


                    if($enc->tipo_cliente != 'EX' && $item->iva_item > 0){
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

                    if (trim($item->posicionarancelaria) != ''){
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
        }

        $objetoXML->endDocument();  // Final del documento

        $cadenaXML = $objetoXML->outputMemory();
        file_put_contents(public_path()."/notas_credito.xml", $cadenaXML);

        return response()->json();
    }
}
