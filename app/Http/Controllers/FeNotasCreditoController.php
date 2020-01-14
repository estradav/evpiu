<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Not;
use XMLWriter;
use Yajra\DataTables\DataTables;


class FeNotasCreditoController extends Controller
{
    public function index(Request $request)
    {
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
                        'CIEV_V_FE.codigo_alterno as cod_alter')
                    ->where('CIEV_V_FacturasTotalizadas.tipodoc','=','CR')
                    ->whereBetween('fecha', array($request->from_date, $request->to_date))
                    ->orderBy('CIEV_V_FacturasTotalizadas.numero', 'asc')
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
                        'CIEV_V_FE.codigo_alterno as cod_alter')
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc','=','CR')
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->take(50)
                    ->get();
            }
            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-right">'.'<a href="/nc/'.$row->id.'/edit" class="btn btn-sm btn-outline-light" id="edit-fac"><i class="far fa-edit"></i></a>'.'</div>';
                    return $btn;
                })
                ->addColumn('selectAll', function($row){
                    $btn = '<input type="checkbox" class="checkboxes test" id="'.$row->id.'" name="'.$row->id.'">';
                    return $btn;
                })
                ->rawColumns(['opciones','selectAll'])
                ->make(true);
        }
        return view('FacturacionElectronica.NotasCredito.index');
    }

    public function CrearXmlnc (Request $request)
    {

        $Notas_credito = $request->selected;
        $Notas_credito = json_decode($Notas_credito);

        $objetoXML = new    XMLWriter();
        $objetoXML->openURI("XML/NotasCredito.xml");
        $objetoXML->openMemory();
        $objetoXML->setIndent(true);
        $objetoXML->setIndentString("\t");
        $objetoXML->startDocument('1.0', 'utf-8');

        $objetoXML->startElement("root");

        foreach ($Notas_credito as $nc) {
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
                    'CIEV_V_FacturasDetalladas.descuento')
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

                    // valida si el item es comprado o se da como regalo
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
                $objetoXML->endElement(); // Final del nodo raíz, "documento"
            }
        }

        $objetoXML->endDocument();  // Final del documento

        $cadenaXML = $objetoXML->outputMemory();
        file_put_contents('XML/NotasCredito.xml', $cadenaXML);

        return response()->json();
    }
}
