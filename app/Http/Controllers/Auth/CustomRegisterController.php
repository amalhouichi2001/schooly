<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\ParentUser as ParentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class CustomRegisterController extends Controller
{
    

    protected $redirectTo = '/home'; // Ou la route de ton dashboard

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Validation
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'role' => ['required', 'in:eleve,enseignant,parent,admin'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    // Création de l'utilisateur principal
    protected function create(array $data)
    {
        $user = User::create([
            'role' => $data['role'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Créer l'entité liée selon le rôle
        switch ($data['role']) {
            case 'eleve':
                Eleve::create([
                    'user_id' => $user->id,
                    'prenom' => $data['prenom'] ?? '',
                    'date_naissance' => $data['date_naissance'] ?? null,
                    'adresse' => $data['adresse'] ?? '',
                    'classe_id' => $data['classe_id'] ?? null,
                    'parent_id' => $data['parent_id'] ?? null,
                ]);
                break;

            case 'enseignant':
                Enseignant::create([
                    'user_id' => $user->id,
                    'prenom' => $data['prenom'] ?? '',
                    'specialite' => $data['specialite'] ?? '',
                ]);
                break;

            case 'parent':
                ParentModel::create([
                    'user_id' => $user->id,
                    'prenom' => $data['prenom'] ?? '',
                    'telephone' => $data['telephone'] ?? '',
                    'adresse' => $data['adresse'] ?? '',
                ]);
                break;
        }

        return $user;
    }
}
