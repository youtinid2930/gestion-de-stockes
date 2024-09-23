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
        .company-logo {
            max-width: 150px; /* Ajustez la taille maximale du logo */
            height: auto; /* Maintenir le ratio d'aspect */
            display: block; /* S'assurer que l'image soit un élément de bloc */
            margin-left: 900px; /* Centrer l'image horizontalement */

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
            <a href="{{ route('bondelivraison.download', $bonDeLivraison->id) }}"><i class="fas fa-file-pdf" title="Télécharger PDF"></i></a>
            <div class="logo-container">
                <img src="{{ asset('image/logo.jpeg') }}" alt="Logo" class="company-logo">
            </div>
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
    
    @if ($bonDeLivraison->bonDeLivraisonDetails->isNotEmpty())
    @foreach ($bonDeLivraison->bonDeLivraisonDetails as $bonDeLivraisondetail)
    @if ($bonDeLivraisondetail->commande_id == null)
    <h3>Destination :</h3>

    @if (auth()->user()->hasRole('admin'))
        @if ($bonDeLivraisondetail->demande->magasinier)
            <p>Nom : {{ $bonDeLivraisondetail->demande->magasinier->name }} {{ $bonDeLivraisondetail->demande->magasinier->last_name }}</p>
            <p>Tel : {{ $bonDeLivraisondetail->demande->magasinier->telephone }}</p>
        @else
            <p>Le magasinier n'est pas disponible.</p>
        @endif
    @elseif(auth()->user()->hasRole('magasinier'))
        @if ($bonDeLivraisondetail->demande->gestionnaire)
            <p>Nom : {{ $bonDeLivraisondetail->demande->gestionnaire->name }} {{ $bonDeLivraisondetail->demande->gestionnaire->last_name }}</p>
            <p>Tel : {{ $bonDeLivraisondetail->demande->gestionnaire->telephone }}</p>
        @else
            <p>Nom : {{ $bonDeLivraisondetail->demande->magasinier->name }} {{ $bonDeLivraisondetail->demande->magasinier->last_name }}</p>
            <p>Tel : {{ $bonDeLivraisondetail->demande->magasinier->telephone }}</p>
        @endif
    @else
        <p>Nom : {{ $bonDeLivraisondetail->demande->gestionnaire->name }} {{ $bonDeLivraisondetail->demande->gestionnaire->last_name }}</p>
        <p>Tel : {{ $bonDeLivraisondetail->demande->gestionnaire->telephone }}</p>
    @endif
    @endif
    @endforeach
    @else
    <p>Aucun détail de bon de livraison disponible.</p>
    @endif
    

    <table>
    <thead>
        <tr>
            <th>Code Article</th>
            <th>Description</th>
            <th>Quantité Livrée</th>
            @if ($bonDeLivraisondetail->commande_id !== null)
                <th>Prix Unitaire (DH)</th>
                <th>Prix Total (DH)</th>
            @else
                <th>Quantité Restante</th>
            @endif
             
        </tr>
    </thead>
    
        @foreach ($bonDeLivraison->bonDeLivraisonDetails as $bonDeLivraisondetail)
            @if ($bonDeLivraisondetail->commande_id !== null)
                @foreach($bonDeLivraisondetail->commande->commandeDetails as $detail)
                    <tbody>
                        <td>{{ $detail->article->sku }}</td>
                        <td>{{ $detail->article->description }}</td>
                        <td>{{ $detail->quantite }}</td>
                        <td>{{ number_format($detail->article->unit_price, 2, ',', ' ') }} DH</td>
                        <td>{{ number_format($detail->quantite * $detail->article->unit_price, 2, ',', ' ') }} DH</td>
                    
                @endforeach
            @else
                @foreach($bonDeLivraisondetail->demande->demandeDetails as $detail)
                    <tbody>
                        <td>{{ $detail->article->sku }}</td>
                        <td>{{ $detail->article->description }}</td>
                        <td>{{ $bonDeLivraisondetail->quantity_livree }}</td>
                        <td>{{ number_format($bonDeLivraisondetail->quantity_restant, 0, ',', ' ') }}</td>
                    </tbody>
                @endforeach
            @endif
        @endforeach  
    </table>


    

    <div class="signature">
        <p>Préparé par : {{$bonDeLivraison->user->name}} {{$bonDeLivraison->user->last_name}}    Date : {{$bonDeLivraison->updated_at}}</p>
    </div>

    <h3>Commentaires/Remarques :</h3>
    <p>[Remarques ou instructions supplémentaires]</p>

    <h3>Conditions Générales :</h3>
    <p>[Conditions liées à la livraison]</p>

    <h3>Informations d'Enregistrement de l'Entreprise :</h3>
    <p>{{ $company->registration_number }}</p>
</div>
    <div class="return-button">
        <button onclick="window.history.back()" class="btn btn-primary">Retour</button>
    </div>
</body>
</html>
