@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box" style="display: block;">
            <form action="{{ route('articles.updateStock', $article->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="quantity">Quantité à ajouter</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                </div>
                <button type="submit" class="btn">Ajouter au stock</button>
                <a href="{{ route('articles.index') }}" class="btn">Precedent</a>
            </form>
        </div>
    </div>
</div>
@endsection
