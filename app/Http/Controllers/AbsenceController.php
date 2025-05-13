<?php

namespace App\Http\Controllers;
use App\Models\Classe;
use App\Models\Absence;
use Illuminate\Http\Request;
use App\Models\Eleve;
class AbsenceController extends Controller
{
    public function index()
    {
        $classes = Classe::all(); // Récupère toutes les classes
        $absences = Absence::with('eleve')->get(); // Charge aussi les élèves liés
       $eleves = Eleve::all();
        return view('absences.index', compact('classes', 'absences','eleves'));
    }
     public function indexen()
    {
        $classes = Classe::all(); // Récupère toutes les classes
        $absences = Absence::with('eleve')->get(); // Charge aussi les élèves liés
       $eleves = Eleve::all();
        return view('absences.indexen', compact('classes', 'absences','eleves'));
    }
   public function getElevesByClasse($classeId)
{
    // Attention : vérifie que dans ta table 'eleves' tu as bien un champ 'classe_id'
    $eleves = Eleve::where('classe_id', $classeId)->get(['id', 'nom', 'prenom']);
    return response()->json($eleves);
}
  public function marquer(Request $request)
{
    Absence::create([
        'eleve_id' => $request->eleve_id,
        'date' => now(),
        'justifiee' => false,
        'motif' => null
    ]);

    return redirect()->back()->with('success', 'Absence enregistrée avec succès.');
}

public function storeAjax(Request $request)
{
    $request->validate([
        'eleve_id' => 'required|exists:eleves,id',
        'motif' => 'required|string|max:255',
        'justifie' => 'required|boolean',
        'date' => 'required|date',
    ]);

    Absence::create([
        'eleve_id' => $request->eleve_id,
        'motif' => $request->motif,
        'justifie' => $request->justifie,
        'date' => $request->date,
    ]);

    return redirect()->back()->with('success', 'Absence justifiée avec succès.');
}
public function justifier(Request $request)
    {
        // Validation des données reçues
        $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'justifie' => 'required|boolean',
            'motif' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Création ou mise à jour de l'absence
        Absence::create([
            'eleve_id' => $request->eleve_id,
            'justifiee' => $request->justifie,
            'motif' => $request->motif,
            'date' => $request->date,
        ]);

        return redirect()->back()->with('success', 'Absence justifiée avec succès.');
    }

public function create()
{
    $eleves = Eleve::all();
    return view('absences.create', compact('eleves'));
}

public function show($id)
{
    $absence = Absence::findOrFail($id);
    return view('absences.show', compact('absence'));
}


}
