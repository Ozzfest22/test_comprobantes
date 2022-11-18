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
                    <h1>Reportes SS</h1>
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
                                <th>Comprobante</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Monto</th>
                                <th>Impuesto</th>
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
        $.datepicker.setDefaults($.datepicker.regional["es"]);


        $("#start_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
        $("#end_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });

        var user = "{{$creador}}"

        function cargar_datos(start_date = '', end_date = '') {
            $('#reportTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('reportss.index')}}",
                    data: {
                        start_date: start_date,
                        end_date: end_date
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    }, {
                        data: 'voucher_serie',
                        name: 'voucher_serie'
                    },
                    {
                        data: 'type_name',
                        name: 'type_name'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'voucher_date',
                        render: function(data, type, row, meta) {
                            return moment(row.voucher_date).format('YYYY-MM-DD');
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
                    {
                        data: 'igv',
                        name: 'igv'
                    }
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
                        targets: 5,
                        render: function(data) {
                            if (data == 'No Enviado') {
                                return `<span class="badge badge-dark">${data}</span>`;
                            } else {
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
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        className: 'btn-exportar-excel',
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar PDF',
                        filename: 'Reporte Ventas',
                        title: 'Reporte de Ventas ' + $("#start_date").val() + ' - ' + $("#end_date").val() + ' creador por ' + user,
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        className: 'btn-exportar-pdf',
                        customize: function(doc) {
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: 'center',
                                image: 'data:image/jpeg;base64,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'
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Reporte de Ventas',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7]
                        },
                        className: 'btn-exportar-print',
                    },
                    'pageLength'
                ]
            })
        }

        cargar_datos()

        $('#filter').click(function(e) {
            e.preventDefault();
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            if (start_date != '' && end_date != '') {
                $('#reportTable').DataTable().destroy();
                cargar_datos(start_date, end_date);
            } else {
                alert('Both Date is required');
            }
        });

        $('#reset').click(function(e) {
            e.preventDefault();
            $('#start_date').val('');
            $('#end_date').val('');
            $('#reportTable').DataTable().destroy();
            cargar_datos();
        });
    });
</script>
@stop