
    <table class="table">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Article</th>
                <th>Quantité demandée</th>
                <th>Quantité Restant</th>
                <th>Quantité disponible</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($demandes as $demande)
                <tr>
                    <td rowspan="{{ $demande->demandeDetails->count() }}">{{ $demande->numero }}</td>
                    @php
                        $firstDetail = $demande->demandeDetails->first();
                        $availableQuantity = $depotArticles->get($firstDetail->article_id)->quantity ?? 0;
                    @endphp
                    <td>{{ $firstDetail->article->name }}</td>
                    <td>{{ $firstDetail->quantity }}</td>
                    @if($demande->status === 'Livrée partiellement')
                    <td>{{ $firstDetail->quantity_restant }}</td>
                    @else
                    <td>{{ $firstDetail->quantity }}</td>
                    @endif
                    <td>{{ $availableQuantity }}</td>
                    <td rowspan="{{ $demande->demandeDetails->count() }}">
                        <input type="checkbox" name="demandes[]" value="{{ $demande->id }}">
                    </td>
                </tr>
                @foreach($demande->demandeDetails->slice(1) as $detail)
                    @php
                        $availableQuantity = $depotArticles->get($detail->article_id)->quantity ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $detail->article->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        @if($demande->status === 'Livrée partiellement')
                        <td>{{ $firstDetail->quantity_restant }}</td>
                        @endif
                        <td>{{ $availableQuantity }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

