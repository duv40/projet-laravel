<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau de Bord Étudiant - {{ config('app.name', 'Laravel') }}</title>
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
        .section-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #4338ca;
            margin-bottom: 1rem;
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
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-indigo-800 mb-2">Bonjour, {{ Auth::user()->name }} !</h1>
                <p class="text-base text-gray-600">
                    Bienvenue sur votre espace personnel. Consultez les prochains séminaires ou gérez vos préférences.
                </p>
            </div>

            {{-- Prochains Séminaires --}}
            <div class="mb-8">
                <div class="section-title">Prochains Séminaires</div>
                @if($prochainsSeminaires && $prochainsSeminaires->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-indigo-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Présentateur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lieu</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($prochainsSeminaires as $seminaire)
                                <tr class="transition-all duration-200 hover:bg-indigo-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $seminaire->titre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $seminaire->presentateur->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $seminaire->date_presentation ? $seminaire->date_presentation->format('d/m/Y') : 'N/D' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $seminaire->heure_debut ? \Carbon\Carbon::parse($seminaire->heure_debut)->format('H:i') : 'N/D' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $seminaire->lieu ?? 'En ligne/À définir' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('seminaires.authentifie.show', $seminaire) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-semibold rounded-md shadow hover:bg-indigo-700 transition-all duration-200">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-gray-500">Aucun séminaire programmé pour le moment.</p>
                @endif
            </div>

            {{-- Séminaires Passés Récemment --}}
            @if($seminairesPassesRecemment && $seminairesPassesRecemment->count() > 0)
            <div class="mb-8">
                <div class="section-title">Séminaires Récents</div>
                <ul>
                    @foreach($seminairesPassesRecemment as $seminaire)
                        <li class="py-2 border-b last:border-b-0 flex items-center justify-between group">
                            <div>
                                <a href="{{ route('seminaires.authentifie.show', $seminaire) }}"
                                   class="text-indigo-600 hover:text-indigo-900 font-medium transition-colors duration-200">
                                    {{ $seminaire->titre }}
                                </a>
                                <span class="text-sm text-gray-500"> - Passé le {{ $seminaire->date_presentation ? $seminaire->date_presentation->format('d/m/Y') : '' }}</span>
                            </div>
                            @if($seminaire->fichierPresentation)
                                <a href="{{ route('seminaires.fichier.download', $seminaire) }}"
                                   class="ml-4 text-xs text-green-600 hover:text-green-800 transition-colors duration-200 inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                                    </svg>
                                    (Télécharger Présentation)
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Raccourcis Utiles --}}
            <div>
                <div class="section-title">Actions Rapides</div>
                <ul class="mt-2 list-disc list-inside text-sm text-gray-600 space-y-1">
                    <li>
                        <a href="{{ route('seminaires.authentifie.index') }}"
                           class="text-indigo-600 hover:underline hover:text-indigo-800 transition-colors duration-200">
                            Voir tous les séminaires
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('preferences.notifications.edit') }}"
                           class="text-indigo-600 hover:underline hover:text-indigo-800 transition-colors duration-200">
                            Gérer mes préférences de notification
                        </a>
                    </li>
                </ul>
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