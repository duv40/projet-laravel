<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserPreferenceController extends Controller
{
    /**
     * Affiche le formulaire pour éditer les préférences de l'utilisateur.
     */
    public function edit()
    {
        // Vérifie que l'utilisateur est un étudiant
        if (Gate::denies('isEtudiant')) {
            abort(403);
        }

        $user = Auth::user();
        // Tu passeras $user à la vue pour pré-remplir le formulaire
        return view('preferences.edit', compact('user'));
    }

    /**
     * Met à jour les préférences de l'utilisateur.
     */
    public function update(Request $request)
    {
        // Vérifie que l'utilisateur est un étudiant
        if (Gate::denies('isEtudiant')) {
            abort(403);
        }

        $user = Auth::user();

        // Validation (optionnelle ici, mais bonne pratique si plus de champs)
        // $request->validate([
        //     'recoit_notifications_seminaires' => 'sometimes|boolean',
        // ]);

        // Le champ 'recoit_notifications_seminaires' est un booléen sur le modèle User
        $user->recoit_notifications_seminaires = $request->has('recoit_notifications_seminaires'); // true si la case est cochée, false sinon
        $user->save();

        return redirect()->route('preferences.notifications.edit')
                         ->with('success', 'Vos préférences de notification ont été mises à jour.');
    }
}