<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $classe_id = $request->input('classe_id');
        $matiere_id = $request->input('matiere_id');
        $classes = Classe::All();
        $matieres= Matiere::All();
        // Récupérer les élèves de la classe (dans users avec role = eleve)
        $eleves = User::where('role', 'eleve')
            ->where('classe_id', $classe_id)
            ->get();

        // Récupérer les notes existantes pour cette classe et cette matière
        // notes reliées à user_id et matière
        $notesExistantes = Note::whereIn('eleve_id', $eleves->pluck('id'))
            ->where('matiere_id', $matiere_id)
            ->get()
            ->keyBy('eleve_id');


        return view('notes.index', compact('eleves', 'classe_id', 'matiere_id', 'notesExistantes', 'classes','matieres'));
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);
        return view('notes.show', compact('note'));
    }

    public function mesNotes()
    {
        $eleve = Auth::user();

        if (!$eleve || $eleve->role !== 'eleve') {
            return redirect()->back()->withErrors('Vous n’êtes pas autorisé à accéder à ces informations.');
        }

        $notes = Note::where('eleve_id', $eleve->id)->get();
        $moyenne = $notes->avg('valeur');

        return view('eleves.notes', compact('notes', 'moyenne'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'notes' => 'required|array',
            'notes.*.eleve_id' => 'required|exists:users,id',
            'notes.*.matiere_id' => 'required|exists:matieres,id',
            'notes.*.valeur' => 'required|numeric|min:0|max:20',
        ]);

        $enseignant = Auth::user();

        if (!$enseignant || $enseignant->role !== 'enseignant') {
            return redirect()->back()->withErrors("Seul un enseignant peut enregistrer des notes.");
        }

        foreach ($request->notes as $noteData) {
            Note::create([
                'eleve_id' => $noteData['eleve_id'],
                'enseignant_id' => $enseignant->id,
                'matiere_id' => $noteData['matiere_id'],
                'note' => $noteData['valeur'],
                'classe_id' => $request->classe_id,
            ]);
        }

        return redirect()->route('notes.show')->with('success', 'Notes enregistrées avec succès.');

    }
public function voirNotesExistantes(Request $request)
{
    $classe_id = $request->input('classe_id');
    $matiere_id = $request->input('matiere_id');

    // Vérifie si les paramètres sont présents
    if (!$classe_id || !$matiere_id) {
        return redirect()->back()->withErrors('Classe et matière requises.');
    }

    // Récupère les élèves de la classe
   $eleves = \App\Models\User::where('role', 'eleve')
    ->where('classe_id', $classe_id)
    ->get();


    // Récupère les notes existantes pour la classe et la matière
    $notesExistantes = \App\Models\Note::where('classe_id', $classe_id)
        ->where('matiere_id', $matiere_id)
        ->with('enseignant')
        ->get()
        ->keyBy('eleve_id');

    return view('notes.existantes', compact('eleves', 'notesExistantes', 'classe_id', 'matiere_id'));
}

    public function create()
    {
        $enseignant = Auth::user();

        if (!$enseignant || $enseignant->role !== 'enseignant') {
            return redirect()->back()->withErrors("Accès réservé aux enseignants.");
        }

        $classes = Classe::all();
        $matieres = Matiere::all();

        return view('notes.create', compact('classes', 'matieres'));
    }
}
