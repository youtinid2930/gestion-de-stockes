@extends('layouts.app')

@section('title', 'Article')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty(request()->id) ? route('articles.update', request()->id) : route('articles.store') }}" method="post">
                @csrf
                @if(!empty(request()->id))
                    @method('PUT')
                @endif

                <label for="name">Nom</label>
                <input  type="text" name="name" id="name" placeholder="Veuillez saisir le nom">

                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Veuillez saisir la description"></textarea>

                <label for="unit_price">Prix unitaire</label>
                <input  type="number" name="unit_price" id="unit_price" placeholder="Veuillez saisir le prix">

                <label for="stock">Quantité</label>
                <input type="number" name="quantity" id="stock" placeholder="Veuillez saisir la quantité">

                <label for="category_id">Catégorie</label>
                <select name="category_id" id="category_id" onchange="updateCaracteristiques()">
                    <option value="">--Choisir une catégorie--</option>
                    @foreach ($finalCategories as $categorie)
                        <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                    @endforeach
                </select>

                <label for="date_de_fabrication">Date de fabrication</label>
                <input type="date" name="date_de_fabrication" id="date_de_fabrication">

                <label for="date_d_expiration">Date d'expiration</label>
                <input type="date" name="date_d_expiration" id="date_d_expiration">

                <div id="caracteristiques-container"></div>

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
                                <input type="text" name="caracteristiques[${caracteristique.id}][valeur]" placeholder="Saiser la valeur">
                                <input type="hidden" name="caracteristiques[${caracteristique.id}][id]" value="${caracteristique.id}">`;
                    container.innerHTML += html;
                });
            });
    }
</script>
@endsection
