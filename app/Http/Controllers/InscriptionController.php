<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Eleve;
use App\Models\Paiement;
use App\Models\Classe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{public function storeInscription(Request $request)
{
    $request->validate([
        'eleve_id' => 'required|exists:eleves,id',
        'date_inscription' => 'required|date',
    ]);

    Inscription::create([
        'eleve_id' => $request->eleve_id,
        'date_inscription' => $request->date_inscription,
        'validee' => false,
    ]);

    return redirect('/parent/inscription')->with('success', 'Élève inscrit avec succès.');

}

    public function show($eleve_id)
    {
        $eleve = Eleve::findOrFail($eleve_id);
        $inscriptions = Inscription::where('eleve_id', $eleve_id)->first();

        return view('inscriptions.show', compact('eleve', 'inscription'));
    }

    // Valider une inscription
    public function valider(Request $request, $eleve_id)
    {
        $eleve = Eleve::findOrFail($eleve_id);

        $inscription = Inscription::create([
            'eleve_id' => $eleve->id,
            'parent_id' => Auth::id(),
            'date' => now(),
            'status' => 'validee'
        ]);

        return redirect()->route('inscription.show', $eleve_id)
                         ->with('success', 'Inscription validée. Veuillez procéder au paiement.');
    }

    public function create()
{
    $classes = Classe::all(); // Assure-toi d’avoir importé Classe
    return view('inscriptions.create', compact('classes'));
}


    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'date_naissance' => 'required|date',
        'adresse' => 'required|string',
        'classe_id' => 'required|exists:classes,id',
        'user_id' => 'required|exists:users,id',
    ]);

    Eleve::create($request->all());

    return redirect('/parent/inscription')->with('success', 'Élève inscrit avec succès.');

}
    public function index()
    {
        $inscriptions = Inscription::with(['eleve', 'paiement'])->get();
        return view('inscriptions.index', compact('inscriptions'));
    }
    public function formInscription()
{
    $inscriptions = Inscription::with(['eleve', 'paiement'])->get();

    return view('parent.inscription', compact('inscriptions'));
}
}
