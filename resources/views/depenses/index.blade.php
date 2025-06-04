@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Suivi des dépenses</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <a href="{{ route('depenses.create') }}" style="margin-bottom: 20px; display:inline-block;">+ Ajouter une dépense</a>

    <p><strong>Total dépenses : </strong> {{ number_format($total, 2) }} DT</p>

    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Description</th>
                <th>Montant (DT)</th>
                <th>Date</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($depenses as $depense)
                <tr>
                    <td>{{ $depense->description }}</td>
                    <td>{{ number_format($depense->montant, 2) }}</td>
                    <td>{{ \Carbon\Carbon::parse($depense->date)->format('d/m/Y') }}</td>
                    <td>{{ $depense->categorie ?? '-' }}</td>
                    <td>
                        <a href="{{ route('depenses.edit', $depense->id) }}">Modifier</a> |
                        <form action="{{ route('depenses.destroy', $depense->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:red; cursor:pointer;">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;">Aucune dépense enregistrée.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $depenses->links() }}
</div>
@endsection
