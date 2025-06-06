<?php

namespace App\Mail;

use App\Models\Seminaire;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class ResumeSoumisMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public Seminaire $seminaire;

    /**
     * Create a new message instance.
     */
    public function __construct(Seminaire $seminaire)
    {
        $this->seminaire = $seminaire;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Résumé Soumis pour le Séminaire : ' . $this->seminaire->titre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.seminaires.resume_soumis',
            with: [
                'titreSeminaire' => $this->seminaire->titre,
                'presentateurNom' => $this->seminaire->presentateur->name,
                'resume' => $this->seminaire->resume, // On passe le résumé directement
                'urlDetailsSeminaire' => route('secretaire.seminaires.show', $this->seminaire->id),
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