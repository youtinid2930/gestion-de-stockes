@extends('layouts.app')

@section('title', 'Catégorie')

@section('content')
<div class="home-content">
<div class="overview-boxes">
    <div class="box">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" required>
            
            <label for="parent_id">Catégorie Parente</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Aucune</option>
                <x-category-dropdown :categories="$categories" :selected="old('parent_id')" />
            </select>
            
            <button type="submit">Ajouter</button>
        </form>
    </div>
    <button onclick="window.location.href='{{ route('categories.index') }}'" style="border-radius: 6px;">Precedent</button>
</div>
</div>
@endsection
