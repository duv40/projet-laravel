<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Accueil</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
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
            max-width: 900px;
            width: 100%;
            position: relative;
        }
        .hero-main .logo-img {
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
        .hero-main h1 {
            font-size: 3.2rem;
            font-weight: 900;
            color: #4338ca;
            letter-spacing: 0.04em;
            margin-bottom: 0.5rem;
        }
        .hero-main h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #f59e42;
            margin-bottom: 1.5rem;
        }
        .hero-main p {
            font-size: 1.15rem;
            color: #374151;
            margin-bottom: 0;
        }
        .welcome-link {
            color: #6366f1;
            font-weight: 600;
            margin-left: 1rem;
            margin-right: 1rem;
            text-decoration: underline;
            transition: color 0.2s;
            font-size: 1.1rem;
        }
        .welcome-link:hover {
            color: #f59e42;
        }
        .public-btn {
            background: linear-gradient(90deg, #6366f1 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            border-radius: 9999px;
            padding: 1.1rem 3.5rem;
            font-size: 1.3rem;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            transition: background 0.2s, transform 0.2s;
            margin-top: 3.5rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .public-btn:hover {
            background: linear-gradient(90deg, #fbbf24 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.04);
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
        @media (max-width: 700px) {
            .hero-main {
                padding: 1.5rem 0.5rem 2rem 0.5rem;
                border-radius: 1.5rem;
            }
            .hero-main h1 {
                font-size: 2.1rem;
            }
            .public-btn {
                font-size: 1rem;
                padding: 0.8rem 1.5rem;
            }
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
                <img src="https://img.icons8.com/color/96/000000/conference.png" alt="Séminaire" style="width:70px;height:70px;">
            </div>
            <h1>{{ config('app.name', 'Laravel') }}</h1>
            <h2>Plateforme moderne de gestion des séminaires</h2>
            <p>
                Découvrez, proposez et suivez tous les séminaires de l'IMSP.<br>
                Connectez-vous ou inscrivez-vous pour participer activement à la vie scientifique !
            </p>
        </div>

        <a href="{{ route('seminaires.public.index') }}" class="public-btn animate-fade-in">
            Voir les séminaires publics
        </a>

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