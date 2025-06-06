<?php

namespace Database\Seeders;

// use App\Models\User; // Plus besoin ici si UserSeeder s'en charge complètement
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // L'ancien code créait 10 utilisateurs aléatoires et un utilisateur spécifique "Test User".
        // Nous allons remplacer cela par un appel à notre UserSeeder, qui est plus structuré
        // et crée des utilisateurs avec des rôles spécifiques.

        // User::factory(10)->create(); // Ancienne ligne, à commenter ou supprimer

        // User::factory()->create([       // Ancienne ligne, à commenter ou supprimer
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // --- NOTRE NOUVELLE APPROCHE ---
        // Appelle le UserSeeder que nous avons créé.
        // UserSeeder se chargera de créer tous les types d'utilisateurs nécessaires.
        $this->call([
            UserSeeder::class,
            // Si tu crées d'autres seeders (pour DemandePresentation, Seminaire, etc.),
            // tu les ajouteras ici aussi :
            // DemandePresentationSeeder::class,
            // SeminaireSeeder::class,
        ]);

        $this->command->info('Toutes les tables principales ont été peuplées via leurs seeders respectifs !');
    }
}