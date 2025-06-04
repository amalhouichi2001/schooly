<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conge;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf; 
class CongeController extends Controller
{
    public function index()
{
    $conges = Conge::with('user')->latest()->get();
    return view('conges.index', compact('conges'));
}

public function create()
{
    $enseignants = User::where('role', 'enseignant')->get();
    return view('conges.create', compact('enseignants'));
}

public function updateStatut(Request $request, $id)
{
    $request->validate([
        'statut' => 'required|in:approuvé,rejeté',
    ]);

    $conge = Conge::findOrFail($id);
    $conge->statut = $request->statut;
    $conge->save();

    return redirect()->route('conges.index')->with('success', 'Statut mis à jour avec succès.');
}


public function generatePdf($id)
{
    $conge = Conge::with('user')->findOrFail($id);

    $pdf = Pdf::loadView('conges.pdf', compact('conge')); // tu dois avoir une vue `resources/views/conges/pdf.blade.php`
    
    return $pdf->download("conge-{$conge->id}.pdf");
}

public function store(Request $request)
{
    $request->validate([
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after_or_equal:date_debut',
        'type' => 'required|string',
    ]);

    Conge::create([
        'user_id' => auth()->id(), // Automatiquement le prof connecté
        'date_debut' => $request->date_debut,
        'date_fin' => $request->date_fin,
        'type' => $request->type,
        'motif' => $request->motif,
        'statut' => 'en attente',
    ]);

    return redirect()->route('conges.index')->with('success', 'Demande de congé envoyée.');
}



}
