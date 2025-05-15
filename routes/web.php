<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EleveController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EmploiTempsController;
use App\Http\Controllers\ParentUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\SalleController;
/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/

Route::get('/inscription/create', [InscriptionController::class, 'create'])->name('parents.inscription.form');
Route::post('/inscription', [InscriptionController::class, 'store'])->name('parents.inscription.store');
Route::post('/parent/inscription', [ParentUserController::class, 'storeInscription'])->name('parents.inscription.store');
Route::get('/inscription/create', [InscriptionController::class, 'create'])->name('inscription.create');
Route::post('/inscription/store', [InscriptionController::class, 'store'])->name('inscription.store');
Route::get('parents/inscription/form', [ParentUserController::class, 'formInscription'])->name('parents.inscription.form');

Route::middleware(['auth'])->group(function () {
    Route::get('parent/inscription', [ParentUserController::class, 'formInscription'])->name('parents.inscription.form');
    Route::post('parent/inscription', [ParentUserController::class, 'storeInscription'])->name('parents.inscription.store');
});

// Inscriptions
Route::get('/inscription/{eleve}', [InscriptionController::class, 'show'])->name('inscription.show');
Route::post('/inscription/valider/{eleve}', [InscriptionController::class, 'valider'])->name('inscription.valider');
Route::get('/inscriptions', [InscriptionController::class, 'index'])->name('inscription.index');

// Paiements
Route::post('/paiement/{inscription}', [PaiementController::class, 'store'])->name('parents.paiement');




Route::get('/', function () {
    return view('welcome');
});




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

    // matieres routes
    Route::prefix('matieres')->name('matieres.')->group(function () {
        // Afficher la liste des matières
        Route::get('/', [MatiereController::class, 'index'])->name('index');
        // Afficher une matière et ses enseignants
        Route::get('{matiere}', [MatiereController::class, 'show'])->name('show');
        // Afficher le formulaire de création de matière
        Route::get('/create', [MatiereController::class, 'create'])->name('create');
        // Enregistrer une nouvelle matière
        Route::post('/store', [MatiereController::class, 'store'])->name('store');
        // Afficher le formulaire d'édition d'une matière
        Route::get('{matiere}/edit', [MatiereController::class, 'edit'])->name('edit');
        // Mettre à jour une matière
        Route::put('{matiere}', [MatiereController::class, 'update'])->name('update');
        // Supprimer une matière
        Route::delete('{matiere}', [MatiereController::class, 'destroy'])->name('destroy');
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
    Route::resource('emploi', EmploiTempsController::class);
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

    Route::get('/emplois', [EmploiTempsController::class, 'index'])->name('emploi.index');
    Route::get('/emplois/{id}', [EmploiTempsController::class, 'show'])->name('emploi.show');
    Route::get('/enseignant/classe/{classeId}/eleves', [AbsenceController::class, 'getElevesByClasse']);
    Route::post('/absences/marquer', [AbsenceController::class, 'marquer'])->name('absences.marquer');
    Route::post('/absences/justifier', [AbsenceController::class, 'storeAjax'])->name('absences.justifier');

    Route::get('enseignant/classe/{classe}/eleves', [AbsenceController::class, 'getElevesByClasse'])
        ->name('enseignant.classe.eleves');
    Route::post('/absences/store-ajax', [AbsenceController::class, 'storeAjax'])->name('absences.storeAjax');

    Route::get('/enseignant/classes', [EnseignantController::class, 'classes'])->name('enseignant.classes');

    Route::get('/enseignant/exercice', [EnseignantController::class, 'exercice'])->name('enseignant.exercice');
    Route::get('/emploi', [EmploiTempsController::class, 'index'])->name('emploi.index');

    // Routes spécifiques aux parents
    Route::middleware(['auth'])->group(function () {
        Route::get('/enseignant/absences', [EnseignantController::class, 'indexen'])->name('enseignant.absences');
        Route::get('/enseignant/classe/{id}/eleves', [EnseignantController::class, 'getEleves']);
        Route::post('/enseignant/absence', [EnseignantController::class, 'storeAbsence'])->name('enseignant.absence.store');
    });
    Route::get('/parent/inscription', [ParentUserController::class, 'formInscription'])->name('parent.inscription.form');

    Route::get('/parent/enfants', [ParentUserController::class, 'mesEnfants'])->name('parents.enfants');

    Route::post('/parents/inscription/{eleve_id}', [ParentUserController::class, 'storeinscriptions'])->name('parent.store.inscription');

    Route::post('/parent/{id}/inscription', [ParentUserController::class, 'submitInscription'])->name('parent.inscription.submit');

    Route::post('/parents/paiement/{id}', [ParentUserController::class, 'paiement'])->name('parents.paiement');
    Route::get('/parents/facture/{id}', [ParentUserController::class, 'genererFacturePDF'])->name('parents.facture.pdf');
    Route::get('parent/{id}/inscription', [ParentUserController::class, 'inscription']);
    Route::get('/parent/absences', [ParentUserController::class, 'absences'])->name('parents.absences');
    // Routes pour l'inscription d'un élève
    Route::post('/inscription/{eleve_id}/valider', [InscriptionController::class, 'valider'])->name('inscription.valider');
    Route::post('/paiement/{inscription_id}', [PaiementController::class, 'store'])->name('parents.paiement');


    // Routes élève
    Route::get('/eleves/emploi', [EmploiTempsController::class, 'index'])->name('eleves.emploi');
    Route::get('/eleve/exercices', [EleveController::class, 'exercices'])->name('eleves.exercices');
    Route::get('/eleve/exercices/{id}', [EleveController::class, 'showExercice'])->name('eleves.exercice.show');
    Route::get('/eleve/notes', [NoteController::class, 'mesNotes'])->name('eleves.notes')->middleware('auth');
    Route::get('/eleve/emploi', [EleveController::class, 'monEmploi'])->name('eleves.emploi');

    // Routes d'authentification
    Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');
});

require __DIR__ . '/auth.php';
