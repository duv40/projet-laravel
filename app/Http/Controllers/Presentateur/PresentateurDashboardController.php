<?php

namespace App\Http\Controllers\Presentateur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\DemandePresentation;
use App\Models\Seminaire;

class PresentateurDashboardController extends Controller
{
    public function index()
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }

        $user = Auth::user();

        $demandesEnAttente = $user->demandesPresentationsSoumises()
                                ->where('statut', 'en_attente')
                                ->count();

        $demandesAcceptees = $user->demandesPresentationsSoumises()
                                ->where('statut', 'accepte')
                                ->count();

        // Séminaires programmés pour lesquels le résumé n'a pas encore été soumis
        $seminairesSansResume = $user->seminairesPresentes()
                                   ->where('statut', 'programmé')
                                   ->whereNull('resume')
                                //    ->where('date_presentation', '>', now()->addDays(10)) // Exemple pour la règle des 10 jours
                                   ->orderBy('date_presentation', 'asc')
                                   ->get();

        // Prochains séminaires acceptés
        $prochainsSeminairesAcceptes = $user->seminairesPresentes()
            ->where('statut', 'programmé')
            ->orderBy('date_presentation', 'asc')
            ->take(5)
            ->get();


        return view('presentateur.dashboard', compact(
            'user',
            'demandesEnAttente',
            'demandesAcceptees',
            'seminairesSansResume',
            'prochainsSeminairesAcceptes'
        ));
    }
}