<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandePresentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'presentateur_id',
        'titre',
        'description_courte',
        'document_joint',
        'statut',
    ];

    // Une demande appartient à un utilisateur (le présentateur)
    public function presentateur()
    {
        return $this->belongsTo(User::class, 'presentateur_id');
    }

    // Une demande acceptée peut donner lieu à un séminaire
    public function seminaire()
    {
        return $this->hasOne(Seminaire::class);
    }
}