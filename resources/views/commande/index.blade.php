@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<div class="home-content">

    <div class="overview-boxes">
        <div class="box">
         @if($commandes->isNotEmpty())
            <table class="mtable">
                
                    <tr>
                        <th>Fournisseur</th>
                        <th>Articles</th>
                        <th>Quantité Totale</th>
                        <th>Prix Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                
                
                    @foreach ($commandes as $commande)
                        <tr>
                            <td>{{ $commande->fournisseur->name }} {{ $commande->fournisseur->last_name }}</td>
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
                                @if($commande->status == "En attente")
                                <a href="{{ route('commande.edit', $commande->id) }}" class="btn btn-icon">
                                    <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                </a>
                                <form action="{{ route('commande.destroy', $commande->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button btn btn-icon">
                                    <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                    </button>
                                </form>
                                @else
                                    @if(!$commande->facteurs)
                                        <a href="{{ route('factures.show', $commande->id) }}" class="btn btn-icon">
                                            <i class="fas fa-file-invoice" aria-hidden="true" data-toggle="tooltip" title="Gérer la facteur"></i>
                                        </a>
                                    @else      
                                        <a href="{{ route('factures.create', $commande->id) }}" class="btn btn-icon">
                                            <i class="fas fa-file-invoice" aria-hidden="true" data-toggle="tooltip" title="Créer la facteur"></i>
                                        </a>
                                    @endif
                                @endif
                                <a href="{{ route('commande.show', $commande->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur la commande">&#9660;</a>
                            </td>

                        </tr>
                    @endforeach
                
            </table>
            @else
                <div>Aucune commande trouvée</div>
            @endif
            
            <a href="{{ route('commande.create') }}" class="btn" style="margin-right: 80%; margin-top: 1%;">Créer une commande</a>
            
        </div>
        <a href="{{ route('facteurs.index') }}" class="btn" style="margin-right: 80%; margin-top: 1%;">Voir les facteur</a>
    </div>
    
</div>
@endsection
