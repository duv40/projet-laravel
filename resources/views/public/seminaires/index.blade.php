{{-- Ce layout peut être un layout plus simple "guest" si tu en as un, ou un layout public dédié --}}
{{-- Pour l'instant, on peut utiliser le layout de base de Laravel pour la page d'accueil ou un layout "guest" de Breeze --}}
{{-- S'il n'y a pas de notion de "layout invité" distinct pour cette page, tu peux recréer une structure HTML de base ici. --}}
{{-- Ou adapter la vue welcome.blade.php pour inclure une section pour ces séminaires. --}}

{{-- Supposons un layout très simple pour l'exemple, tu devras l'adapter avec tes CSS/JS Vite --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Séminaires Publics - {{ config('app.name', 'Laravel') }}</title>
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
            max-width: 1100px;
            width: 100%;
            position: relative;
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
            display: inline-block;
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
        @media (max-width: 900px) {
            .hero-main {
                padding-left: 1.5rem !important;
                padding-right: 1.5rem !important;
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
            <h1 class="text-3xl font-extrabold text-indigo-800 mb-6 tracking-tight text-center">Séminaires Programmés</h1>
            @if($seminaires->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($seminaires as $seminaire)
                        <div class="bg-white shadow-xl rounded-2xl p-6 hover:shadow-2xl transition-shadow duration-300 group animate-fade-in border border-indigo-100">
                            <h2 class="text-xl font-bold text-indigo-700 group-hover:text-indigo-900 transition-colors duration-200 mb-2">{{ $seminaire->titre }}</h2>
                            <p class="text-sm text-gray-600 mb-1">
                                <strong>Date :</strong> {{ $seminaire->date_presentation ? $seminaire->date_presentation->format('d/m/Y') : 'N/D' }}
                                @if($seminaire->heure_debut)
                                    à {{ \Carbon\Carbon::parse($seminaire->heure_debut)->format('H:i') }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 mb-1"><strong>Lieu :</strong> {{ $seminaire->lieu ?? 'N/D' }}</p>
                            @if($seminaire->presentateur)
                                <p class="text-sm text-gray-600 mb-3"><strong>Présentateur :</strong> {{ $seminaire->presentateur->name }}</p>
                            @endif
                            <a href="{{ route('seminaires.public.show', $seminaire) }}"
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                                Voir les détails
                                <svg class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 text-center">
                    {{ $seminaires->links() }}
                </div>
            @else
                <p class="text-gray-600 text-center py-12">Aucun séminaire programmé publiquement pour le moment.</p>
            @endif
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