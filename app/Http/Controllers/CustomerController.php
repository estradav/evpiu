<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index ()
    {
        set_time_limit(40); // tiempo maximo para realizar la consulta
        $customer=Customer::join('Customer_Types','Customer_Types.custyp_62','=','customer_master.custyp_23')
            ->join('tax_master','tax_master.taxcde_25','=', 'customer_master.txcde1_23')
            ->select('customer_master.custid_23','customer_master.name_23','customer_master.addr1_23',
                'customer_master.cntct_23','customer_types.desc_62 as tipo_contribuyente','tax_master.taxdes_25 as impuesto')
            ->take(500)->latest('customer_master.creationdate')->get();

        return view('max.clientes.index', compact('customer'));
    }


    public function show($customer)
    {
        $customer = DB::connection('sqlsrv_max')
            ->table('customer_master')
            ->leftJoin('customer_types', 'Customer_Types.custyp_62', '=', 'customer_master.custyp_23')
            ->leftJoin('tax_master','tax_master.taxcde_25','=', 'customer_master.txcde1_23')
            ->select('customer_master.custid_23','customer_master.name_23','customer_master.addr1_23',
                'customer_master.city_23','customer_master.state_23','customer_master.cntry_23',
                'customer_master.cntct_23','customer_master.phone_23','customer_master.email1_23',
                'customer_master.udfkey_23','customer_master.creationdate','customer_master.modificationdate',
                'customer_master.creationdate','customer_master.modificationdate','customer_master.modifiedby',
                'customer_types.desc_62 as tipo_contribuyente','tax_master.taxdes_25 as impuesto')
            ->where('customer_master.custid_23', '=', $customer)->limit('1')->get();

        return view('max.Clientes.show', compact('customer'));
    }
}
