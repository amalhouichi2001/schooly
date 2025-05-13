<?php

namespace App\Http\Controllers;

use App\Models\Emploi;
use App\Models\Classe;
use App\Models\Enseignant;
use Illuminate\Http\Request;

class EmploiTempsController extends Controller
{
    public function index(Request $request)
{
    $classeId = $request->input('classe_id');

    if ($classeId) {
        $emplois = Emploi::where('classe_id', $classeId)->get();
    } else {
        $emplois = [];
    }

    $classes = Classe::all();

    return view('emploi.index', compact('classes', 'emplois'));
}


    // Méthode pour afficher les emplois du temps d'une classe spécifique
    public function show(Request $request)
    {
        // Récupérer l'ID de la classe via la requête
        $classeId = $request->input('classe_id');

        // Si l'ID de la classe est valide, récupérer les emplois du temps
        if ($classeId) {
            $emplois = Emploi::where('classe_id', $classeId)->get();
        } else {
            $emplois = [];
        }

        // Récupérer toutes les classes pour le formulaire
        $classes = Classe::all();
        
        return view('emploi.index', compact('classes', 'emplois'));
    }
    
    public function getByClasse($id)
    {
        $emplois = Emploi::where('classe_id', $id)->get();
        return response()->json($emplois);
    }

    public function create()
    {
        $classes = Classe::all();
        $enseignants = Enseignant::all(); // Récupère tous les enseignants
        return view('emploi.create', compact('classes', 'enseignants')); // Passe les variables à la vue
    }
public function store(Request $request)
{
    $request->validate([
        'classe_id' => 'required|exists:classes,id',
        'jour' => 'required',
        'seance' => 'required',
        'matiere' => 'required',
        'enseignant' => 'nullable|string',
        'heure_debut' => 'required',
        'heure_fin' => 'required',
    ]);

    Emploi::create($request->all());

    return redirect()->route('emploi.index')->with('success', 'Emploi du temps créé avec succès.');
}


    public function edit($id)
    {
        $emploi = Emploi::findOrFail($id);
        $classes = Classe::all();
        $enseignants = Enseignant::all();
        return view('emploi.edit', compact('emploi', 'classes', 'enseignants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'jour' => 'required',
            'seance' => 'required',
            'matiere' => 'required',
            'enseignant_id' => 'required|exists:enseignants,id',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        $emploi = Emploi::findOrFail($id);
        $emploi->update($request->all());
        return redirect()->route('emploi.index')->with('success', 'Emploi du temps mis à jour.');
    }
}
