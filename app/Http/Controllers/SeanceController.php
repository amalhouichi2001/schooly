<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Classe;
use App\Models\User;
use App\Models\Matiere;
use App\Models\salles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeanceController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Corrigé : appel correct à l'utilisateur authentifié
         $seances = collect();
       $rolesAutorisés = ['eleve', 'enseignant', 'parent'];

if (in_array($user->role, $rolesAutorisés)) {
    if ($user->classe_id) {
        $seances = Seance::where('emploi_class_id', $user->classe_id)
            ->with(['matiere', 'salle'])
            ->latest()
            ->get();
    }
 } elseif ($user->isAdmin()) {
            // Récupérer toutes les séances si l'utilisateur est un administrateur
            $seances = Seance::with(['matiere', 'salle'])
                ->latest()
                ->get();
        } else {
            // Si l'utilisateur n'est ni élève ni admin, on retourne une erreur ou une vue vide
            $seances = collect(); // Collection vide
        }

        return view('seances.index', compact('seances'));
    }


    public function create()
    {
        $classes = Classe::all();
        $enseignants = User::where('role', 'enseignant')->get();
        $matieres = Matiere::all();
        $salles = salles::all();



        // Définir une valeur nulle pour éviter l'erreur
        $seance = null;

        return view('seances.create', compact('enseignants', 'classes', 'matieres', 'salles', 'seance'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'emploi_class_id' => 'nullable|exists:classes,id',
            'emploi_enseignant_id' => 'nullable|exists:users,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'duration' => 'required|integer',
            'matiere_id' => 'required|exists:matieres,id',
            'salle_id' => 'required|exists:salles,id',
            'type' => 'required|in:cours,examen',
        ]);

        Seance::create($validated);
        return redirect()->route('seances.index')->with('success', 'Séance ajoutée avec succès.');
    }

    public function show($id)
    {
        $seance = Seance::with(['matiere', 'salle'])->findOrFail($id);
        return view('seances.show', compact('seance'));
    }


    public function edit($id)
    {
        $seance = Seance::findOrFail($id);
        $classes = Classe::all();
        $enseignants = User::where('role', 'enseignant')->get();
        $matieres = Matiere::all();
        $salles = salles::all();

        return view('seances.edit', compact('seance', 'classes', 'enseignants', 'matieres', 'salles'));
    }

    public function update(Request $request, $id)
    {
        $seance = Seance::findOrFail($id);

        $validated = $request->validate([
            'emploi_class_id' => 'nullable|exists:classes,id',
            'emploi_enseignant_id' => 'nullable|exists:users,id',
            'date' => 'required|date',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'duration' => 'required|integer',
            'matiere_id' => 'required|exists:matieres,id',
            'salle_id' => 'required|exists:salles,id',
            'type' => 'required|in:cours,examen',
        ]);

        $seance->update($validated);
        return redirect()->route('seances.index')->with('success', 'Séance modifiée.');
    }

    public function destroy($id)
    {
        $seance = Seance::findOrFail($id);
        $seance->delete();
        return redirect()->route('seances.index')->with('success', 'Séance supprimée.');
    }
}
