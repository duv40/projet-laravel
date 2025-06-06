<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandePresentation;
use App\Models\Seminaire;
use Illuminate\Support\Facades\Gate;

class SecretaireDashboardController extends Controller
{
    public function index()
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        $demandesEnAttente = DemandePresentation::where('statut', 'en_attente')->count();

        $seminairesAProgrammer = DemandePresentation::where('statut', 'accepte')
            ->whereDoesntHave('seminaire') // Celles qui n'ont pas encore de séminaire lié
            ->count();

        $seminairesAPublier = Seminaire::where('statut', 'programmé')
            ->whereNotNull('resume') // Seulement si le résumé est là
            // ->where('est_publie', false) // Si tu ajoutes un champ 'est_publie'
            ->count(); // Un indicateur que quelque chose est prêt à être rendu public

        $seminairesPassesSansFichier = Seminaire::where('statut', 'passé')
            ->whereDoesntHave('fichierPresentation')
            ->count();

        return view('secretaire.dashboard', compact(
            'demandesEnAttente',
            'seminairesAProgrammer',
            'seminairesAPublier',
            'seminairesPassesSansFichier'
        ));
    }
}