@extends('layouts.app')

@section('title', 'Article')

@section('content')
<div class="container">
    <h1>Modifier l'article</h1>
    <form action="{{ route('articles.update', $article->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('articles.form', ['article' => $article, 'categories' => $categories])        <button type="submit">Valider</button>
    </form>
</div>
@endsection
