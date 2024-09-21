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
            <a href="{{ route('bondedemande.download', $demande->id) }}"><i class="fas fa-file-pdf" title="Télécharger PDF"></i></a>
            <div class="logo-container">
                <img src="{{ asset('image/logo.jpeg') }}" alt="Logo" class="company-logo">
            </div>
        </div>
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
            <p>Département : {{ $employer->department }}</p>
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
    <div class="return-button">
        <button onclick="window.history.back()" class="btn btn-primary">Retour</button>
    </div>
</body>
</html>
