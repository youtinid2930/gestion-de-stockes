@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
    @if (auth()->user()->role == 'admin' || auth()->user()->role == 'gestionnaire')
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Commande</div>
                    <div class="number">{{ $data['commandes']['nbre'] }}</div>
                    <div class="indicator">
                        <i class="bx bx-up-arrow-alt"></i>
                        <span class="text">Depuis hier</span>
                    </div>
                </div>
                <i class="bx bx-cart-alt cart"></i>
            </div>
        
            @endif
        
            <div class="box">
                <div class="right-side">
                    <div class="box-topic">Article</div>
                    <div class="number">{{ $data['articles']['nbre'] }}</div>
                    <div class="indicator">
                        <i class="bx bx-up-arrow-alt"></i>
                        <span class="text">Depuis hier</span>
                    </div>
                </div>
                <i class="bx bx-cart cart three"></i>
            </div>
       
    </div>

    
        <div class="sales-boxes">
            <div class="recent-sales box">
                <div class="title">Commandes récentes</div>
                <div class="sales-details">
                    <ul class="details">
                        <li class="topic">Date</li>
                        @foreach ($data['recentCommandes'] as $commande)
                            <li><a href="#">{{ date('d M Y', strtotime($commande->date_commande)) }}</a></li>
                        @endforeach
                    </ul>
                    <ul class="details">
                        <li class="topic">Client</li>
                        @foreach ($data['recentCommandes'] as $commande)
                            <li><a href="#">{{ $commande->client_name }}</a></li>
                        @endforeach
                    </ul>
                    <ul class="details">
                        <li class="topic">Article</li>
                        @foreach ($data['recentCommandes'] as $commande)
                            @foreach ($commande->details as $detail)
                                <li><a href="#">{{ $detail->article_name }}</a></li>
                            @endforeach
                        @endforeach
                    </ul>
                    <ul class="details">
                        <li class="topic">Prix</li>
                        @foreach ($data['recentCommandes'] as $commande)
                            <li><a href="#">{{ number_format($commande->total_price, 0, ",", " ") . " DH" }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="button">
                    <a href="#">Voir Tout</a>
                </div>
            </div>
        </div>
    
</div>
@endsection
