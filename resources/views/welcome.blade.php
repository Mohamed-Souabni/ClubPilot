<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ClubPilot - Universite Cadi Ayyad</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="welcome-body">
    <main class="welcome-page">
        <section class="welcome-hero">
            <img class="hero-university-logo" src="{{ asset('images/uca-logo.png') }}" alt="Universite Cadi Ayyad">

            <div class="hero-left">
                <p class="hero-kicker">Plateforme universitaire de gestion des clubs</p>

                <h1 class="hero-main-title">ClubPilot</h1>

                <p class="hero-description">
                    Une solution moderne pour organiser les clubs etudiants :
                    membres, evenements, taches, budget, presences,
                    notifications et tableaux de bord.
                </p>

                <div class="hero-actions">
                    @auth
                        <a class="hero-primary" href="{{ route('dashboard') }}">Accéder à  Mon espace</a>
                    @else
                        <a class="hero-primary" href="{{ route('register') }}">Créer un compte</a>
                        <a class="hero-secondary" href="{{ route('login') }}">Se connecter</a>
                    @endauth
                </div>
            </div>

            <div class="hero-activity-strip">
                <div class="activity-card">
                    <img src="{{ asset('images/club-activity-1.jpg') }}" alt="Activite sportive">
                    <span>Sports</span>
                </div>

                <div class="activity-card">
                    <img src="{{ asset('images/club-activity-2.jpg') }}" alt="Evenement club">
                    <span>Evenements</span>
                </div>

                <div class="activity-card">
                    <img src="{{ asset('images/club-activity-3.jpg') }}" alt="Competition etudiante">
                    <span>Competitions</span>
                </div>
            </div>
        </section>

        <section class="welcome-modules">
            <h2>Une plateforme pensee pour les clubs etudiants</h2>

            <div class="welcome-module-grid">
                <div class="welcome-module-card">
                    <span>01</span>
                    <h3>Clubs et membres</h3>
                    <p>Creation des clubs, roles, statuts et demandes d'adhesion.</p>
                </div>

                <div class="welcome-module-card">
                    <span>02</span>
                    <h3>Evenements</h3>
                    <p>Planification des evenements et validation des presences par QR code.</p>
                </div>

                <div class="welcome-module-card">
                    <span>03</span>
                    <h3>Taches</h3>
                    <p>Assignation, suivi, priorites et commentaires entre membres.</p>
                </div>

                <div class="welcome-module-card">
                    <span>04</span>
                    <h3>Budget</h3>
                    <p>Suivi des revenus, depenses, categories et solde restant.</p>
                </div>

                <div class="welcome-module-card">
                    <span>05</span>
                    <h3>Notifications</h3>
                    <p>Alertes internes pour informer rapidement les membres actifs.</p>
                </div>

                <div class="welcome-module-card">
                    <span>06</span>
                    <h3>Dashboard</h3>
                    <p>Statistiques, alertes, evenements proches et taches en retard.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
