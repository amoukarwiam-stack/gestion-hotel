@extends('emails.layouts.app')

@section('title', 'Confirmation Réservation')

@section('header')
Confirmation Réservation
@endsection

@section('content')

<p>Bonjour {{ $reservation->client->user->name }},</p>

<p>Votre réservation a été confirmée avec succès.</p>

<ul>
    <li><strong>Chambre :</strong> {{ $reservation->chambre->numero }}</li>
    <li><strong>Prix :</strong> {{ $reservation->chambre->prix }} DH</li>
    <li><strong>Date début :</strong> {{ $reservation->date_debut }}</li>
    <li><strong>Date fin :</strong> {{ $reservation->date_fin }}</li>
</ul>

<p>Merci pour votre confiance.</p>

@endsection