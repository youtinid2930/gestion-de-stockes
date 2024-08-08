@extends('layouts.app')

@section('title', 'Demande')

@section('content')
<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
            
            <table>
                <tr>
                    <th>Quantity</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Delivery Address</th>
                    <th>Action</th>
                </tr>
                @foreach ($demandes as $value)
                    <tr>
                        <td>{{ $value->quantity }}</td>
                        <td>{{ $value->notes }}</td>
                        <td>{{ $value->status }}</td>
                        <td>{{ $value->delivery_address }}</td>
                        <td><a href="{{ route('demande.edit', $value->id) }}"><i class='bx bx-edit-alt'></i></a>
                        <form action="{{ route('demande.destroy', $demande->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('vous etes sure de supprimer cette demande?');" class="delete-button">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                       </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <br>
        <button onclick="window.location='{{ route('demande.showDemandes') }}'">Créer Demande</button>
    </div>
</div>
@endsection

