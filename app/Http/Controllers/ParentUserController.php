<?php

namespace App\Http\Controllers;

use App\Models\ParentUser;
use App\Models\Eleve;
use App\Models\Absence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaiementConfirmationMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Inscription;

class ParentUserController extends Controller
{
    /**
     * Affiche la liste des parents.
     */
    public function index()
    {
        $parents = ParentUser::all();
        return view('parents.index', compact('parents'));
    }
public function create_ins()
    {
        return view('inscription.create');
    }
    /**
     * Affiche le formulaire de création d'un parent.
     */
    public function create()
    {
        $users = User::where('role', 'parent')->get(); // Optionnel si tu veux lier à un utilisateur
        return view('parents.create', compact('users'));
    }

    /**
     * Enregistre un nouveau parent dans la base de données.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:parent_users',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            // 'user_id' => 'nullable|exists:users,id', // si associé à un utilisateur
        ]);

        ParentUser::create($validated);

        return redirect()->route('parents.index')->with('success', 'Parent ajouté avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'un parent.
     */
    public function edit(ParentUser $parent)
    {
        return view('parents.edit', compact('parent'));
    }

    /**
     * Met à jour les informations d'un parent.
     */
    public function update(Request $request, ParentUser $parent)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:parent_users,email,' . $parent->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
        ]);

        $parent->update($validated);

        return redirect()->route('parents.index')->with('success', 'Parent mis à jour avec succès.');
    }

    /**
     * Supprime un parent de la base de données.
     */
    public function destroy(ParentUser $parent)
    {
        $parent->delete();
        return redirect()->route('parents.index')->with('success', 'Parent supprimé avec succès.');
    }
    public function dashboard()
    {
        return view('dashboards.parent');
    }

    /**
     * Affiche les enfants associés au parent connecté.
     */
    public function mesEnfants()
    {
        $user = Auth::user();
        $eleve = Eleve::where('parent_id', $user->id)->get();

        return view('parents.enfants', compact('eleve'));
    }

    /**
     * Affiche les absences des enfants du parent connecté.
     */
    public function absences()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à cette page.');
    }

    $eleveIds = Eleve::where('parent_id', $user->id)->pluck('id');
    $absences = Absence::whereIn('eleve_id', $eleveIds)->get();

    return view('parents.absences', compact('absences'));
}
public function inscrireEnfant($eleve_id)
{
    $eleve = Eleve::where('id', $eleve_id)->where('parent_id', Auth::id())->firstOrFail();

    $inscription = Inscription::create([
        'eleve_id' => $eleve->id,
        'date_inscription' => now(),
        'validee' => false,
    ]);

    return redirect()->route('parents.paiement', $inscription->id)
                     ->with('success', 'Inscription initiée. Veuillez effectuer le paiement.');
}


public function formInscription()
{
    $inscriptions = Inscription::with('eleve')->get(); // Ajoute cette ligne
    $eleves = Eleve::all(); // Si tu as besoin de lister les élèves dans un <select>
    return view('parents.inscription', compact('inscriptions', 'eleves'));
}
public function storeInscription(Request $request)
{
    $request->validate([
        'eleve_id' => 'required|exists:eleves,id',
        'date_naissance' => 'required|date',
    ]);

    Inscription::create([
        'eleve_id' => $request->eleve_id,
        'date_naissance' => $request->date_naissance,
        'validee' => false,
    ]);

    return redirect()->route('parents.inscription')->with('success', 'Inscription réussie');
}







public function inscription()
{
    $user = Auth::user();

    // Check if the user is authenticated
    if (!$user) {
        return redirect()->route('login'); // Redirect to login page or any other handling
    }

    // Proceed if authenticated
    $eleve = $user->eleve; // Get the related 'eleve' for the authenticated user
    
    return view('parents.inscription', compact('eleve'));
}




public function storeinscriptions($eleve_id)
{
    $eleve = Eleve::findOrFail($eleve_id);

    // Vérifie s’il existe déjà une inscription non validée
    $existing = Inscription::where('eleve_id', $eleve_id)
                           ->where('validee', false)
                           ->first();

    if ($existing) {
        return redirect()->back()->with('error', 'Une inscription non validée existe déjà pour cet élève.');
    }

    // Crée une nouvelle inscription
    $inscription = Inscription::create([
        'eleve_id' => $eleve_id,
        'date_inscription' => now(),
        'validee' => false,
    ]);

    return redirect()->route('parents.paiement', $inscription->id)
                     ->with('success', 'Inscription créée. Veuillez procéder au paiement.');
}


public function paiement(Request $request, $inscriptionId)
{
    $inscription = Inscription::findOrFail($inscriptionId);
    $inscription->paiement_status = 'payé';
    $inscription->mode_paiement = $request->mode;
    $inscription->save();

    Mail::to($inscription->parent->email)->send(new PaiementConfirmationMail($inscription));

    return redirect()->route('parents.facture.pdf', $inscription->id);
}

// Génère la facture PDF
public function genererFacturePDF($id)
{
    $inscription = Inscription::findOrFail($id);
    $pdf = Pdf::loadView('parents.facture', compact('inscription'));
    return $pdf->download('facture_paiement_'.$inscription->id.'.pdf');
}

}
