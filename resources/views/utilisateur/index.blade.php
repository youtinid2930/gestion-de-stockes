<!-- resources/views/utilisateur/index.blade.php -->

@extends('layouts.app')

@section('title', 'Utilisateur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->hasRole('admin'))
                                Admin
                            @elseif ($user->hasRole('gestionnaire'))
                                Gestionnaire
                            @elseif ($user->hasRole('magasinier'))
                                Magasinier
                            @else
                                Pas de rôle
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('utilisateur.edit', $user->id) }}" class="btn btn-icon" data-toggle="tooltip" title="mettre a jour l'utilisateur"><i class='bx bx-edit-alt'></i></a>
                            <form action="{{ route('utilisateur.destroy', $user->id) }}" method="POST" style="display:inline;" data-toggle="tooltip" title="Supprimer l'utilisateur">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="delete-button btn btn-icon">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                            <a href="{{ route('utilisateur.show', $user->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur l'utilisateur">&#9660;</button>
                        </td>
                    </tr>
                @endforeach
            </table>
            <a href="{{ route('utilisateur.create') }}" class="btn" style="margin-right: 80%; margin-top: 1%;">Ajouter Utilisateur</a>
        </div>
        
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
</div>
@endsection
