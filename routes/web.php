<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EleveController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EnseignantController;

use App\Http\Controllers\ParentUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\SalleController;
use App\Models\Inscription;
use App\Models\Seance;
use App\Http\Controllers\FinancialRecordController;
use App\Http\Controllers\DepenseController;
/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/









Route::get('/', function () {
    return view('welcome');
});


Route::get('/financial-records', [FinancialRecordController::class, 'index'])->name('financial-records.index');
Route::get('/financial-records/create/{enseignant}', [FinancialRecordController::class, 'create'])->name('financial-records.create');
Route::post('/financial-records/store', [FinancialRecordController::class, 'store'])->name('financial-records.store');
Route::get('/financial-records/{id}/edit', [FinancialRecordController::class, 'edit'])->name('financial-records.edit');
Route::put('/financial-records/{id}', [FinancialRecordController::class, 'update'])->name('financial-records.update');
Route::delete('/financial-records/{id}', [FinancialRecordController::class, 'destroy'])->name('financial-records.destroy');
Route::get('/financial-records/print/{enseignant_id}', [FinancialRecordController::class, 'print'])->name('financial-records.print');
Route::get('/financial-records/download-all', [FinancialRecordController::class, 'downloadAll'])->name('financial-records.download-all');


Route::get('/conges', [CongeController::class, 'index'])->name('conges.index');
Route::get('/conges/create', [CongeController::class, 'create'])->name('conges.create');
Route::post('/conges', [CongeController::class, 'store'])->name('conges.store');
Route::patch('/conges/{conge}/statut', [CongeController::class, 'updateStatut'])->name('conges.updateStatut');
Route::get('/conges/{conge}/pdf', [CongeController::class, 'generatePdf'])->name('conges.pdf');

Route::resource('events', EventController::class);
Route::post('events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');


Route::resource('depenses', DepenseController::class);




Route::get('/monespace', function () {
    return view('profile');
})->middleware('auth')->name('profile');

Route::middleware('auth')->group(function () {
    // eleves routes
    Route::prefix('eleves')->name('eleves.')->group(function () {
        Route::get('/', [EleveController::class, 'index'])->name('index'); // List all élèves
        Route::get('/create', [EleveController::class, 'create'])->name('create'); // Show add form
        Route::post('/store', [EleveController::class, 'store'])->name('store'); // Handle form submission
        Route::get('/{id}/edit', [EleveController::class, 'edit'])->name('edit'); // Edit form
        Route::put('/{id}', [EleveController::class, 'update'])->name('update'); // Update élève
        Route::delete('/{id}', [EleveController::class, 'destroy'])->name('destroy'); // Delete élève
        Route::get('/{id}', [EleveController::class, 'show'])->name('show'); // Optional: show details
    });
    // enseignants routes
    Route::prefix('enseignants')->name('enseignants.')->group(function () {
        Route::get('enseignants', [EnseignantController::class, 'index'])->name('index');
        Route::get('enseignants/create', [EnseignantController::class, 'create'])->name('create');
        Route::post('enseignants', [EnseignantController::class, 'store'])->name('store');
        Route::get('enseignants/{id}/edit', [EnseignantController::class, 'edit'])->name('edit');
        Route::put('enseignants/{id}', [EnseignantController::class, 'update'])->name('update');
        Route::delete('enseignants/{id}', [EnseignantController::class, 'destroy'])->name('destroy');
    });
Route::resource('seances', SeanceController::class);

    // matieres routes
    Route::prefix('matieres')->name('matieres.')->group(function () {
    // 1. Chemins fixes d'abord
    Route::get('/', [MatiereController::class, 'index'])->name('index');
    Route::get('/create', [MatiereController::class, 'create'])->name('create');
    Route::post('/', [MatiereController::class, 'store'])->name('store');
    Route::get('{matiere}/edit', [MatiereController::class, 'edit'])->name('edit');
    Route::put('{matiere}', [MatiereController::class, 'update'])->name('update');
    Route::delete('{matiere}', [MatiereController::class, 'destroy'])->name('destroy');

    // 2. Route dynamique à la fin
    Route::get('{matiere}', [MatiereController::class, 'show'])->name('show');
});

    // salles routes
    Route::prefix('salles')->group(function () {
        Route::get('/', [SalleController::class, 'index'])->name('salles.index');
        Route::get('/create', [SalleController::class, 'create'])->name('salles.create');
        Route::post('/', [SalleController::class, 'store'])->name('salles.store');
        Route::get('/{salle}/edit', [SalleController::class, 'edit'])->name('salles.edit');
        Route::put('/{salle}', [SalleController::class, 'update'])->name('salles.update');
        Route::delete('/{salle}', [SalleController::class, 'destroy'])->name('salles.destroy');
    });

    // classes routes
    Route::prefix('classes')->name('classes.')->group(function () {
        Route::get('/', [ClasseController::class, 'index'])->name('index');
        Route::get('/create', [ClasseController::class, 'create'])->name('create');
        Route::post('/', [ClasseController::class, 'store'])->name('store');
        Route::get('/{classe}/edit', [ClasseController::class, 'edit'])->name('edit');
        Route::put('/{classe}', [ClasseController::class, 'update'])->name('update');
        Route::delete('/{classe}', [ClasseController::class, 'destroy'])->name('destroy');

        // Nouvelle route pour afficher une classe et gérer ses élèves
        Route::get('/{classe}', [ClasseController::class, 'show'])->name('show');

        // Routes pour ajouter / retirer des élèves
        Route::post('/{classe}/ajouter-eleve', [ClasseController::class, 'ajouterEleve'])->name('ajouterEleve');
        Route::delete('/{classe}/retirer-eleve/{eleve}', [ClasseController::class, 'retirerEleve'])->name('retirerEleve');
        // bulletin routes 
        Route::get('/{classe}/bulletin/{eleve}', [ClasseController::class, 'bulletin'])->name('bulletin');

        Route::get('/classes/{classe}/bulletin/{eleve}/pdf', [ClasseController::class, 'exportBulletinPDF'])
            ->name('classes.bulletin.pdf');
    });


    Route::get('/paiement/{eleve_id}/create', [inscriptionController::class, 'create'])->name('parents.paiement');
    Route::get('/parents/paiement/{id}', [InscriptionController::class, 'showPaiement'])->name('parents.paiement.payer');
    Route::get('/paiement/{eleve_id}', [InscriptionController::class, 'form'])->name('paiement.form');
Route::get('/paiement/{id}', [InscriptionController::class, 'form'])->name('parents.paiement.form');
Route::post('/paiement/{id}', [InscriptionController::class, 'payer'])->name('parents.paiement.payer');

Route::post('/paiement/{id}', [InscriptionController::class, 'payer'])->name('parents.paiement.payer');

Route::get('/facture/{id}', [InscriptionController::class, 'genererFacturePDF'])->name('parents.facture');
Route::get('/emploi', [SeanceController::class, 'index'])->name('emploi.index');


    Route::post('/parents/paiement/{id}', [InscriptionController::class, 'payer'])->name('parents.paiement.payer');
Route::get('/seances', [SeanceController::class, 'index'])->name('seances.index');
    Route::post('/seances', [SeanceController::class, 'store'])->name('seances.store');

    // 🔐 Routes pour les parents
    Route::prefix('parents')->group(function () {

        // Liste et formulaire
        Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('parents.inscriptions');

        // Créer une inscription pour un élève
        Route::post('/inscription/{eleve_id}', [InscriptionController::class, 'storeinscriptions'])->name('parents.inscription.store');
        Route::post('parents/store', [ParentUserController::class, 'store'])->name('parents.store');

        //paiement

        Route::post('/parents/paiement/{id}', [InscriptionController::class, 'payer'])->name('parents.paiement');

        Route::get('/facture/{id}', [InscriptionController::class, 'genererFacturePDF'])->name('parents.facture.pdf');
    });
Route::get('/notes/existantes', [NoteController::class, 'voirNotesExistantes'])->name('notes.existantes');
Route::resource('matieres', MatiereController::class);
    // 🧑‍💼 Routes pour l’admin
    Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('admin.inscriptions.index');
        Route::get('/inscriptions/{id}', [InscriptionController::class, 'show'])->name('admin.inscriptions.show');
        Route::get('/eleves/create', [InscriptionController::class, 'create'])->name('admin.eleves.create');
        Route::post('/eleves/store', [InscriptionController::class, 'store'])->name('admin.eleves.store');
    });

    Route::get('/monespace/edit', [ProfileController::class, 'edit'])->name('edit.profile');
    Route::post('/monespace/update', [ProfileController::class, 'update'])->name('update.profile');
    Route::get('/monespace/password', [ProfileController::class, 'passwordForm'])->name('password.form');
    Route::post('/monespace/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'create'])->name('register');

    Route::get('/register', [RegisteredUserController::class, 'showRegistrationForm'])->name('register');

    // Traitement de l'inscription (POST)
    Route::post('/register', [RegisteredUserController::class, 'register']);

    // Routes dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();

        switch ($user->role) {
            case 'admin':
                return view('dashboards.admin');
            case 'eleve':
                return view('dashboards.eleve');
            case 'enseignant':
                return view('dashboards.enseignant');
            case 'parent':
                return view('dashboards.parent');
            default:
                abort(403, 'Accès non autorisé.');
        }
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Routes avec contrôleurs de ressources
    Route::resource('eleves', EleveController::class);
    Route::resource('absences', AbsenceController::class);
    Route::resource('notes', NoteController::class);

    Route::resource('classes', ClasseController::class);
    Route::resource('exercices', ExerciceController::class);
    Route::resource('enseignants', EnseignantController::class);
    Route::resource('parents', ParentUserController::class);

    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');




    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');

    Route::get('/enseignant/classe/{id}/eleves', [App\Http\Controllers\ClasseController::class, 'getEleves']);
    // Marquer l'absence
    Route::post('/absences/marquer', [AbsenceController::class, 'marquer'])->name('absences.marquer');
    Route::post('/absence', [AbsenceController::class, 'indexen'])->name('absence');
    Route::get('/absences/{id}', [AbsenceController::class, 'show'])->name('absences.show');
    Route::get('/exercices/{id}', [ExerciceController::class, 'show'])->name('exercices.show');


    // Justifier l'absence
    Route::post('/absences/justifier', [AbsenceController::class, 'justifier'])->name('absences.justifier');


    Route::get('/enseignant/classe/{classeId}/eleves', [AbsenceController::class, 'getElevesByClasse']);
    Route::post('/absences/marquer', [AbsenceController::class, 'marquer'])->name('absences.marquer');
    Route::post('/absences/justifier', [AbsenceController::class, 'storeAjax'])->name('absences.justifier');

    Route::get('enseignant/classe/{classe}/eleves', [AbsenceController::class, 'getElevesByClasse'])
        ->name('enseignant.classe.eleves');
    Route::post('/absences/store-ajax', [AbsenceController::class, 'storeAjax'])->name('absences.storeAjax');

    Route::get('/enseignant/classes', [EnseignantController::class, 'classes'])->name('enseignant.classes');

    Route::get('/enseignant/exercice', [EnseignantController::class, 'exercice'])->name('enseignant.exercice');


    // Routes spécifiques aux parents

    Route::get('/enseignant/classe/{id}/eleves', [EnseignantController::class, 'getEleves']);
    Route::post('/enseignant/absence', [EnseignantController::class, 'storeAbsence'])->name('enseignant.absence.store');


    Route::get('/parent/enfants', [ParentUserController::class, 'mesEnfants'])->name('parents.enfants');
    Route::get('/enfants/{id}', [EleveController::class, 'show'])->name('enfants.show');

    Route::get('/parent/absences', [ParentUserController::class, 'absences'])->name('parents.absences');
    Route::get('/absences', [AbsenceController::class, 'index'])->name('absences.index');

    //exercice eleve

    // Routes élève
    Route::post('/eleve/exercices/{id}/import', [EleveController::class, 'import'])->name('eleves.exercices.import');


    Route::get('/eleve/exercices', [EleveController::class, 'exercices'])->name('eleves.exercices');
    Route::get('/eleve/exercices/{id}', [EleveController::class, 'showExercice'])->name('eleves.exercice.show');
    Route::get('/eleve/notes', [NoteController::class, 'mesNotes'])->name('eleves.notes')->middleware('auth');
    Route::get('/eleve/emploi', [EleveController::class, 'monEmploi'])->name('eleves.emploi');

    // Routes d'authentification
    Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
});

Route::get('/emploi', [SeanceController::class, 'index'])->name('emploi.index');
Route::get('/emploi/create', [SeanceController::class, 'create'])->name('emploi.create');
Route::get('/emploi/show/{id}', [SeanceController::class, 'show'])->name('seances.show');

Route::get('/emploi/edit', [SeanceController::class, 'edit'])->name('emploi.edit');
Route::get('/emploi/destroy', [SeanceController::class, 'destroy'])->name('emploi.destroy');

Route::post('/eleves/exercices/{id}/upload', [ExerciceController::class, 'uploadReponse'])->name('eleves.exercice.upload');
Route::post('/eleve/exercices/{id}/import', [EleveController::class, 'import'])->name('eleves.exercices.import');
Route::get('/exercices/{id}/soumettre', [ExerciceController::class, 'formSoumission'])
    ->middleware(['auth'])
    ->name('exercices.soumettre');


Route::get('/paiement/{id}', [ParentUserController::class, 'showPaiementForm'])->name('parents.paiement.form');
Route::post('/paiement/{id}/valider', [ParentUserController::class, 'validerPaiement'])->name('parents.paiement.valider');

// Soumettre le fichier
Route::post('/exercices/{id}/soumettre', [ExerciceController::class, 'uploadReponse'])
    ->middleware(['auth'])
    ->name('exercices.repondre');
require __DIR__ . '/auth.php';
