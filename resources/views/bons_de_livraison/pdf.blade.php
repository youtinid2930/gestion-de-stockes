<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Livraison</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        .header, .footer { text-align: center; }
        .header img { width: 100px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .signature { margin-top: 30px; }
    </style>
</head>
<body>

<div class="container">
        <div class="header-icons">
            <a href="#" onclick="window.print()"><i class="fas fa-print" title="Imprimer"></i></a>
            <a href="{{ route('bondelivraison.download', $bonDeLivraison->id) }}"><i class="fas fa-file-pdf" title="Télécharger PDF"></i></a>
        </div>
    <div class="header">
        <h1>{{ $company->name }} </h1>
        <p>{{ $company->address }}</p>
        <p>{{ $company->contact }}</p>
    </div>

    <h2 style="margin-left: 40%;">Bon de Livraison</h2>
    <p>Numéro du Document : {{ $bonDeLivraison->numero }}</p>
    <p>Date : {{ $bonDeLivraison->date_livraison }}</p>
    <p>Date du Bon de Livraison : {{ $bonDeLivraison->date_livraison }}</p>
    
    @if($bonDeLivraisondetail->commande_id == null)
        <h3>Destination :</h3>
        @if(auth()->user()->hasRole('admin'))
        <p>Nom : {{ $bonDeLivraisondetail->demande->magasinier->name }} {{ $bonDeLivraisondetail->demande->magasinier->last_name}}</p>
        <p>Tel : {{ $bonDeLivraisondetail->demande->magasinier->telephone }} </p>
        @else
        <p>Nom : {{ $bonDeLivraisondetail->demande->gestionnaire->name}} {{ $bonDeLivraisondetail->demande->gestionnaire->last_name}}</p>
        <p>Tel : {{ $bonDeLivraisondetail->demande->gestionnaire->telephone }} </p>
        @endif
        <p>Adresse : {{ $bonDeLivraisondetail->demande->delivery_address }}</p>
    @endif
    

    <table>
        <thead>
            <tr>
                <th>Code Article</th>
                <th>Description</th>
                <th>Quantité Livrée</th>
                @if($bonDeLivraisondetail->commande_id != null)
                <th>Prix Unitaire (DH)</th>
                <th>Prix Total (DH)</th>
                @else
                <th>Quantité Restante</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($bonDeLivraison->bonDeLivraisonDetails as $detail)
                @php
                    // Assuming demandeDetails is a collection, we need to find the correct article
                    $article = $detail->demande->demandeDetails->first()->article;
                @endphp
                <tr>
                    <td>{{ $article->sku }}</td>
                    <td>{{ $article->description }}</td>
                    <td>{{ $detail->quantity_livree }}</td>
                    @if($bonDeLivraisondetail->commande_id != null)
                    <td>{{ number_format($article->unit_price, 2, ',', ' ') }} </td>
                    <td>{{ number_format($detail->quantity_livree * $article->unit_price, 2, ',', ' ') }} </td>
                    @else
                    <td>{{ $detail->quantity_restant }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    

    <div class="signature">
        <p>Préparé par : {{$bonDeLivraison->user->name}} {{$bonDeLivraison->user->last_name}}    Date : {{$bonDeLivraison->updated_at}}</p>
        <p>Reçu par : _______________________     Date : _______________</p>
    </div>

    <h3>Commentaires/Remarques :</h3>
    <p>[Remarques ou instructions supplémentaires]</p>

    <h3>Conditions Générales :</h3>
    <p>[Conditions liées à la livraison]</p>

    <h3>Informations d'Enregistrement de l'Entreprise :</h3>
    <p>{{ $company->registration_number }}</p>
</div>
</body>
</html>
