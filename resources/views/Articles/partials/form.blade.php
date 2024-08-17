<form action="{{ !empty($article) ? route('articles.update', $article->id) : route('articles.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if(!empty($article))
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
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (old('category_id') ?? $article->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="images">Image</label>
    <input type="file" name="images" id="images">

    <input type="hidden" name="publier" value="0">
    <button type="submit" name="publier" value="1">Valider</button>
   
    @if(session('message'))
        <div class="alert {{ session('message')['type'] }}">
            {{ session('message')['text'] }}
        </div>
    @endif
</form>