<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absence;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class ParentUserController extends Controller
{
    /**
     * Affiche la liste des parents.
     */
    public function index()
    {
        $parents = User::where('role', 'parent')->get();
        return view('parents.index', compact('parents'));
    }

    public function create_ins()
    {
        return view('inscription.create');
    }

    /**
     * Affiche le formulaire de création d'un parent.
     */
    public function create()
    {
        return view('parents.create');
    }

    /**
     * Enregistre un nouveau parent dans la base de données.
     */
    public function store(Request $request)
{
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'telephone' => 'nullable|string|max:20',
        'adresse' => 'nullable|string|max:255',
        'password' => 'required|string|min:6|confirmed', // ajoute la validation du mot de passe
    ]);

    $validated['role'] = 'parent';
    $validated['password'] = Hash::make($validated['password']); // hash du mot de passe

    User::create($validated);

    return redirect()->route('parents.index')->with('success', 'Parent ajouté avec succès.');
}


    /**
     * Affiche le formulaire de modification d'un parent.
     */
    public function edit(User $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    /**
     * Met à jour les informations d'un parent.
     */
    public function update(Request $request, User $parent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $parent->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);

        $parent->update($validated);

        return redirect()->route('parents.index')->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Supprime un parent de la base de données.
     */
    public function destroy(User $parent)
    {
        $parent->delete();
        return redirect()->route('parents.index')->with('success', 'Parent supprimé avec succès.');
    }

    public function dashboard()
    {
        return view('dashboards.parent');
    }

    /**
     * Affiche les enfants associés au parent connecté.
     */
    public function mesEnfants()
    {
        $user = Auth::user();
        $eleves = $user->enfants()->get();
        return view('parents.enfants', compact('eleves'));
    }

    public function show($id)
    {
        $eleve = User::findOrFail($id);
        return view('eleves.show', compact('eleve'));
    }
public function showPaiementForm($id)
{
    $inscription = Inscription::findOrFail($id);
    return view('parents.paiement_form', compact('inscription'));
}

public function validerPaiement(Request $request, $id)
{
    $request->validate([
        'montant' => 'required|numeric|min:0',
        'methode' => 'required|string',
    ]);

    $inscription = Inscription::findOrFail($id);

    // Logique de traitement du paiement ici (tu peux l'ajouter plus tard)
    $inscription->statut = 'payee';
    $inscription->save();

    return redirect()->route('parents.inscriptions')->with('success', 'Paiement effectué avec succès.');
}

    /**
     * Affiche les absences des enfants du parent connecté.
     */
    public function absences()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
        }

        $eleveIds = $user->enfants()->pluck('users.id');
        $absences = Absence::whereIn('eleve_id', $eleveIds)->get();

        return view('parents.absences', compact('absences'));
    }
}
