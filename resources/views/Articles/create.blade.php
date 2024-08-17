@extends('layouts.app')

@section('title', 'Article')

@section('content')
<div class="container">
    <h1>Créer un nouvel article</h1>
    <form action="{{ route('articles.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('articles.form', ['categories' => $categories])
        <button type="submit">Valider</button>
    </form>
</div>
@endsection
