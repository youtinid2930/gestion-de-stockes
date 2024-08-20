@extends('layouts.app')

@section('title', 'Article')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box" style="display: block;">
            <br>
            <table class="mtable">
                <tr>
                    <th>Nom article</th>
                    <th>Catégorie</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Action</th>
                </tr>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>{{ $article->total_quantity }}</td>
                        <td>{{ $article->unit_price }}</td>
                        <td>
                            <a href="{{ route('articles.edit', $article->id) }}">
                                <i class='bx bx-edit-alt'></i>
                            </a>
                                <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('vous etes sure de supprimer cette Article?');" class="delete-button">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </table>

            <div class='pagination'>
            @if ($page > 1)
                <a href="{{ route('articles.index', ['page' => $page - 1]) }}">&laquo; Précédent</a>
            @endif

            @for ($i = 1; $i <= $total_pages; $i++)
                <a class="{{ $i == $page ? 'active' : '' }}" href="{{ route('articles.index', ['page' => $i]) }}">{{ $i }}</a>
            @endfor

            @if ($page < $total_pages)
                <a href="{{ route('articles.index', ['page' => $page + 1]) }}">Suivant &raquo;</a>
            @endif
            </div>
            <div class="mt-3 btns">
            <a href="{{ route('articles.create') }}" class="btn btn-primary">creer article</a>
            </div>
        </div>
    </div>
</div>
@endsection
