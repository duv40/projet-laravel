<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Utile pour manipuler dates/heures

class Seminaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'demande_presentation_id',
        'presentateur_id',
        'titre',
        'resume',
        'statut',
        'date_presentation',
        'heure_debut',
        'heure_fin',
        'lieu',
    ];

    protected $casts = [
        'date_presentation' => 'date:Y-m-d', // Caste en objet Carbon et formate en Y-m-d
        // 'heure_debut' => 'datetime:H:i', // Ou laisser comme string si tu gères manuellement
        // 'heure_fin' => 'datetime:H:i',
    ];

    // Un séminaire peut provenir d'une demande
    public function demandePresentation()
    {
        return $this->belongsTo(DemandePresentation::class);
    }

    // Un séminaire est animé par un présentateur (User)
    public function presentateur()
    {
        return $this->belongsTo(User::class, 'presentateur_id');
    }

    // Un séminaire a un fichier de présentation
    public function fichierPresentation()
    {
        return $this->hasOne(FichierPresentation::class);
    }

    // Accesseur pour combiner date et heure de début (exemple)
    public function getDebutDateTimeAttribute(): ?Carbon
    {
        if ($this->date_presentation && $this->heure_debut) {
            return Carbon::parse($this->date_presentation->toDateString() . ' ' . $this->heure_debut);
        }
        return null;
    }

    // Accesseur pour combiner date et heure de fin (exemple)
    public function getFinDateTimeAttribute(): ?Carbon
    {
        if ($this->date_presentation && $this->heure_fin) {
            return Carbon::parse($this->date_presentation->toDateString() . ' ' . $this->heure_fin);
        }
        return null;
    }
}