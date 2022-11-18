<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->input('start_date') && $request->input('end_date')) {
                $start_date = Carbon::parse($request->input('start_date'));
                $end_date = Carbon::parse($request->input('end_date'));

                if ($end_date->greaterThan($start_date)) {
                    $general_vouchers = DB::table('voucher')
                        ->join('voucher_detail', 'voucher.id', '=', 'voucher_detail.id_voucher')
                        ->join('clients', 'voucher.id_client', '=', 'clients.id')
                        ->join('voucher_status', 'voucher.id_voucher_status', '=', 'voucher_status.id')
                        ->select('voucher.id', 'voucher.voucher_serie', 'clients.name as client_name', 'voucher.voucher_date', 'voucher_status.name as status_name', DB::raw('SUM(voucher_detail.price * voucher_detail.quantity) as monto'))
                        //->where('voucher.id_voucher_type', '=', '2')
                        //->whereDay('voucher.voucher_date','=', date('d'))
                        ->whereBetween('voucher.voucher_date', [$start_date, $end_date])
                        ->groupBy('voucher.id', 'voucher.voucher_serie', 'client_name', 'voucher_date', 'status_name')
                        ->get();
                } else {
                    $general_vouchers = DB::table('voucher')
                        ->join('voucher_detail', 'voucher.id', '=', 'voucher_detail.id_voucher')
                        ->join('clients', 'voucher.id_client', '=', 'clients.id')
                        ->join('voucher_status', 'voucher.id_voucher_status', '=', 'voucher_status.id')
                        ->select('voucher.id', 'voucher.voucher_serie', 'clients.name as client_name', 'voucher.voucher_date', 'voucher_status.name as status_name', DB::raw('SUM(voucher_detail.price * voucher_detail.quantity) as monto'))
                        //->where('voucher.id_voucher_type', '=', '2')
                        //->whereDay('voucher.voucher_date','=', date('d'))
                        ->groupBy('voucher.id', 'voucher.voucher_serie', 'client_name', 'voucher_date', 'status_name')
                        ->get();
                }
            } else {
                $general_vouchers = DB::table('voucher')
                    ->join('voucher_detail', 'voucher.id', '=', 'voucher_detail.id_voucher')
                    ->join('clients', 'voucher.id_client', '=', 'clients.id')
                    ->join('voucher_status', 'voucher.id_voucher_status', '=', 'voucher_status.id')
                    ->select('voucher.id', 'voucher.voucher_serie', 'clients.name as client_name', 'voucher.voucher_date', 'voucher_status.name as status_name', DB::raw('SUM(voucher_detail.price * voucher_detail.quantity) as monto'))
                    //->where('voucher.id_voucher_type', '=', '2')
                    //->whereDay('voucher.voucher_date','=', date('d'))
                    ->groupBy('voucher.id', 'voucher.voucher_serie', 'client_name', 'voucher_date', 'status_name')
                    ->get();
            }

            return response()->json([
                'general_vouchers' => $general_vouchers
            ]);
        }

        return view('reports.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
