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
   

    
    // Traitement du paiement
    public function payer(Request $request, $id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->statut = 'payee';
        
        $inscription->save();

        return redirect()->route('parents.inscriptions')->with('success', 'Paiement effectué avec succès.');
    }

    // Générer facture PDF
    public function genererFacturePDF($id)
    {
        $inscription = Inscription::findOrFail($id);
        $pdf = Pdf::loadView('parents.facture', compact('inscription'));
        return $pdf->download('facture_paiement_' . $inscription->id . '.pdf');
    }

    // Affiche la liste de toutes les inscriptions
    public function index()
    {
        $inscriptions = Inscription::with(['eleve'])->get();
        return view('inscriptions.index', compact('inscriptions'));
    }

   

  
}
