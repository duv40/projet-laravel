<?php

namespace App\Mail;

use App\Models\DemandePresentation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class NouvelleDemandeSoumiseMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public DemandePresentation $demande;

    /**
     * Create a new message instance.
     */
    public function __construct(DemandePresentation $demande)
    {
        $this->demande = $demande;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nouvelle Demande de Présentation Soumise : ' . $this->demande->titre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.demandes.nouvelle_soumise',
            with: [
                'titreDemande' => $this->demande->titre,
                'presentateurNom' => $this->demande->presentateur->name,
                'descriptionCourte' => $this->demande->description_courte,
                'urlDetailsDemande' => route('secretaire.demandes.show', $this->demande->id), // Assure-toi que cette route existe
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return []; // Si la demande a un document_joint, tu pourrais l'attacher ici
    }
}