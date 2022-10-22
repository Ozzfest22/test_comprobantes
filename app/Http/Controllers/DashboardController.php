<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //select dayname(v.voucher_date) as day_v, sum(d.price * d.quantity) as sum_days 
    //from voucher v inner join voucher_detail d on v.id = d.id_voucher 
    //where v.voucher_date > now() - INTERVAL 0 day group by day_v;


    //select dayname(order_date) as day_order, sales as ventas from reporte where order_date > now() - interval 7 day;

    public function Index()
    {
        $dataBar = $this->barSales();

        $dataPie = $this->pieProducts();

        $dataBar2 = $this->salesClient();

        return view("dashboard.index", compact('dataBar', 'dataPie', 'dataBar2'));
    }

    public function salesClient()
    {
        $clientsSales = DB::select("CALL sp_salesclients");

        $dataBar2 = [];

        foreach ($clientsSales as $sale) {
            $dataBar2['label'][] = $sale->name;
            $dataBar2['data'][] = $sale->ventas;
        }

        $dataBar2['dataBar2'] = json_encode($dataBar2);

        return $dataBar2;
    }

    public function pieProducts()
    {
        $products = DB::select("CALL sp_masvendido");

        $dataPie = [];

        foreach ($products as $product) {
            $dataPie['label'][] = $product->name;
            $dataPie['data'][] = $product->cantidad;
        }

        $dataPie['dataPie'] = json_encode($dataPie);

        return $dataPie;
    }

    public function barSales()
    {
        $ventas = DB::select("CALL sp_reporte");

        $dataBar = [];

        foreach ($ventas as $venta) {
            $dataBar['label'][] = $venta->day_v;
            $dataBar['data'][] = $venta->sum_days;
        }

        $dataBar['dataBar'] = json_encode($dataBar);

        return $dataBar;
    }
}
