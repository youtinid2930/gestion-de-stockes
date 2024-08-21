@extends('layouts.app')

@section('title', 'Demande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        @if(auth()->user()->hasRole('magasinier') || auth()->user()->hasRole('gestionnaire'))
        <h1>Mes commandes</h1>
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
                    <a href="{{ route('demande.edit', $demande->id) }}"><i class='bx bx-edit-alt'></i></a>
                    <form action="{{ route('demande.destroy', $demande->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                        <button type="submit" onclick="return confirm('vous êtes sûr de supprimer cette demande?');" class="delete-button">
                            <i class='bx bx-trash'></i>
                        </button>
                </form>
                </td>
                </tr>
                @endforeach
            </table>

            @else
                 <div> Aucune demande trouvée <div>
            @endif
        </div>
        <br>
        <button onclick="window.location='{{ route('demande.create') }}'" class="btn">Créer Demande</button>
        @endif
        @if(auth()->user()->hasRole('magasinier') || auth()->user()->hasRole('admin'))

        @endif
    </div>
</div>
@endsection

