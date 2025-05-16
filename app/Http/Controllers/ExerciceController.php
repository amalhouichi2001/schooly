<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ExerciceAnswer;
use Illuminate\Support\Carbon;

class ExerciceController extends Controller
{
public function index()
{
    $user = Auth::user(); // Utilisateur connecté
    $exercices = collect(); // Valeur par défaut vide

    if ($user->isEleve()) {
        // Si l'élève a une classe, on récupère les exercices liés à sa classe
        if ($user->classe_id) {
            $exercices = Exercice::where('classe_id', $user->classe_id)
                ->with(['matiere', 'enseignant']) // si des relations existent
                ->latest()
                ->get();
        }
    } elseif ($user->isAdmin()) {
        // L'administrateur voit tous les exercices
        $exercices = Exercice::with(['matiere', 'enseignant']) // relations si nécessaires
            ->latest()
            ->get();
    } elseif ($user->isEnseignant()) {
        // L'enseignant voit uniquement ses propres exercices
        $exercices = Exercice::where('enseignant_id', $user->id)
            ->with(['matiere', 'classe']) // relations si nécessaires
            ->latest()
            ->get();
    }

    return view('exercices.index', compact('exercices'));
}

public function uploadReponse(Request $request, $id)
{
    $request->validate([
        'reponse' => 'required|file|max:10240', // max 10MB
    ]);

    $exercice = Exercice::findOrFail($id);

    $filename = time() . '_' . $request->file('reponse')->getClientOriginalName();
    $path = $request->file('reponse')->storeAs('reponses', $filename, 'public');

    // Vérifie si l'élève a déjà soumis une réponse
    $exist = ExerciceAnswer::where('exercice_id', $id)
        ->where('eleve_id', Auth::id())
        ->first();

    if ($exist) {
        return back()->withErrors('Vous avez déjà soumis une réponse pour cet exercice.');
    }

    ExerciceAnswer::create([
        'exercice_id' => $id,
        'eleve_id' => Auth::id(),
        'reponse' => $path,
        'submitted_at' => Carbon::now(),
    ]);

    return back()->with('success', 'Réponse envoyée avec succès !');
}

    
public function create()
{
    $classes = Classe::all(); // ou avec un filtrage si nécessaire
    return view('exercices.create', compact('classes'));
}
    public function show($id)
{
    $exercice = Exercice::findOrFail($id);
   return view('exercices.show', compact('exercice'));

}
public function edit($id)
{
    $exercice = Exercice::findOrFail($id);
    return view('exercices.edit', compact('exercice'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $exercice = Exercice::findOrFail($id);
    $exercice->titre = $request->input('titre');
    $exercice->description = $request->input('description');
    $exercice->save();

    return redirect()->route('exercices.index')->with('success', 'Exercice mis à jour avec succès.');
}
public function destroy($id)
{
    $exercice = Exercice::findOrFail($id);
    $exercice->delete();

    return redirect()->route('exercices.index')->with('success', 'Exercice supprimé avec succès.');
}
    public function store(Request $request)
{
    // Validation
    $request->validate([
    'titre' => 'required|string|max:255',
    'description' => 'required|string', // Ajoute cette ligne
    'classe_id' => 'required|exists:classes,id',
    'date_limite' => 'required|date',
    'fichier' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240',
]);


    // Stockage du fichier
    $fichierNom = null;
    if ($request->hasFile('fichier')) {
        $fichierNom = $request->file('fichier')->store('exercices', 'public');
    }

    // Création de l'exercice


Exercice::create([
    'titre' => $request->titre,
    'classe_id' => $request->classe_id,
    'date_limite' => $request->date_limite,
    'fichier' => $fichierNom,
    'enseignant_id' => Auth::id(), 
    'description' => $request->description, 
]);


    return redirect()->route('exercices.index')
                     ->with('success', 'Exercice créé avec succès.');
}

    
}
