<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\ParentUser; 
class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Gère la soumission du formulaire d'inscription.
     */
 // Renomme ce modèle si nécessaire

public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => ['required', 'in:eleve,enseignant,parent,admin'],
    ]);

    // Création du user dans la table "users"
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Insertion dans la table spécifique selon le rôle
    switch ($request->role) {
        case 'eleve':
            Eleve::create([
                'user_id' => $user->id,
                // Ajoute d'autres champs si nécessaires
            ]);
            break;

        case 'enseignant':
            Enseignant::create([
                'user_id' => $user->id,
            ]);
            break;

        case 'parent':
            ParentModel::create([
                'user_id' => $user->id,
            ]);
            break;

        // Pas besoin de faire quelque chose pour l’admin
    }

    event(new Registered($user));
    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
}

}