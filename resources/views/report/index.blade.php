@extends('layouts.app')

@section('title', 'Rapport')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <!-- Formulaire de filtrage -->
            <form method="GET" action="{{ route('report.index') }}">
                <label for="start_date">Date de début :</label>
                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}">
    
                <label for="end_date">Date de fin :</label>
                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}">
    
                <label for="category">Catégorie :</label>
                <select id="category" name="category">
                    <option value="">Toutes les catégories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
    
                <label for="quantity">Quantité minimale :</label>
                <input type="number" id="quantity" name="quantity" value="{{ request('quantity') }}" min="0">
    
                <button type="submit" class="btn" style="margin-top: 2%;">Filtrer</button>
            </form>
        </div>
        <div class="box">
            <h4>Les niveaux de stock</h4>
        
            <!-- Graphiques -->
            <div class="box">
                <canvas id="stockChart"></canvas>
            </div>
            <div class="box">
                <canvas id="articleStockChart"></canvas>
            </div>
        </div>
        <div class="box">
            <h4>Les mouvements de stock</h4>
            <div class="box">
                <canvas id="stockmov1"></canvas>
                <h6 style="margin-left: 30%">Les quantité des Article en fonction de Temps</h6>
            </div>
            <div class="box">
                <canvas id="stockmov2"></canvas>
                <h6 style="margin-left: 30%">Les mouvement de stock par articles</h6>
            </div>
            
            <div class="box">
                <canvas id="stockmov3"></canvas>
                <h6 style="margin-left: 30%">Percentage des entrée et les sortie</h6>
            </div>
            
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Graphique des niveaux de stock par catégorie
    const ctx = document.getElementById('stockChart').getContext('2d');
    const stockChart = new Chart(ctx, {
        type: 'bar',
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

    // Graphique des niveaux de stock par article
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
    function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
    }
    var lineChart = new Chart(document.getElementById('stockmov1'), {
    type: 'line',
    data: {
        labels: {!! json_encode($lineChartData['labels']) !!},
        datasets: [
            @foreach($lineChartData['data'] as $article => $quantities)
                {
                    label: '{{ $article }}',
                    data: {!! json_encode($quantities) !!},
                    fill: false,
                    borderColor: getRandomColor(),
                    tension: 0.1
                },
            @endforeach
        ]
    }
    
    });
    var barChart = new Chart(document.getElementById('stockmov2'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($barChartData['labels']) !!},
        datasets: [
            {
                label: 'Entrée',
                data: {!! json_encode($barChartData['Entrée']) !!},
                backgroundColor: 'rgba(0, 255, 0, 0.6)', // Green for Entrée
            },
            {
                label: 'Sortie',
                data: {!! json_encode($barChartData['Sortie']) !!},
                backgroundColor: 'rgba(255, 0, 0, 0.6)', // Red for Sortie
            }
        ]
    }
    });
    var pieChart = new Chart(document.getElementById('stockmov3'), {
    type: 'pie',
    data: {
        labels: {!! json_encode($pieChartData['labels']) !!},
        datasets: [{
            data: {!! json_encode($pieChartData['data']) !!},
            backgroundColor: ['rgba(0, 255, 0, 0.6)', 'rgba(255, 0, 0, 0.6)']
        }]
    }
    
    });
    document.getElementById('downloadReportBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default action of the anchor tag
        convertChartsToImages();
    });
    function convertChartsToImages() {
        // Convert all charts to images
        const stockChartImage = document.getElementById('stockChart').toDataURL('image/png');
        const articleStockChartImage = document.getElementById('articleStockChart').toDataURL('image/png');
        const stockMov1Image = document.getElementById('stockmov1').toDataURL('image/png');
        const stockMov2Image = document.getElementById('stockmov2').toDataURL('image/png');
        const stockMov3Image = document.getElementById('stockmov3').toDataURL('image/png');
        // Store the base64 images in hidden inputs
        document.getElementById('stockChartImage').value = stockChartImage;
        document.getElementById('articleStockChartImage').value = articleStockChartImage;
        document.getElementById('stockMov1Image').value = stockMov1Image;
        document.getElementById('stockMov2Image').value = stockMov2Image;
        document.getElementById('stockMov3Image').value = stockMov3Image;
        // Submit the form
        document.getElementById('chartForm').submit();
    }
});


</script>
<form id="chartForm" action="{{ route('report.download') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="stockChartImage" id="stockChartImage">
    <input type="hidden" name="articleStockChartImage" id="articleStockChartImage">
    <input type="hidden" name="stockMov1Image" id="stockMov1Image">
    <input type="hidden" name="stockMov2Image" id="stockMov2Image">
    <input type="hidden" name="stockMov3Image" id="stockMov3Image">

    <!-- Pass the filter data to the report download action -->
    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
    <input type="hidden" name="category" value="{{ request('category') }}">
    <input type="hidden" name="quantity" value="{{ request('quantity') }}">
</form>
<center><a href="#" id="downloadReportBtn" class="btn btn-primary">Télécharger le rapport</a></center>

@endsection