<!-- resources/views/bons_de_livraison/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <h3>Créer Bon de Livraison</h3>
            <form action="{{route('bons_de_livraison.store')}}" method="POST">
                @csrf

                <input type="hidden" name="date_livraison" value="{{ now()->format('Y-m-d') }}">

                <label for="demande_id">Choisir le destinataire</label>
                <select name="demande_id" id="demande_id" required>
                    <option value="">-- Sélectionner --</option>
                    @if(auth()->user()->hasRole('admin'))
                    @foreach($demandes as $demande)
                        <option value="{{ $demande->delivery_address }}">
                            {{ $demande->delivery_address}}
                        </option>
                    @endforeach
                    @else
                    @foreach($demandes as $demande)
                        <option value="{{ $demande->delivery_address }}">
                            {{ $demande->delivery_address }}
                        </option>
                    @endforeach
                    @endif

                </select>
                <div id="demandes-table">
                    
                </div>

                <button type="submit" class="btn">Valider</button>
                @if(session('message'))
                    <div class="alert {{ session('message.type') }}">
                        {{ session('message.text') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#demande_id').on('change', function() {
            let deliveryAddress = $(this).val();
            if (deliveryAddress) {
                $.ajax({
                    url: `/get-demandes/${deliveryAddress}`,
                    type: 'GET',
                    success: function(data) {
                        $('#demandes-table').html(data);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#demandes-table').html('');
            }
        });
    });
</script>
@endsection