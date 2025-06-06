<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de Bord Administrateur - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(120deg, #e0e7ff 0%, #fdf6e3 100%);
        }
        .hero-main {
            margin-top: 5rem;
            margin-bottom: 5rem;
            padding: 3rem 2rem 2rem 2rem;
            background: #fff;
            border-radius: 2.5rem;
            box-shadow: 0 8px 32px 0 rgba(59, 130, 246, 0.13);
            max-width: 1000px;
            width: 100%;
            position: relative;
        }
        .logo-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fbbf24 0%, #818cf8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 4px 24px 0 rgba(251, 191, 36, 0.13);
        }
        .logo-img img {
            width: 70px;
            height: 70px;
        }
        .hero-title {
            font-size: 2.3rem;
            font-weight: 900;
            color: #4338ca;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
            text-align: center;
        }
        .hero-subtitle {
            font-size: 1.3rem;
            font-weight: 600;
            color: #f59e42;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .hero-desc {
            font-size: 1.1rem;
            color: #374151;
            margin-bottom: 2.5rem;
            text-align: center;
        }
        .stat-bloc {
            background: linear-gradient(90deg, #f3f4f6 0%, #e0e7ff 100%);
            border-radius: 1.5rem;
            box-shadow: 0 2px 12px 0 rgba(99, 102, 241, 0.07);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 0;
        }
        .stat-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 8px 0 rgba(99, 102, 241, 0.09);
            margin-bottom: 1rem;
        }
        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #4338ca;
            margin-bottom: 0.2rem;
        }
        .stat-label {
            font-size: 1rem;
            color: #6366f1;
            font-weight: 600;
        }
        .admin-btn {
            background: linear-gradient(90deg, #6366f1 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            border-radius: 9999px;
            padding: 0.9rem 2.2rem;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            transition: background 0.2s, transform 0.2s;
            margin-bottom: 1.2rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: inline-block;
            text-align: center;
        }
        .admin-btn:hover {
            background: linear-gradient(90deg, #fbbf24 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.04);
        }
        .quick-links {
            margin-top: 2.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }
        @media (max-width: 900px) {
            .hero-main {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
            }
            .quick-links {
                flex-direction: column;
                gap: 0.7rem;
            }
        }
        .footer-bloc {
            margin-top: 5rem;
            text-align: center;
            color: #6366f1;
            font-size: 1rem;
        }
        .footer-bloc span {
            background: #f3f4f6;
            border-radius: 9999px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex flex-col">
    <div class="w-full flex flex-col items-center min-h-screen">
        <div class="w-full flex justify-end pt-8 pr-12">
            @if (Route::has('login'))
                @auth
                    @php
                        $user = Auth::user();
                        if ($user->role === 'admin') {
                            $dashboardRoute = route('admin.dashboard');
                        } elseif ($user->role === 'secretaire') {
                            $dashboardRoute = route('secretaire.dashboard');
                        } elseif ($user->role === 'presentateur') {
                            $dashboardRoute = route('presentateur.dashboard');
                        } elseif ($user->role === 'etudiant') {
                            $dashboardRoute = route('etudiant.dashboard');
                        } else {
                            $dashboardRoute = route('dashboard');
                        }
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="welcome-link">Tableau de bord</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline ml-2">
                        @csrf
                        <button type="submit" class="welcome-link" style="background:none;border:none;padding:0;cursor:pointer;">
                            Se déconnecter
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="welcome-link">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="welcome-link">S'inscrire</a>
                    @endif
                @endauth
            @endif
        </div>
        <div class="hero-main animate-fade-in">
            <div class="logo-img">
                <img src="https://img.icons8.com/color/96/000000/conference.png" alt="Admin">
            </div>
            <div class="hero-title">Tableau de Bord Administrateur</div>
            <div class="hero-subtitle">Bienvenue, {{ Auth::user()->name }} !</div>
            <div class="hero-desc">
                Espace d'administration de la plateforme de gestion des séminaires.<br>
                Retrouvez ici toutes les statistiques et accès rapides pour gérer la plateforme.
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="stat-bloc">
                    <div class="stat-icon">
                        <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4V7a4 4 0 10-8 0v3m12 4v2a4 4 0 01-3 3.87M9 16v2a4 4 0 01-3 3.87" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ $nombreTotalUtilisateurs ?? 0 }}</div>
                    <div class="stat-label">Utilisateurs inscrits</div>
                </div>
                <div class="stat-bloc">
                    <div class="stat-icon">
                        <svg class="w-10 h-10 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ $nombreSeminairesProgrammes ?? 0 }}</div>
                    <div class="stat-label">Séminaires programmés</div>
                </div>
                <div class="stat-bloc">
                    <div class="stat-icon">
                        <svg class="w-10 h-10 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 013-3.87m0 0V7a4 4 0 10-8 0v3m12 4v2a4 4 0 01-3 3.87" />
                        </svg>
                    </div>
                    <div class="stat-value">{{ $nombreDemandesEnAttente ?? 0 }}</div>
                    <div class="stat-label">Demandes en attente</div>
                </div>
            </div>
            <div class="quick-links">
                <a href="{{ route('admin.utilisateurs.index') }}" class="admin-btn">Gérer les Utilisateurs</a>
                <a href="{{ route('admin.configuration.edit') }}" class="admin-btn">Configurer le Système</a>
                <!--
                <a href="{{ route('secretaire.demandes.index') }}" class="admin-btn" style="background:linear-gradient(90deg,#818cf8 0%,#fbbf24 100%);">Demandes (Secrétaire)</a>
                <a href="{{ route('secretaire.seminaires.index') }}" class="admin-btn" style="background:linear-gradient(90deg,#fbbf24 0%,#818cf8 100%);">Séminaires (Secrétaire)</a>
                    -->
            </div>
        </div>
        <div class="footer-bloc">
            <span>
                IMSP - Institut de Mathématiques et de Sciences Physiques
            </span>
            <div class="mt-2" style="font-size:0.95em;">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>
</body>
</html>