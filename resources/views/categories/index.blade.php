
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
                    <a href="{{ route('categories.edit', $category->id) }}">
                        <i class="bx bx-edit-alt"></i>
                    </a>
                    <a href="{{ route('category.characteristics', $category->id) }}">
                        <i class="bx bx-cog"></i>
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this category?');" class="delete-button">
                            <i class='bx bx-trash'></i>
                        </button>
                    </form>
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
    <button onclick="window.location.href='{{ route('categories.create') }}'" style="margin: 1em; border-radius: 6px;">Ajouter Catégorie</button>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
     @endif
</div>
</div>
@endsection
