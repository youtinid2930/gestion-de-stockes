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
            margin-bottom: 10px;
        }
        .footer {
            border-top: 2px solid #000;
            margin-top: 10px;
        }
        .details {
            margin-bottom: 10px;
        }
        .details p {
            margin: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
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
            margin-bottom: 10px;
        }
        .summary p {
            margin: 5px 0;
            text-align: right;
        }
        
    </style>

</head>
<body>
    <div class="container">
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
                    <th>Montant Payé</th>
                    <th>Prix Unitaire (DH)</th>
                    <th>Prix Total (DH)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->facteurDetails as $item)
                <tr>
                    <td>{{ $item->article->sku }}</td>
                    <td>{{ $item->article->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($invoice->amount_paid, 2, ',', ' ') }}</td>
                    <td>{{ number_format($item->article->unit_price, 2, ',', ' ') }}</td>
                    <td>{{ number_format($invoice->total_amount, 2, ',', ' ') }}</td>
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

</body>
</html>
