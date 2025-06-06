@component('mail::message')
# <span style="color:#ef4444;">❌ Demande de Présentation Rejetée</span>

Bonjour <span style="color:#f59e42;">{{ $presentateurNom }}</span>,

Nous vous contactons concernant votre demande de présentation intitulée :

**<span style="color:#4338ca;">"{{ $titreDemande }}"</span>**

---

Après examen, nous sommes au regret de vous informer que votre proposition n'a pas été retenue pour le moment.

@if($motifRejet)
**Motif du refus :**  
@component('mail::panel')
{{ $motifRejet }}
@endcomponent
@endif

---

Nous vous encourageons à soumettre d'autres propositions à l'avenir.

Cordialement,  
L'équipe {{ config('app.name') }}
@endcomponent