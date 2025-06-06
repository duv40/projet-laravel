<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tous les Séminaires - {{ config('app.name', 'Laravel') }}</title>
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
            <h1 class="text-2xl font-bold text-indigo-800 mb-8 text-center">Tous les Séminaires</h1>
            @if($seminaires->count() > 0)
                <div class="space-y-6">
                    @foreach($seminaires as $seminaire)
                        <div class="p-6 bg-gradient-to-br from-white via-indigo-50 to-indigo-100 border border-indigo-100 rounded-xl shadow hover:shadow-xl transition-all duration-300 group animate-fade-in">
                            <h3 class="text-xl font-bold text-indigo-700 group-hover:text-indigo-900 transition-colors duration-200 mb-1">
                                <a href="{{ route('seminaires.authentifie.show', $seminaire) }}">
                                    {{ $seminaire->titre }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 mb-1">
                                Le {{ $seminaire->date_presentation ? $seminaire->date_presentation->format('d/m/Y') : 'N/D' }}
                                @if($seminaire->heure_debut)
                                    à {{ \Carbon\Carbon::parse($seminaire->heure_debut)->format('H:i') }}
                                @endif
                                - {{ $seminaire->lieu ?? 'Lieu à définir' }}
                            </p>
                            @if($seminaire->presentateur)
                                <p class="text-sm text-gray-600 mb-2">Par : <span class="font-semibold">{{ $seminaire->presentateur->name }}</span></p>
                            @endif
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('seminaires.authentifie.show', $seminaire) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-md shadow hover:bg-indigo-700 transition-all duration-200">
                                    Voir le détail
                                </a>
                                @if($seminaire->statut === 'passé' && $seminaire->fichierPresentation)
                                    <a href="{{ route('seminaires.fichier.download', $seminaire) }}"
                                       class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-semibold rounded-md shadow hover:bg-green-700 transition-all duration-200">
                                        <svg class="w-4 h-4 mr-1 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                                        </svg>
                                        Télécharger la présentation
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $seminaires->links() }}
                </div>
            @else
                <p class="text-gray-500 text-center py-12">Aucun séminaire à afficher pour le moment.</p>
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