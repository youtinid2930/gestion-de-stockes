@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
        <form action="{{ !empty($demande) ? route('demande.update', $demande->id) : route('demande.store') }}" method="POST">
                @csrf
                @if (!empty($demande))
                    @method('PUT')
                @endif

                <label for="quantity">quantity</label>
                <input value="{{ old('quantity', $demande->quantity ?? '') }}" type="text" name="name" id="quantity" placeholder="Veuillez saisir le quantity">
                
                <input value="{{ old('id', $demande->id ?? '') }}" type="hidden" name="id" id="id">
                
                <label for="notes">Notes</label>
                <input value="{{ old('notes', $demande->notes ?? '') }}" type="text" name="last_name" id="notes" placeholder="Veuillez saisir le Notes">
                
                <label for="status">status</label>
                <input value="{{ old('status', $demande->status ?? '') }}" type="text" name="phone" id="status" placeholder="Veuillez saisir le status">
                
                <label for="delivery_address">delivery_address</label>
                <input value="{{ old('delivery_address', $demande->delivery_address ?? '') }}" type="text" name="address" id="delivery_address" placeholder="Veuillez saisir l'delivery_address">


                <button type="submit">Valider</button>

                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
