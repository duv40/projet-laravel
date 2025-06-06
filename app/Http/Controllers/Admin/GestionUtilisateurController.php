<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Assure-toi que c'est bien le chemin vers ton modèle User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth; // Pour vérifier qu'on ne se supprime pas soi-même
use Illuminate\Support\Facades\Gate;

class GestionUtilisateurController extends Controller
{
    /**
     * Affiche la liste de tous les utilisateurs.
     */
    public function index()
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        $utilisateurs = User::orderBy('name')->paginate(15);
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel utilisateur.
     */
    public function create()
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        $roles = ['etudiant', 'presentateur', 'secretaire', 'admin']; // Pour un select dans le formulaire
        return view('admin.utilisateurs.create', compact('roles'));
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     */
    public function store(Request $request)
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs'], // 'utilisateurs' est le nom de ta table
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:etudiant,presentateur,secretaire,admin'],
            'recoit_notifications_seminaires' => ['sometimes', 'boolean'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'recoit_notifications_seminaires' => $request->boolean('recoit_notifications_seminaires'),
        ]);

        return redirect()->route('admin.utilisateurs.index')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Affiche les détails d'un utilisateur spécifique.
     */
    public function show(User $utilisateur) // Route Model Binding sur le paramètre 'utilisateur'
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        return view('admin.utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Affiche le formulaire pour modifier un utilisateur existant.
     */
    public function edit(User $utilisateur)
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        $roles = ['etudiant', 'presentateur', 'secretaire', 'admin'];
        return view('admin.utilisateurs.edit', compact('utilisateur', 'roles'));
    }

    /**
     * Met à jour un utilisateur existant dans la base de données.
     */
    public function update(Request $request, User $utilisateur)
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email,'.$utilisateur->id], // Ignore l'email actuel de l'utilisateur
            'role' => ['required', 'in:etudiant,presentateur,secretaire,admin'],
            'recoit_notifications_seminaires' => ['sometimes', 'boolean'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Mot de passe optionnel à la modification
        ]);

        $utilisateur->name = $request->name;
        $utilisateur->email = $request->email;
        $utilisateur->role = $request->role;
        $utilisateur->recoit_notifications_seminaires = $request->boolean('recoit_notifications_seminaires');

        if ($request->filled('password')) {
            $utilisateur->password = Hash::make($request->password);
        }
        $utilisateur->save();

        return redirect()->route('admin.utilisateurs.index')
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprime un utilisateur de la base de données.
     */
    public function destroy(User $utilisateur)
    {
        if (Gate::denies('isAdmin')) {
            abort(403);
        }

        if (Auth::id() === $utilisateur->id) {
            return redirect()->route('admin.utilisateurs.index')
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte administrateur.');
        }

        $nomUtilisateur = $utilisateur->name;
        $utilisateur->delete();

        return redirect()->route('admin.utilisateurs.index')
                         ->with('success', "L'utilisateur \"{$nomUtilisateur}\" a été supprimé.");
    }
}