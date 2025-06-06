<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeminairesTable extends Migration
{
    public function up(): void
    {
        Schema::create('seminaires', function (Blueprint $table) {
            $table->id();

            $table->foreignId('demande_presentation_id')
                ->nullable()
                ->constrained('demande_presentations')
                ->onDelete('set null');

            $table->foreignId('presentateur_id')
                ->nullable()
                ->constrained('utilisateurs')
                ->onDelete('set null');

            $table->string('titre');
            $table->text('resume')->nullable();
            $table->enum('statut', ['programmé', 'passé', 'annulé'])->default('programmé');

            // Modification ici pour que date_presentation ne stocke QUE la date
            $table->date('date_presentation')->nullable();
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();

            $table->string('lieu')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seminaires');
    }
}