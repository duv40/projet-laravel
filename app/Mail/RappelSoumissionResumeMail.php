<?php

namespace App\Mail;

use App\Models\Seminaire;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class RappelSoumissionResumeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Seminaire $seminaire;
    public Carbon $dateLimite;

    /**
     * Create a new message instance.
     */
    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
        // Calcule la date limite (ex: 10 jours avant la présentation)
        $this->dateLimite = Carbon::parse($seminaire->date_presentation . ' ' . $seminaire->heure_debut)->subDays(10);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel : Soumission du Résumé pour votre Séminaire "' . $this->seminaire->titre . '"',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.presentateurs.rappel_resume',
            with: [
                'presentateurNom' => $this->seminaire->presentateur->name,
                'titreSeminaire' => $this->seminaire->titre,
                'datePresentation' => $this->seminaire->date_presentation->format('d/m/Y'),
                'dateLimiteSoumission' => $this->dateLimite->format('d/m/Y'),
                'urlSoumettreResume' => route('presentateur.seminaires.resume.form', $this->seminaire->id),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}