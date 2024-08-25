@extends('layouts.app')

@section('title', 'Livraison')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <div class="title">Bons de Livraison</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro de Livraison</th>
                        <th>Numéro des Demandes/Commandes</th>
                        <th>Date de Livraison</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(Auth::user()->hasRole('admin'))
                        @foreach($bonsDeLivraisonCommande as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->commande)
                                            <a href="{{ route('commande.show', $detail->commande->id) }}">{{ $detail->commande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ route('bons_de_livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button btn btn-icon">
                                            <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @foreach($bonsDeLivraisonDemande as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ route('bons_de_livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button btn btn-icon">
                                            <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    @elseif(Auth::user()->hasRole('magasinier'))
                        @foreach($meBonsDeLivraison as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn">Modifier</a>
                                    <form action="{{ route('bons_de_livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button btn btn-icon">
                                            <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                        </button>
                                </td>
                            </tr>
                        @endforeach

                        @foreach($bonDeLivraisonrecus as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ route('bons_de_livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button btn btn-icon">
                                            <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    @else
                        @foreach($bonDeLivraisonrecus as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-warning">Modifier</a>
                                    <form action="{{ route('bons_de_livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?');" class="delete-button btn btn-icon">
                                            <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la commande"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" 
                onclick="window.location.href='{{ route('bons_de_livraison.create') }}'" 
                style="width: 200px; height: 50px; padding: 10px;">
            Créer Bon de Livraison
        </button>
    </div>
</div>
@endsection
