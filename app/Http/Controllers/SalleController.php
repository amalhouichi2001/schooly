<?php
namespace App\Http\Controllers;


use App\Models\salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function index()
    {
        $salles = salle::all();
        return view('salles.index', compact('salles'));
    }

    public function create()
    {
        return view('salles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'nullable|integer',
        ]);

        salle::create($request->all());

        return redirect()->route('salles.index')->with('success', 'Salle ajoutée avec succès.');
    }

    public function edit(salle$salle)
    {
        return view('salles.edit', compact('salle'));
    }

    public function update(Request $request, salle $salle)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'capacite' => 'nullable|integer',
        ]);

        $salle->update($request->all());

        return redirect()->route('salles.index')->with('success', 'Salle mise à jour.');
    }

    public function destroy(salles $salle)
    {
        $salle->delete();

        return redirect()->route('salles.index')->with('success', 'Salle supprimée.');
    }
}
