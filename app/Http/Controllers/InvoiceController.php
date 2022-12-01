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
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$invoices = Voucher::where('id_voucher_type', '2')->get();

        if ($request->ajax()) {

            $invoices = DB::table('voucher')
                ->join('voucher_detail', 'voucher.id', '=', 'voucher_detail.id_voucher')
                ->join('clients', 'voucher.id_client', '=', 'clients.id')
                ->join('voucher_status', 'voucher.id_voucher_status', '=', 'voucher_status.id')
                ->select('voucher.id', 'voucher.voucher_serie', 'clients.name as client_name', 'voucher.voucher_date', 'voucher_status.name as status_name', DB::raw('SUM(voucher_detail.price * voucher_detail.quantity) as monto'))
                ->where('voucher.id_voucher_type', '=', '2')
//->whereDay('voucher.voucher_date','=', date('d'))
                ->groupBy('voucher.id', 'voucher.voucher_serie', 'client_name', 'voucher_date', 'status_name')
                ->get();

            return DataTables::of($invoices)
                ->addColumn('acciones', 'invoices.actions')
                ->rawColumns(['acciones'])
                ->make(true);
        }

        return view('invoices.index');
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
        $company = Company::first();

        return view('invoices.create', compact('products', 'clients', 'currencies', 'company'));
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
        $company = Company::all()->first();
        //usuario
        $user = Auth::id();
        //cliente
        $clientName = $request->client_name;
        $name = strstr($clientName, ' | ', true);
        $client_find = Client::where('id', $name)->first();

        //Factura
        $invoice = new Voucher();
        $invoice->id_voucher_type = $tipo->id;
        $invoice->voucher_serie = $serie;
        $invoice->voucher_number = $numberFinal;
        $invoice->voucher_date = $actualDate;
        $invoice->id_voucher_status = $status->id;
        $invoice->id_currency = $currency;
        $invoice->id_companie = $company->id;
        $invoice->id_user = $user;
        $invoice->id_client = $client_find->id;


        //forma numero 2
        $products = $request->input('product', []);
        $quantities = $request->input('cantidad', []);
        $prices = $request->input('precio', []);
        $cantidad = count($request->product);
        if ($cantidad != 0) {
            $invoice->save();
            for ($product = 0; $product < count($products); $product++) {
                $product_name = Product::where('name', $request->product[$product])->first()->id;

                $invoice->products()->attach($product_name, ['quantity' => $quantities[$product], 'price' => $prices[$product]]);
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
        //$invoice_details = VoucherDetail::where('id_voucher', $id)->get();
        $invoice_details = $invoice->products()->where('id_voucher', $id)->get();
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
