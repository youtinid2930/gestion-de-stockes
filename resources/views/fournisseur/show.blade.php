@extends('layouts.app')

@section('title', 'Fournisseur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
                <label for="nom">Nom</label>
                <input value="{{ old('name', $fournisseur->name) }}" type="text" name="name" id="nom" readonly>
                

                <label for="prenom">Prénom</label>
                <input value="{{ old('last_name', $fournisseur->last_name) }}" type="text" name="last_name" id="prenom" readonly >
               

                <label for="telephone">N° de téléphone</label>
                <input value="{{ old('telephone', $fournisseur->phone) }}" type="text" name="phone" id="telephone" readonly>
                

                <label for="email">Email</label>
                <input value="{{ old('email', $fournisseur->email) }}" type="email" name="email" id="email" readonly>

                <label for="adresse">Adresse</label>
                <input value="{{ old('adresse', $fournisseur->address) }}" type="text" name="address" id="adresse" readonly>
                <div style="display: flex; flex-direction: row; margin-top: 2%;">
                <button onclick="window.location.href='{{ route('fournisseur.edit',$fournisseur->id) }}'" style="border-radius: 6px;">Mise a jour</button>
                <form action="{{ route('fournisseur.destroy', $fournisseur->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('est ce que tu es sur vous voulez supprimer cet fournisseur ?');" style="border-radius: 6px; margin-left: 1%;">
                        <i class='bx bx-trash'></i>
                    </button>
                </form>
                </div>
        </div>
        <button onclick="window.location.href='{{ route('fournisseur.index') }}'" style="border-radius: 6px;">Precedent</button>
    </div>
</div>
@endsection
