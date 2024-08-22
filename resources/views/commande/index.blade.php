@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<div class="home-content">

    <div class="overview-boxes">
        <div class="box">
         @if($commandes->isNotEmpty())
            <table class="mtable">
                <thead>
                    <tr>
                        <th>Fournisseur</th>
                        <th>Articles</th>
                        <th>Quantité Totale</th>
                        <th>Prix Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
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
                            <td> {{ $commande->status }} </td>
                            <td>{{ optional($commande->updated_at)->format('d/m/Y H:i:s') ?? 'Date non disponible' }}</td>
                            <td>
                                <a href="{{ route('commande.edit', $commande->id) }}">
                                    <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                </a>
                                <form action="{{ route('commande.destroy', $commande->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button">
                                    <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                    </button>
                                </form>
                                <a href="{{ route('commande.edit', $commande->id) }}">
                                    <i class="fas fa-check" data-toggle="tooltip" title="Valider la commande"></i>
                                </a>         
                                <a href="{{ route('factures.index', ['commande_id' => $commande->id]) }}">
                                    <i class="fas fa-file-invoice" aria-hidden="true" data-toggle="tooltip" title="Facture de commande"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div>Aucune commande trouvée</div>
            @endif
        </div>
        <div style="background-color: #03be1c;margin-left: 5%;margin-right: 73%;border-radius: 5%;padding: 1%;">
            <a href="{{ route('commande.create') }}" style="color: white">Créer une commande <i class="bx bx-plus"></i></a>
        </div>
    </div>
</div>
@endsection
