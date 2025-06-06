<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichierPresentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'seminaire_id',
        'nom_original_fichier',
        'chemin_stockage',
        'type_mime',
        'taille_octets',
    ];

    // Un fichier de présentation appartient à un séminaire
    public function seminaire()
    {
        return $this->belongsTo(Seminaire::class);
    }
}