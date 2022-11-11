@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="container">
    <div class="">
        <div class="">
            <br>
            <div class="card">
                <div class="card-header">
                    <h1>Reportes</h1>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="start_date" placeholder="Fecha inicio" readonly>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info text-white" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="end_date" placeholder="Fecha final" readonly>
                            </div>
                        </div>
                        <div class="col-sm">
                            <button id="filter" class="btn btn-success">Filtrar</button>
                            <button id="reset" class="btn btn-warning">Reiniciar</button>
                        </div>
                    </div>

                    <table class="table table-light mt-2 nowrap" style="width: 100%;" id="reportTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Monto</th>
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
    $.datepicker.setDefaults($.datepicker.regional["es"]);

    $(function() {
        $("#start_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
        $("#end_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
    });

    function fetch(start_date, end_date) {
        $.ajax({
            url: "{{route('reports.index')}}",
            type: "GET",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            dataType: 'json',
            success: function(data) {
                $("#reportTable").DataTable({
                    data: data.general_vouchers,
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
                            render: function(data, type, row, meta) {
                                return moment(row.voucher_date).format('DD-MM-YYYY');
                            },
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
                    ],
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
                    },
                    responsive: true,
                    columnDefs: [{
                            targets: 0,
                            visible: false
                        },
                        {
                            targets: 4,
                            render: function(data) {
                                if(data == 'No Enviado'){
                                    return `<span class="badge badge-dark">${data}</span>`;
                                }else{
                                    return `<span class="badge badge-success">${data}</span>`;
                                }
                                
                            }
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            text: 'Exportar Excel',
                            filename: 'Reporte Ventas',
                            title: '',
                            exportOptions: {
                                columns: [1, 2, 3, 4, ':visible']
                            },
                            className: 'btn-exportar-excel',
                        },
                        {
                            extend: 'pdfHtml5',
                            text: 'Exportar PDF',
                            filename: 'Reporte Ventas',
                            title: 'Reporte de Ventas',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5]
                            },
                            className: 'btn-exportar-pdf',
                            customize: function(doc) {
                                doc.content[1].margin = [100, 0, 100, 0]
                            }
                        },
                        {
                            extend: 'print',
                            title: 'Reporte de Ventas',
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5]
                            },
                            className: 'btn-exportar-print',
                        },
                        'pageLength'
                    ]
                })
            }
        })
    };

    fetch()

    $(document).on("click", "#filter", function(e) {
        e.preventDefault();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        if (start_date == "" || end_date == "") {
            alert("Both date required");
        } else {
            $('#reportTable').DataTable().destroy();
            fetch(start_date, end_date);
        }
    });

    $(document).on("click", "#reset", function(e) {
        e.preventDefault();
        $("#start_date").val(''); // empty value
        $("#end_date").val('');
        $('#reportTable').DataTable().destroy();
        fetch();
    });
</script>
@stop