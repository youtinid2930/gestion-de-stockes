@extends('layouts.app')

@section('title', 'Fournisseur')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            <table class="mtable">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                @foreach ($fournisseurs as $value)
                    <tr>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->last_name }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->address }}</td>
                        <td>{{ $value->email }}</td>
                        <td>
                        <a href="{{ route('fournisseur.edit', $value->id) }}" class="btn btn-icon" data-toggle="tooltip" title="mettre a jour le fournisseur"><i class='bx bx-edit-alt'></i></a>
                        <form action="{{ route('fournisseur.destroy', $value->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('est ce que tu es sur vous voulez supprimer cet fournisseur ?');" class="delete-button btn btn-icon">
                                <i class='bx bx-trash'></i>
                            </button>
                        </form>
                        <a href="{{ route('fournisseur.show', $value->id) }}" class="btn btn-icon" data-toggle="tooltip" title="Voir plus sur le fournisseur">&#9660;</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div style="background-color: #03be1c;margin-left: 5%;margin-right: 75%;border-radius: 5%;padding: 1%;">
            <a href="{{ route('fournisseur.create') }}" style="color: white">Ajouter Fournisseur <i class="bx bx-plus"></i></a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
    
</div>
@endsection
