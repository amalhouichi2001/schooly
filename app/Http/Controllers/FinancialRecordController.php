<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialRecord;
use App\Models\User;


use Illuminate\Support\Facades\File;

class FinancialRecordController extends Controller
{
    public function create($enseignant_id)
    {
        // On récupère l'utilisateur avec rôle enseignant
        $enseignant = User::where('role', 'enseignant')->findOrFail($enseignant_id);
        return view('financial_records.create', compact('enseignant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'enseignant_id' => 'required|exists:users,id',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:revenu,dépense',
        ]);

        // On vérifie que l'utilisateur est bien un enseignant
        $enseignant = User::where('role', 'enseignant')->findOrFail($request->enseignant_id);

        FinancialRecord::create([
            'user_id' => $enseignant->id,
            'montant' => $request->montant,
            'type' => $request->type,
            'date' => $request->date,
        ]);


        return redirect()->route('financial-records.index')->with('success', 'Enregistrement ajouté.');
    }

    public function edit($id)
    {
        $record = FinancialRecord::findOrFail($id);
        return view('financial_records.edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = FinancialRecord::findOrFail($id);

        $request->validate([
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'type' => 'required|in:revenu,dépense',
        ]);

        $record->update([
            'montant' => $request->montant,
            'date' => $request->date,
            'type' => $request->type,
        ]);


        return redirect()->route('financial-records.index')->with('success', 'Enregistrement modifié.');
    }


public function downloadAll(Request $request)
{
    $mois = $request->input('mois') ?? now()->format('Y-m');
    [$year, $month] = explode('-', $mois);

    // ✅ Récupérer les fiches de paie avec les utilisateurs de rôle "enseignant"
    $records = FinancialRecord::with(['enseignant' => function ($q) {
            $q->where('role', 'enseignant');
        }])
        ->whereYear('date', $year)
        ->whereMonth('date', $month)
        ->get()
        ->filter(fn($record) => $record->enseignant) // Écarte les users non enseignants
        ->groupBy('user_id');

    if ($records->isEmpty()) {
        return back()->with('error', "Aucune fiche de paie trouvée pour $mois.");
    }

    $tempDir = storage_path('app/temp');
    if (!File::exists($tempDir)) {
        File::makeDirectory($tempDir, 0755, true);
    }

    $zipFile = storage_path("app/fiches_paie_{$mois}.zip");
    $zip = new \ZipArchive;

    if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
        foreach ($records as $userId => $groupedRecords) {
            $enseignant = $groupedRecords->first()->enseignant;
            $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $enseignant->name);
            $html = view('pdf.fiche-paie', compact('enseignant', 'groupedRecords'))->render();
            $filePath = $tempDir . "/fiche_{$safeName}.html";
            file_put_contents($filePath, $html);
            $zip->addFile($filePath, "fiche_{$safeName}.html");
        }
        $zip->close();
    } else {
        return back()->with('error', 'Impossible de créer le fichier ZIP.');
    }

    return response()->download($zipFile)->deleteFileAfterSend(true);
}

public function print($enseignant_id)
{
    $enseignant = User::where('role', 'enseignant')->with('financialRecords')->findOrFail($enseignant_id);
    return view('financial_records.print', compact('enseignant'));
}

    public function destroy($id)
    {
        $record = FinancialRecord::findOrFail($id);
        $record->delete();

        return redirect()->route('financial-records.index')->with('success', 'Enregistrement supprimé.');
    }
 public function index(Request $request)
{
    $user = auth()->user();

    // Si l'utilisateur est enseignant, il ne voit que ses propres données
    if ($user->role === 'enseignant') {
        $enseignants = collect([$user->load(['financialRecords' => function ($q) use ($request) {
            if ($mois = $request->input('mois')) {
                [$year, $month] = explode('-', $mois);
                $q->whereYear('date', $year)->whereMonth('date', $month);
            }
        }])]);
    } else {
        // Admin : peut voir tous les enseignants avec filtre optionnel
        $enseignantId = $request->input('enseignant_id');
        $mois = $request->input('mois');

        $enseignantsQuery = User::where('role', 'enseignant')->with(['financialRecords' => function ($q) use ($mois) {
            if ($mois) {
                [$year, $month] = explode('-', $mois);
                $q->whereYear('date', $year)->whereMonth('date', $month);
            }
        }]);

        if ($enseignantId) {
            $enseignantsQuery->where('id', $enseignantId);
        }

        $enseignants = $enseignantsQuery->get();
    }

    // Liste de tous les enseignants pour les filtres (dropdown, etc.)
    $allEnseignants = User::where('role', 'enseignant')->get();

    // Somme des montants pour le mois courant
    $totalMensuel = FinancialRecord::whereMonth('date', now()->month)
        ->whereYear('date', now()->year)
        ->sum('montant');

    return view('financial_records.index', compact('enseignants', 'user', 'totalMensuel', 'allEnseignants'));
}


}
