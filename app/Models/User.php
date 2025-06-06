<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail // Enlever MustVerifyEmail si non utilisé
{
    use HasFactory, Notifiable;

    protected $table = 'utilisateurs'; // Important car le nom de la table n'est pas 'users'

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'recoit_notifications_seminaires',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Pour Laravel 10+
        'recoit_notifications_seminaires' => 'boolean',
    ];

    // Un utilisateur (présentateur) peut avoir soumis plusieurs demandes de présentation
    public function demandesPresentationsSoumises()
    {
        return $this->hasMany(DemandePresentation::class, 'presentateur_id');
    }

    // Un utilisateur (présentateur) peut être assigné à plusieurs séminaires
    public function seminairesPresentes()
    {
        return $this->hasMany(Seminaire::class, 'presentateur_id');
    }

    // Méthodes d'aide pour les rôles (optionnel mais pratique)
    public function isEtudiant(): bool { return $this->role === 'etudiant'; }
    public function isPresentateur(): bool { return $this->role === 'presentateur'; }
    public function isSecretaire(): bool { return $this->role === 'secretaire'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
}