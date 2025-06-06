<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
// Si tu utilises les noms de classe directement dans $schedule->command() :
// use App\Console\Commands\RappelSoumissionResumeCommand;
// use App\Console\Commands\RappelVeilleSeminaireCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Les commandes sont généralement auto-découvertes.
        // Tu peux les lister explicitement ici si tu le souhaites.
        // \App\Console\Commands\RappelSoumissionResumeCommand::class,
        // \App\Console\Commands\RappelVeilleSeminaireCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Rappel pour la soumission des résumés
        // Exécute tous les jours à 07:00 (par exemple)
        $schedule->command('seminaires:envoyer-rappels-resume')
                 ->dailyAt('07:00');

        // Rappel la veille du séminaire
        // Exécute tous les jours à 09:00 (par exemple)
        $schedule->command('seminaires:envoyer-rappels-veille')
                 ->dailyAt('09:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}