@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')

<div class="home-content">
    @if(auth()->user()->hasRole('admin'))
    <div class="overview-boxes" style="flex-direction: row;">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Commande</div>
            <div class="number">{{ $data['commandes']['nbre'] ?? 'N/A' }}</div>
            <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Depuis {{ $data['commandes']['timeSinceLastUpdate'] }}</span>
            </div>
        </div>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Article</div>
            <div class="number">{{ $data['articles']['nbre'] }}</div>
            <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text">Depuis {{ $data['articles']['timeSinceLastUpdate'] }}</span>
            </div>
        </div>
    </div>
</div>

    
<div class="sales-boxes">
    <div class="recent-sales box">
        <div class="title">Commandes récentes</div>
            <table class="">
                    <tr>
                        <th>Fournisseur</th>
                        <th>Articles</th>
                        <th>Quantité Totale</th>
                        <th>Prix Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>

                    @forelse ($data['recentCommandes'] as $commande)
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
                        <td>{{ optional($commande->updated_at)->format('d M Y') }}</td>
                        <td> 
                        <a href="{{ route('commande.edit', $commande->id) }}"><i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i></a>
                            <form action="{{ route('commande.destroy', $commande->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button">
                                    <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                </button>
                            </form>
                            <a href="{{ route('commande.edit', $commande->id) }}"><i class="fas fa-check" data-toggle="tooltip" title="Valider la commande"></i></a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4">Aucune commande récente</td>
                        </tr>
                    @endforelse
            </table>
        <div class="button">
            <a href="{{route('commande.index')}}">Voir Tout</a>
        </div>
    </div>
    @endif

</div>
</div>
@endsection
