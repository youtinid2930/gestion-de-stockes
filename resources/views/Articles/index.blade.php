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
                            @if(auth()->user()->hasRole('admin'))
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
                            @endif
                            @if(auth()->user()->hasRole('magasinier'))
                                @if($article->total_quantity == 0)
                                <a href="{{ route('articles.add', ['id' => $article->id]) }}" class="btn btn-icon" title="Ajouter au stock">
                                    <i class='bx bx-plus'></i>
                                </a>
                                @else
                                <a href="{{ route('articles.add', ['id' => $article->id]) }}" class="btn btn-icon" title="Mettre à jour">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('articles.cancelStock', ['id' => $article->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler l\'ajout de stock?');" class="delete-button btn btn-icon" title="Annuler">
                                        <i class='bx bx-x'></i>
                                    </button>
                                </form>
                                @endif
                            @endif
                            <button onclick="window.location.href='{{ route('articles.show', $article->id) }}'" class="btn">Voir plus</button>
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
            @if(auth()->user()->hasRole('admin'))
            <div class="mt-3">
                <button onclick="window.location.href='{{ route('articles.create') }}'" class="btn">Créer article</button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
