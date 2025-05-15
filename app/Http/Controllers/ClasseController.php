<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }
    public function show(Classe $classe)
    {
        $elevesDansClasse = $classe->eleves;
        $elevesSansClasse = \App\Models\User::where('role', 'eleve')
                                ->whereNull('classe_id')->get();
    
        return view('classes.show', compact('classe', 'elevesDansClasse', 'elevesSansClasse'));
    }
    
    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:100',
        ]);

        Classe::create($request->only('nom', 'niveau'));

        return redirect()->route('classes.index')->with('success', 'Classe ajoutée avec succès.');
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:100',
        ]);

        $classe->update($request->only('nom', 'niveau'));

        return redirect()->route('classes.index')->with('success', 'Classe modifiée avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();

        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }
    public function ajouterEleve(Request $request, Classe $classe)
    {
        $request->validate([
            'eleve_id' => 'required|exists:users,id',
        ]);

        $eleve = \App\Models\User::findOrFail($request->eleve_id);
        $eleve->classe_id = $classe->id;
        $eleve->save();

        return back()->with('success', 'Élève ajouté à la classe.');
    }

    public function retirerEleve(Classe $classe, \App\Models\User $eleve)
    {
        if ($eleve->classe_id == $classe->id) {
            $eleve->classe_id = null;
            $eleve->save();
        }

        return back()->with('success', 'Élève retiré de la classe.');
    }
    
}
