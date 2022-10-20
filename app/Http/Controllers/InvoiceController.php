<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\VoucherType;
use App\Models\Voucher;
use Illuminate\Support\Carbon;
use App\Models\VoucherStatus;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use App\Models\VoucherDetail;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Voucher::where('id_voucher_type', '2')->get()->all();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        $clients = Client::all();
        $currencies = Currency::pluck('name', 'id')->toArray();

        return view('invoices.create', compact('products', 'clients', 'currencies'));
    }

    public function precio_ajax_f(Request $request)
    {
        $articulo = $request->product;
        $producto = Product::where('name', $articulo)->first();
        return $producto->price;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //tipo_factura
        $tipo = VoucherType::where('name', 'Factura')->get('id')->first();

        //serie y numero
        $ultimaEntrada = Voucher::where('id_voucher_type', '2');

        if (isset($ultimaEntrada)) {
            $numero = $ultimaEntrada->count();
            $numero++;
            $cantidad_registro = $numberFinal = str_pad($numero, 3, "0", STR_PAD_LEFT);
            $codigo_guia = 'F' . $cantidad_registro;
        } else {
            $codigo_guia = "F001";
            $numberFinal = "001";
        }

        $serie = $codigo_guia;

        //fecha
        $actualDate = Carbon::now()->toDateTimeString();

        //estado
        $status = VoucherStatus::where('name', 'No Enviado')->get('id')->first();
        //moneda
        $currency = $request->get('currency_voucher');
        //compañia
        $company = Company::first()->get('id');
        //usuario
        $user = Auth::id();
        //cliente
        $clientName = $request->client_name;
        $name = strstr($clientName, ' | ', true);
        $client_find = Client::where('id', $name)->first();

        //Factura
        $voucher = new Voucher();
        $voucher->id_voucher_type = $tipo->id;
        $voucher->voucher_serie = $serie;
        $voucher->voucher_number = $numberFinal;
        $voucher->voucher_date = $actualDate;
        $voucher->id_voucher_status = $status->id;
        $voucher->id_currency = $currency;
        $voucher->id_companie = 1;
        $voucher->id_user = $user;
        $voucher->id_client = $client_find->id;

        //contador de registros y detalle
        $cantidad = count($request->product);
        if ($cantidad != 0) {
            $voucher->save();
            for ($i = 0; $i < $cantidad; $i++) {
                $product_name = Product::where('name', $request->product[$i])->first();

                $voucher_detail = new VoucherDetail();

                $voucher_detail->id_voucher = $voucher->id;
                $voucher_detail->id_prod = $product_name->id;
                $voucher_detail->quantity = $request->cantidad[$i];
                $voucher_detail->price = $request->precio[$i];
                $voucher_detail->save();
            }
        }

        return redirect()->route('invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Voucher::find($id);
        $invoice_details = VoucherDetail::where('id_voucher', $id)->get();
        $subtotal = 0;

        return view('invoices.show', compact('invoice', 'invoice_details', 'subtotal'));
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