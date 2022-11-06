@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <a class="btn btn-success" href="{{route('vouchers.create')}}">Crear</a>

                    <table class="table table-light" id="tableVouchers">
                        <thead class="thead-light">
                            <tr>
                                <th hidden>Id</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#tableVouchers').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('vouchers.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'voucher_serie',
                    name: 'voucher_serie'
                },
                {
                    data: 'client.name',
                    name: 'client.name'
                },
                {
                    data: 'voucher_status.name',
                    name: 'voucher_status.name'
                },
                {
                    data: 'voucher_date',
                    name: 'vocher_date'
                },
                {
                    data: 'acciones',
                    name: 'acciones'
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            responsive: true
        })
    });
</script>
@stop