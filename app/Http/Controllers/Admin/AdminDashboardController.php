<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seminaire;
use App\Models\DemandePresentation;
use Illuminate\Support\Facades\Gate;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        $nombreTotalUtilisateurs = User::count();
        $nombreSeminairesProgrammes = Seminaire::where('statut', 'programmé')->count();
        $nombreDemandesEnAttente = DemandePresentation::where('statut', 'en_attente')->count();

        // Tu peux ajouter d'autres statistiques pertinentes ici

        return view('admin.dashboard', compact(
            'nombreTotalUtilisateurs',
            'nombreSeminairesProgrammes',
            'nombreDemandesEnAttente'
        ));
    }
}