@extends('layouts.app')

@section('title', 'Liste des Factures')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h1>Liste des Factures</h1>

            @if($facteurs)

            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro de Facture</th>
                        <th>Date d'émission</th>
                        <th>Date d'échéance</th>
                        <th>Fournisseur</th>
                        <th>Montant Total</th>
                        <th>Montant Payé</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($facteurs as $facteur)
                        <tr>
                            <td>{{ $facteur->invoice_number }}</td>
                            <td>{{ $facteur->issue_date->format('d-m-Y') }}</td>
                            <td>{{ $facteur->due_date->format('d-m-Y') }}</td>
                            <td>{{ $facteur->fournisseur->name }} {{$facteur->fournisseur->last_name}}</td>
                            <td>{{ $facteur->total_amount }}</td>
                            <td>{{ $facteur->amount_paid }}</td>
                            <td>{{ $facteur->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                {{ 'aucune facteur crée' }}
            @endif
        </div>
        <a href="{{ route('commandes.index') }}" class="btn" style="margin-right: 80%;">Retour</a>
    </div>
</div>

@endsection
