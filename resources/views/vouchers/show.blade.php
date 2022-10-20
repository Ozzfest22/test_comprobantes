@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{$voucher->company->ruc}}
                    <br>
                    {{$voucher->voucher_date}}
                    <br>
                    {{$voucher->voucher_serie}}
                    <br>
                    <br>
                    <address>
                        {{$voucher->company->name}}
                        <br>
                        {{$voucher->company->phone}}
                        <br>
                        {{$voucher->company->email}}
                    </address>
                    <br>
                    <br>
                    <br>
                    <address>
                        {{$voucher->client->name}}
                        <br>
                        {{$voucher->client->phone}}
                        <br>
                        {{$voucher->client->email}}
                    </address>
                    <br>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Codigo Producto</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th hidden></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($voucher_details as $voucher_detail)
                            <tr>
                                <td>{{$voucher_detail->product->cod_prod}}</td>
                                <td>{{$voucher_detail->product->name}}</td>
                                <td>{{$voucher_detail->price}}</td>
                                <td>{{$voucher_detail->quantity}}</td>
                                <td>{{$voucher->currency->gloss}} {{$voucher_detail->price * $voucher_detail->quantity}}</td>
                                <td hidden>{{$subtotal = $voucher_detail->price * $voucher_detail->quantity + $subtotal}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody>
                            <tr align="center">
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td colspan="2">{{$voucher->currency->gloss}} {{$subtotal}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection