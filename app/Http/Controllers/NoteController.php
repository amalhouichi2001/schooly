<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Eleve;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\Exercice;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
{
    // Récupérer l'ID de la classe
    $classe_id = $request->input('classe_id');
    
    // Récupérer toutes les classes
    $classes = Classe::all();

    // Si une classe est sélectionnée, récupérer les élèves de cette classe
    $eleves = Eleve::where('classe_id', $classe_id)->get();

    // Récupérer les notes liées à cette classe
    $notes = Note::where('classe_id', $classe_id)->get();

    return view('notes.index', compact('classes', 'eleves', 'notes', 'classe_id'));
}

public function show($id)
{
    // Récupérer la note par ID
    $note = Note::findOrFail($id);

    // Passer la note à la vue
    return view('notes.show', compact('note'));
}




   public function mesNotes()
{
    $eleve = Auth::user()->eleve;

    if (!$eleve) {
        return redirect()->back()->withErrors('Aucun élève associé à cet utilisateur.');
    }

    $notes = Note::where('eleve_id', $eleve->id)->get();
    $moyenne = $notes->avg('valeur');

    return view('eleves.notes', compact('notes', 'moyenne'));
}


public function create()
{
    $eleves = Eleve::where('classe_id', 1)->get(); // adapte au besoin
    $classe_id = 1; // temporaire
    $enseignant_id = 1; // à adapter selon l'enseignant connecté ou choisi

    return view('notes.create', compact('eleves', 'classe_id', 'enseignant_id'));
}

public function store(Request $request)
{
    // Validation des entrées
    $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'enseignant_id' => 'required|exists:users,id',  // Vérifie que l'enseignant_id existe
        'notes' => 'required|array',
    ]);

    

    // Enregistrement des notes
    foreach ($request->notes as $eleve_id => $noteData) {
        Note::create([
            'eleve_id' => $eleve_id,
            'enseignant_id' => $request->enseignant_id,
            'matiere' => $noteData['matiere'],
            'valeur' => $noteData['valeur'],
        ]);
    }

    return redirect()->back()->with('success', 'Notes enregistrées avec succès.');
}



    





}
