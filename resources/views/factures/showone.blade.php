<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .footer {
            border-top: 2px solid #000;
            margin-top: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table td {
            text-align: right;
        }
        .table td:first-child {
            text-align: left;
        }
        .summary {
            margin-bottom: 20px;
        }
        .summary p {
            margin: 5px 0;
            text-align: right;
        }
        .header-icons {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }
        .header-icons a {
            color: #333;
            text-decoration: none;
            margin-right: 15px;
            transition: color 0.3s;
        }
        .header-icons a:hover {
            color: #007bff;
        }
        .header-icons i {
            font-size: 24px;
            background: #f1f1f1;
            padding: 10px;
            border-radius: 50%;
            transition: background 0.3s, color 0.3s;
        }
        .header-icons i:hover {
            background: #007bff;
            color: #fff;
        }

        .return-button {
            margin-top: 1%;
            margin-bottom: 2%;
            text-align: center;
        }
        .return-button button {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .return-button button:hover {
            background-color: #0056b3;
        }
    </style>
     <!-- Include FontAwesome for icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="header-icons">
            <a href="#" onclick="window.print()"><i class="fas fa-print" title="Imprimer"></i></a>
            <a href="{{ route('factures.download', $invoice->id) }}"><i class="fas fa-file-pdf" title="Télécharger PDF"></i></a>
        </div>
        <!-- En-tête -->
        <div class="header">
            <h1>{{ $company->name }}</h1>
            <p>{{ $company->address }}</p>
            <p>{{ $company->contact }}</p>
        </div>

        <!-- Titre de la Facture -->
        <h2 style="text-align: center;">FACTURE</h2>

        <!-- Détails de la Facture -->
        <div class="details">
            <p><strong>Numéro de Facture:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Date de Facture:</strong> {{ $invoice->issue_date }}</p>
            <p><strong>Date d'Échéance:</strong> {{ $invoice->due_date }}</p>
        </div>

        <!-- Informations sur le Fournisseur -->
        <div class="details">
            <p><strong>Fournisseur:</strong></p>
            <p>Nom: {{ $invoice->fournisseur->name }} {{ $invoice->fournisseur->last_name }}</p>
            <p>Adresse: {{ $invoice->fournisseur->email }}</p>
            <p>Contact: {{ $invoice->fournisseur->phone }}</p>
        </div>

        <!-- Informations sur le Client (Admin) -->
        <div class="details">
            <p><strong>Client (Admin):</strong></p>
            <p>Nom: {{ $admin->name }} {{ $admin->last_name }}</p>
            <p>Entreprise: {{ $company->name }}</p>
            <p>Adresse: {{ $admin->email }}</p>
            <p>Contact: {{ $admin->telephone }}</p>
        </div>

        <!-- Articles de la Facture -->
        <table class="table">
            <thead>
                <tr>
                    <th>Code Article</th>
                    <th>Description</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire (DH)</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->facteurDetails as $item)
                <tr>
                    <td>{{ $item->article->sku }}</td>
                    <td>{{ $item->article->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    
                    <td>{{ number_format($item->article->unit_price, 2, ',', ' ') }}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Résumé -->
        <div class="summary">
            <p>Montant Payé: {{ number_format($invoice->amount_paid, 2, ',', ' ') }} DH</p>
            <p>Montant total paye : {{ number_format($total_paid, 2, ',', ' ')}} DH </p>
            <p>Prix Total: {{ number_format($invoice->total_amount, 2, ',', ' ') }} DH</p>
            <p>Montant Total HT: {{ number_format($subtotal, 2, ',', ' ') }} DH</p>
            <p>Taxes ({{ $invoice->tax_rate }}%): {{ number_format($taxes, 2, ',', ' ') }} DH</p>
            <p>Remises: {{ number_format($discounts, 2, ',', ' ') }} DH</p>
            <p><strong>Montant Total TTC: {{ number_format($totalAmount, 2, ',', ' ') }} DH</strong></p>
        </div>

        <!-- Conditions de Paiement -->
        <div class="details">
            <p><strong>Conditions de Paiement:</strong> {{ $company->payment_terms }}</p>
            <p><strong>Détails Bancaires:</strong> {{ $company->bank_details }}</p>
            <p><strong>Instructions de Paiement:</strong> {{ $company->payment_instructions }}</p>
            <p><strong>Status de facteur:</strong> {{ $invoice->status }} </p>
        </div>

        <!-- Termes et Conditions -->
        <div class="details">
            <p><strong>Termes et Conditions:</strong></p>
            <p>{{ $company->terms_conditions_commandes }}</p>
        </div>

        <!-- Informations d'Enregistrement de l'Entreprise -->
        <div class="footer">
            <p><strong>Informations d'Enregistrement de l'Entreprise:</strong> {{ $company->registration_number }}</p>
        </div>
    </div>
    <div class="return-button">
        <button onclick="window.history.back()" class="btn btn-primary">Retour</button>
    </div>
    

</body>
</html>
