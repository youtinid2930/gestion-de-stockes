@extends('layouts.app')

@section('title', 'Livraison')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <div class="title">Bons de Livraison</div>
            <table class="table">
                
                    <tr>
                        <th>Numéro de Livraison</th>
                        <th>Numéro des Demandes<br>Commandes</th>
                        <th>Date de Livraison</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                
                
                    @role('admin')
                        @foreach($bonsDeLivraisonCommande as $bon)
                            <tr>
                                <td rowspan="">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->commande)
                                            <a href="{{ route('commande.show', $detail->commande->id) }}">{{ $detail->commande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-icon">
                                        <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                    </a>
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
                                <td rowspan="">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a><br>
                                        @endif
                                    @endforeach
                                </td>
                                <td rowspan="">
                                    {{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}
                                </td>
                                <td rowspan="">
                                    {{ $bon->status }}
                                </td>
                                <td rowspan="">
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-icon">
                                        <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                    </a>
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

                    @endrole

                    @role('magasinier')
                        @foreach($meBonsDeLivraison as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a>
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
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-icon">
                                        <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                    </a>
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

                        @foreach($bonDeLivraisonrecus as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a>
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
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-icon">
                                        <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                    </a>
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

                    @endrole

                    @unlessrole('admin|magasinier')
                        @foreach($bonDeLivraisonrecus as $bon)
                            <tr>
                                <td rowspan="{{ $bon->bonDeLivraisonDetails->count() + 1 }}">{{ $bon->numero }}</td>
                                <td>
                                    @foreach($bon->bonDeLivraisonDetails as $detail)
                                        @if ($detail->demande)
                                            <a href="{{ route('demande.show', $detail->demande->id) }}">{{ $detail->demande->numero }}</a>
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
                                    <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-icon">
                                        <i class='bx bx-edit-alt' data-toggle="tooltip" title="Mettre à jour la commande"></i>
                                    </a>
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
                    @endunlessrole
                
            </table>
        </div>
    </div>
</div>
@endsection
