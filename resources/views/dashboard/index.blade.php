@extends('layouts.app')

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
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    $(document).ready(function() {
        const cData = JSON.parse(`<?php echo $dataBar; ?>`)

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
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        })
    });
</script>
<script>
    $(document).ready(function() {
        const cData = JSON.parse(`<?php echo $dataPie; ?>`)

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
@endsection