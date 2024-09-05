@extends('layouts.app')

@section('title', 'Facteurs')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
        <h1>Liste des Factures</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table class="table">
           
            <tr>
                <th>Numéro de Facture</th>
                <th>Fournisseur</th>
                <th>Montant Total</th>
                <th>Montant Payé</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
    
     
            @foreach($Facteurs as $facteur)
            <tr>
                <td>{{ $facteur->invoice_number }}</td>
                <td>{{ $facteur->fournisseur->name }} {{$facteur->fournisseur->last_name}}</td>
                <td>{{ $facteur->total_amount }}</td>
                <td>{{ $facteur->amount_paid }}</td>
                <td>{{ $facteur->status }}</td>
                <td>
                <a href="{{ route('factures.edit', $facteur->id) }}" class="btn btn-icon" data-toggle="tooltip" title="mettre a jour la facteur"><i class='bx bx-edit-alt'></i></a>
                    <form action="{{ route('facteurs.destroy', $facteur->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('est ce que tu es sur vous voulez supprimer cette facteur ?');" class="delete-button btn btn-icon">
                            <i class='bx bx-trash' data-toggle="tooltip" title="Supprimer la facteur"></i>
                        </button>
                    </form>
                    <a href="{{ route('factures.showone',$facteur->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur la facteur">&#9660;</a>
                </td>
            </tr>
            @endforeach
    
            </table>
            @if($total_amount > $total_paid)
            <a href="{{ route('factures.create', $id) }}" class="btn" style="margin-right: 80%;">
                    Ajouter un facteur
            </a>
            @endif
            <a href="{{ route('commandes.index') }}" class="btn" style="margin-right: 80%; margin-top: 1%;">Retour</a>
        </div>
        @if (session('error'))
        <div class="alert alert-danger">
        {{ session('error') }}
        </div>
        @endif
    </div>
</div>

@endsection