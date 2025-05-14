<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Absence;
use App\Models\Seance;
use App\Models\User;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        $absences = Absence::with(['eleve', 'enseignant', 'seance'])->get();
        $eleves = User::where('role', 'eleve')->get();
        $seances = Seance::all();
        return view('absences.index', compact('classes', 'absences', 'eleves','seances'));
    }

    public function ajouterJustification(Request $request)
{
    $request->validate([
        'eleve_id' => 'required|exists:eleves,id',
        'absence_id' => 'required|exists:absences,id',
        'motif' => 'required|string|max:255',
    ]);

    // Trouver l'absence
    $absence = Absence::find($request->absence_id);

    // Ajouter la justification
    $absence->motif = $request->motif;
    $absence->justifie = true;  // Marquer comme justifiée
    $absence->save();

    return redirect()->back()->with('success', 'Justification ajoutée avec succès');
}


    public function getElevesByClasse($classeId)
    {
        $eleves = User::where('role', 'eleve')->where('classe_id', $classeId)->get(['id', 'nom', 'prenom']);
        return response()->json($eleves);
    }

    public function marquer(Request $request)
{
    $request->validate([
        'eleve_id' => 'required|exists:users,id',
        'seance_id' => 'required|exists:seances,id',
    ]);

    Absence::create([
        'eleve_id' => $request->eleve_id,
        'enseignant_id' => auth()->id(), // L'enseignant connecté
        'seance_id' => $request->seance_id,
        'date' => now(),
        'motif' => null, // Tu peux éventuellement ajouter un champ pour un motif
    ]);

    return redirect()->back()->with('success', 'Absence enregistrée avec succès.');
}


    public function justifier(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:users,id',
            'seance_id' => 'required|exists:seances,id',
            'motif' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Absence::create([
            'eleve_id' => $request->eleve_id,
            'enseignant_id' => auth()->id(),
            'seance_id' => $request->seance_id,
            'motif' => $request->motif,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Absence justifiée avec succès.');
    }

    public function create()
    {
        $eleves = User::where('role', 'eleve')->get();
        return view('absences.create', compact('eleves'));
    }

    public function show($id)
    {
        $absence = Absence::with(['eleve', 'enseignant', 'seance'])->findOrFail($id);
        return view('absences.show', compact('absence'));
    }
}
