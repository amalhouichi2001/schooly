<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EnseignantController extends Controller
{
    public function index()
    {
        $enseignants = User::where('role', 'enseignant')->get();
        return view('enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        $matieres = Matiere::all();
        return view('enseignants.create', compact('matieres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'date_naissance' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'matiere_id' => 'nullable|exists:matieres,id',
            'profile_photo_path' => 'nullable|image|max:2048',
            'statut' => 'in:active,desactive',
        ]);

        $data['role'] = 'enseignant';
        $data['password'] = bcrypt($data['password']);

        if ($request->hasFile('profile_photo_path')) {
            $data['profile_photo_path'] = $request->file('profile_photo_path')->store('photos', 'public');
        }

        User::create($data);

        return redirect()->route('enseignants.index')->with('success', 'Enseignant ajouté avec succès.');
    }

    public function edit($id)
    {
        $enseignant = User::where('role', 'enseignant')->findOrFail($id);
        $matieres = Matiere::all();
        return view('enseignants.edit', compact('enseignant', 'matieres'));
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
