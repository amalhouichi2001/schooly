<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Classe;
use App\Models\matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class NoteController extends Controller
{
public function index(Request $request)
{
    $classes = Classe::all();
    $matieres = Matiere::all();

    $classe_id = $request->input('classe_id');
    $matiere = $request->input('matiere');

    // Récupérer les élèves uniquement si une classe est sélectionnée
    $eleves = collect(); // une collection vide par défaut

    if ($classe_id && $matiere) {
        $eleves = User::where('role', 'eleve')
                      ->where('classe_id', $classe_id)
                      ->get();
    }

    return view('notes.index', compact('classes', 'matieres', 'classe_id', 'matiere', 'eleves'));
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
        'notes.*.matiere' => 'required|string|max:255',
        'notes.*.valeur' => 'required|numeric|min:0|max:20',
    ]);

    $enseignant = Auth::user();

    if (!$enseignant || $enseignant->role !== 'enseignant') {
        return redirect()->back()->withErrors("Seul un enseignant peut enregistrer des notes.");
    }

    DB::beginTransaction();

    try {
        foreach ($request->notes as $noteData) {
            Note::create([
                'eleve_id' => $noteData['eleve_id'],
                'enseignant_id' => $enseignant->id,
                'matiere' => $noteData['matiere'], 
                'valeur' => $noteData['valeur'],
                'classe_id' => $request->classe_id,
            ]);
        }

        DB::commit();
        return redirect()->route('notes.index')->with('success', 'Notes enregistrées avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors('Erreur lors de l’enregistrement des notes : ' . $e->getMessage());
    }
}
function create()
{
    $enseignant = Auth::user();

    if (!$enseignant || $enseignant->role !== 'enseignant') {
        return redirect()->back()->withErrors("Accès réservé aux enseignants.");
    }

    $classes = Classe::all();
    $matieres = Matiere::all(); // Récupérer toutes les matières

    return view('notes.create', compact('classes', 'matieres'));
}
}
