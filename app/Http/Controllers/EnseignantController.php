<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matiere;
use App\Models\Exercice;
use Illuminate\Http\Request;
use App\Models\Classe;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = User::where('role', 'enseignant')->get();
        $classes = Classe::with('eleves')->get();
        return view('enseignants.index', compact('enseignants','classes'));
    }
   

public function classes()
{
    // Exemple : récupérer les classes liées à l'enseignant connecté
    $enseignant = auth()->user();
    // supposons que l’enseignant a une relation 'classes' (à définir dans le modèle User)
    $classes = $enseignant->classes; 

    return view('classes.index', compact('classes'));
}

    public function create()
    {
        $matieres = Matiere::all();
        return view('enseignants.create', compact('matieres'));
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'adresse' => 'nullable|string|max:255',
        'date_naissance' => 'required|date',
        'email' => 'required|email|unique:users,email',
        'telephone' => 'required|string|max:20',
        'gender' => 'required|in:male,female',
        'matiere_id' => 'nullable|exists:matieres,id',
        'password' => 'required|string|min:6',
        'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        'statut' => 'in:active,desactive',
    ]);

    if ($request->hasFile('profile_photo_path')) {
        $photoPath = $request->file('profile_photo_path')->store('enseignants', 'public');
    } else {
        // Avatar par défaut
        $photoPath = 'images/default-avatar.png'; // Assure-toi que ce fichier existe dans public/images/
    }

    $data = [
        'name' => $validated['name'],
        'prenom' => $validated['prenom'],
        'adresse' => $validated['adresse'] ?? null,
        'date_naissance' => $validated['date_naissance'],
        'telephone' => $validated['telephone'],
        'gender' => $validated['gender'],
        'email' => $validated['email'],
        'matiere_id' => $validated['matiere_id'] ?? null,
        'password' => bcrypt($validated['password']),
        'role' => 'enseignant',
        'profile_photo_path' => $photoPath,
        'statut' => $validated['statut'] ?? 'active',
    ];

    User::create($data);

    return redirect()->route('enseignants.index')->with('success', 'Enseignant ajouté avec succès.');
}


    public function edit($id)
    {
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);
        $matieres = Matiere::all();
        return view('enseignants.edit', compact('enseignant', 'matieres'));
    }
public function voirReponses($exercice_id)
{
    $exercice = Exercice::with('answers.eleve')->findOrFail($exercice_id);
    return view('prof.reponses_exercice', compact('exercice'));
}

    public function update(Request $request, $id)
    {
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $enseignant->id,
            'gender' => 'required|in:male,female',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'required|date',
            'matiere_id' => 'nullable|exists:matieres,id',
            'password' => 'nullable|string|min:6',
            'statut'=>'in:active,desactive',
            'profile_photo_path' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_photo_path')) {
            if ($enseignant->profile_photo_path) {
                Storage::disk('public')->delete($enseignant->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('profile_photo_path')->store('enseignants', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $enseignant->update($validated);

        return redirect()->route('enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);
        if ($enseignant->profile_photo_path) {
            Storage::disk('public')->delete($enseignant->profile_photo_path);
        }
        $enseignant->delete();

        return redirect()->route('enseignants.index')->with('success', 'Enseignant supprimé.');
    }

    public function show($id)
    {
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);
        return view('enseignants.show', compact('enseignant'));
    }
}
