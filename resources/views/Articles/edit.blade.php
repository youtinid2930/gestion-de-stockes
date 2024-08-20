@extends('layouts.app')

@section('title', 'Mettre à jour l\'article')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ route('articles.update', $article->id) }}" method="post">
                @csrf
                @method('PUT')

                <label for="name">Nom</label>
                <input type="text" name="name" id="name" placeholder="Veuillez saisir le nom" value="{{ old('name', $article->name) }}">

                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Veuillez saisir la description">{{ old('description', $article->description) }}</textarea>

                <label for="unit_price">Prix unitaire</label>
                <input type="number" name="unit_price" id="unit_price" placeholder="Veuillez saisir le prix" value="{{ old('unit_price', $article->unit_price) }}">

                <label for="quantity">Quantité</label>
                <input type="number" name="quantity" id="quantity" placeholder="Quantité" value="{{ old('quantity', $article->depots->where('depot_id', $user->depot_id)->first()->quantity ?? 0) }}">

                <label for="category_id">Catégorie</label>
                <select name="category_id" id="category_id" onchange="updateCaracteristiques()">
                    <option value="">--Choisir une catégorie--</option>
                    @foreach ($finalCategories as $categorie)
                        <option value="{{ $categorie->id }}" {{ $article->category_id == $categorie->id ? 'selected' : '' }}>{{ $categorie->name }}</option>
                    @endforeach
                </select>

                <label for="date_de_fabrication">Date de fabrication</label>
                <input type="date" name="date_de_fabrication" id="date_de_fabrication" value="{{ old('date_de_fabrication', $article->date_de_fabrication ? $article->date_de_fabrication->format('Y-m-d') : '') }}">

                <label for="date_d_expiration">Date d'expiration</label>
                <input type="date" name="date_d_expiration" id="date_d_expiration" value="{{ old('date_d_expiration', $article->date_d_expiration ? $article->date_d_expiration->format('Y-m-d') : '') }}">

                <div id="caracteristiques-container">
                    @foreach ($article->characteristics as $caracteristique)
                        <label>{{ $caracteristique->name }}</label>
                        <input type="text" name="caracteristiques[{{ $caracteristique->id }}][valeur]" placeholder="Saisir la valeur" value="{{ old('caracteristiques.' . $caracteristique->id . '.valeur', $caracteristique->pivot->valeur) }}">
                        <input type="hidden" name="caracteristiques[{{ $caracteristique->id }}][id]" value="{{ $caracteristique->id }}">
                    @endforeach
                </div>

                <button type="submit" style="border-radius: 6px; margin-top: 2%; margin-bottom: 2%;">Valider</button>

                @if(session('message'))
                    <div class="alert {{ session('message')['type'] }}">
                        {{ session('message')['text'] }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
<script>
    function updateCaracteristiques() {
        var categoryId = document.getElementById('category_id').value;
        var url = '{{ route("articles.caracteristiques", ":id") }}';
        url = url.replace(':id', categoryId);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var container = document.getElementById('caracteristiques-container');
                container.innerHTML = '';
                data.forEach(caracteristique => {
                    var html = `<label>${caracteristique.name}</label>
                                <input type="text" name="caracteristiques[${caracteristique.id}][valeur]" placeholder="Saisir la valeur">
                                <input type="hidden" name="caracteristiques[${caracteristique.id}][id]" value="${caracteristique.id}">`;
                    container.innerHTML += html;
                });
            });
    }
</script>
@endsection
