@extends('layouts.app')

@section('title', 'Report')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <canvas id="stockChart"></canvas>
        </div>
        <div class="box">
            <canvas id="articleStockChart"></canvas>
        <div>
            <script>
            const ctx = document.getElementById('stockChart').getContext('2d');
            const stockChart = new Chart(ctx, {
                type: 'bar', // or 'pie', 'line', etc.
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Niveaux de Stock par Catégorie',
                        data: @json($chartData['data']),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
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
            });
            // Article Chart
            const articleCtx = document.getElementById('articleStockChart').getContext('2d');
            new Chart(articleCtx, {
                type: 'bar',
                data: {
                labels: @json($articleChartData['labels']),
                datasets: [{
                    label: 'Niveaux de Stock par Article',
                    data: @json($articleChartData['data']),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
            });
            </script>
        
    </div>
</div>
@endsection