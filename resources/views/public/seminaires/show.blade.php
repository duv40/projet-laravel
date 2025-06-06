{{-- Similaire au layout de public/seminaires/index.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seminaire->titre }} - {{ config('app.name', 'Laravel') }}</title>
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
            max-width: 800px;
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
            <div class="mb-6">
                <a href="{{ route('seminaires.public.index') }}" class="text-indigo-600 hover:text-indigo-800 transition-colors duration-200">← Retour à la liste des séminaires</a>
            </div>
            <h1 class="text-3xl font-bold text-indigo-800 mb-4">{{ $seminaire->titre }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Date</p>
                    <p class="text-lg text-gray-700 font-semibold">{{ $seminaire->date_presentation ? $seminaire->date_presentation->format('l j F Y') : 'Date à définir' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Heure de début</p>
                    <p class="text-lg text-gray-700 font-semibold">{{ $seminaire->heure_debut ? \Carbon\Carbon::parse($seminaire->heure_debut)->format('H:i') : 'N/D' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lieu</p>
                    <p class="text-lg text-gray-700 font-semibold">{{ $seminaire->lieu ?? 'Non spécifié' }}</p>
                </div>
            </div>
            @if($seminaire->presentateur)
                <p class="mb-6 text-md text-indigo-700 font-medium">Présenté par : <span class="font-semibold underline underline-offset-2">{{ $seminaire->presentateur->name }}</span></p>
            @endif
            @if($seminaire->resume)
                <div class="prose max-w-none text-gray-700 mt-6">
                    <h2 class="text-xl font-semibold mb-2 text-indigo-700">Résumé</h2>
                    <div class="p-4 bg-indigo-50 rounded-md shadow-inner animate-fade-in">
                        {!! nl2br(e($seminaire->resume)) !!}
                    </div>
                </div>
            @else
                <p class="text-gray-500 mt-6 italic">Le résumé de ce séminaire sera bientôt disponible.</p>
            @endif
            @if (Auth::check() && $seminaire->statut === 'passé' && $seminaire->fichierPresentation)
                <div class="mt-8">
                     <a href="{{ route('seminaires.fichier.download', $seminaire) }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 animate-fade-in">
                        <svg class="w-5 h-5 mr-2 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                        </svg>
                        Télécharger la présentation
                    </a>
                </div>
            @elseif ($seminaire->statut === 'passé' && $seminaire->fichierPresentation)
                <p class="mt-8 text-sm text-gray-500">Connectez-vous pour télécharger la présentation.</p>
            @endif
            <div class="mt-8 flex justify-end">
                @if (!Auth::check())
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 transition-colors duration-200">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 transition-colors duration-200">S'inscrire</a>
                    @endif
                @endif
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