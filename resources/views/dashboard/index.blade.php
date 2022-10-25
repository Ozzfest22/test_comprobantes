@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col">
                            <canvas id="chart-ventas"></canvas>
                        </div>
                        <div class="col">
                            <canvas id="pie-products"></canvas>
                        </div>
                        <div class="col">
                            <canvas id="chart-clients"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@stop
@section('css')

@stop

@section('js')
<script>
    $(document).ready(function() {

        var cData = <?php echo json_encode($dataBar) ?>;
        const ctx = document.getElementById('chart-ventas').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cData.label,
                datasets: [{
                    label: 'Ventas por dia',
                    data: cData.data,
                    backgroundColor: [
                        '#e1bee7',
                        '#ce93d8',
                        '#ba68c8',
                        '#ab47bc',
                        '#9c27b0',
                        '#8e24aa',
                        '#c5cae9',
                    ],
                    borderWidth: 1
                }]

            },
            options: {
                scales: {
                    y: {

                        beginAtZero: true

                    }
                }
            }
        })
    });
</script>
<script>
    $(document).ready(function() {
        var cData = <?php echo json_encode($dataPie) ?>;

        const ctx = document.getElementById('pie-products').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: cData.label,
                datasets: [{
                    label: 'Producto mas vendido',
                    data: cData.data,
                    backgroundColor: [
                        '#e1bee7',
                        '#ce93d8',
                        '#ba68c8',
                        '#ab47bc',
                        '#9c27b0',
                        '#8e24aa',
                        '#c5cae9',
                    ],
                    borderWidth: 1
                }]

            }
        })
    });
</script>
<script>
    $(document).ready(function() {
        var cData = <?php echo json_encode($dataBar2) ?>;

        const ctx = document.getElementById('chart-clients').getContext('2d');

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: cData.label,
                datasets: [{
                    label: 'Clientes con mas ventas',
                    data: cData.data,
                    backgroundColor: [
                        '#e1bee7',
                        '#ce93d8',
                        '#ba68c8',
                        '#ab47bc',
                        '#9c27b0',
                        '#8e24aa',
                        '#c5cae9',
                    ],
                    borderWidth: 1
                }]

            },
            options: {
                scales: {
                    y: {

                        beginAtZero: true

                    }
                }
            }
        })
    });
</script>
@stop