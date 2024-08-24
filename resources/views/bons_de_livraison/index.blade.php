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
                        <th>Numéro</th>
                        <th>Date de Livraison</th>
                        <th>Adresse de Livraison</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bonsDeLivraison as $bon)
                        <tr>
                            <td>{{ $bon->numero }}</td>
                            <td>{{ \Carbon\Carbon::parse($bon->date_livraison)->format('Y-m-d') }}</td>
                            <td>
                                {{ optional($bon->bonDeLivraisonDetails->first()->demande)->delivery_address ?? 'Adresse non disponible' }}
                            </td>
                            <td>
                                <a href="{{ route('bons_de_livraison.edit', $bon->id) }}" class="btn btn-warning">Modifier</a>
                                <form action="{{ route('bons_de_livraison.destroy', $bon->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @if($bon->bonDeLivraisonDetails->isNotEmpty())
                            <tr>
                                <td colspan="4">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Numéro de Demande</th>
                                                <th>Article</th>
                                                <th>Quantité</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bon->bonDeLivraisonDetails as $detail)
                                                <tr>
                                                    <td>{{ $detail->demande->numero }}</td>
                                                    <td>{{ $detail->article->name }}</td>
                                                    <td>{{ $detail->quantity }}</td>
                                                    
                                                    <td>{{ number_format($detail->quantity * $detail->unit_price, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
                    @endforeach
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
