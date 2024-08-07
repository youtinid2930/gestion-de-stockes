@extends('layouts.app')

@section('title', 'Caracteristique')

@section('content')
<div class="home-content">
<div class="overview-boxes">
<div class="box">
    <h2>Caracteristique de {{ $category->name }}</h2>

    <form action="{{ route('characteristicsbycategorie.store', $category->id) }}" method="POST">
        @csrf
        <label for="name">nom de caracteristique</label>
        <select name="name" id="name" required>
            <option value="">Sélectionner une caractere</option>
            @foreach($caracteristique as $character) 
                <option value="{{ $character->name }}">{{ $character->name }}</option>
            @endforeach
        </select>
        <div class="button-container">
            <button type="submit" style="border-radius: 5%;">Ajouter</button>
        </div>
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

<script>
    $(document).ready(function() {
        $('#name').select2({
            placeholder: 'Sélectionner une caractere',
            allowClear: true,
            theme: 'bootstrap4'
        });
    });
</script>
@endsection
