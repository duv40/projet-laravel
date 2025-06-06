@component('mail::message')
# <span style="color:#6366f1;">📅 Rappel : Séminaire Demain !</span>

Bonjour <span style="color:#f59e42;">{{ $nomDestinataire }}</span>,

N'oubliez pas, le séminaire suivant a lieu demain :

---

**<span style="color:#4338ca;">Titre :</span>** {{ $titreSeminaire }}  
**<span style="color:#4338ca;">Présenté par :</span>** {{ $presentateurNom }}  
**<span style="color:#4338ca;">Date :</span>** Demain, {{ $datePresentation }} à {{ $heureDebut }}  
**<span style="color:#4338ca;">Lieu :</span>** {{ $lieu }}

---

Nous avons hâte de vous y accueillir !

@component('mail::button', ['url' => $urlDetailsSeminaire, 'color' => 'primary'])
Revoir les Détails du Séminaire
@endcomponent

Cordialement,  
L'équipe {{ config('app.name') }}
@endcomponent