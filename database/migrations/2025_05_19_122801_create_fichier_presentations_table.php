<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fichier_presentations', function (Blueprint $table) {
            $table->id();

            // Lien vers le séminaire auquel ce fichier appartient
            // Un fichier appartient à un seul séminaire.
            // Un séminaire peut avoir un seul fichier de présentation (pour l'instant).
            // Si tu veux qu'un séminaire puisse avoir plusieurs fichiers, enlève ->unique() ici.
            // Mais pour "LE fichier de la présentation", unique() est logique.
            $table->foreignId('seminaire_id')
                  ->unique() // Assure qu'un séminaire n'a qu'un seul 'FichierPresentation' principal
                  ->constrained('seminaires')
                  ->onDelete('cascade'); // Si le séminaire est supprimé, son fichier l'est aussi

            $table->string('nom_original_fichier'); // Le nom du fichier tel que téléversé par l'utilisateur
            $table->string('chemin_stockage');    // Le chemin où le fichier est stocké sur le serveur (ex: 'presentations/nom_unique_genere.pdf')
            $table->string('type_mime')->nullable();       // Le type MIME du fichier (ex: 'application/pdf')
            $table->unsignedBigInteger('taille_octets')->nullable(); // La taille du fichier en octets

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fichier_presentations');
    }
};
