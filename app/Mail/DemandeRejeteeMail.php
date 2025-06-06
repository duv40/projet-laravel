<?php

namespace App\Mail;

use App\Models\DemandePresentation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class DemandeRejeteeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public DemandePresentation $demande;
    public ?string $motifRejet; // Optionnel : pour indiquer la raison du rejet

    /**
     * Create a new message instance.
     */
    public function __construct(DemandePresentation $demande, ?string $motifRejet = null)
    {
        $this->demande = $demande;
        $this->motifRejet = $motifRejet;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Concernant votre Demande de Présentation : ' . $this->demande->titre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.demandes.rejetee',
            with: [
                'titreDemande' => $this->demande->titre,
                'presentateurNom' => $this->demande->presentateur->name,
                'motifRejet' => $this->motifRejet,
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