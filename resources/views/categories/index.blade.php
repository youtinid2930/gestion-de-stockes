
@extends('layouts.app')

@section('title', 'Catégorie')

@section('content')
<div class="home-content">

<div class="mt-4">
    
    <div class="list-group">
        @foreach ($categories as $category)
            <div class="list-group-item">
                <a data-toggle="collapse" href="#collapseCategory{{ $category->id }}" aria-expanded="false" aria-controls="collapseCategory{{ $category->id }}">
                    {{ $category->name }}
                </a>
                <div class="float-right">
                    @if(auth()->user()->can('gerer categorie'))
                    <a href="{{ route('categories.edit', $category->id) }}"  data-toggle="tooltip" title="Mettre a jour la categorie">
                        <i class="bx bx-edit-alt"></i>
                    </a>
                    @endif
                    <a href="{{ route('category.characteristics', $category->id) }}"  data-toggle="tooltip" title="Gerer les caracteristique de la categorie">
                        <i class="bx bx-cog"></i>
                    </a>
                    @if(auth()->user()->can('gerer categorie'))
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" data-toggle="tooltip" title="Supprimer la categorie">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer la categorie?');" class="delete-button">
                            <i class='bx bx-trash'></i>
                        </button>
                    </form>
                    @endif
                </div>
                @if ($category->souscategories->count() > 0)
                <div class="collapse" id="collapseCategory{{ $category->id }}">
                    <div class="card card-body">
                        @include('categories.partial.category', ['categories' => $category->souscategories])
                    </div>
                </div>
                @endif
            </div>
        @endforeach
    </div>
    @if(auth()->user()->can('gerer categorie'))
    <div class="mt-3 btns">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Ajouter Catégorie</a>
        <a href="{{ route('caracteristique.index') }}" class="btn btn-secondary">Gérer les caractéristiques</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @endif
</div>
</div>
@endsection
