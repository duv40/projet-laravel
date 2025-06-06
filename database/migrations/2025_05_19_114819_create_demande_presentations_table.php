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
        Schema::create('demande_presentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presentateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->string('titre');
            $table->text('description_courte')->nullable(); // PAS DE UNIQUE sur du TEXT !
            $table->string('document_joint')->nullable(); // chemin vers fichier PDF par exemple
            $table->enum('statut', ['en_attente', 'accepte', 'rejete'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_presentations');
    }
};
