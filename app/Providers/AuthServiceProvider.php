<?php

namespace App\Providers;

use App\Models\User;
use App\Models\DemandePresentation; // Si utilisé dans un Gate ici
// use App\Models\Seminaire; // Si utilisé dans un Gate ici
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// Importe tes Policies ici quand tu les crées
// use App\Policies\DemandePresentationPolicy;
// use App\Policies\SeminairePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // DemandePresentation::class => DemandePresentationPolicy::class,
        // Seminaire::class => SeminairePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isEtudiant', function (User $user) {
            return $user->role === 'etudiant';
        });

        Gate::define('isPresentateur', function (User $user) {
            return $user->role === 'presentateur';
        });

        Gate::define('isAtLeastPresentateur', function (User $user) {
            return in_array($user->role, ['presentateur', 'etudiant']);
        });

        Gate::define('isSecretaire', function (User $user) {
            return $user->role === 'secretaire';
        });

        Gate::define('isAdmin', function (User $user) {
            return $user->role === 'admin';
        });

        // Exemple de Gate pour une action spécifique (idéalement dans une Policy)
        Gate::define('manage-demande-status', function(User $user) {
            return $user->isSecretaire();
        });

        // Exemple de Gate avec modèle (idéalement dans une Policy)
        Gate::define('update-own-demande', function (User $user, DemandePresentation $demande) {
            return $user->id === $demande->presentateur_id && $demande->statut === 'en_attente';
        });
    }
}