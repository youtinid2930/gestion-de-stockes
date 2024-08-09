@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Fournisseur</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($commandes as $value)
                    <tr>
                        <td>{{ $value->fournisseur->name }}</td>
                        <td>{{ $value->quantite }}</td>
                        <td>{{ $value->prix }}</td>
                        <td>{{ $value->date_commande->format('d/m/Y H:i:s') }}</td>
                        <td>
                        <a href="{{ route('fournisseur.edit', $value->id) }}"><i class='bx bx-edit-alt'></i></a>
                        <form action="{{ route('fournisseur.destroy', $value->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('est ce que tu es sur vous voulez supprimer cet fournisseur ?');" class="delete-button">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                        <button onclick="window.location.href='{{ route('fournisseur.show', $value->id) }}'">Voir plus</button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div style="background-color: #03be1c;margin-left: 5%;margin-right: 73%;border-radius: 5%;padding: 1%;">
            <a href="{{ route('commande.create') }}" style="color: white">Creer un commande<i class="bx bx-plus"></i></a>
        </div>
    </div>
</div>
@endsection
