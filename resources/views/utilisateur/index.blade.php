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
                                gestionnaire
                            @elseif ($user->hasRole('magasinier'))
                                magasinier
                            @else
                                pas de role
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('utilisateur.edit', $user->id) }}"><i class='bx bx-edit-alt'></i></a>
                            <form action="{{ route('utilisateur.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');" class="delete-button">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                            <button onclick="window.location.href='{{ route('utilisateur.show', $user->id) }}'">Voir plus</button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="btn">
            <a href="{{ route('utilisateur.create') }}">Add User <i class="bx bx-plus"></i></a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
</div>
@endsection
