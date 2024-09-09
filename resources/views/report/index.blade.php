@extends('layouts.app')

@section('title', 'Report')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <!-- Formulaire de filtrage -->
        <form method="GET" action="{{ route('report.download') }}">
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

            <button type="submit">Filtrer</button>
        </form>

        <!-- Graphiques -->
        <div class="box">
            <canvas id="stockChart"></canvas>
        </div>
        <div class="box">
            <canvas id="articleStockChart"></canvas>
        </div>
    </div>
</div>

<script>
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
</script>

<center><div class="mt-3 btns">
    <a href="{{ route('report.download', [
        'start_date' => request('start_date'),
        'end_date' => request('end_date'),
        'category' => request('category'),
        'quantity' => request('quantity')
    ]) }}" class="btn btn-primary">Télécharger le rapport</a>
</center><br><br><br><br><br>

@endsection