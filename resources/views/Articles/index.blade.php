@extends('layouts.app')

@section('title', 'Article')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <form action="{{ !empty(request()->id) ? route('articles.update', request()->id) : route('articles.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                @if(!empty(request()->id))
                    @method('PUT')
                @endif

                <label for="name">Nom de l'article</label>
                <input value="{{ old('name', $article->name ?? '') }}" type="text" name="name" id="name" placeholder="Veuillez saisir le nom">

                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Veuillez saisir la description">{{ old('description', $article->description ?? '') }}</textarea>

                <label for="unit_price">Prix unitaire</label>
                <input value="{{ old('unit_price', $article->unit_price ?? '') }}" type="number" name="unit_price" id="unit_price" placeholder="Veuillez saisir le prix">

                <label for="stock">Quantité</label>
                <input value="{{ old('stock', $article->stock ?? '') }}" type="number" name="stock" id="stock" placeholder="Veuillez saisir la quantité">

                <label for="category_id">Catégorie</label>
                <select name="category_id" id="category_id">
                    <option value="">--Choisir une catégorie--</option>
                    <x-category-dropdown :categories="$categories" :selected="old('parent_id')" />
                </select>

                <label for="images">Image</label>
                <input type="file" name="images" id="images">

                <input type="hidden" name="publier" value="0">
                <button type="submit" name="publier" value="1">Publier</button>
                <button type="submit">Valider</button>

                @if(session('message'))
                    <div class="alert {{ session('message')['type'] }}">
                        {{ session('message')['text'] }}
                    </div>
                @endif
            </form>
        </div>

        <div class="box" style="display: block;">
            <form action="{{ route('articles.index') }}" method="get">
                <table class="mtable">
                    <tr>
                        <th>Nom article</th>
                        <th>Catégorie</th>
                        <th>Quantité</th>
                        <th>Prix unitaire</th>
                        <th>Date fabrication</th>
                        <th>Date expiration</th>
                    </tr>
                    <tr>
                        <td><input type="text" name="name" id="name" placeholder="Veuillez saisir le nom"></td>
                        <td>
                            <select name="category_id" id="category_id">
                                <option value="">--Choisir une catégorie--</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="stock" id="stock" placeholder="Veuillez saisir la quantité"></td>
                        <td><input type="number" name="unit_price" id="unit_price" placeholder="Veuillez saisir le prix"></td>
                        <td><input type="date" name="date_fabrication" id="date_fabrication"></td>
                        <td><input type="date" name="date_expiration" id="date_expiration"></td>
                    </tr>
                </table>
                <br>
                <button type="submit">Valider</button>
            </form>
            <br>
            <table class="mtable">
                <tr>
                    <th>Nom article</th>
                    <th>Catégorie</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Date fabrication</th>
                    <th>Date expiration</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->stock }}</td>
                        <td>{{ $article->unit_price }}</td>
                        <td>{{ $article->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $article->updated_at->format('d/m/Y H:i:s') }}</td>
                        <td><img width="100" height="100" src="{{ $article->images }}" alt="{{ $article->name }}"></td>
                        <td><a href="{{ route('articles.edit', $article->id) }}"><i class='bx bx-edit-alt'></i></a></td>
                    </tr>
                @endforeach
            </table>

            <div class='pagination'>
                @if ($page > 1)
                    <a href="{{ route('articles.index', ['page' => $page - 1]) }}">&laquo; Précédent</a>
                @endif

                @for ($i = 1; $i <= $total_pages; $i++)
                    <a class="{{ $i == $page ? 'active' : '' }}" href="{{ route('articles.index', ['page' => $i]) }}">{{ $i }}</a>
                @endfor

                @if ($page < $total_pages)
                    <a href="{{ route('articles.index', ['page' => $page + 1]) }}">Suivant &raquo;</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
