<?php

namespace App\Http\Controllers\Presentateur;

use App\Http\Controllers\Controller;
use App\Models\DemandePresentation;
use App\Models\User; // NOUVEAU: Importer le modèle User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;     // NOUVEAU: Importer la façade Mail
use App\Mail\NouvelleDemandeSoumiseMail;  // NOUVEAU: Importer ton Mailable // Nécessaire pour le 'document_joint'
use Illuminate\Support\Facades\Gate;

class DemandePresentationController extends Controller
{
    /**
     * Display a listing of the resource (les demandes du présentateur connecté).
     */
    public function index()
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }
        $demandes = Auth::user()->demandesPresentationsSoumises()->latest()->paginate(10);
        return view('presentateur.demandes.index', compact('demandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }
        return view('presentateur.demandes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }

        $validatedData = $request->validate([
            'titre' => 'required|string|max:255|min:5',
            'description_courte' => 'nullable|string|min:10',
            'document_joint' => 'nullable|file|mimes:pdf,doc,docx,txt|max:5120',
        ]);

        $demande = new DemandePresentation($validatedData);
        $demande->presentateur_id = Auth::id();

        if ($request->hasFile('document_joint')) {
            $demande->document_joint = $request->file('document_joint')->store('demandes_documents', 'public');
        }

        $demande->save();

        // --- ENVOI DE L'EMAIL ---
        $secretaires = User::where('role', 'secretaire')->get();
        if ($secretaires->isNotEmpty()) {
            foreach ($secretaires as $secretaire) {
                Mail::to($secretaire->email)
                    ->queue(new NouvelleDemandeSoumiseMail($demande));
            }
        }
        // --- FIN ENVOI EMAIL ---

        return redirect()->route('presentateur.demandes.index')
                         ->with('success', 'Votre demande de présentation a été soumise avec succès.');
    }

    /**
     * Display the specified resource (une demande spécifique du présentateur).
     */
    public function show(DemandePresentation $demandePresentation) // Route Model Binding
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }
        // S'assurer que le présentateur ne voit que ses propres demandes
        if ($demandePresentation->presentateur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé à cette demande.');
        }
        return view('presentateur.demandes.show', compact('demandePresentation'));
    }

    /**
     * Show the form for editing the specified resource.
     * Un présentateur peut modifier sa demande uniquement si elle est 'en_attente'.
     */
    public function edit(DemandePresentation $demandePresentation)
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }
        if ($demandePresentation->presentateur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        if ($demandePresentation->statut !== 'en_attente') {
            return redirect()->route('presentateur.demandes.show', $demandePresentation)
                             ->with('error', 'Cette demande ne peut plus être modifiée.');
        }
        return view('presentateur.demandes.edit', compact('demandePresentation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DemandePresentation $demandePresentation)
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }
        if ($demandePresentation->presentateur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        if ($demandePresentation->statut !== 'en_attente') {
            return redirect()->route('presentateur.demandes.show', $demandePresentation)
                             ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $validatedData = $request->validate([
            'titre' => 'required|string|max:255|min:5',
            'description_courte' => 'nullable|string|min:10',
            'document_joint' => 'nullable|file|mimes:pdf,doc,docx,txt|max:5120',
            // Ne pas permettre de changer le statut ou presentateur_id ici
        ]);

        // Gérer le document joint s'il est mis à jour
        if ($request->hasFile('document_joint')) {
            // Supprimer l'ancien fichier s'il existe
            if ($demandePresentation->document_joint) {
                Storage::disk('public')->delete($demandePresentation->document_joint);
            }
            $validatedData['document_joint'] = $request->file('document_joint')->store('demandes_documents', 'public');
        } elseif ($request->input('supprimer_document_joint')) { // Ajouter une case à cocher pour supprimer
             if ($demandePresentation->document_joint) {
                Storage::disk('public')->delete($demandePresentation->document_joint);
            }
            $validatedData['document_joint'] = null;
        }


        $demandePresentation->update($validatedData);

        return redirect()->route('presentateur.demandes.show', $demandePresentation)
                         ->with('success', 'Demande de présentation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage (Annuler la demande).
     * Un présentateur peut annuler sa demande uniquement si elle est 'en_attente'.
     */
    public function destroy(DemandePresentation $demandePresentation)
    {
        if (Gate::denies('isPresentateur')) {
            abort(403);
        }
        if ($demandePresentation->presentateur_id !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        if ($demandePresentation->statut !== 'en_attente') {
            return redirect()->route('presentateur.demandes.show', $demandePresentation)
                             ->with('error', 'Cette demande ne peut plus être annulée.');
        }

        // Supprimer le document joint s'il existe
        if ($demandePresentation->document_joint) {
            Storage::disk('public')->delete($demandePresentation->document_joint);
        }

        $demandePresentation->delete();
        // Alternative : changer le statut à 'annulée' au lieu de supprimer
        // $demandePresentation->update(['statut' => 'annulee_par_presentateur']);

        return redirect()->route('presentateur.demandes.index')
                         ->with('success', 'Demande de présentation annulée avec succès.');
    }

    
}