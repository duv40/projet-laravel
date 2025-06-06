<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seminaire; // Optionnel, si tu veux afficher des séminaires sur la page d'accueil publique

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil ou redirige l'utilisateur connecté vers son tableau de bord.
     */
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Logique de redirection basée sur le rôle
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isSecretaire()) {
                return redirect()->route('secretaire.dashboard');
            } elseif ($user->isPresentateur()) { // Priorité si un utilisateur a plusieurs "casquettes"
                return redirect()->route('presentateur.dashboard');
            } elseif ($user->isEtudiant()) {
                return redirect()->route('etudiant.dashboard');
            } else {
                // Fallback vers le dashboard générique de Breeze si aucun rôle spécifique n'est trouvé
                // ou si l'utilisateur a un rôle non couvert ci-dessus.
                return redirect()->route('dashboard');
            }
        }

        // Pour les visiteurs non connectés :
        // Optionnel : Charger des séminaires récents à afficher sur la page d'accueil
        // $seminairesRecents = Seminaire::where('statut', 'programmé')
        //                             ->where('date_presentation', '>=', now()) // Uniquement ceux à venir
        //                             ->orderBy('date_presentation', 'asc')
        //                             ->take(3) // Nombre de séminaires à afficher
        //                             ->get();
        // return view('welcome', compact('seminairesRecents'));

        return view('welcome'); // La vue welcome.blade.php de base
    }
}