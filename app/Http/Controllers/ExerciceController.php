<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ExerciceController extends Controller
{
 public function index()
{
    $enseignantId = auth()->id(); // ou auth()->user()->id

    $exercices = Exercice::where('enseignant_id', $enseignantId)->get();

    return view('exercices.index', compact('exercices'));
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
