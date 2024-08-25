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

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</div>
</div>
@endsection
