@component('mail::message')
# <span style="color:#6366f1;">📬 Nouvelle Demande de Présentation</span>

Une nouvelle demande de présentation a été soumise et nécessite votre attention.

---

**<span style="color:#4338ca;">Titre :</span>** <span style="color:#374151;">{{ $titreDemande }}</span>  
**<span style="color:#4338ca;">Proposée par :</span>** <span style="color:#374151;">{{ $presentateurNom }}</span>

@if($descriptionCourte)
**Description :**  
@component('mail::panel')
{{ $descriptionCourte }}
@endcomponent
@endif

---

Vous pouvez consulter tous les détails de cette demande et la traiter en cliquant sur le bouton ci-dessous :

@component('mail::button', ['url' => $urlDetailsDemande, 'color' => 'primary'])
Voir la Demande
@endcomponent

Merci,  
L'équipe {{ config('app.name') }}
@endcomponent