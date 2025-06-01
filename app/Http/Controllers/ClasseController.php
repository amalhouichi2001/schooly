<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Matiere;
use App\Models\User;
use App\Models\Note;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        return view('classes.index', compact('classes'));
    }
    public function show(Classe $classe)
    {
        $elevesDansClasse = $classe->eleves()->with('notes')->get();

        $moyennes = [];
        foreach ($elevesDansClasse as $eleve) {
            $latestNotes = $eleve->notes
                ->sortByDesc('created_at')
                ->unique('matiere_id');

            $moyenne = $latestNotes->count() ? $latestNotes->avg('valeur') : null;
            $eleve->moyenne = $moyenne ? round($moyenne, 2) : null;

            if ($eleve->moyenne !== null) {
                $moyennes[] = $eleve->moyenne;
            }
        }

        // Rang par ordre décroissant des moyennes
        $elevesDansClasse = $elevesDansClasse->sortByDesc('moyenne')->values();
        foreach ($elevesDansClasse as $index => $eleve) {
            $eleve->rang = $eleve->moyenne !== null ? $index + 1 : null;
        }

        $moyenneClasse = count($moyennes) > 0 ? round(array_sum($moyennes) / count($moyennes), 2) : null;

        // Élèves sans classe pour la sélection
        $elevesSansClasse = User::whereNull('classe_id')
                       ->where('role', 'eleve')
                       ->get();


        return view('classes.show', compact('classe', 'elevesDansClasse', 'elevesSansClasse', 'moyenneClasse'));
    }


    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:100',
        ]);

        Classe::create($request->only('nom', 'niveau'));

        return redirect()->route('classes.index')->with('success', 'Classe ajoutée avec succès.');
    }

    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:100',
        ]);

        $classe->update($request->only('nom', 'niveau'));

        return redirect()->route('classes.index')->with('success', 'Classe modifiée avec succès.');
    }

    public function destroy(Classe $classe)
    {
        $classe->delete();

        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès.');
    }
    public function ajouterEleve(Request $request, Classe $classe)
    {
        $request->validate([
            'eleve_id' => 'required|exists:users,id',
        ]);

        $eleve = \App\Models\User::findOrFail($request->eleve_id);
        $eleve->classe_id = $classe->id;
        $eleve->save();

        return back()->with('success', 'Élève ajouté à la classe.');
    }

    public function retirerEleve(Classe $classe, \App\Models\User $eleve)
    {
        if ($eleve->classe_id == $classe->id) {
            $eleve->classe_id = null;
            $eleve->save();
        }

        return back()->with('success', 'Élève retiré de la classe.');
    }



    public function bulletin(Classe $classe, User $eleve)
    {
        // Vérifier que l'élève appartient bien à la classe
        if ($eleve->classe_id !== $classe->id) {
            abort(404);
        }

        // Charger les notes avec matière et enseignant
        $notes = $eleve->notes()
            ->with(['matiere', 'enseignant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('matiere_id'); // Dernière note par matière

        // Calculer la moyenne des notes (si des notes existent)
        $moyenne = $notes->isNotEmpty()
            ? round($notes->avg('note'), 2)
            : null;

        return view('classes.bulletin', compact('classe', 'eleve', 'notes', 'moyenne'));
    }



public function exportBulletinPDF(Classe $classe, User $eleve)
{
    // Vérifie que l’élève appartient bien à la classe
    if ($eleve->classe_id !== $classe->id) {
        abort(404);
    }

    $notes = $eleve->notes()
        ->with(['matiere', 'enseignant'])
        ->where('classe_id', $classe->id)
        ->get()
        ->unique('matiere_id');

    $moyenne = $notes->isNotEmpty()
        ? round($notes->avg('note'), 2)
        : null;

    $pdf = Pdf::loadView('classes.bulletin_pdf', [
        'classe' => $classe,
        'eleve' => $eleve,
        'notes' => $notes,
        'moyenne' => $moyenne,
    ]);
$pdf = Pdf::loadView('classes.bulletin_pdf', compact('classe', 'eleve', 'notes', 'moyenne'));
    return $pdf->download("bulletin_{$eleve->id}.pdf");
}
}
