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
        $user = Auth::user();
   $heures = [
        '08:00-10:00',
        '10:00-12:00',
        '12:00-14:00',
        '14:00-16:00',
        '16:00-18:00',
    ];

    // Définir les jours - exemple jours de la semaine en français
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi','samedi'];
        $seances = Seance::with(['matiere', 'enseignant', 'salle', 'classe'])
                        ->orderBy('date')
                        ->orderBy('heure_debut')
                        ->get();

        $classes = Classe::all();
        $matieres = Matiere::all();
        $enseignants = User::where('role', 'enseignant')->get();
        $salles = Salle::all();

        return view('seances.index', compact('seances', 'classes', 'matieres', 'enseignants', 'salles', 'user','seances', 'heures', 'jours'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'emploi' => 'required|array',
        ]);

        $jours = [
            'Lundi' => 'Monday',
            'Mardi' => 'Tuesday',
            'Mercredi' => 'Wednesday',
            'Jeudi' => 'Thursday',
            'Vendredi' => 'Friday',
            'Samedi' => 'Saturday',
        ];

        $donnees = $request->input('emploi');
        $classeId = $request->input('classe_id');

        foreach ($donnees as $jour => $plages) {
            foreach ($plages as $heure => $details) {
                if (!empty($details['matiere_id']) && !empty($details['enseignant_id']) && !empty($details['salle_id'])) {

                    [$heureDebut, $heureFin] = explode('-', $heure);
                    $dateSeance = Carbon::now()->next($jours[$jour])->format('Y-m-d');
                    $duration = (strtotime($heureFin) - strtotime($heureDebut)) / 60;

                    // Optionnel : vérifier si la séance existe déjà (pour éviter doublons)

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
                    ]);
                }
            }
        }

        return redirect()->route('seances.index')->with('success', 'Emploi du temps enregistré avec succès.');
    }
}
