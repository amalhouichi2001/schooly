<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    // Afficher la liste de toutes les matières
    public function index()
    {
        $matieres = Matiere::all(); // Récupère toutes les matières
        return view('matieres.index', compact('matieres'));
    }

    // Afficher les détails d'une matière spécifique avec ses enseignants
    public function show(Matiere $matiere)
    {
        $enseignants = $matiere->enseignants; // Récupère les enseignants liés à la matière
        return view('matieres.show', compact('matiere', 'enseignants'));
    }

    // Formulaire de création d'une nouvelle matière
    public function create()
    {
        return view('matieres.create');
    }

    // Stocker une nouvelle matière dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        // Création de la nouvelle matière
        Matiere::create([
            'nom' => $request->input('nom'),
        ]);

        return redirect()->route('matieres.index')->with('success', 'Matière créée avec succès.');
    }

    // Formulaire de modification d'une matière
    public function edit(Matiere $matiere)
    {
        return view('matieres.edit', compact('matiere'));
    }

    // Mise à jour d'une matière
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        // Mise à jour de la matière
        $matiere->update([
            'nom' => $request->input('nom'),
        ]);

        return redirect()->route('matieres.index')->with('success', 'Matière mise à jour avec succès.');
    }

    // Supprimer une matière
    public function destroy(Matiere $matiere)
    {
        // Supprime la matière
        $matiere->delete();

        return redirect()->route('matieres.index')->with('success', 'Matière supprimée avec succès.');
    }
}
