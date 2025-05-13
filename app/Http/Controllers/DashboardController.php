<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Ajouté
use App\Models\Inscription; // ✅ À ajouter si tu utilises ce modèle

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return view('dashboards.admin');
            case 'enseignant':
                return view('dashboards.enseignant');
            case 'parent':
                $eleves = Eleve::where('parent_id', Auth::id())->get();
                return view('dashboards.parent', compact('eleves'));
            case 'eleve':
                return view('dashboards.eleve');
        }
    }

    public function inscriptionsEtPaiements()
    {
        $inscriptions = Inscription::with(['eleve', 'paiement'])->get();
        return view('inscriptions.index', compact('inscriptions'));
    }
}
