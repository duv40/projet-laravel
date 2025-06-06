<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\DemandePresentation;
use App\Models\Seminaire; // Nécessaire si la validation crée un séminaire
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
// use App\Mail\DemandeValideeNotification; // A créer
// use App\Mail\DemandeRejeteeNotification; // A créer
use Illuminate\Support\Facades\Gate;
use App\Mail\DemandeValideeMail;
use App\Mail\DemandeRejeteeMail;

class GestionDemandeController extends Controller
{
    public function index()
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        $demandes = DemandePresentation::with('presentateur') // Eager load le présentateur
                                      ->latest() // Les plus récentes d'abord
                                      ->paginate(15);
        return view('secretaire.demandes.index', compact('demandes'));
    }

    public function show(DemandePresentation $demandePresentation)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        $demandePresentation->load('presentateur'); // Assurer que le présentateur est chargé
        return view('secretaire.demandes.show', compact('demandePresentation'));
    }

    public function valider(Request $request, DemandePresentation $demandePresentation)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        if ($demandePresentation->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $demandePresentation->statut = 'accepte';
        $demandePresentation->save();

        // Tu créeras probablement le séminaire ici ou dans une étape suivante.
        // Si le séminaire est créé et que la date est fixée, tu peux le passer au Mailable.
        // Pour l'instant, on suppose qu'il n'est pas encore créé ou que la date n'est pas fixée.
        $seminaireCree = null; // Ou récupère/crée le séminaire associé

        // --- ENVOI DE L'EMAIL ---
        if ($demandePresentation->presentateur) { // S'assurer que la relation est chargée ou existe
            Mail::to($demandePresentation->presentateur->email)
                ->queue(new DemandeValideeMail($demandePresentation, $seminaireCree));
        }
        // --- FIN ENVOI EMAIL ---

        return redirect()->route('secretaire.demandes.index')->with('success', 'Demande validée.');
    }

    public function rejeter(Request $request, DemandePresentation $demandePresentation)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }

        if ($demandePresentation->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        // Optionnel: récupérer un motif de rejet du formulaire si tu en as un
        $motifRejet = $request->input('motif_rejet'); // Assure-toi d'avoir un champ 'motif_rejet' dans ton formulaire

        $demandePresentation->statut = 'rejete';
        $demandePresentation->save();

        // --- ENVOI DE L'EMAIL ---
        if ($demandePresentation->presentateur) {
            Mail::to($demandePresentation->presentateur->email)
                ->queue(new DemandeRejeteeMail($demandePresentation, $motifRejet));
        }
        // --- FIN ENVOI EMAIL ---

        return redirect()->route('secretaire.demandes.index')->with('success', 'Demande rejetée.');
    }
}