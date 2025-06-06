<?php

namespace App\Http\Controllers;

use App\Imports\ExerciceAnswersImport;
use App\Models\Classe;
use App\Models\User;
use App\Models\Exercice;
use App\Models\Inscription;
use App\Models\Seance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class EleveController extends Controller
{
    public function index()
    {
        $eleves = User::where('role', 'eleve')->get();
        return view('eleves.index', compact('eleves'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        Excel::import(new ExerciceAnswersImport, $request->file('file'));

        return back()->with('success', 'Réponses importées avec succès.');
    }

    public function monEmploi()
    {
        $eleve = Auth::user();
$classes = Classe::all();
$emploiDuTemps = Seance::all();
        if (!$eleve || $eleve->role !== 'eleve') {
            return redirect()->back()->withErrors('Accès refusé ou en attente d’activation.');
        }

        $emploiDuTemps = Seance::where('emploi_class_id', $eleve->classe_id)
            ->with('matiere')
            ->orderByRaw("FIELD(date, 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')")
            ->orderBy('heure_debut')
            ->get();

      return view('eleves.emploi', compact('classes', 'emploiDuTemps'));
    }

  
    public function exercices()
    {
        $exercices = Exercice::with('matiere')->get();
        return view('eleves.exercices', compact('exercices'));
    }

    public function showExercice($id)
    {
        $exercice = Exercice::with('matiere')->findOrFail($id);
        return view('eleves.exercice_detail', compact('exercice'));
    }

    public function showInscriptionForm($id)
    {
        $eleve = User::where('role', 'eleve')->findOrFail($id);
        return view('inscription.form', compact('eleve'));
    }

    public function create()
    {
        $classes = Classe::all();
        $parents = User::where('role', 'parent')->get();
        return view('eleves.create', compact('classes', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'required|date',
            'classe_id' => 'nullable|exists:classes,id',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'password' => 'required|string|min:6',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'parents' => 'nullable|array',
            'parents.*' => 'exists:users,id',
        ]);

        $photoPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $photoPath = $request->file('profile_photo_path')->store('eleves', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'prenom' => $validated['prenom'],
            'adresse' => $validated['adresse'] ?? null,
            'date_naissance' => $validated['date_naissance'],
            'classe_id' => $validated['classe_id'] ?? null,
            'telephone' => $validated['telephone'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'eleve',
            'profile_photo_path' => $photoPath,
        ]);

        $authUser = Auth::user();
        if ($authUser && $authUser->role === 'parent') {
            $user->parents()->attach($authUser->id);
        } elseif (isset($validated['parents'])) {
            $user->parents()->sync($validated['parents']);
        }

        Inscription::create([
            'eleve_id' => $user->id,
            'date_inscription' => now(),
            'validee' => false,
            'classe_id' => $validated['classe_id'] ?? null,
            'statut' => 'non payée',
        ]);

        if ($authUser && $authUser->role === 'parent') {
            return redirect()->route('parents.inscriptions')->with('success', 'Élève ajouté avec succès.');
        }

        return redirect()->route('classes.index')->with('success', 'Élève ajouté avec succès.');
    }

    public function show($id)
    {
        $eleve = User::where('role', 'eleve')->findOrFail($id);
        return view('eleves.show', compact('eleve'));
    }

    public function edit($id)
    {
        $eleve = User::where('role', 'eleve')->findOrFail($id);
        $classes = Classe::all();
        return view('eleves.edit', compact('eleve', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $eleve = User::where('role', 'eleve')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $eleve->id,
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'required|date',
            'gender' => 'required|in:male,female',
            'classe_id' => 'required|exists:classes,id',
            'password' => 'nullable|string|min:6',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('profile_photo_path')) {
            if ($eleve->profile_photo_path && Storage::disk('public')->exists($eleve->profile_photo_path)) {
                Storage::disk('public')->delete($eleve->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('profile_photo_path')->store('eleves', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $eleve->update($validated);

        return redirect()->route('eleves.index')->with('success', 'Élève mis à jour.');
    }

    public function destroy($id)
    {
        $eleve = User::where('role', 'eleve')->findOrFail($id);
        $eleve->delete();

        return redirect()->route('eleves.index')->with('success', 'Élève supprimé.');
    }

    public function getEleves($classe_id)
    {
        $eleves = User::where('role', 'eleve')->where('classe_id', $classe_id)->get();
        return response()->json($eleves);
    }
}
