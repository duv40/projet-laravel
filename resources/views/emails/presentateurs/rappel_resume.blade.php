@component('mail::message')
# <span style="color:#f59e42;">⏰ Rappel : Soumission de votre Résumé</span>

Bonjour <span style="color:#6366f1;">{{ $presentateurNom }}</span>,

Ceci est un rappel amical concernant la soumission du résumé pour votre présentation :

**<span style="color:#4338ca;">Titre du Séminaire :</span>** {{ $titreSeminaire }}  
**<span style="color:#4338ca;">Date de Présentation :</span>** {{ $datePresentation }}

---

La date limite pour la soumission de votre résumé est le :

@component('mail::panel')
**{{ $dateLimiteSoumission }}**
@endcomponent

Merci de le soumettre dès que possible via le bouton ci-dessous :

@component('mail::button', ['url' => $urlSoumettreResume, 'color' => 'primary'])
Soumettre mon Résumé
@endcomponent

Si vous avez déjà soumis votre résumé, veuillez ignorer ce message.

Cordialement,  
L'équipe {{ config('app.name') }}
@endcomponent