@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="">
        <div class="">
            <div class="card">
                <div class="card-header">
                    <h1>Facturas</h1>
                </div>

                <div class="card-body">
                    <a class="btn btn-success mb-3" href="{{route('invoices.create')}}">Crear</a>

                    <table class="table table-light mt-2 nowrap" style="width: 100%;" id="invoicesTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Monto</th>
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
        $('#invoicesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('invoices.index')}}",
            dataType: 'json',
            type: "POST",
            columns: [{
                    data: 'id',
                    name: 'id'
                }, {
                    data: 'voucher_serie',
                    name: 'voucher_serie'
                },
                {
                    data: 'client_name',
                    name: 'client_name'
                },
                {
                    data: 'voucher_date',
                    name: 'voucher_date'
                },
                {
                    data: 'status_name',
                    name: 'status_name'
                },
                {
                    data: 'monto',
                    name: 'monto'
                }, 
                {
                    data: 'acciones',
                    name: 'acciones'
                }
            ],
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
            },
            responsive: true,
            columnDefs: [{
                targets: 0,
                visible: false
            }]
        });
    });
</script>
@stop