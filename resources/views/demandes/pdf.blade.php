<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bon de Demande</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header, .footer {
            text-align: center;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $company->name }}</h1>
            <p>{{ $company->address }}</p>
            <p>Tel: {{ $company->contact }}</p>
            <p>Email: {{ $company->email }}</p>
        </div>

        <h2 style="margin-left: 39%;">BON DE DEMANDE</h2>

        <p>Numéro du document : {{ $demande->numero }}</p>
        <p>Date : {{ $demande->created_at->format('d/m/Y') }}</p>
        <p>Date de la demande : {{ $demande->created_at->format('d/m/Y') }}</p>

        @if(auth()->user()->hasRole('gestionnaire'))
            <h3>Demandeur :</h3>
            <p>Nom : {{ $employer->first_name }} {{ $employer->second_name }}</p>
            <p>Département : {{ $employer->departement }}</p>
            <p>Contact : {{ $employer->contact }}</p>
        @elseif(auth()->user()->hasRole('magasinier'))
            @if($demande->admin_id)
                <h3>Demandeur :</h3>
                <p>Nom : {{ $demande->magasinier->name }} {{ $demande->magasinier->last_name }}</p>
                <p>Département : {{ $demande->magasinier->depot->name }}</p>
                <p>Tel : {{ $demande->magasinier->telephone }}</p>
                <p>Email : {{ $demande->magasinier->email }}</p>
            @else
                <h3>Demandeur :</h3>
                <p>Nom : {{ $demande->gestionnaire->name }} {{ $demande->gestionnaire->last_name }}</p>
                <p>Département : {{ $demande->gestionnaire->depot->name }}</p>
                <p>Tel : {{ $demande->gestionnaire->telephone }}</p>
                <p>Email : {{ $demande->gestionnaire->email }}</p>
            @endif
        @else
            <h3>Demandeur :</h3>
            <p>Nom : {{ $demande->magasinier->name }} {{ $demande->magasinier->last_name }}</p>
            <p>Département : {{ $demande->magasinier->depot->name }}</p>
            <p>Tel : {{ $demande->magasinier->telephone }}</p>
            <p>Email : {{ $demande->magasinier->email }}</p>
        @endif
        @if($demande->status == "Complétée" || $demande->status == "Livrée")
        <table>
            <thead>
                <tr>
                    <th>Code Article</th>
                    <th>Description</th>
                    <th>Quantité Demandée</th>
                    <th>Quantité Livrée</th>
                    <th>Quantité Restante</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demande->demandeDetails as $detail)
                <tr>
                    <td>{{ $detail->article->sku }}</td>
                    <td>{{ $detail->article->description }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->quantity_livree }}</td>
                    <td>{{ $detail->quantity_restant }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <table>
            <thead>
                <tr>
                    <th>Code Article</th>
                    <th>Description</th>
                    <th>Quantité Demandée</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demande->demandeDetails as $detail)
                <tr>
                    <td>{{ $detail->article->sku }}</td>
                    <td>{{ $detail->article->description }}</td>
                    <td>{{ $detail->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <p>Motif de la Demande : {{ $demande->notes }}</p>
        <p>Statut : {{ $demande->status }}</p>
        <p>Niveau d'Urgence : [Élevé/Moyen/Bas]</p>
        <p>Commentaires/Remarques : [Remarques supplémentaires ou instructions]</p>

        <p>Approuvé Par : _______________________    Date : _______________</p>

        <div class="footer">
            <p>Conditions Générales : [Conditions générales liées à la demande]</p>
            <p>Informations de l'Entreprise : [Numéro d'enregistrement de l'entreprise]</p>
        </div>
    </div>
</body>
</html>
