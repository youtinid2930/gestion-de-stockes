@extends('layouts.app')

@section('title', 'Caracteristique')

@section('content')
<div class="home-content">
<div class="overview-boxes">
<div class="box">
    <h2>Caracteristiques</h2>

    <form action="{{ isset($editCharacteristic) ? route('characteristics.update', $editCharacteristic->id) : route('characteristics.store') }}" method="POST">
        @csrf
        @if(isset($editCharacteristic))
            @method('PUT')
            <label for="name">Nom de caracteristique</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $editCharacteristic->name }}" required>
            <div class="button-container">
                <button type="submit" style="border-radius: 5%;">Mettre à jour</button>
            </div>
        @else
            <label for="name">Nom de caracteristique</label>
            <input type="text" name="name" id="name" class="form-control" required>
            <div class="button-container">
                <button type="submit" style="border-radius: 5%;">Ajouter</button>
            </div>
        @endif
    </form>

    <div class="list-group mt-4">
        @foreach($caracteristiques as $characteristic)
            <div class="list-group-item">
                {{ $characteristic->name }}
                <div class="float-right">
                    <a href="{{ route('characteristics.edit', $characteristic->id) }}">
                        <i class="bx bx-edit-alt"></i>
                    </a>
                    <form action="{{ route('characteristics.destroy', [$characteristic->id]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('est ce que tu es sur vous voulez supprimer cet caracteristique ?');" class="delete-button">
                            <i class='bx bx-trash'></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="button-container">
    <button onclick="window.location.href='{{ route('categories.index') }}'" style="border-radius: 5px;">Precedent</button>
    </div>
</div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
     @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
</div>
</div>
@endsection
