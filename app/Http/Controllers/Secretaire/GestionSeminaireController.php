<?php

namespace App\Http\Controllers\Secretaire;

use App\Http\Controllers\Controller;
use App\Models\Seminaire;
use App\Models\DemandePresentation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage; // Au cas où on supprime un fichier avec le séminaire
use Illuminate\Support\Facades\Gate;
// use App\Mail\SeminairePublieNotification;
use App\Mail\SeminairePublieMail;

class GestionSeminaireController extends Controller
{
    /**
     * Affiche la liste de tous les séminaires gérés.
     */
    public function index()
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        $seminaires = Seminaire::with(['presentateur', 'demandePresentation', 'fichierPresentation'])
                              ->latest('date_presentation') // Ou tri par date de création/modification
                              ->paginate(15);
        return view('secretaire.seminaires.index', compact('seminaires'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau séminaire.
     * Peut être pré-rempli à partir d'une demande acceptée.
     */
    public function create(Request $request)
    {
        if (Gate::denies('isSecretaire')) { // Utilise le Gate que tu as défini
            abort(403, 'Action non autorisée.');
        }

        $seminaire = new Seminaire(); // Crée une nouvelle instance de Seminaire (pour l'Option B)
        $demandeLiee = null;          // Initialise $demandeLiee

        $demande_id = $request->query('demande_id'); // Récupère l'ID de la demande depuis l'URL (ex: ?demande_id=123)

        if ($demande_id) {
            $demandeLiee = DemandePresentation::with('presentateur') // Eager load le présentateur
                                            ->where('id', $demande_id)
                                            ->where('statut', 'accepte')
                                            // Optionnel: vérifier si un séminaire n'est pas déjà lié à cette demande
                                            // ->whereDoesntHave('seminaire')
                                            ->first();

            if ($demandeLiee) {
                // Pré-remplir l'objet $seminaire avec les informations de la demande liée
                $seminaire->demande_presentation_id = $demandeLiee->id;
                $seminaire->titre = $demandeLiee->titre;
                $seminaire->presentateur_id = $demandeLiee->presentateur_id;
            }
        }
        $presentateurs = User::whereIn('role', ['presentateur', 'etudiant']) // Ou un filtre plus spécifique
                             ->orderBy('name')
                             ->get();

        return view('secretaire.seminaires.create', compact('seminaire', 'demandeLiee', 'presentateurs'));
    }

    /**
     * Enregistre un nouveau séminaire dans la base de données.
     */
    public function store(Request $request)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'presentateur_id' => 'required|exists:utilisateurs,id', // Table 'utilisateurs'
            'demande_presentation_id' => 'nullable|exists:demande_presentations,id|unique:seminaires,demande_presentation_id',
            'resume' => 'nullable|string', // Le résumé peut être ajouté ici ou plus tard par le présentateur/secrétaire
            'date_presentation' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'lieu' => 'nullable|string|max:255',
            // 'statut' est 'programmé' par défaut via la migration
        ]);

        $seminaire = Seminaire::create($validatedData);

        return redirect()->route('secretaire.seminaires.index')
                         ->with('success', 'Séminaire "'.$seminaire->titre.'" programmé avec succès.');
    }

    /**
     * Affiche les détails d'un séminaire spécifique.
     */
    public function show(Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        $seminaire->load(['presentateur', 'demandePresentation', 'fichierPresentation']);
        return view('secretaire.seminaires.show', compact('seminaire'));
    }

    /**
     * Affiche le formulaire pour modifier un séminaire existant.
     */
    public function edit(Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        $presentateurs = User::whereIn('role', ['presentateur', 'etudiant'])->orderBy('name')->get();
        $demandeLiee = $seminaire->demandePresentation; // La demande actuellement liée, si elle existe

        // Pour le select de la demande, on pourrait lister les demandes acceptées non encore liées OU la demande actuelle
        $demandesPossibles = DemandePresentation::where('statut', 'accepte')
            ->where(function ($query) use ($seminaire) {
                $query->whereDoesntHave('seminaire') // Celles qui n'ont pas encore de séminaire
                      ->orWhere('id', $seminaire->demande_presentation_id); // Ou la demande actuelle de ce séminaire
            })->get();


        return view('secretaire.seminaires.edit', compact('seminaire', 'presentateurs', 'demandeLiee', 'demandesPossibles'));
    }

    /**
     * Met à jour un séminaire existant dans la base de données.
     */
    public function update(Request $request, Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        $validatedData = $request->validate([
            'titre' => 'required|string|max:255',
            'presentateur_id' => 'required|exists:utilisateurs,id',
            'demande_presentation_id' => 'nullable|exists:demande_presentations,id|unique:seminaires,demande_presentation_id,' . $seminaire->id,
            'resume' => 'nullable|string',
            'date_presentation' => 'required|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut',
            'lieu' => 'nullable|string|max:255',
            'statut' => 'required|in:programmé,passé,annulé',
        ]);

        $seminaire->update($validatedData);

        return redirect()->route('secretaire.seminaires.show', $seminaire)
                         ->with('success', 'Séminaire "'.$seminaire->titre.'" mis à jour.');
    }

    /**
     * Supprime (ou annule) un séminaire.
     */
    public function destroy(Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        // Avant de supprimer, gérer le fichier de présentation si la logique est 'cascade' sur la table fichiers
        if ($seminaire->fichierPresentation) {
            // Si onDelete n'est pas cascade sur la table FichierPresentation pour seminaire_id
            // Storage::disk('public')->delete($seminaire->fichierPresentation->chemin_stockage);
            // $seminaire->fichierPresentation->delete();
            // Mais si c'est cascade, la suppression du séminaire gérera la suppression du fichier en BDD
            // et il faudrait un observer pour supprimer le fichier physique.
            // Pour simplifier, on s'attend à ce que onDelete('cascade') sur FichierPresentation.seminaire_id existe
            // et on supprime juste le séminaire. Il faudra un Observer pour le fichier physique.
        }

        $titre = $seminaire->titre; // Garder le titre pour le message
        $seminaire->delete();

        // Alternative: Annuler au lieu de supprimer
        // $seminaire->statut = 'annulé';
        // $seminaire->save();
        // return redirect()->route('secretaire.seminaires.index')->with('success', 'Séminaire "'.$titre.'" annulé.');


        return redirect()->route('secretaire.seminaires.index')
                         ->with('success', 'Séminaire "'.$titre.'" supprimé.');
    }

    /**
     * Action spécifique pour "publier" (notifier) un séminaire.
     * Cette méthode n'est pas standard RESTful, donc elle a sa propre route.
     */
    public function publier(Seminaire $seminaire)
    {
        if (Gate::denies('isSecretaire')) {
            abort(403);
        }
        if ($seminaire->statut !== 'programmé' || empty($seminaire->resume)) {
            return back()->with('error', 'Le séminaire ne peut être publié (vérifiez statut et résumé).');
        }
        // TODO: Mettre à jour un statut 'est_publie' sur le séminaire si besoin
        // $seminaire->update(['est_publie' => true]); // Si tu as un tel champ

        // --- ENVOI DE L'EMAIL ---
        $utilisateursANotifier = User::where('recoit_notifications_seminaires', true)
                                     // Optionnel: exclure le présentateur lui-même s'il est abonné
                                     // ->where('id', '!=', $seminaire->presentateur_id)
                                     ->get();

        foreach ($utilisateursANotifier as $utilisateur) {
            Mail::to($utilisateur->email)
                ->queue(new SeminairePublieMail($seminaire, $utilisateur));
        }
        // --- FIN ENVOI EMAIL ---

        return back()->with('success', 'Séminaire publié et notifications envoyées.');
    }
}