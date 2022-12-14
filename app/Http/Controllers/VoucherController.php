<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Product;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherDetail;
use App\Models\VoucherStatus;
use App\Models\VoucherType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VoucherRequest;
use App\Mail\VoucherMail;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use PDF;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$vouchers = Voucher::where('id_voucher_type','1')->get()->all();

        if($request->ajax()){
            $vouchers = Voucher::where('id_voucher_type','1')->with('client')->with('voucher_status')->with('products')->get();
            
            return DataTables::of($vouchers)
                ->addColumn('acciones', 'vouchers.actions')    
                ->rawColumns(['acciones'])   
                ->make(true);

                
        }
        
        return view('vouchers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        $products = Product::all();
        $currencies = Currency::pluck('name', 'id')->toArray();

        return view('vouchers.create', compact('clients', 'products', 'currencies'));
    }

    public function precio_ajax_b(Request $request)
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
    public function store(VoucherRequest $request)
    {
        //tipo_boleta
        $tipo = VoucherType::where('name', 'Boleta')->get('id')->first();

        //serie y numero
        $ultimaEntrada = Voucher::where('id_voucher_type','1');

        if (isset($ultimaEntrada)) {
            $numero = $ultimaEntrada->count();
            $numero++;
            $cantidad_registro = $numberFinal = str_pad($numero, 3, "0", STR_PAD_LEFT);
            $codigo_guia = 'B' . $cantidad_registro;
        } else {
            $codigo_guia = "B001";
            $numberFinal = "001";
        }

        $serie = $codigo_guia;

        //fecha
        $actualDate = Carbon::now()->toDateTimeString();

        //estado
        $status = VoucherStatus::where('name', 'No Enviado')->get('id')->first();
        //moneda
        $currency = $request->get('currency_voucher');
        //compa??ia
        $company = Company::all()->first();
        //usuario
        $user = Auth::id();
        //cliente
        $clientName = $request->client_name;
        $name = strstr($clientName, ' | ', true);
        $client_find = Client::where('id', $name)->first();

        //Voucher
        $voucher = new Voucher();
        $voucher->id_voucher_type = $tipo->id;
        $voucher->voucher_serie = $serie;
        $voucher->voucher_number = $numberFinal;
        $voucher->voucher_date = $actualDate;
        $voucher->id_voucher_status = $status->id;
        $voucher->id_currency = $currency;
        $voucher->id_companie = $company->id;
        $voucher->id_user = $user;
        $voucher->id_client = $client_find->id;
        

        //contador de registros y detalle
        $products = $request->input('product',[]);
        $quantities = $request->input('cantidad',[]);
        $prices = $request->input('precio',[]);
        $cantidad = count($request->product);
        if($cantidad != 0){
            $voucher->save();
            for($product = 0; $product < count($products); $product++){
                $product_name = Product::where('name', $request->product[$product])->first()->id;

                $voucher->products()->attach($product_name, ['quantity' => $quantities[$product], 'price' => $prices[$product]]);
            }
        }

        return redirect()->route('vouchers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = Voucher::find($id);
        $voucher_details = $voucher->products()->where('id_voucher', $id)->get();
        $subtotal = 0;

        return view('vouchers.show', compact('voucher', 'voucher_details', 'subtotal'));
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

    public function voucher_send(Request $request)
    {
        $voucher = Voucher::find($request->id);
        $voucher_details = $voucher->products()->where('id_voucher', $request->id)->get();
        $data['voucher'] = $voucher;
        $data['voucher_details'] = $voucher_details;
        $data['subtotal'] = 0;
        $pdf = PDF::loadView('vouchers.show_pdf', $data);

        Mail::to($voucher->client->email)->send(new VoucherMail($pdf));

        return redirect()->route('vouchers.index');
    }
}
