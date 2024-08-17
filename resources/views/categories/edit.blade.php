@extends('layouts.app')

@section('title', 'Catégorie')

@section('content')
<div class="home-content">
<div class="overview-boxes">
    <div class="box">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>

            
            <label for="parent_id">Catégorie Parente</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Aucune</option>
                <x-category-dropdown :categories="$categories" :selected="old('parent_id', $category->parent_id)" />
            </select>
            
            <button type="submit">Mettre à Jour</button>
        </form>
    </div>
    <button onclick="window.location.href='{{ route('categories.index') }}'" style="border-radius: 6px;">Precedent</button>
</div>
</div>
@endsection
