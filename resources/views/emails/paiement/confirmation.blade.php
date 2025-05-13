@component('mail::message')
# Paiement confirmé

Bonjour {{ $inscription->eleve->parent->nom }},

Nous confirmons la réception du paiement pour l'inscription de votre enfant **{{ $inscription->eleve->nom }}** le **{{ $inscription->date_inscription->format('d/m/Y') }}**.

**Mode de paiement :** {{ ucfirst($inscription->mode_paiement) }}

@component('mail::button', ['url' => route('parents.facture.pdf', $inscription->id)])
Télécharger la facture
@endcomponent

Merci pour votre confiance.

Cordialement,  
L'équipe Administration SmartSchool
@endcomponent
