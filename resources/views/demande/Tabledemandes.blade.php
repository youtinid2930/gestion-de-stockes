@extends('layouts.app')

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
                        <td><a href="{{ route('demande.edit', $value->id) }}"><i class='bx bx-edit-alt'></i></a></td>
                    </tr>
                @endforeach
            </table>
        </div>
        <button onclick="window.location='{{ route('demande.showDemandes') }}'">Créer Demande</button>
    </div>
</div>
@endsection

