<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Assure-toi que le chemin est correct

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // Mot de passe par défaut 'password'
            'remember_token' => Str::random(10),
            'role' => 'etudiant', // Rôle par défaut
            'recoit_notifications_seminaires' => false, // Préférence de notification par défaut
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the model factory.
     * Ajoute des états pour chaque rôle pour faciliter la création.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // Logique spécifique après la création si besoin
            // Par exemple, si les étudiants doivent toujours recevoir des notifications :
            if ($user->role === 'etudiant') {
                $user->recoit_notifications_seminaires = true;
                $user->save();
            }
        });
    }

    // --- Ajout d'états pour chaque rôle ---
    public function etudiant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'etudiant',
            'recoit_notifications_seminaires' => true, // Les étudiants reçoivent par défaut
        ]);
    }

    public function presentateur(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'presentateur',
            'recoit_notifications_seminaires' => fake()->boolean(70), // 70% de chance de recevoir
        ]);
    }

    public function secretaire(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'secretaire',
            'recoit_notifications_seminaires' => true, // Les secrétaires reçoivent souvent tout
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'recoit_notifications_seminaires' => true, // Les admins aussi
        ]);
    }
}