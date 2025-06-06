@component('mail::message')
# <span style="color:#6366f1;">📝 Soumission de Résumé pour un Séminaire</span>

Le résumé pour le séminaire suivant a été soumis :

---

**<span style="color:#4338ca;">Titre du Séminaire :</span>** {{ $titreSeminaire }}  
**<span style="color:#4338ca;">Présentateur :</span>** {{ $presentateurNom }}

---

**Résumé soumis :**
@component('mail::panel')
{{ $resume }}
@endcomponent

Vous pouvez consulter les détails du séminaire ici :

@component('mail::button', ['url' => $urlDetailsSeminaire, 'color' => 'primary'])
Voir les Détails du Séminaire
@endcomponent

Cordialement,  
L'équipe {{ config('app.name') }}
@endcomponent