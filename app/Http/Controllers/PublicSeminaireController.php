<?php

namespace App\Http\Controllers;

use App\Models\Seminaire;
use App\Models\FichierPresentation; // Nécessaire pour le téléchargement
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PublicSeminaireController extends Controller
{
    /**
     * Affiche la liste des séminaires publics (pour les visiteurs non connectés).
     */
    public function index()
    {
        $seminaires = Seminaire::where('statut', 'programmé') // On ne montre que les séminaires activement programmés
            // ->orWhere('statut', 'passé') // Décommente si tu veux aussi montrer les séminaires passés publiquement
            ->orderBy('date_presentation', 'asc') // Les plus proches d'abord
            ->paginate(10); // Utilise la pagination

        return view('public.seminaires.index', compact('seminaires'));
    }

    /**
     * Affiche les détails d'un séminaire public.
     */
    public function show(Seminaire $seminaire) // Route Model Binding
    {
        // S'assurer que seuls les séminaires appropriés sont montrés publiquement
        if (!in_array($seminaire->statut, ['programmé', 'passé'])) {
            abort(404);
        }
        return view('public.seminaires.show', compact('seminaire'));
    }

    /**
     * Affiche la liste des séminaires pour les utilisateurs authentifiés.
     * Peut être la même que la publique, ou avec plus d'infos/options.
     */
    public function indexAuthentifie()
    {
        if (Gate::denies('isAtLeastPresentateur')) {
            abort(403);
        }

        $seminaires = Seminaire::whereIn('statut', ['programmé', 'passé']) // Les authentifiés voient aussi les passés
            ->orderBy('date_presentation', 'desc') // Les plus récents (passés) ou les plus proches (programmés) en premier
            ->with('presentateur', 'fichierPresentation') // Eager load pour optimiser
            ->paginate(10);

        return view('authentifie.seminaires.index', compact('seminaires'));
    }

    /**
     * Affiche les détails d'un séminaire pour un utilisateur authentifié.
     */
    public function showAuthentifie(Seminaire $seminaire)
    {
        if (Gate::denies('isAtLeastPresentateur')) {
            abort(403);
        }

        $seminaire->load('presentateur', 'fichierPresentation'); // Eager load si besoin
        return view('authentifie.seminaires.show', compact('seminaire'));
    }

    /**
     * Gère le téléchargement du fichier de présentation d'un séminaire.
     * Accessible uniquement aux utilisateurs authentifiés.
     */
    public function telechargerFichier(Seminaire $seminaire)
    {
        if (Gate::denies('isAtLeastPresentateur')) {
            abort(403);
        }

        $fichier = $seminaire->fichierPresentation; // Accède à la relation hasOne

        if (!$fichier || !Storage::disk('public')->exists($fichier->chemin_stockage)) {
            return back()->with('error', 'Fichier de présentation non disponible ou introuvable.');
        }

        // Pour forcer le téléchargement avec le nom original du fichier
        return Storage::disk('public')->download($fichier->chemin_stockage, $fichier->nom_original_fichier);
    }
}