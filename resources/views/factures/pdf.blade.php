<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            text-align: center;
        }
        .logo {
            width: 150px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Facture</h1>
        <table>
            <tr>
                <th>Numéro de Facture</th>
                <td>{{ $facture->numero_facture }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $facture->date_facture->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Montant Total</th>
                <td>{{ number_format($facture->montant_total, 2) }} DH</td>
            </tr>
            <tr>
                <th>Fournisseur</th>
                <td>{{ $facture->commande->fournisseur->name }}</td> <!-- Assurez-vous que la relation est définie correctement -->
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $facture->description }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
