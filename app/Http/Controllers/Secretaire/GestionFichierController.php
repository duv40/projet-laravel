<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Seminaire;
use App\Models\FichierPresentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class GestionFichierController extends Controller
{
    /**
     * Affiche le formulaire pour ajouter ou remplacer le fichier d'un séminaire.
     * On utilise la route `seminaires.fichier.create` pour cela.
     */
    public function create(Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        return view('secretaire.fichiers.create_or_edit', compact('seminaire'));
    }

    /**
     * Enregistre (ou remplace) le fichier de présentation pour un séminaire.
     * On utilise la route `seminaires.fichier.store` pour cela.
     */
    public function store(Request $request, Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        $request->validate([
            // 'fichier_presentation' est le nom du champ input dans le formulaire
            'fichier_presentation' => 'required|file|mimes:pdf,ppt,pptx,doc,docx,zip|max:20480', // Max 20MB
        ]);

        // Supprimer l'ancien fichier s'il existe déjà pour ce séminaire
        if ($seminaire->fichierPresentation) {
            Storage::disk('public')->delete($seminaire->fichierPresentation->chemin_stockage);
            $seminaire->fichierPresentation->delete(); // Supprime l'enregistrement en BDD
        }

        $fichierTeleverse = $request->file('fichier_presentation');
        $nomOriginal = $fichierTeleverse->getClientOriginalName();
        $cheminStockage = $fichierTeleverse->store("seminaires/{$seminaire->id}/presentation_officielle", 'public');

        FichierPresentation::create([
            'seminaire_id' => $seminaire->id,
            'nom_original_fichier' => $nomOriginal,
            'chemin_stockage' => $cheminStockage,
            'type_mime' => $fichierTeleverse->getClientMimeType(),
            'taille_octets' => $fichierTeleverse->getSize(),
        ]);

        return redirect()->route('secretaire.seminaires.show', $seminaire)
                         ->with('success', 'Fichier de présentation pour "'.$seminaire->titre.'" téléversé/mis à jour.');
    }

    /**
     * Supprime le fichier de présentation d'un séminaire.
     * On utilise la route `seminaires.fichier.destroy` pour cela.
     * Le paramètre {fichier} de la route ne sera pas utilisé si on supprime via le séminaire.
     */
    public function destroy(Seminaire $seminaire) // On cible le fichier A TRAVERS le séminaire
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        $fichier = $seminaire->fichierPresentation;

        if ($fichier) {
            Storage::disk('public')->delete($fichier->chemin_stockage);
            $fichier->delete(); // Supprime l'enregistrement FichierPresentation en BDD
            return redirect()->route('secretaire.seminaires.show', $seminaire)
                             ->with('success', 'Fichier de présentation supprimé.');
        }

        return redirect()->route('secretaire.seminaires.show', $seminaire)
                         ->with('error', 'Aucun fichier de présentation à supprimer pour ce séminaire.');
    }

    // Les méthodes index, show, edit, update pour FichierPresentation en tant que ressource distincte
    // ne sont pas strictement nécessaires si on gère toujours le fichier VIA le séminaire et qu'il n'y en a qu'un.
    // Si tu voulais une page listant TOUS les fichiers uploadés, alors index() aurait un sens.
}