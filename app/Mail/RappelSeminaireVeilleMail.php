<?php

namespace App\Mail;

use App\Models\Seminaire;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class RappelSeminaireVeilleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Seminaire $seminaire;
    public User $destinataire;

    /**
     * Create a new message instance.
     */
    public function __construct(Seminaire $seminaire, User $destinataire)
    {
        $this->seminaire = $seminaire;
        $this->destinataire = $destinataire;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel : Séminaire "' . $this->seminaire->titre . '" demain !',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.seminaires.rappel_veille',
            with: [
                'nomDestinataire' => $this->destinataire->name,
                'titreSeminaire' => $this->seminaire->titre,
                'presentateurNom' => $this->seminaire->presentateur?->name ?? 'N/A',
                'datePresentation' => $this->seminaire->date_presentation->format('d/m/Y'),
                'heureDebut' => \Carbon\Carbon::parse($this->seminaire->heure_debut)->format('H:i'),
                'lieu' => $this->seminaire->lieu ?? 'À définir',
                'urlDetailsSeminaire' => route('seminaires.authentifie.show', $this->seminaire->id),
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