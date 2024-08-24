@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')

<div class="home-content">
    <div class="overview-boxes" style="flex-direction: column;">
    @if(auth()->user()->hasRole('admin'))
        <div style="display: flex; flex-direction: row; margin-right: 6%;">
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Commandes en cours</div>
                <div class="number">{{ $data['commandesEnCours']['nbre'] ?? 'N/A' }}</div>
                <div class="indicator">
                    <i class="bx bx-up-arrow-alt"></i>
                    <span class="text">Depuis {{ $data['commandesEnCours']['timeSinceLastUpdate'] }}</span>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Commandes terminées</div>
                <div class="number">{{ $data['commandesTerminees']['nbre'] }}</div>
            </div>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Articles</div>
                <div class="number">{{ $data['articles']['nbre'] }}</div>
                <div class="indicator">
                    <i class="bx bx-up-arrow-alt"></i>
                    <span class="text">Depuis {{ $data['articles']['timeSinceLastUpdate'] }}</span>
                </div>
            </div>
        </div>
        </div>
        <div style="display: flex; flex-direction: row; margin-right: 6%;">
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Articles créés aujourd'hui</div>
                <div class="number">{{ $data['articles']['createdToday'] }}</div>
            </div>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Articles en stock</div>
                <div class="number">
                    {{ $data['articlesInStock'] }}
                </div>
            </div>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Fournisseurs</div>
                <div class="number">{{ $data['fournisseursCount'] }}</div>
            </div>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">Utilisateurs</div>
                <div class="number">{{ $data['usersCount'] }}</div>
            </div>
        </div>
        </div>
</div>


<div class="sales-boxes">
    <div style="display: flex; flex-direction: column; margin-right: 6%;">  
    <div class="recent-sales box" style="margin-bottom: 4%;">
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
    <div class="recent-sales box">
            <div class="title">Demandes récentes</div>
            <table>
                <tr>
                    <th>Magasinier</th>
                    <th>Articles</th>
                    <th>Quantité Totale</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

                @forelse ($data['recentDemandes'] as $demande)
                <tr>
                    <td>{{ $demande->magasinier->name }} {{$demande->magasinier->last_name}}</td>
                    <td>
                        <ul>
                            @foreach ($demande->demandeDetails as $detail)
                                <li>{{ $detail->article->name }} ({{ $detail->quantity }} unités)</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $demande->demandeDetails->sum('quantity') }}</td>
                    <td>{{ optional($demande->updated_at)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('demande.edit', $demande->id) }}"><i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la demande"></i></a>
                        <form action="{{ route('demande.destroy', $demande->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande ?');" class="delete-button">
                                <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la demande"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5">Aucune demande récente</td>
                    </tr>
                @endforelse
            </table>
            <div class="button">
                <a href="{{ route('demande.index') }}">Voir Tout</a>
            </div>
        </div>
    </div>
    </div>
    @elseif(auth()->user()->hasRole('magasinier'))
            <div style="display: flex; flex-direction: row; margin-right: 6%;">
            <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Articles en stock</div>
                        <div class="number">{{ $data['articlesInStock'] }}</div>
                    </div>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Demandes en cours</div>
                        <div class="number">{{ $data['demandesEnCours'] }}</div>
                    </div>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Demandes terminées</div>
                        <div class="number">{{ $data['demandesTerminees'] }}</div>
                    </div>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Livraisons en cours</div>
                        <div class="number">{{ $data['livraisonsEnCours']->count() }}</div>
                    </div>
                </div>
                
            </div>
            <div style="display: flex; flex-direction: row; margin-right: 6%;">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Livraisons livrées</div>
                        <div class="number">{{ $data['livraisonsLivrees']->count() }}</div>
                    </div>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Livraisons terminées</div>
                        <div class="number">{{ $data['livraisonsTerminees']->count() }}</div>
                    </div>
                </div>
            </div>
        <div class="sales-boxes">
            <div style="display: flex; flex-direction: column; margin-right: 6%;">
                <div class="recent-sales box" style="margin-bottom: 4%;">
                    <div class="title">Mes dernieres demandes</div>
                    <table>
                        <tr>
                            <th>Administrateur</th>
                            <th>Articles</th>
                            <th>Quantité Totale</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($data['mesDernieresDemandes'] as $demande)
                        <tr>
                            <td>{{ $demande->magasinier->name }} {{ $demande->magasinier->last_name }}</td>
                            <td>
                                <ul>
                                    @foreach ($demande->demandeDetails as $detail)
                                        <li>{{ $detail->article->name }} ({{ $detail->quantity }} unités)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $demande->demandeDetails->sum('quantity') }}</td>
                            <td>{{ optional($demande->updated_at)->format('d M Y') }}</td>
                            <td>
                            @if($demande->status == "En attente")
                                <a href="{{ route('demande.edit', $demande->id) }}" class="btn btn-icon"><i class='bx bx-edit-alt' data-toggle="tooltip" title="mettre a jour la demande"></i></a>
                                <form action="{{ route('demande.destroy', $demande->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('vous êtes sûr de supprimer cette demande?');" class="delete-button">
                                    <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la demande"></i>
                                </button>
                                </form>
                            @elseif($demande->status == "Livrée")
                                <a href="{{ route('demande.status',$demande->id) }}" class="btn btn-icon"><i class="fa fa-check" data-toggle="tooltip" title="Valider la demande"></i></a>
                            @endif
                                <a href="{{ route('demande.show', $demande->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur la demande">&#9660;</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">Aucune demande récente</td>
                            </tr>
                        @endforelse
                    </table>
                    <div class="button">
                        <a href="{{ route('demande.index') }}" class="btn btn-primary">Voir Tout</a>
                    </div>
                </div>
                <div class="recent-sales box">
                    <div class="title">Dernieres demandes reçues</div>
                    <table>
                        <tr>
                            <th>Gestionnaire</th>
                            <th>Articles</th>
                            <th>Quantité Totale</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($data['derniereDemandesRecues'] as $demande)
                        <tr>
                            <td>{{ $demande->gestionnaire->name }} {{ $demande->gestionnaire->last_name }}</td>
                            <td>
                                <ul>
                                    @foreach ($demande->demandeDetails as $detail)
                                        <li>{{ $detail->article->name }} ({{ $detail->quantity }} unités)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $demande->demandeDetails->sum('quantity') }}</td>
                            <td>{{ optional($demande->updated_at)->format('d M Y') }}</td>
                            <td>
                            <div style="display: flex; flex-direction: row;">
                            @if($demande->status == "En attente")
                                <a href="{{ route('demande.status',$demande->id) }}" class="btn btn-icon"><i class="fa fa-tachometer-alt" data-toggle="tooltip" title="traiter la demande"></i></a>
                            @elseif($demande->status == "En cours de traitement")
                                <a href="{{ route('demande.status',$demande->id) }}" class="btn btn-icon"><i class="fa fa-truck" data-toggle="tooltip" title="livrer la demande"></i></a>
                            @endif
                                <a href="{{ route('demande.show', $demande->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur la demande">▼</a>
                            </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">Aucune demande récente</td>
                            </tr>
                        @endforelse
                    </table>
                    <div class="button">
                        <a href="{{ route('demande.index') }}" class="btn btn-primary">Voir Tout</a>
                    </div>
                </div>
                
            </div>
        </div>
    @else
           <div style="display: flex; flex-direction: row; margin-right: 6%;">
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Demandes en cours</div>
                        <div class="number">{{ $data['demandesEnCours'] }}</div>
                    </div>
                </div>
                <div class="box">
                    <div class="right-side">
                        <div class="box-topic">Demandes terminées</div>
                        <div class="number">{{ $data['demandesTerminees'] }}</div>
                    </div>
                </div>
           </div>
            <div class="sales-boxes">
            <div style="display: flex; flex-direction: column; margin-right: 6%;">
                <div class="recent-sales box" style="margin-bottom: 4%;">
                    <div class="title">Mes dernieres demandes</div>
                    <table>
                        <tr>
                            <th>Administrateur</th>
                            <th>Articles</th>
                            <th>Quantité Totale</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($data['mesDernieresDemandes'] as $demande)
                        <tr>
                            <td>{{ $demande->magasinier->name }} {{ $demande->magasinier->last_name }}</td>
                            <td>
                                <ul>
                                    @foreach ($demande->demandeDetails as $detail)
                                        <li>{{ $detail->article->name }} ({{ $detail->quantity }} unités)</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $demande->demandeDetails->sum('quantity') }}</td>
                            <td>{{ optional($demande->updated_at)->format('d M Y') }}</td>
                            <td>
                            @if($demande->status == "En attente")
                                <a href="{{ route('demande.edit', $demande->id) }}" class="btn btn-icon"><i class='bx bx-edit-alt' data-toggle="tooltip" title="mettre a jour la demande"></i></a>
                                <form action="{{ route('demande.destroy', $demande->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('vous êtes sûr de supprimer cette demande?');" class="delete-button">
                                    <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la demande"></i>
                                </button>
                                </form>
                            @elseif($demande->status == "Livrée")
                                <a href="{{ route('demande.status',$demande->id) }}" class="btn btn-icon"><i class="fa fa-check" data-toggle="tooltip" title="Valider la demande"></i></a>
                            @endif
                                <a href="{{ route('demande.show', $demande->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur la demande">&#9660;</a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">Aucune demande récente</td>
                            </tr>
                        @endforelse
                    </table>
                    <div class="button">
                        <a href="{{ route('demande.index') }}" class="btn btn-primary">Voir Tout</a>
                    </div>
                </div>
            </div>
            </div>
    @endif
    </div>
</div>
</div>
@endsection
