<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Inscription;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function store(Request $request, $inscription_id)
    {
        $inscription = Inscription::findOrFail($inscription_id);

        Paiement::create([
            'inscription_id' => $inscription->id,
            'montant' => 150.00,
            'mode' => $request->mode,
            'date' => Carbon::now(),
            'statut' => 'payé',
        ]);

        return redirect()->route('inscription.index')->with('success', 'Paiement effectué avec succès.');
    }
}
