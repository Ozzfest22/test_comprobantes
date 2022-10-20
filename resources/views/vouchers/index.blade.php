@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <a class="btn btn-success" href="{{route('vouchers.create')}}">Crear</a>

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
                            @foreach($vouchers as $voucher)
                            <tr>
                                <td hidden>{{$voucher->id}}</td>
                                <td>{{$voucher->voucher_serie}}</td>
                                <td>{{$voucher->client->name}}</td>
                                <td>{{$voucher->voucher_status->name}}</td>
                                <td>{{$voucher->voucher_date}}</td>
                                <td>
                                    <a href="{{route('vouchers.show',$voucher->id)}}" class="btn btn-success">Ver</a>
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