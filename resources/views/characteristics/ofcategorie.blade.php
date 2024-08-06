@extends('layouts.app')

@section('title', 'Caracteristique')

@section('content')
<div class="home-content">
<div class="overview-boxes">
<div class="box">
    <h2>Caracteristique de {{ $category->name }}</h2>

    <form action="{{ route('characteristics.store', $category->id) }}" method="POST">
        @csrf
        <label for="name">nom de caracteristique</label>
        <input type="text" name="name" id="name" class="form-control" required>
        <button type="submit" style="border-radius: 6px; margin-top: 1em;">Ajouter</button>
    </form>

    <div class="list-group mt-4">
        @foreach ($characteristics as $characteristic)
            <div class="list-group-item">
                {{ $characteristic->name }}
                <div class="float-right">
                    <form action="{{ route('characteristics.destroy', [$category->id, $characteristic->id]) }}" method="POST" class="d-inline">
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

    <button onclick="window.location.href='{{ route('categories.index') }}'" style="border-radius: 6px;">Precedent</button>
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
