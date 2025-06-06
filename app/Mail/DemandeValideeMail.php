<?php

namespace App\Mail;

use App\Models\DemandePresentation;
use App\Models\Seminaire; // Si on crée un séminaire directement et qu'on veut passer ses infos
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class DemandeValideeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public DemandePresentation $demande;
    public ?Seminaire $seminaire; // Le séminaire créé suite à la validation (peut être null si la date n'est pas encore fixée)

    /**
     * Create a new message instance.
     */
    public function __construct(DemandePresentation $demande, ?Seminaire $seminaire = null)
    {
        $this->demande = $demande;
        $this->seminaire = $seminaire;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre Demande de Présentation a été Validée : ' . $this->demande->titre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.demandes.validee',
            with: [
                'titreDemande' => $this->demande->titre,
                'presentateurNom' => $this->demande->presentateur->name,
                'datePresentation' => $this->seminaire?->date_presentation?->format('d/m/Y'), // Optionnel, si date fixée
                'heureDebutPresentation' => $this->seminaire?->heure_debut ? \Carbon\Carbon::parse($this->seminaire->heure_debut)->format('H:i') : null,
                'urlVoirDetails' => route('presentateur.demandes.show', $this->demande->id), // Lien vers sa demande
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