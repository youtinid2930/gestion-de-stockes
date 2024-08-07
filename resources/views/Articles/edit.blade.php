@extends('layouts.app')

@section('title', 'Modifier l\'article')

@section('content')
<div class="container">
    <h1>Modifier l'article</h1>
    <form action="{{ route('articles.update', $article->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('articles.partials.form', ['article' => $article, 'categories' => $categories])
    </form>
</div>
@endsection
