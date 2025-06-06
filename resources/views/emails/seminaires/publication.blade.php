{{-- Design modernisé, couleurs et structure cohérentes --}}
@component('mail::message')
# 📢 <span style="color:#6366f1;">Nouveau Séminaire Programmé !</span>

Bonjour <span style="color:#f59e42;">{{ $nomDestinataire }}</span>,

Un nouveau séminaire vient d'être programmé et pourrait vous intéresser :

---

**<span style="color:#4338ca;">Titre :</span>** <span style="color:#374151;">{{ $titreSeminaire }}</span>  
**<span style="color:#4338ca;">Présenté par :</span>** <span style="color:#374151;">{{ $presentateurNom }}</span>  
**<span style="color:#4338ca;">Date :</span>** <span style="color:#374151;">{{ $datePresentation }} à {{ $heureDebut }}</span>  
**<span style="color:#4338ca;">Lieu :</span>** <span style="color:#374151;">{{ $lieu }}</span>

---

**Aperçu :**  
@component('mail::panel')
{{ $resumeCourt }}
@endcomponent

Pour plus de détails et pour consulter le résumé complet (si disponible), cliquez ci-dessous :

@component('mail::button', ['url' => $urlDetailsSeminaire, 'color' => 'primary'])
Voir les Détails du Séminaire
@endcomponent

Nous espérons vous y voir nombreux !

Cordialement,  
L'équipe {{ config('app.name') }}

@component('mail::subcopy')
Si vous ne souhaitez plus recevoir ces notifications, vous pouvez gérer vos [préférences ici]({{ route('preferences.notifications.edit') }}).
@endcomponent
@endcomponent