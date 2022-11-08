@extends('adminlte::page')

@section('content')
<div class="container">
    <br>
    <div class="">
        <div class="">
            <div class="card">
                <div class="card-header">
                    <h1>Boletas</h1>
                </div>

                <div class="card-body">
                    <a class="btn btn-success mb-3" href="{{route('vouchers.create')}}">Crear</a>

                    <table class="table table-light mt-2 nowrap" style="width: 100%;" id="tableVouchers">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
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
                    data: 'id',
                    name: 'id'
                }, {
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
            responsive: true,
            columnDefs: [{
                targets: 0,
                visible: false
            }],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    text: 'Exportar Excel',
                    filename: 'Reporte Boletas',
                    title: '',
                    exportOptions: {
                        columns: [1, 2, 3, 4]
                    },
                    className: 'btn-exportar-excel',
                },
                {
                    extend: 'pdfHtml5',
                    text: 'Exportar PDF',
                    filename: 'Reporte Boletas',
                    title: 'Reporte de boletas',
                    exportOptions: {
                        columns: [1,2,3,4]
                    },
                    className: 'btn-exportar-pdf',
                    customize: function(doc){
                        doc.content[1].margin = [100, 0, 100, 0]
                    }
                },
                {
                    extend: 'print',
                    title: '',
                    exportOptions: {
                        columns: [1,2,3,4]
                    },
                    className: 'btn-exportar-print',
                },
                'pageLength'
            ]
        })
    });
</script>
@stop