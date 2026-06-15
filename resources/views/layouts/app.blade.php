<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ClubPilot')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="app-body">
    <nav class="app-nav">
        <div class="app-nav-inner">
            <a class="app-brand" href="{{ route('home') }}">
                <span class="app-brand-mark">CP</span>
                <span>ClubPilot</span>
            </a>

            <div class="app-nav-links">
                @auth
                    @php
                        $unreadNotificationsCount = auth()->user()
                            ->clubNotifications()
                            ->where('is_read', false)
                            ->count();
                    @endphp

                    <a href="{{ route('dashboard') }}">Mon espace</a>
                    <a class="nav-notification-link" href="{{ route('notifications.index') }}">
                        <span>Notifications</span>
                        @if ($unreadNotificationsCount > 0)
                            <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('profile.edit') }}">Profil</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="nav-logout" type="submit">Deconnexion</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Connexion</a>
                    <a class="nav-primary" href="{{ route('register') }}">Inscription</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="app-main">
        @if (session('success'))
            <div class="app-alert app-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="app-alert app-alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="app-alert app-alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="app-panel">
            @yield('content')
        </section>
    </main>
</body>
</html>
