<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\Classe;
use App\Models\User;
use App\Models\Matiere;
use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SeanceController extends Controller
{


public function index()
{
    $horaires = ['08:00', '09:00', '10:15', '11:15', '14:00', '15:00'];
    $jours = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    $startOfWeek = Carbon::now()->startOfWeek(); // lundi
    $endOfWeek = Carbon::now()->endOfWeek();     // dimanche

    $seances = Seance::whereBetween('date', [$startOfWeek, $endOfWeek])
        ->with(['classe', 'enseignant', 'matiere'])
        ->get();

    // Initialisation tableau vide emploi du temps
    $emploi = [];
    foreach ($horaires as $horaire) {
        foreach ($jours as $jour) {
            $emploi[$horaire][$jour] = null;
        }
    }

    // Remplissage des cases avec séances
    foreach ($seances as $seance) {
        $jour = Carbon::parse($seance->date)->format('l'); // Jour en anglais, ex: 'Monday'
        $heure = Carbon::parse($seance->heure_debut)->format('H:i');

        // Si horaire + jour existe dans le tableau, on place la séance
        if (isset($emploi[$heure][$jour])) {
            $emploi[$heure][$jour] = $seance;
        }
    }

    return view('seances.index', compact('emploi', 'horaires', 'jours'));
}

    public function create()
    {
        $classes = Classe::all();
        $enseignants = User::where('role', 'enseignant')->get();
        $matieres = Matiere::all();
        $salles = Salle::all();

        return view('seances.create', compact('classes', 'enseignants', 'matieres', 'salles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'emploi' => 'required|array',
        ]);

        $jours = [
            'Lundi' => 1,
            'Mardi' => 2,
            'Mercredi' => 3,
            'Jeudi' => 4,
            'Vendredi' => 5,
            'Samedi' => 6,
            'Dimanche' => 7,
        ];

        $donnees = $request->input('emploi');
        $classeId = $request->input('classe_id');

        foreach ($donnees as $jour => $plages) {
            foreach ($plages as $heure => $details) {
                if (!empty($details['matiere_id']) && !empty($details['enseignant_id']) && !empty($details['salle_id'])) {
                    [$heureDebut, $heureFin] = explode('-', $heure);

                    $jourNum = $jours[$jour];
                    $dateSeance = Carbon::now()->next($jourNum)->format('Y-m-d');

                    $duration = (strtotime($heureFin) - strtotime($heureDebut)) / 60;

                    $exists = Seance::where('classe_id', $classeId)
                        ->where('date', $dateSeance)
                        ->where('heure_debut', $heureDebut)
                        ->where('heure_fin', $heureFin)
                        ->exists();

                    if (!$exists) {
                        Seance::create([
                            'date' => $dateSeance,
                            'heure_debut' => $heureDebut,
                            'heure_fin' => $heureFin,
                            'matiere_id' => $details['matiere_id'],
                            'enseignant_id' => $details['enseignant_id'],
                            'salle_id' => $details['salle_id'],
                            'classe_id' => $classeId,
                            'type' => 'cours',
                            'duration' => $duration,
                            'jour_semaine' => $jourNum,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('seances.index')->with('success', 'Emploi du temps enregistré avec succès.');
    }
}
