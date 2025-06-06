@component('mail::message')
# <span style="color:#22c55e;">✅ Demande Acceptée !</span>

Bonjour <span style="color:#f59e42;">{{ $presentateurNom }}</span>,

Bonne nouvelle ! Votre demande de présentation intitulée :

**<span style="color:#4338ca;">"{{ $titreDemande }}"</span>**

a été acceptée.

---

@if($datePresentation)
**Date de présentation prévue :** <span style="color:#6366f1;">{{ $datePresentation }}</span>
@if($heureDebutPresentation)
à <span style="color:#6366f1;">{{ $heureDebutPresentation }}</span>
@endif

Plus de détails vous seront communiqués prochainement concernant l'organisation.
@else
Les détails concernant la date et l'heure de votre présentation vous seront communiqués ultérieurement.
@endif

---

N'oubliez pas de préparer et de soumettre votre résumé au moins 10 jours avant la date de présentation.

@component('mail::button', ['url' => $urlVoirDetails, 'color' => 'success'])
Voir ma Demande
@endcomponent

Félicitations !  
L'équipe {{ config('app.name') }}
@endcomponent