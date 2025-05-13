<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    // Affiche la liste des classes
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('classes.create');
    }
public function getEleves($id)
{
    $classe = Classe::with('eleves')->find($id);
    
    if (!$classe) {
        return response()->json([]);
    }

    return response()->json($classe->eleves);
}

    // Enregistre une nouvelle classe
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            
        ]);

        Classe::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Classe ajoutée avec succès.');
    }

    // Affiche une classe spécifique
    public function show(Classe $classe)
    {
        return view('classes.show', compact('classe'));
    }


    public function edit($id)
{
    $classe = Classe::findOrFail($id); // très important

    return view('classes.edit', compact('classe'));
}


    // Met à jour une classe
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            
        ]);

        $classe->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    // Supprime une classe
    public function destroy(Classe $classe)
    {
        $classe->delete();

        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
