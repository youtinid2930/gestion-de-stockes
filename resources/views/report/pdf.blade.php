<!DOCTYPE html>
<html>
<head>
    <title>Rapport</title>
    <style>
        /* Styles pour le PDF */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Rapport</h1>
    <p>Catégorie: {{ $category }}</p>
    <p>Date de début: {{ $startDate }}</p>
    <p>Date de fin: {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Nom de l'article</th>
                <th>Quantité en stock</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($articles as $article)
                <tr>
                    <td>{{ $article->name }}</td>
                    <td>{{ $article->stock }}</td>
                    <td>{{ $article->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucun article trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
