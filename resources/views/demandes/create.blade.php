@extends('layouts.app')

@section('title', 'Demande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty($demande) ? route('demande.update', $demande->id) : route('demande.store') }}" method="POST">
                @csrf
                @if (!empty($demande))
                    @method('PUT')
                @endif
                
                @if(auth()->user()->hasRole('magasinier'))
                    <label for="admin">Administrateur</label>
                    <select name="admin" id="admin">
                        <option value="">--Choisir l'administrateur--</option>
                        @foreach($admins as $admin) 
                            <option value="{{ $admin->id }}">{{ $admin->name }} {{ $admin->last_name }}</option>
                        @endforeach
                    </select>
                @endif
                
                @if(auth()->user()->hasRole('gestionnaire'))
                    <label for="magasin">Magasin</label>
                    <select name="magasin" id="magasin">
                        <option value="">--Choisir le magasin--</option>
                        @foreach($magasins as $magasin) 
                            <option value="{{ $magasin->id }}">{{ $magasin->name }}</option>
                        @endforeach
                    </select>

                    <label for="magasinier">Magasinier</label>
                    <select name="magasinier" id="magasinier">
                        <option value="">--Choisir le magasinier--</option>
                    </select>
                @endif

                <div id="articles">
                    <label for="articles">Articles</label>
                    @foreach (old('articles', $demande->demandeDetails ?? [['id_article' => '', 'quantite' => '', 'prix' => '']]) as $index => $article)
                        <div class="article-group">
                            <select name="articles[{{ $index }}][id_article]" class="article-select" data-index="{{ $index }}">
                                <option value="">Choisir un article</option>
                                @foreach ($allArticles as $value)
                                    <option value="{{ $value->id }}" data-price="{{ $value->unit_price }}" {{ $article['id_article'] == $value->id ? 'selected' : '' }}>
                                        {{ $value->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="quantite">Quantité</label>
                            <input type="number" name="articles[{{ $index }}][quantite]" class="article-quantity" data-index="{{ $index }}" placeholder="Quantité" value="{{ $article['quantite'] }}" />

                            <button type="button" class="remove-article" class="btn" style=" margin-top: 2%; margin-bottom: 2%;">Supprimer</button>
                        </div>
                    @endforeach
                </div>
                <div>
                    <button type="button" id="add-article" class="btn" style="margin-bottom: 2%;">Ajouter article</button>
                </div>

                
                <input value="{{ old('id', $demande->id ?? '') }}" type="hidden" name="id" id="id">
                
                <label for="notes">Notes</label>
                <textarea value="{{ old('notes', $demande->notes ?? '') }}" type="text" name="notes" id="notes" placeholder="Veuillez saisir les notes"></textarea>


                <br><br><br>
                <button type="submit" class="btn">Valider</button>

                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const magasinElement = document.getElementById('magasin');
    const addArticleElement = document.getElementById('add-article');
    const articlesElement = document.getElementById('articles');

    if (magasinElement) {
        magasinElement.addEventListener('change', function() {
            const magasinId = this.value;
            const magasinierSelect = document.getElementById('magasinier');

            if (magasinId) {
                fetch('{{ route('demande.getMagasiniers') }}?magasin_id=' + magasinId)
                    .then(response => response.json())
                    .then(data => {
                        magasinierSelect.innerHTML = '<option value="">--Choisir le magasinier--</option>';
                        data.forEach(magasinier => {
                            magasinierSelect.innerHTML += `<option value="${magasinier.id}">${magasinier.name} ${magasinier.last_name}</option>`;
                        });
                    });
            } else {
                magasinierSelect.innerHTML = '<option value="">--Choisir le magasinier--</option>';
            }
        });
    }

    if (addArticleElement) {
        addArticleElement.addEventListener('click', function() {
            const articlesDiv = articlesElement;
            const articleCount = articlesDiv.children.length;
            const newArticleGroup = `
                <div class="article-group">
                    <select name="articles[${articleCount}][id_article]" class="article-select" data-index="${articleCount}">
                        <option value="">Choisir un article</option>
                        @foreach ($allArticles as $value)
                            <option value="{{ $value->id }}" data-price="{{ $value->unit_price }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                    <label for="quantite">Quantité</label>
                    <input type="number" name="articles[${articleCount}][quantite]" class="article-quantity" data-index="${articleCount}" placeholder="Quantité" />

                    <button type="button" class="remove-article" style="border-radius: 6px; margin-top: 2%; margin-bottom: 2%;">Supprimer</button>
                </div>
            `;
            articlesDiv.insertAdjacentHTML('beforeend', newArticleGroup);
        });
    }

    if (articlesElement) {
        articlesElement.addEventListener('change', function(e) {
            if (e.target.classList.contains('article-select')) {
                const index = e.target.getAttribute('data-index');
                const price = e.target.options[e.target.selectedIndex].getAttribute('data-price');
                const quantity = document.querySelector(`.article-quantity[data-index="${index}"]`).value || 1;
                document.querySelector(`.article-price[data-index="${index}"]`).value = price * quantity;
            }
        });

        articlesElement.addEventListener('input', function(e) {
            if (e.target.classList.contains('article-quantity')) {
                const index = e.target.getAttribute('data-index');
                const price = document.querySelector(`.article-select[data-index="${index}"]`).options[document.querySelector(`.article-select[data-index="${index}"]`).selectedIndex].getAttribute('data-price');
                document.querySelector(`.article-price[data-index="${index}"]`).value = price * e.target.value;
            }
        });

        articlesElement.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-article')) {
                e.target.parentElement.remove();
            }
        });
    }
});

</script>
@endsection
