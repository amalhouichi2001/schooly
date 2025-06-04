@extends('layouts.app')

@section('content')
<style>
    
    h1 { color: #333; font-size: 28px; margin-bottom: 20px; }
    .btn { padding: 8px 14px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; }
    .btn:hover { background-color: #45a049; }
    .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .table th, .table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    .table th { background-color: #f2f2f2; }
    .status { padding: 5px 8px; border-radius: 4px; font-size: 12px; }
    .status.approuvé { background-color: #c8e6c9; color: #2e7d32; }
    .status.rejeté { background-color: #ffcdd2; color: #c62828; }
    .status.en-attente { background-color: #fff3cd; color: #856404; }
    .actions form { display: inline-block; margin-right: 5px; }
    .actions button, .actions a { padding: 5px 10px; font-size: 12px; border: none; cursor: pointer; border-radius: 4px; }
    .approve { background-color: #28a745; color: white; }
    .reject { background-color: #dc3545; color: white; }
    .pdf { background-color: #007bff; color: white; text-decoration: none; }
</style>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h1>Gestion des Congés</h1>
        @if(Auth::user()->isEnseignant())
    <a href="{{ route('conges.create') }}"
       class="btn btn-primary">
       + Nouveau Congé
    </a>
@endif

    </div>

    @if (session('success'))
        <div style="background-color: #d4edda; padding: 10px; border: 1px solid #c3e6cb; color: #155724; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #f8d7da; padding: 10px; border: 1px solid #f5c6cb; color: #721c24; border-radius: 4px;">
            {{ session('error') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Motif</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($conges as $conge)
                <tr>
                    <td>{{ $conge->id }}</td>
                    <td>{{ $conge->user->name ?? 'Non défini' }}</td>
                    <td>{{ ucfirst($conge->type) }}</td>
                    <td>{{ $conge->date_debut }}</td>
                    <td>{{ $conge->date_fin }}</td>
                    <td>{{ $conge->motif }}</td>
                    <td>
                        <span class="status {{ $conge->statut == 'approuvé' ? 'approuvé' : ($conge->statut == 'rejeté' ? 'rejeté' : 'en-attente') }}">
                            {{ ucfirst($conge->statut) }}
                        </span>
                    </td>
                    <td class="actions">
                       @if(Auth::user()->isAdmin() && $conge->statut === 'en attente')
    <form method="POST" action="{{ route('conges.updateStatut', $conge->id) }}">
        @csrf @method('PATCH')
        <input type="hidden" name="statut" value="approuvé">
        <button class="approve">Approuver</button>
    </form>

    <form method="POST" action="{{ route('conges.updateStatut', $conge->id) }}">
        @csrf @method('PATCH')
        <input type="hidden" name="statut" value="rejeté">
        <button class="reject">Rejeter</button>
    </form>
@endif

                        <a href="{{ route('conges.pdf', $conge->id) }}" class="pdf" target="_blank">PDF</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #777;">Aucune demande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
