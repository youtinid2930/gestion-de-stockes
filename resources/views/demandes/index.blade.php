@extends('layouts.app')

@section('title', 'Demande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        @if(auth()->user()->hasRole('magasinier') || auth()->user()->hasRole('gestionnaire'))
        <div class="box" style="margin-right: 70%;"><h3>Mes demandes</h3></div>
        <div class="box">
            @if($Medemandes->isNotEmpty())
            <table>
                <tr>
                @if(auth()->user()->hasRole('magasinier'))
                    <th>Administrateur</th>
                @else
                    <th>Magasinier</th>
                @endif
                <th>Articles</th>
                <th>Quantité</th>
                <th>Status</th>
                <th>Adresse de livraison</th>
                <th>Action</th>
                </tr>
                @foreach ($Medemandes as $demande)
                <tr>
                @if(auth()->user()->hasRole('magasinier'))
                    <td>{{ $demande->admin->name }} {{ $demande->admin->last_name }}</td>
                @else
                    <td>{{ $demande->magasinier->name }} {{ $demande->magasinier->last_name }}</td>
                @endif
            
                <!-- Articles and Quantities -->
                <td>
                @foreach($demande->demandeDetails as $detail)
                    <div>{{ $detail->article->name }}</div>
                @endforeach
                </td>
                <td>
                @foreach($demande->demandeDetails as $detail)
                    <div>{{ $detail->quantity }}</div>
                @endforeach
                </td>

                <!-- Status and Delivery Address -->
                <td>{{ $demande->status }}</td>
                <td>{{ $demande->delivery_address }}</td>

                <!-- Actions -->
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
                @endforeach
            </table>

            @else
                 <div> Aucune demande trouvée <div>
            @endif
            <br>
            <button onclick="window.location='{{ route('demande.create') }}'" class="btn">Créer Demande</button>
        </div>
        
        @endif
        @if(auth()->user()->hasRole('magasinier') || auth()->user()->hasRole('admin'))
           <div class="box" style="margin-right: 60%;"><h3>Les demandes reçues</h3></div>
            <div class="box">
            @if($demandesRecus->isNotEmpty())
            <table>
                <tr>
                @if(auth()->user()->hasRole('magasinier'))
                    <th>Gestionnaire</th>
                @else
                    <th>Magasinier</th>
                @endif
                <th>Articles</th>
                <th>Quantité</th>
                <th>Status</th>
                <th>Adresse de livraison</th>
                <th>Action</th>
                </tr>
                @foreach ($demandesRecus as $demande)
                <tr>
                @if(auth()->user()->hasRole('magasinier'))
                    <td>{{ $demande->gestionnaire->name }} {{ $demande->gestionnaire->last_name }}</td>
                @else
                    <td>{{ $demande->magasinier->name }} {{ $demande->magasinier->last_name }}</td>
                @endif
            
                <!-- Articles and Quantities -->
                <td>
                @foreach($demande->demandeDetails as $detail)
                    <div>{{ $detail->article->name }}</div>
                @endforeach
                </td>
                <td>
                @foreach($demande->demandeDetails as $detail)
                    <div>{{ $detail->quantity }}</div>
                @endforeach
                </td>

                <!-- Status and Delivery Address -->
                <td>{{ $demande->status }}</td>
                <td>{{ $demande->delivery_address }}</td>

                <!-- Actions -->
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
                @endforeach
            </table>

            @else
                 <div> Aucune demande trouvée <div>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection

