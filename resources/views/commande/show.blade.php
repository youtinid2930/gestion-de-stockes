@extends('layouts.app')

@section('title', 'Commande')

@section('content')

<div class="home-content">

    <div class="overview-boxes">
        <div class="box">
            <p><strong>Numero:</strong> {{ $commande->numero }} </p>
            <p><strong>Date de creation:</strong> {{ $commande->created_at }}</p>
            <h4>Information sur le fournisseur</h4>
            <p><strong>Nom:</strong> 
                {{ $commande->fournisseur->name }} {{ $commande->fournisseur->last_name }}
            </p>
            <p><strong>Email:</strong> {{ $commande->fournisseur->email }}</p>
            <p><strong>Telephone:</strong> {{ $commande->fournisseur->phone }}</p>
            <h4>Information sur l'article</h4>
            @foreach($commande->commandeDetails as $detail)
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" value="{{ $detail->article->name }}" readonly>

                <label for="description">Description</label>
                <textarea name="description" id="description" readonly>{{ $detail->article->description }}</textarea>

                <label for="unit_price">Quantité demandé</label>
                <input type="number" name="unit_price" id="unit_price" value="{{ $detail->quantite }}" readonly>

                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" value="{{ $detail->article->sku }}" readonly>

                <label for="serial_number">Numéro de série</label>
                <input type="text" name="serial_number" id="serial_number" value="{{ $detail->article->serial_number }}" readonly>

                <label for="batch_number">Numéro de lot</label>
                <input type="text" name="batch_number" id="batch_number" value="{{ $detail->article->batch_number }}" readonly>

                <label for="combined_code">Code combiné</label>
                <input type="text" name="combined_code" id="combined_code" value="{{ $detail->article->combined_code }}" readonly>

                <label for="category_id">Catégorie</label>
                <input type="text" name="category_id" id="category_id" value="{{ $detail->article->category->name ?? 'N/A' }}" readonly>

                <label for="date_de_fabrication">Date de fabrication</label>
                <input type="text" name="date_de_fabrication" id="date_de_fabrication" value="{{ $detail->article->date_de_fabrication ? $detail->article->date_de_fabrication->format('d/m/Y H:i:s') : 'date non disponible' }}" readonly>

                <label for="date_d_expiration">Date d'expiration</label>
                <input type="text" name="date_d_expiration" id="date_d_expiration" value="{{ $detail->article->date_d_expiration ? $detail->article->date_d_expiration->format('d/m/Y H:i:s') : 'date non disponible' }}" readonly>

        @endforeach
        <button onclick="window.history.back()" class="btn">Retour</button>
        <div>
    </div>
</div>
@endsection