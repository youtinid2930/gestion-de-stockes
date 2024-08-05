@extends('layouts.app')


@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <label for="nom">Nom</label> <br>
            <input value="{{$utilisateur->name }}" type="text" name="name" id="nom" readonly> <br>
            <label for="last_name">Prénom</label> <br>
            <input value="{{$utilisateur->last_name }}" type="text" name="last_name" id="prenom" readonly> <br>
            <label for="telephone">N° de téléphone</label> <br>
            <input value="{{$utilisateur->telephone }}" type="text" name="telephone" id="telephone" readonly> <br>
            <label for="email">Email</label> <br>
            <input value="{{$utilisateur->email }}" type="text" name="email" id="email" readonly> <br>
            <label for="etat">État</label> <br>
            <input value="{{$utilisateur->etat }}" type="text" name="etat" id="etat" readonly> <br>
            <label for="role">Role</label> <br>
            <input value="{{$utilisateur->roles->pluck('name')->implode(', ') }}" type="text" name="etat" id="etat" readonly> <br>
            <label for="adresse">Adresse</label> <br>
            <input value="{{$utilisateur->adresse }}" type="text" name="adresse" id="adresse" readonly> <br>
            <label for="location">État</label> <br>
            <input value="{{$utilisateur->location }}" type="text" name="location" id="location" readonly> <br>
            <label for="derniere_login">Derniere Login</label> <br>
            <input value="{{$utilisateur->derniere_login }}" type="text" name="derniere_login" id="derniere_login" readonly> <br>
            <div class="btns">
                <button onclick="window.location.href='{{ route('utilisateur.edit', $utilisateur->id) }}'"><i class='bx bx-edit-alt'></i></button>
                <form action="{{ route('utilisateur.destroy', $utilisateur->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('est ce que tu es sur vous voulez supprimer cet utilisateur ?');">
                        <i class='bx bx-trash'></i>
                    </button>
                </form>
                <button onclick="window.location.href='{{ route('utilisateur.index') }}'">Precedent</button>
            </div>
        </div>
    </div>
</div>

@endsection