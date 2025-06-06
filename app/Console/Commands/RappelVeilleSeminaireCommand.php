<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Models\User; // Pour récupérer les utilisateurs abonnés
use Illuminate\Support\Facades\Mail;
use App\Mail\RappelSeminaireVeilleMail; // Ton Mailable
use Carbon\Carbon;

class RappelVeilleSeminaireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seminaires:envoyer-rappels-veille';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des emails de rappel la veille des séminaires aux utilisateurs abonnés.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Début de l\'envoi des rappels de la veille...');

        // Séminaires qui ont lieu demain
        $dateDeDemain = Carbon::tomorrow()->toDateString();

        $seminairesDeDemain = Seminaire::with('presentateur')
            ->where('statut', 'programmé') // Uniquement ceux toujours programmés
            ->whereNotNull('date_presentation')
            ->whereDate('date_presentation', $dateDeDemain)
            ->get();

        if ($seminairesDeDemain->isEmpty()) {
            $this->info('Aucun séminaire programmé pour demain. Aucun rappel envoyé.');
            return;
        }

        // Récupérer tous les utilisateurs qui veulent recevoir des notifications
        $utilisateursANotifier = User::where('recoit_notifications_seminaires', true)->get();

        if ($utilisateursANotifier->isEmpty()) {
            $this->info('Aucun utilisateur ne souhaite recevoir de notifications.');
            return;
        }

        foreach ($seminairesDeDemain as $seminaire) {
            $this->info("Envoi des rappels pour le séminaire '{$seminaire->titre}' prévu le {$seminaire->date_presentation->format('d/m/Y')}.");
            foreach ($utilisateursANotifier as $utilisateur) {
                // Optionnel : ne pas envoyer au présentateur lui-même s'il a déjà une notif spécifique
                // if ($seminaire->presentateur_id === $utilisateur->id) {
                //     continue;
                // }
                Mail::to($utilisateur->email)
                    ->queue(new RappelSeminaireVeilleMail($seminaire, $utilisateur));
                $this->info("Rappel de la veille envoyé à {$utilisateur->email}.");
            }
        }

        $this->info('Fin de l\'envoi des rappels de la veille.');
    }
}