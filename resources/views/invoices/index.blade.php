@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <a class="btn btn-success" href="{{route('invoices.create')}}">Crear</a>

                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th hidden>Id</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td hidden>{{$invoice->id}}</td>
                                <td>{{$invoice->voucher_serie}}</td>
                                <td>{{$invoice->client->name}}</td>
                                <td>{{$invoice->voucher_date}}</td>
                                <td>{{$invoice->voucher_status->name}}</td>
                                <td>
                                    <a href="{{route('invoices.show',$invoice->id)}}" class="btn btn-success">Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection