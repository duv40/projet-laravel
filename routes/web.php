<?php

use Illuminate\Support\Facades\Route;

// --- Imports de Contrôleurs (À COMPLÉTER AU FUR ET À MESURE) ---
// Contrôleurs fournis par Breeze ou de base
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; // Si tu crées un HomeController pour la page d'accueil

// Contrôleurs pour les fonctionnalités communes aux authentifiés
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\PublicSeminaireController; // Ce nom est peut-être à revoir, car il gère aussi la consultation pour les authentifiés

// Contrôleurs spécifiques aux rôles (avec leurs namespaces)
use App\Http\Controllers\Etudiant\EtudiantDashboardController;
use App\Http\Controllers\Presentateur\PresentateurDashboardController;
use App\Http\Controllers\Presentateur\DemandePresentationController as PresentateurDemandeController;
use App\Http\Controllers\Presentateur\PresentateurSeminaireController;
use App\Http\Controllers\Secretaire\SecretaireDashboardController;
use App\Http\Controllers\Secretaire\GestionDemandeController;
use App\Http\Controllers\Secretaire\GestionSeminaireController;
use App\Http\Controllers\Secretaire\GestionFichierController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\GestionUtilisateurController;
use App\Http\Controllers\Admin\ConfigurationSystemeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === ROUTES PUBLIQUES ===
// La route '/' de base que tu avais (modifiée pour pointer vers un contrôleur si tu veux plus de logique)
Route::get('/', function () {
    // Ici, tu pourrais appeler [HomeController::class, 'index']
    // pour une logique plus complexe (ex: afficher les derniers séminaires publics)
    return view('welcome'); // Ou ta vue d'accueil principale
})->name('home');

// Si tu veux une liste publique des séminaires accessible sans login
Route::get('/seminaires-publics', [PublicSeminaireController::class, 'index'])->name('seminaires.public.index');
Route::get('/seminaires-publics/{seminaire}', [PublicSeminaireController::class, 'show'])->name('seminaires.public.show');


// === ROUTES D'AUTHENTIFICATION (Breeze) ===
// Garde cette ligne telle quelle, elle est essentielle
require __DIR__.'/auth.php';


// === ROUTES POUR UTILISATEURS AUTHENTIFIÉS ===
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard générique après connexion (celui que tu avais)
    // Tu peux le garder ou le remplacer par des redirections vers les dashboards spécifiques aux rôles
    Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->can('isAdmin')) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->can('isSecretaire')) {
        return redirect()->route('secretaire.dashboard');
    }
    if ($user->can('isAtLeastPresentateur')) {
        return redirect()->route('presentateur.dashboard');
    }
    if ($user->can('isEtudiant')) {
        return redirect()->route('etudiant.dashboard');
    }
    // Par défaut, tu peux afficher une vue ou rediriger ailleurs
    return view('dashboard');
})->name('dashboard');

    // Routes de Profil (fournies par Breeze - déjà dans ton code de base)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Préférences de Notification (communes)
    Route::get('/preferences-notifications', [UserPreferenceController::class, 'edit'])->name('preferences.notifications.edit');
    Route::put('/preferences-notifications', [UserPreferenceController::class, 'update'])->name('preferences.notifications.update');

    // Consultation des Séminaires (pour utilisateurs connectés)
    Route::get('/seminaires', [PublicSeminaireController::class, 'indexAuthentifie'])->name('seminaires.authentifie.index');
    Route::get('/seminaires/{seminaire}', [PublicSeminaireController::class, 'showAuthentifie'])->name('seminaires.authentifie.show');
    Route::get('/seminaires/{seminaire}/telecharger', [PublicSeminaireController::class, 'telechargerFichier'])->name('seminaires.fichier.download');


    // --- ROUTES SPÉCIFIQUES AUX RÔLES ---

    // Étudiant
    Route::prefix('etudiant')->name('etudiant.')->middleware('can:isEtudiant')->group(function () {
        Route::get('/dashboard', [EtudiantDashboardController::class, 'index'])->name('dashboard');
    });

    // Présentateur
    Route::prefix('presentateur')->name('presentateur.')->middleware('can:isAtLeastPresentateur')->group(function () {
        Route::get('/dashboard', [PresentateurDashboardController::class, 'index'])->name('dashboard');
        Route::get('/demandes', [PresentateurDemandeController::class, 'index'])->name('demandes.index');
        Route::get('/demandes/creer', [PresentateurDemandeController::class, 'create'])->name('demandes.create');
        Route::post('/demandes', [PresentateurDemandeController::class, 'store'])->name('demandes.store');
        Route::get('/demandes/{demandePresentation}', [PresentateurDemandeController::class, 'show'])->name('demandes.show');
        Route::get('/seminaires-programmes/{seminaire}/resume/soumettre', [PresentateurSeminaireController::class, 'showSoumettreResumeForm'])->name('seminaires.resume.form');
        Route::post('/seminaires-programmes/{seminaire}/resume', [PresentateurSeminaireController::class, 'storeResume'])->name('seminaires.resume.store');
        Route::get('/seminaires-programmes', [PresentateurSeminaireController::class, 'index'])->name('seminaires.index');
    });

    // Secrétaire Scientifique
    Route::prefix('secretaire')->name('secretaire.')->middleware('can:isSecretaire')->group(function () {
        Route::get('/dashboard', [SecretaireDashboardController::class, 'index'])->name('dashboard');
        Route::get('/demandes-a-traiter', [GestionDemandeController::class, 'index'])->name('demandes.index');
        Route::get('/demandes-a-traiter/{demandePresentation}', [GestionDemandeController::class, 'show'])->name('demandes.show');
        Route::patch('/demandes-a-traiter/{demandePresentation}/valider', [GestionDemandeController::class, 'valider'])->name('demandes.valider');
        Route::patch('/demandes-a-traiter/{demandePresentation}/rejeter', [GestionDemandeController::class, 'rejeter'])->name('demandes.rejeter');
        Route::get('/seminaires-a-gerer', [GestionSeminaireController::class, 'index'])->name('seminaires.index');
        Route::get('/seminaires-a-gerer/creer', [GestionSeminaireController::class, 'create'])->name('seminaires.create');
        Route::post('/seminaires-a-gerer', [GestionSeminaireController::class, 'store'])->name('seminaires.store');
        Route::get('/seminaires-a-gerer/{seminaire}', [GestionSeminaireController::class, 'show'])->name('seminaires.show');
        Route::get('/seminaires-a-gerer/{seminaire}/modifier', [GestionSeminaireController::class, 'edit'])->name('seminaires.edit');
        Route::put('/seminaires-a-gerer/{seminaire}', [GestionSeminaireController::class, 'update'])->name('seminaires.update');
        Route::delete('/seminaires-a-gerer/{seminaire}', [GestionSeminaireController::class, 'destroy'])->name('seminaires.destroy');
        Route::patch('/seminaires-a-gerer/{seminaire}/publier', [GestionSeminaireController::class, 'publier'])->name('seminaires.publier');
        Route::get('/seminaires-passes/{seminaire}/fichier/ajouter', [GestionFichierController::class, 'create'])->name('seminaires.fichier.create');
        Route::post('/seminaires-passes/{seminaire}/fichier', [GestionFichierController::class, 'store'])->name('seminaires.fichier.store');
        Route::get('/seminaires-passes/{seminaire}/fichier/modifier', [GestionFichierController::class, 'edit'])->name('seminaires.fichier.edit');
        Route::put('/seminaires-passes/{seminaire}/fichier', [GestionFichierController::class, 'update'])->name('seminaires.fichier.update');
        Route::delete('/seminaires-passes/{seminaire}/fichier', [GestionFichierController::class, 'destroy'])->name('seminaires.fichier.destroy');
    });

    // Administrateur
    Route::prefix('admin')->name('admin.')->middleware('can:isAdmin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('utilisateurs', GestionUtilisateurController::class);
        Route::get('/configuration', [ConfigurationSystemeController::class, 'edit'])->name('configuration.edit');
        Route::put('/configuration', [ConfigurationSystemeController::class, 'update'])->name('configuration.update');
    });

}); // Fin du groupe middleware auth