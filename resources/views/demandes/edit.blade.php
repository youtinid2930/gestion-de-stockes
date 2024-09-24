@extends('layouts.app')

@section('title', 'Modifier Demande')

@section('content')
<div class="home-content">
<div class="overview-boxes">
    <div class="box">
    <h2>Modifier Demande #{{ $demande->numero }}</h2>
    <form action="{{ route('demande.update', $demande->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h4>Articles</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demande->demandeDetails as $detail)
                    <tr>
                        <td>
                            <select name="details[{{ $loop->index }}][article_id]" class="form-control" required>
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}" {{ $article->id == $detail->article_id ? 'selected' : '' }}>
                                        {{ $article->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="details[{{ $loop->index }}][quantity]" class="form-control" value="{{ $detail->quantity }}" required>
                            <input type="hidden" name="details[{{ $loop->index }}][id]" value="{{ $detail->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <label for="urgence">urgence</label>
        <select name="urgence" id="urgence">
            <option value="">{{ $demande->urgence }}</option>
            <option value="{{ 'Bas' }}">Bas</option>
            <option value="{{ 'Moyen' }}">Moyen</option>
            <option value="{{ 'Élevé' }}">Élevé</option>
        </select>
        
        <button type="submit" class="btn">Mettre à jour</button>
    </form>
    <button onclick="window.history.back()" class="btn">Retour</button>
</div>
</div>
</div>
@endsection
