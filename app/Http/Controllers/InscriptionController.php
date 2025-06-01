<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InscriptionController extends Controller
{


    // Affiche une inscription spécifique liée à l’utilisateur connecté
    public function inscriptions()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Récupérer tous les enfants du parent connecté
        $eleves = $user->enfants;

        // Récupérer les inscriptions de tous ses enfants
        $inscriptions = Inscription::whereIn('eleve_id', $eleves->pluck('id'))->with('eleve')->get();

        return view('parents.inscriptions', compact('inscriptions'));
    }

    // Crée une nouvelle inscription
   

    
   


public function form($id)
{
    $inscription = Inscription::with('eleve')->findOrFail($id); // charge aussi l'élève

    $user = $inscription->eleve; // élève associé

    return view('parents.paiement', compact('inscription', 'user'));
}


    // Générer facture PDF
    public function genererFacturePDF($id)
    {
        $inscription = Inscription::findOrFail($id);
        $pdf = Pdf::loadView('parents.facture', compact('inscription'));
        return $pdf->download('facture_paiement_' . $inscription->id . '.pdf');
    }

 public function index()
{
    $user = auth()->user();

    if ($user->isAdmin()) {
        $inscriptions = Inscription::with('eleve')->get();
    } elseif ($user->isParent()) {
        $enfantsIds = $user->enfants->pluck('id');

        $inscriptions = Inscription::with('eleve')
            ->whereIn('eleve_id', $enfantsIds)
            ->get();
    } else {
        $inscriptions = collect(); // vide pour les autres rôles
    }

    return view('inscription.index', compact('inscriptions', 'user'));
}
public function create($user_id)
{
    $user = User::where('id', $user_id)
                ->where('role', 'eleve')
                ->firstOrFail();

    return view('parents.paiement', compact('user'));
}
public function showPaiement($inscriptionId)
{
    $inscription = Inscription::findOrFail($inscriptionId); // ou autre logique
    $user = auth()->user(); // ou récupérer l'utilisateur associé

   
    return view('parents.paiement', [
    'inscription' => $inscription,
    'user' => $user
]);
}

public function payer($id)
{
    $inscription = Inscription::findOrFail($id);
    $inscription->statut = 'payee';
    $inscription->save();

    return redirect()->route('parents.paiement.form', $id)->with('success', 'Paiement effectué avec succès.');
}


   

  
}
