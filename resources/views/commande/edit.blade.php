@extends('layouts.app')

@section('title', 'Edit Commande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ route('commande.update', $commande->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Ensure the method is PUT for updating -->
                
                <!-- Hidden field for the commande ID -->
                <input value="{{ $commande->id }}" type="hidden" name="id" id="id">

                <!-- Fournisseur Selection -->
                <label for="id_fournisseur">Fournisseur</label>
                <select name="id_fournisseur" id="id_fournisseur">
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}" {{ $commande->fournisseur_id == $fournisseur->id ? 'selected' : '' }}>
                            {{ $fournisseur->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Articles Section -->
                <label for="articles">Articles</label>
                <div id="articles">
                    @foreach ($commande->commandeDetails as $index => $articleDetail)
                        <div class="article-group">
                            <select name="articles[{{ $index }}][id_article]" class="article-select" data-index="{{ $index }}">
                                <option value="">Select Article</option>
                                @foreach ($articles as $value)
                                    <option value="{{ $value->id }}" data-price="{{ $value->unit_price }}" {{ $articleDetail->article_id == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>

                            <label for="quantité">Quantité</label>
                            <input type="number" name="articles[{{ $index }}][quantite]" class="article-quantity" data-index="{{ $index }}" placeholder="Quantité" value="{{ $articleDetail->quantite }}" />

                            <label for="Prix">Prix</label>
                            <input type="number" name="articles[{{ $index }}][prix]" class="article-price" data-index="{{ $index }}" placeholder="Prix" value="{{ $articleDetail->prix }}" readonly />

                            <button type="button" class="remove-article" style="border-radius: 6px;">Supprimer</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-article" style="border-radius: 6px;">Ajouter article</button>

                

                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif
            </form>
        </div>
        <div style="display:flex; flex-direction: row;">
        <button type="submit" style="border-radius: 6px;">Mettre à jour</button>
        <button onclick="window.location.href='{{ route('commande.index') }}'" style="border-radius: 6px; margin-left: 4%;">Precedent</button>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-article').addEventListener('click', function() {
        const articlesDiv = document.getElementById('articles');
        const articleCount = articlesDiv.children.length;
        const newArticleGroup = `
            <div class="article-group">
                <select name="articles[${articleCount}][id_article]" class="article-select" data-index="${articleCount}">
                    <option value="">Select Article</option>
                    @foreach ($articles as $value)
                        <option value="{{ $value->id }}" data-price="{{ $value->unit_price }}">{{ $value->name }}</option>
                    @endforeach
                </select>

                <input type="number" name="articles[${articleCount}][quantite]" class="article-quantity" data-index="${articleCount}" placeholder="Quantité" />
                <input type="number" name="articles[${articleCount}][prix]" class="article-price" data-index="${articleCount}" placeholder="Prix" readonly />

                <button type="button" class="remove-article">Remove</button>
            </div>
        `;
        articlesDiv.insertAdjacentHTML('beforeend', newArticleGroup);
    });

    document.getElementById('articles').addEventListener('change', function(e) {
        if (e.target.classList.contains('article-select')) {
            const index = e.target.getAttribute('data-index');
            const price = e.target.options[e.target.selectedIndex].getAttribute('data-price');
            const quantity = document.querySelector(`.article-quantity[data-index="${index}"]`).value || 1;
            document.querySelector(`.article-price[data-index="${index}"]`).value = price * quantity;
        }
    });

    document.getElementById('articles').addEventListener('input', function(e) {
        if (e.target.classList.contains('article-quantity')) {
            const index = e.target.getAttribute('data-index');
            const price = document.querySelector(`.article-select[data-index="${index}"]`).options[document.querySelector(`.article-select[data-index="${index}"]`).selectedIndex].getAttribute('data-price');
            document.querySelector(`.article-price[data-index="${index}"]`).value = price * e.target.value;
        }
    });

    document.getElementById('articles').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-article')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection
