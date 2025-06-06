<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de Bord Présentateur - {{ config('app.name', 'Laravel') }}</title>
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
        .stat-bloc {
            background: linear-gradient(90deg, #fbbf24 0%, #6366f1 100%);
            color: #fff;
            border-radius: 1.5rem;
            padding: 2rem 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .add-btn {
            background: linear-gradient(90deg, #6366f1 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            border-radius: 9999px;
            padding: 0.7rem 2rem;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            transition: background 0.2s, transform 0.2s;
            margin-bottom: 2rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: inline-block;
        }
        .add-btn:hover {
            background: linear-gradient(90deg, #fbbf24 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.04);
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
            <h1 class="text-2xl font-bold text-indigo-800 mb-8 text-center">Tableau de Bord Présentateur</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="stat-bloc">
                    <div class="text-base font-medium mb-2">Demandes en attente</div>
                    <span class="text-4xl font-extrabold">{{ $demandesEnAttente }}</span>
                </div>
                <div class="stat-bloc">
                    <div class="text-base font-medium mb-2">Demandes acceptées</div>
                    <span class="text-4xl font-extrabold">{{ $demandesAcceptees }}</span>
                </div>
                <div class="stat-bloc">
                    <div class="text-base font-medium mb-2">Séminaires programmés</div>
                    <span class="text-4xl font-extrabold">{{ $prochainsSeminairesAcceptes->count() }}</span>
                </div>
            </div>
            @if($seminairesSansResume->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-bold text-indigo-800 mb-3">Résumés à soumettre</h3>
                <ul class="space-y-2">
                    @foreach($seminairesSansResume as $seminaire)
                    <li class="p-3 border rounded-md flex justify-between items-center bg-indigo-50 hover:bg-indigo-100 transition-colors duration-200">
                        <div>
                            <span class="font-medium text-gray-800">{{ $seminaire->titre }}</span>
                            <span class="text-sm text-gray-500"> (pour le {{ $seminaire->date_presentation ? $seminaire->date_presentation->format('d/m/Y') : 'N/D' }})</span>
                        </div>
                        <a href="{{ route('presentateur.seminaires.resume.form', $seminaire) }}" class="text-sm text-indigo-600 hover:underline hover:text-indigo-800 transition-colors duration-200">Soumettre le résumé</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="flex flex-col md:flex-row gap-6">
                <a href="{{ route('presentateur.demandes.create') }}" class="add-btn flex-1 text-center">Nouvelle demande de présentation</a>
                <a href="{{ route('presentateur.demandes.index') }}" class="add-btn flex-1 text-center">Voir mes demandes</a>
                <a href="{{ route('presentateur.seminaires.index') }}" class="add-btn flex-1 text-center">Voir mes séminaires programmés</a>
                <a href="{{ route('seminaires.authentifie.index') }}" class="add-btn flex-1 text-center">Consulter tous les séminaires</a>
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