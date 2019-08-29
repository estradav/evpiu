<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        set_time_limit(30); // tiempo maximo para realizar la consulta
        $invoice = DB::connection('sqlsrv_max')
            ->table('invoice_master')
            ->leftJoin('tax_master','tax_master.taxcde_25','=', 'invoice_master.taxcd1_31')
            ->select('invoice_master.ordnum_31','invoice_master.invce_31','invoice_master.name_31',
                'invoice_master.addr1_31','invoice_master.cntry_31','invoice_master.state_31',
                'invoice_master.city_31','invoice_master.cntct_31','invoice_master.phone_31',
                'tax_master.taxdes_25 as tax_type')
            ->take(1000)->latest('invoice_master.CreationDate')->get();

        return view('max.invoice.index', compact('invoice'));
    }


    public function show($invoice)
    {
        set_time_limit(10);
       $invoice = DB::connection('sqlsrv_max')
            ->table('invoice_master')
            ->leftJoin('tax_master','tax_master.taxcde_25','=', 'invoice_master.taxcd1_31')
            ->leftJoin('customer_master','customer_master.custid_23', '=', 'invoice_master.custid_31')
            ->select('invoice_master.ordnum_31','invoice_master.invce_31','invoice_master.name_31',
                'invoice_master.addr1_31','invoice_master.cntry_31','invoice_master.state_31','invoice_master.city_31',
                'invoice_master.cntct_31','invoice_master.phone_31','invoice_master.custid_31','invoice_master.creationdate',
                'tax_master.taxdes_25 as tax_type', 'customer_master.udfkey_23 as nit')
            ->where('invoice_master.ordnum_31', '=', $invoice)
            ->limit('1') // trae un solo registro , para evitar duplicados
            ->get();

//
//        $detail = DB::table('invoice_detail')
//            ->leftJoin('part_sales','part_sales.prtnum_29', '=', 'invoice_detail.prtnum_32')
//            ->select('invoice_detail.ordnum_32','part_sales.pmdes1_29 as descr_prod','part_sales.bomuom_29 as u_med')
//            ->where('invoice_detail.ordnum_32','=', $invoice)
//            ->unionAll($invoice)

        return view('max.invoice.show', compact('invoice'));
    }
 }
