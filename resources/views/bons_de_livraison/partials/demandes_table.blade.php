<table class="table">
    <thead>
        <tr>
            <th>Numéro</th>
            <th>Article</th>
            <th>Quantité demandée</th>
            <th>Quantité disponible</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($demandes as $demande)
            <!-- Main row for the first article in the demande -->
            <tr>
                <td rowspan="{{ $demande->demandeDetails->count() }}">{{ $demande->numero }}</td>
                @php
                    $firstDetail = $demande->demandeDetails->first();
                    $availableQuantity = $depotArticles->get($firstDetail->article_id)->quantity ?? 0;
                @endphp
                <td>{{ $firstDetail->article->name }}</td>
                <td>{{ $firstDetail->quantity }}</td>
                <td>{{ $availableQuantity }}</td>
                <td rowspan="{{ $demande->demandeDetails->count() }}">
                    <input type="checkbox" name="demande" value="{{ $demande->id }}">
                </td>
            </tr>
            <!-- Subsequent rows for additional articles in the demande -->
            @foreach($demande->demandeDetails->slice(1) as $detail)
                @php
                    $availableQuantity = $depotArticles->get($detail->article_id)->quantity ?? 0;
                @endphp
                <tr>
                    <td>{{ $detail->article->name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $availableQuantity }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
