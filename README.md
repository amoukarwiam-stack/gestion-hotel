🏨 Hotel LaWiam – Système de Réservation

Application web de gestion de réservations hôtelières permettant aux clients de réserver des chambres et aux administrateurs de gérer l’hôtel.

🛠️ Technologies utilisées
PHP 8 / Laravel 10
MySQL
Sanctum (API Authentication)
DomPDF (génération PDF)
XML Import / Export
Mail (Laravel Mailables)
HTML5, CSS3
JavaScript
⚙️ Installation et lancement
git clone https://github.com/amoukarwiam-stack/gestion-hotel.git

cd hotel-reservation

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan serve
🔐 Authentification
Login avec Sanctum token
Rôles : Admin / Client
Middleware protection des routes
✨ Fonctionnalités principales
👤 Client
Inscription / Login
Voir chambres disponibles
Faire une réservation
Télécharger facture PDF
Recevoir email de confirmation
🛠️ Admin
Ajouter / modifier / supprimer chambres
Gérer les réservations
Changer l’état (Confirmée / Annulée)
Voir statistiques
Export / Import XML
📊 Fonctionnalités avancées
Trigger MySQL (gestion disponibilité chambre)
Stored procedure (statistiques réservations)
Export XML / Import XML
Génération PDF (DomPDF)
Emails automatiques
👤 Auteur

Wiam Amoukar
Projet de fin d’études – Gestion Hôtel LaWiam