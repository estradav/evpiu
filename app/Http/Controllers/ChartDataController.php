<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Datetime;
use Illuminate\Support\Facades\DB;

class ChartDataController extends Controller
{
    /* Obtenemos la fecha  de la tabla usuarios y sacamos solo el mes */
    public function getAllMonths()
    {
        $month_array = array();
        $users_date = User::orderBy('created_at','asc')->pluck('created_at');
        $users_date = json_decode($users_date);
        if ( ! empty($users_date)){
            foreach ($users_date as $unformatted_date){
                $date = new \Datetime( $unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }


    /* contamos la cantidad de registros que hay por mes */
    public function getMonthlyUserCount($month)
    {
        $monthly_user_count = User::whereMonth('created_at', $month)->get()->count();
        return $monthly_user_count;
    }

    /* realizamos un arreglo para mostrar el nombre de los meses y poner la cantidad de registros en un foreach */
    public function  getMonthlyUserData()
    {
        $monthly_user_count_array = array();
        $month_array = $this->getAllMonths();
        $month_name_array = array();
        if (! empty($month_array)){
            foreach ( $month_array as $month_no => $month_name){
               $monthly_user_count = $this->getMonthlyUserCount($month_no);
               array_push($monthly_user_count_array, $monthly_user_count);
               array_push($month_name_array, $month_name);
            }
        }
        $max_no = max( $monthly_user_count_array);
        //$max = round(($max_no + 10/2)/10) * 10;
        $monthly_user_data_array = array(
            'months'    =>  $month_name_array,
            'User_Count_data'   =>  $monthly_user_count_array,
            //'Max'   => $max
        );
        return  $monthly_user_data_array;
    }


    /* INICIO  CANTIDAD DE FACTURAS POR MES EN UN PERIODO DE 1 AÑO   */
    public function getAllMonthsInvoice()
    {
        $month_array = array();
        $año = '2019';
        $invoice_date = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')->whereYear('CIEV_V_FacturasTotalizadasIntranet.fecha', $año)->orderBy('CIEV_V_FacturasTotalizadasIntranet.fecha','asc')
            ->pluck('CIEV_V_FacturasTotalizadasIntranet.fecha');
        $invoice_date = json_decode($invoice_date);
        if ( ! empty($invoice_date)){
            foreach ($invoice_date as $unformatted_date){
                $date = new \Datetime( $unformatted_date);
                $month_no = $date->format('m');
                $month_name = $date->format('M');
                $month_array[$month_no] = $month_name;
            }
        }
        return $month_array;
    }


    public function getMonthlyInvoiceCount($month)
    {
        $año = '2019';
        $monthly_invoice_count = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')->whereYear('CIEV_V_FacturasTotalizadasIntranet.fecha', $año)
            ->whereMonth('CIEV_V_FacturasTotalizadasIntranet.fecha',$month)->get()->count();

        return $monthly_invoice_count;
    }

    public function  getMonthlyInvoiceData()
    {
        $monthly_invoice_count_array = array();
        $month_array = $this->getAllMonthsInvoice();
        $month_name_array = array();
        if (! empty($month_array)){
            foreach ( $month_array as $month_no => $month_name){
                $monthly_invoice_count = $this->getMonthlyInvoiceCount($month_no);
                array_push($monthly_invoice_count_array, $monthly_invoice_count);
                array_push($month_name_array, $month_name);
            }
        }
        $monthly_invoice_data_array = array(
            'Invoice_months'    =>  $month_name_array,
            'Invoice_Count_data'   =>  $monthly_invoice_count_array,
        );
        return  $monthly_invoice_data_array;
    }
    /* FIN  CANTIDAD DE FACTURAS POR MES EN UN PERIODO DE 1 AÑO   */


    /* INICIO VENTAS POR MES EN UN PERIODO DE 1 AÑO  */

    public function getMonthlyInvoiceValue($month)
    {
        $año = '2019';
        $monthly_invoice_value = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')
            ->whereYear('CIEV_V_FacturasTotalizadasIntranet.FECHA', $año)
            ->whereMonth('CIEV_V_FacturasTotalizadasIntranet.FECHA',$month)
            ->whereIn('CIEV_V_FacturasTotalizadasIntranet.tipocliente',['PN','RC'])
            ->sum('CIEV_V_FacturasTotalizadasIntranet.subtotal');

        return $monthly_invoice_value;
    }

    public function getMonthlyInvoiceValueExp($month)
    {
        $año = '2019';
        $monthly_invoice_value_exp = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')
            ->whereYear('CIEV_V_FacturasTotalizadasIntranet.FECHA', $año)
            ->whereMonth('CIEV_V_FacturasTotalizadasIntranet.FECHA',$month)
            ->where('CIEV_V_FacturasTotalizadasIntranet.tipocliente','=','EX')
            ->sum('CIEV_V_FacturasTotalizadasIntranet.subtotal');

        return $monthly_invoice_value_exp;
    }


    public function  getMonthlyInvoiceDataValue()
    {
        $monthly_invoice_value_array = array();
        $monthly_invoice_value_exp_array = array();
        $month_array = $this->getAllMonthsInvoice();
        $month_name_array = array();
        if (! empty($month_array)){
            foreach ( $month_array as $month_no => $month_name){
                $monthly_invoice_value = $this->getMonthlyInvoiceValue($month_no);
                $monthly_invoice_value_exp = $this->getMonthlyInvoiceValueExp($month_no);
                array_push($monthly_invoice_value_array, number_format($monthly_invoice_value,0,'','') / 1000000);
                array_push($monthly_invoice_value_exp_array, number_format($monthly_invoice_value_exp,0,'','') / 1000000);
                array_push($month_name_array, $month_name);
            }
        }
        $monthly_invoice_data_array = array(
            'Invoice_value_months'          =>  $month_name_array,
            'Invoice_value_data'            =>  $monthly_invoice_value_array,
            'Invoice_value_data_exp'        =>  $monthly_invoice_value_exp_array
        );
        return  $monthly_invoice_data_array;
    }
    /* FIN VENTAS POR MES EN UN PERIODO DE 1 AÑO  */



    /* INICIO VENTAS POR AÑO EN UN PERIODO DE 3 AÑOS  */
/* Consulta las facturas por año y las suma dependiendo si es exportacion o si es nacional */
    public function getAllAgesInvoice()
    {
        $age_array = array();
        $invoice_age_date = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')->orderBy('CIEV_V_FacturasTotalizadasIntranet.FECHA','asc')
            ->pluck('CIEV_V_FacturasTotalizadasIntranet.FECHA');
        $invoice_age_date = json_decode($invoice_age_date);
        if ( ! empty($invoice_age_date)){
            foreach ($invoice_age_date as $unformatted_date){
                $date = new \Datetime( $unformatted_date);
                $age_no = $date->format('Y');
                $age_name = $date->format('Y');
                $age_array[$age_no] = $age_name;
            }
        }
        return $age_array;
    }

    public function getAgesInvoiceCount($year)
    {
        $age_invoice_count = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')
            ->WhereYear('CIEV_V_FacturasTotalizadasIntranet.FECHA',$year)
            ->whereIn('CIEV_V_FacturasTotalizadasIntranet.tipocliente',['PN','RC'])
            ->sum('CIEV_V_FacturasTotalizadasIntranet.subtotal');

        return $age_invoice_count;
    }

    public function getAgesInvoiceCountExp($year)
    {

        $ages_invoice_value_exp = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')
            ->whereYear('CIEV_V_FacturasTotalizadasIntranet.FECHA', $year)
            ->where('CIEV_V_FacturasTotalizadasIntranet.tipocliente','=','EX')
            ->sum('CIEV_V_FacturasTotalizadasIntranet.subtotal');

        return $ages_invoice_value_exp;
    }



    public function  getAgeInvoiceData()
    {
        $age_invoice_sum_array = array();
        $age_array = $this->getAllAgesInvoice();
        $age_name_array = array();
        $ages_invoice_value_exp_array = array();
        if (! empty($age_array)){
            foreach ( $age_array as $age_no => $age_name){
                $age_invoice_count = $this->getAgesInvoiceCount($age_no);
                $ages_invoice_value_exp = $this->getAgesInvoiceCountExp($age_no);
                array_push($age_invoice_sum_array, number_format($age_invoice_count,0,'','') / 1000000);
                array_push($ages_invoice_value_exp_array, number_format($ages_invoice_value_exp,0,'','') / 1000000);
                array_push($age_name_array, $age_name);
            }
        }
       /* $max_no = max( $age_invoice_count_array);
        $max = round(($max_no + 10/2)/10) * 10;*/
        $age_invoice_data_array = array(
            'Invoice_age'          =>  $age_name_array,
            'Invoice_sum_data'     =>  $age_invoice_sum_array,
            'Invoice_sum_data_exp' =>   $ages_invoice_value_exp_array
            //'Max'   => $max
        );

        return  $age_invoice_data_array;

    }
    /* FIN VENTAS POR AÑO EN UN PERIODO DE 3 AÑOS  */



/* INICIO VENTAS POR DIA EN UN PERIODO DE 30 DIAS  */

    public function getAllDaysInvoice()
    {
        $day_array = array();
        $invoice_day_date = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')->orderBy('CIEV_V_FacturasTotalizadasIntranet.FECHA','asc')
            ->where('CIEV_V_FacturasTotalizadasIntranet.FECHA','>=',Carbon::now()->subMonth())
            ->pluck('CIEV_V_FacturasTotalizadasIntranet.FECHA');
        $invoice_day_date = json_decode($invoice_day_date);
        if ( ! empty($invoice_day_date)){
            foreach ($invoice_day_date as $unformatted_date){
                $date = new \Datetime( $unformatted_date);
                $day_no = $date->format('d');
                $day_name = $date->format('d');
                $day_array[$day_no] = $day_name;
            }
        }
        return $day_array;
    }

    public function getDaysInvoiceCount($day)
    {
        $day_invoice_count = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')
            ->WhereDay('CIEV_V_FacturasTotalizadasIntranet.FECHA',$day)
            ->whereIn('CIEV_V_FacturasTotalizadasIntranet.tipocliente',['PN','RC'])
            ->sum('CIEV_V_FacturasTotalizadasIntranet.subtotal');

        return $day_invoice_count;
    }

    public function getDaysInvoiceCountEx($day)
    {
        $day_invoice_count_ex = DB::connection('MAX')->table('CIEV_V_FacturasTotalizadasIntranet')
            ->WhereDay('CIEV_V_FacturasTotalizadasIntranet.FECHA',$day)
            ->where('CIEV_V_FacturasTotalizadasIntranet.tipocliente','=','EX')
            ->sum('CIEV_V_FacturasTotalizadasIntranet.subtotal');

        return $day_invoice_count_ex;
    }


    public function  getDayInvoiceData()
    {
        $day_invoice_sum_array = array();
        $day_invoice_sum_array_ex = array();
        $day_array = $this->getAllDaysInvoice();
        $day_name_array = array();

        if (! empty($day_array)){
            foreach ( $day_array as $day_no => $day_name){
                $day_invoice_count = $this->getDaysInvoiceCount($day_no);
                $day_invoice_count_ex = $this->getDaysInvoiceCountEx($day_no);
                array_push($day_invoice_sum_array, number_format($day_invoice_count,0,'','') / 1000000);
                array_push($day_invoice_sum_array_ex, number_format($day_invoice_count_ex,0,'','') / 1000000);
                array_push($day_name_array, $day_name);
            }
        }

        $day_invoice_data_array = array(
            'Invoice_day'           =>  $day_name_array,
            'Invoice_day_sum_data'  =>  $day_invoice_sum_array,
            'Invoice_day_sum_data_exp'  => $day_invoice_sum_array_ex

        );

        return  $day_invoice_data_array;

    }
    /* FIN VENTAS POR DIA EN UN PERIODO DE 30 DIAS  */
}
