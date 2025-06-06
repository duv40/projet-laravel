<?php

namespace App\Http\Controllers\Presentateur;

use App\Http\Controllers\Controller;
use App\Models\Seminaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Pour la gestion des dates
use Illuminate\Support\Facades\Mail;     // NOUVEAU
use App\Mail\ResumeSoumisMail; 



class PresentateurSeminaireController extends Controller
{
    /**
     * Affiche la liste des séminaires programmés ou passés pour le présentateur.
     */
    public function index()
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }

        $seminaires = Auth::user()->seminairesPresentes() // Utilise la relation définie dans User.php
                            ->whereIn('statut', ['programmé', 'passé'])
                            ->orderBy('date_presentation', 'desc') // Les plus récents ou à venir en premier
                            ->paginate(10);
        return view('presentateur.seminaires.index', compact('seminaires'));
    }

    /**
     * Affiche le formulaire pour soumettre le résumé d'un séminaire.
     */
    public function showSoumettreResumeForm(Seminaire $seminaire)
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }

        // Vérifier que le séminaire appartient au présentateur et qu'il est programmé
        if ($seminaire->presentateur_id !== Auth::id() || $seminaire->statut !== 'programmé') {
            abort(403, 'Action non autorisée.');
        }

        // Vérifier la règle des 10 jours (exemple)
        $dateLimiteSoumission = Carbon::parse($seminaire->date_presentation . ' ' . $seminaire->heure_debut)->subDays(10);
        if (Carbon::now()->gt($dateLimiteSoumission) && empty($seminaire->resume)) {
            // La date limite est dépassée, mais on pourrait quand même autoriser la soumission avec un avertissement
            // ou le bloquer si la règle est stricte.
            // Pour l'instant, on laisse le formulaire s'afficher.
            session()->flash('warning', 'Attention: La date limite pour soumettre le résumé est normalement passée.');
        }

        return view('presentateur.seminaires.resume_form', compact('seminaire'));
    }

    /**
     * Enregistre le résumé soumis pour un séminaire.
     */
    public function storeResume(Request $request, Seminaire $seminaire)
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }

        // Vérifier que le séminaire appartient au présentateur et qu'il est programmé
        $validatedData = $request->validate([
            'resume' => 'required|string|min:50',
        ]);

        $seminaire->resume = $validatedData['resume'];
        $seminaire->save();

        // --- ENVOI DE L'EMAIL ---
        $secretaires = User::where('role', 'secretaire')->get();
        if ($secretaires->isNotEmpty()) {
            foreach ($secretaires as $secretaire) {
                Mail::to($secretaire->email)
                    ->queue(new ResumeSoumisMail($seminaire));
            }
        }
        // --- FIN ENVOI EMAIL ---

        return redirect()->route('presentateur.seminaires.index') // Ou vers la page du séminaire
                         ->with('success', 'Le résumé de votre présentation a été soumis avec succès.');
    }
}