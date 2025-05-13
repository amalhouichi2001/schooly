<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\User;
use App\Models\Exercice;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class EnseignantController extends Controller
{
    /**
     * Afficher la liste des enseignants.
     */
   public function classes()
{
    $classes = Classe::all(); // récupère toutes les classes

    return view('classes.index', compact('classes'));
}
public function exercice()
{
    $exercices = Exercice::with('classe')->get(); // N'oublie pas le 'use App\Models\Exercice;'

    return view('exercices.index', compact('exercices'));
}



    public function index()
    {
        $enseignants = Enseignant::all();
        return view('enseignants.index', compact('enseignants'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('enseignants.create');
    }

    /**
     * Enregistrer un nouvel enseignant.
     */
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
        'specialite' => 'required|string|max:255',
    ]);

    try {
        DB::beginTransaction();

        $user = User::create([
            'name' => $request->prenom . ' ' . $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'enseignant',
        ]);

        Enseignant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'specialite' => $request->specialite,
            'user_id' => $user->id,
        ]);

        DB::commit();

        return redirect()->route('enseignants.index')->with('success', 'Enseignant créé avec succès.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
    }
}

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit($id)
    {
        $enseignant = Enseignant::findOrFail($id);
        return view('enseignants.edit', compact('enseignant'));
    }

    /**
     * Mettre à jour un enseignant existant.
     */
    public function update(Request $request, $id)
    {
        $enseignant = Enseignant::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
        ]);

        // Mise à jour des données de l'enseignant
        $enseignant->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'specialite' => $request->specialite,
        ]);

        // Mise à jour du nom dans la table users
        if ($enseignant->user) {
            $enseignant->user->update([
                'name' => $request->prenom . ' ' . $request->nom,
            ]);
        }

        return redirect()->route('enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');
    }
    public function emploi()
    {
        $enseignantId = Auth::user()->id;
    
        // Récupérer les séances de l’emploi du temps du professeur connecté
        $emplois = DB::table('emploi_temps')
            ->where('enseignant_id', $enseignantId)
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();
    
        // Grouper par jour
        $grouped = $emplois->groupBy('jour');
    
        return view('enseignants.emploi', compact('grouped'));
    }
    
    public function indexens()
    {
        $classes = Classe::all();
        return view('enseignant.absences', compact('classes'));
    }

    public function getEleves($id)
    {
        $eleves = Eleve::where('classe_id', $id)->get();
        return response()->json($eleves);
    }

    public function storeAbsence(Request $request)
    {
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'date' => 'required|date',
            'justifie' => 'boolean',
            'motif' => 'nullable|string',
        ]);

        Absence::create([
            'eleve_id' => $request->eleve_id,
            'date' => $request->date,
            'justifie' => $request->justifie ?? false,
            'motif' => $request->motif,
        ]);

        return response()->json(['message' => 'Absence enregistrée avec succès.']);
    }
}
