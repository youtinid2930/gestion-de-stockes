<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            color: #333;
            margin-bottom: 10px; 
        }
        h2 {
            color: #333;
            margin-bottom: 5px;
        }
        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 5px; 
        }
        .chart-container {
            margin: 10px 0; 
            page-break-inside: avoid; 
            text-align: center;
        }
        img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            padding: 0; 
            max-height: 500px;
        }
        .image-title {
            font-size: 14px; 
            color: #777; 
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Rapport de Stock</h1>
    @if($start_date)
    <p><strong>Date de début :</strong> {{ $start_date }}</p>
    <p><strong>Date de fin :</strong> {{ $end_date }}</p>
    @endif
    <p><strong>Catégorie :</strong> {{ $category }}</p>
    @if($quantity)
    <p><strong>Quantité minimale :</strong> {{ $quantity }}</p>
    @endif

    <div class="chart-container">
        <h2>Niveaux de Stock par Catégorie</h2>
        <img src="{{ $stockChartImage }}" alt="Stock Chart">
        <div class="image-title">Niveaux de Stock par Catégorie</div>
    </div>

    <div class="chart-container">
        <h2>Niveaux de Stock par Article</h2>
        <img src="{{ $articleStockChartImage }}" alt="Article Stock Chart">
        <div class="image-title">Niveaux de Stock par Article</div>
    </div>

    <div class="chart-container">
        <h2>Les Quantités des Articles en fonction du Temps</h2>
        <img src="{{ $stockMov1Image }}" alt="Stock Movement 1">
        <div class="image-title">Les Quantités des Articles en fonction du Temps</div>
    </div>

    <div class="chart-container">
        <h2>Mouvements de Stock par Article</h2>
        <img src="{{ $stockMov2Image }}" alt="Stock Movement 2">
        <div class="image-title">Mouvements de Stock par Article</div>
    </div>

    <div class="chart-container">
        <h2>Pourcentage des Entrées et Sorties</h2>
        <img src="{{ $stockMov3Image }}" alt="Stock Movement 3">
        <div class="image-title">Pourcentage des Entrées et Sorties</div>
    </div>
</body>
</html>
