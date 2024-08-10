@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Fournisseur</th>
                    <th>Articles</th>
                    <th>Quantité Totale</th>
                    <th>Prix Total</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
                @foreach ($commandes as $commande)
                    <tr>
                        <td>{{ $commande->fournisseur->name }}</td>
                        <td>
                            <ul>
                                @foreach ($commande->commandeDetails as $detail)
                                    <li>{{ $detail->article->name }} ({{ $detail->quantite }} unités à {{ $detail->prix }} chacune)</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $commande->commandeDetails->sum('quantite') }}</td>
                        <td>{{ $commande->commandeDetails->sum('prix') }}</td>
                        <td>{{ $commande->date_commande }}</td>
                        <td>
                            <a href="{{ route('commande.edit', $commande->id) }}"><i class='bx bx-edit-alt'></i></a>
                            <form action="{{ route('commande.destroy', $commande->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div style="background-color: #03be1c;margin-left: 5%;margin-right: 73%;border-radius: 5%;padding: 1%;">
            <a href="{{ route('commande.create') }}" style="color: white">Créer une commande <i class="bx bx-plus"></i></a>
        </div>
    </div>
</div>
@endsection
