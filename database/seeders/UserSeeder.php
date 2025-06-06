<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Assure-toi que le chemin est correct
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer les utilisateurs existants pour éviter les doublons lors du re-seeding (optionnel)
        // User::truncate(); // Attention, supprime toutes les données de la table

        // Créer un utilisateur Admin spécifique
        User::factory()->admin()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@seminaire.test',
            'password' => Hash::make('password'), // Ou un mot de passe plus sécurisé
        ]);

        // Créer un utilisateur Secrétaire spécifique
        User::factory()->secretaire()->create([
            'name' => 'Secrétaire Un',
            'email' => 'secretaire@seminaire.test',
            'password' => Hash::make('password'),
        ]);

        // Créer un utilisateur Présentateur spécifique
        User::factory()->presentateur()->create([
            'name' => 'Dr. Présentateur Alpha',
            'email' => 'presentateur.alpha@seminaire.test',
            'password' => Hash::make('password'),
        ]);

         // Créer un autre utilisateur Présentateur spécifique
        User::factory()->presentateur()->create([
            'name' => 'Prof. Présentateur Beta',
            'email' => 'presentateur.beta@seminaire.test',
            'password' => Hash::make('password'),
        ]);

        // Créer quelques Étudiants
        User::factory()->etudiant()->count(5)->create(); // Crée 5 étudiants avec des données aléatoires

        // Créer un étudiant spécifique pour des tests plus ciblés
        User::factory()->etudiant()->create([
            'name' => 'Étudiant Testeur',
            'email' => 'etudiant.test@seminaire.test',
            'password' => Hash::make('password'),
        ]);

        // Tu peux aussi créer des utilisateurs qui sont 'etudiant' mais qui pourraient agir comme 'presentateur'
        // en utilisant l'état par défaut ou en ajustant la logique de recoit_notifications_seminaires manuellement
        User::factory()->create([
            'name' => 'Étudiant Présentateur Potentiel',
            'email' => 'etudiant.presente@seminaire.test',
            'password' => Hash::make('password'),
            'role' => 'etudiant', // La factory mettra recoit_notifications_seminaires à true grâce au afterCreating
        ]);

        $this->command->info('Table des utilisateurs peuplée !');
    }
}