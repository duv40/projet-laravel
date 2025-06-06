<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Seminaire;
use App\Models\User; // Si tu as besoin de l'objet User complet
use Illuminate\Support\Facades\Mail;
use App\Mail\RappelSoumissionResumeMail; // Ton Mailable
use Carbon\Carbon;

class RappelSoumissionResumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seminaires:envoyer-rappels-resume'; // Nom pour appeler la commande

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoie des emails de rappel aux présentateurs pour soumettre leur résumé.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Début de l\'envoi des rappels de soumission de résumé...');

        // La date limite pour le résumé est 10 jours AVANT la date de présentation.
        // Nous voulons envoyer un rappel, par exemple, 3 jours AVANT cette date limite.
        // Donc, 10 + 3 = 13 jours avant la date de présentation.
        $dateCiblePourRappel = Carbon::now()->addDays(13)->toDateString();
        // Ou, si tu veux envoyer un rappel X jours AVANT la date LIMITE de soumission :
        // $joursAvantDateLimite = 3;
        // $dateDePresentationPourRappel = Carbon::now()->addDays(10 + $joursAvantDateLimite)->toDateString();

        $seminairesNecessitantRappel = Seminaire::with('presentateur')
            ->where('statut', 'programmé')
            ->whereNull('resume') // Seulement si le résumé n'est pas encore soumis
            ->whereNotNull('date_presentation') // Assure-toi que la date est fixée
            // On cible les séminaires dont la date de présentation est dans 13 jours (pour rappel à J-3 de la deadline de J-10)
            ->whereDate('date_presentation', $dateCiblePourRappel)
            ->get();

        if ($seminairesNecessitantRappel->isEmpty()) {
            $this->info('Aucun séminaire ne nécessite de rappel de soumission de résumé aujourd\'hui.');
            return;
        }

        foreach ($seminairesNecessitantRappel as $seminaire) {
            if ($seminaire->presentateur) { // Vérifie si le présentateur existe
                Mail::to($seminaire->presentateur->email)
                    ->queue(new RappelSoumissionResumeMail($seminaire));
                $this->info("Rappel envoyé à {$seminaire->presentateur->email} pour le séminaire '{$seminaire->titre}'.");
            } else {
                $this->warn("Aucun présentateur assigné pour le séminaire ID {$seminaire->id}, titre '{$seminaire->titre}'.");
            }
        }

        $this->info('Fin de l\'envoi des rappels de soumission de résumé.');
    }
}