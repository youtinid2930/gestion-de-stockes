@extends('layouts.app')

@section('title', 'Article Details')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form method="post">
                @csrf
                @method('GET') <!-- Assuming it's a read-only page -->

                <label for="name">Nom</label>
                <input type="text" name="name" id="name" value="{{ $article->name }}" readonly>

                <label for="description">Description</label>
                <textarea name="description" id="description" readonly>{{ $article->description }}</textarea>

                <label for="unit_price">Prix unitaire</label>
                <input type="number" name="unit_price" id="unit_price" value="{{ $article->unit_price }}" readonly>

                <label for="sku">SKU</label>
                <input type="text" name="sku" id="sku" value="{{ $article->sku }}" readonly>

                <label for="serial_number">Numéro de série</label>
                <input type="text" name="serial_number" id="serial_number" value="{{ $article->serial_number }}" readonly>

                <label for="batch_number">Numéro de lot</label>
                <input type="text" name="batch_number" id="batch_number" value="{{ $article->batch_number }}" readonly>

                <label for="combined_code">Code combiné</label>
                <input type="text" name="combined_code" id="combined_code" value="{{ $article->combined_code }}" readonly>

                <label for="category_id">Catégorie</label>
                <input type="text" name="category_id" id="category_id" value="{{ $article->category->name ?? 'N/A' }}" readonly>

                <label for="date_de_fabrication">Date de fabrication</label>
                <input type="text" name="date_de_fabrication" id="date_de_fabrication" value="{{ $article->date_de_fabrication ? $article->date_de_fabrication->format('d/m/Y H:i:s') : 'date non disponible' }}" readonly>

                <label for="date_d_expiration">Date d'expiration</label>
                <input type="text" name="date_d_expiration" id="date_d_expiration" value="{{ $article->date_d_expiration ? $article->date_d_expiration->format('d/m/Y H:i:s') : 'date non disponible' }}" readonly>

                <label for="total_quantity">Quantité totale</label>
                <input type="number" name="total_quantity" id="total_quantity" value="{{ $article->total_quantity }}" readonly>

                <label for="created_at">Créé le</label>
                <input type="text" name="created_at" id="created_at" value="{{ $article->created_at->format('d/m/Y H:i:s') }}" readonly>

                <label for="updated_at">Mis à jour le</label>
                <input type="text" name="updated_at" id="updated_at" value="{{ $article->updated_at->format('d/m/Y H:i:s') }}" readonly>
                
                <div>Caracteristiques<div>
                @foreach($caracteristiques as $caracteristique) 
                    <label for="{{ $caracteristique->caracteristique->name }}">{{ $caracteristique->caracteristique->name }}</label>
                    <input type="text" name="{{ $caracteristique->caracteristique->name }}" id="{{ $caracteristique->caracteristique->name }}" value="{{ $caracteristique->valeur }}" readonly>
                @endforeach

                <div class="mt-3">
                    <a href="{{ route('articles.index') }}" class="btn btn-secondary">Retour à la liste</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
