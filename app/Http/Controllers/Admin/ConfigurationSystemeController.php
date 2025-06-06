<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
// Pour lire/écrire dans les fichiers de config Laravel: use Illuminate\Support\Facades\Config;
// Pour gérer .env (via un paquet) : use App\Services\DotEnvEditor; (exemple)

class ConfigurationSystemeController extends Controller
{
    /**
     * Affiche le formulaire de configuration du système.
     */
    public function edit()
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        // Exemples de configurations que tu pourrais vouloir gérer :
        // - Nombre d'éléments par page par défaut
        // - Adresse email du contact principal pour le support
        // - Activer/Désactiver certaines fonctionnalités globales

        // Pour l'instant, on peut imaginer des valeurs stockées dans config/app.php ou une table 'settings'.
        // $delaiAvantSoumissionResumeJours = config('app.delai_soumission_resume_jours', 10);
        // $contactEmailSupport = config('app.contact_support_email', 'support@example.com');

        // return view('admin.configuration.edit', compact('delaiAvantSoumissionResumeJours', 'contactEmailSupport'));
        return view('admin.configuration.edit');
    }

    /**
     * Met à jour la configuration du système.
     */
    public function update(Request $request)
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        // Exemple de validation
        // $validatedData = $request->validate([
        //     'delai_soumission_resume_jours' => 'required|integer|min:1|max:30',
        //     'contact_support_email' => 'required|email',
        // ]);

        // Logique de sauvegarde des configurations :
        // Option 1: Mettre à jour des fichiers de configuration Laravel (plus complexe et pas toujours recommandé directement)
        // Config::set('app.delai_soumission_resume_jours', $validatedData['delai_soumission_resume_jours']);
        // (Nécessiterait une stratégie pour rendre ces changements persistants, car Config::set est pour la requête actuelle)

        // Option 2: Stocker dans une table 'settings' (clé/valeur)
        // Setting::updateOrCreate(['key' => 'delai_soumission_resume_jours'], ['value' => $validatedData['delai_soumission_resume_jours']]);
        // Setting::updateOrCreate(['key' => 'contact_support_email'], ['value' => $validatedData['contact_support_email']]);

        // Option 3: Utiliser un paquet pour éditer le fichier .env (pour les paramètres qui y sont stockés)
        // $editor = new DotEnvEditor();
        // $editor->setKey('MAIL_FROM_ADDRESS', $request->input('mail_from_address'));
        // $editor->save();


        // Pour l'instant, on simule
        // Log::info('Configuration du système mise à jour (simulation)', $validatedData);

        return redirect()->route('admin.configuration.edit')
                         ->with('success', 'Configuration du système mise à jour (simulation).');
    }
}