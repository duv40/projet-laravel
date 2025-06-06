<?php

namespace App\Http\Controllers\Etudiant; // Namespace correct

use App\Http\Controllers\Controller; // Contrôleur de base Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pour accéder à l'utilisateur connecté
use App\Models\Seminaire; // Pour récupérer des informations sur les séminaires
use Illuminate\Support\Facades\Gate;

class EtudiantDashboardController extends Controller
{
    /**
     * Affiche le tableau de bord pour l'étudiant.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Gate::denies('isEtudiant')) {
            abort(403);
        }

        $user = Auth::user(); // Récupère l'utilisateur actuellement authentifié

        // Exemple: Récupérer les X prochains séminaires programmés
        $prochainsSeminaires = Seminaire::where('statut', 'programmé')
                                     ->where('date_presentation', '>=', now()->toDateString()) // À partir d'aujourd'hui
                                     ->orderBy('date_presentation', 'asc')
                                     ->orderBy('heure_debut', 'asc')
                                     ->take(5) // Afficher les 5 prochains
                                     ->get();

        // Exemple: Récupérer les X derniers séminaires passés (si l'étudiant veut y accéder rapidement)
        $seminairesPassesRecemment = Seminaire::where('statut', 'passé')
                                        ->orderBy('date_presentation', 'desc')
                                        ->orderBy('heure_debut', 'desc')
                                        ->take(3)
                                        ->get();

        // Tu peux ajouter d'autres logiques ici, par exemple :
        // - Séminaires auxquels l'étudiant s'est "inscrit" (si tu ajoutes cette fonctionnalité)
        // - Dernières annonces, etc.

        return view('etudiant.dashboard', [
            'user' => $user,
            'prochainsSeminaires' => $prochainsSeminaires,
            'seminairesPassesRecemment' => $seminairesPassesRecemment,
        ]);
    }
}