<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Demandes de Présentation - {{ config('app.name', 'Laravel') }}</title>
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
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-indigo-800">Mes Demandes de Présentation</h1>
                <a href="{{ route('presentateur.demandes.create') }}" class="add-btn">Nouvelle Demande</a>
            </div>
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            @if($demandes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-indigo-50 to-indigo-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Soumise le</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($demandes as $demande)
                                <tr class="transition-all duration-200 hover:bg-indigo-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ Str::limit($demande->titre, 50) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $demande->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($demande->statut == 'accepte') bg-green-100 text-green-800
                                            @elseif($demande->statut == 'rejete') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $demande->statut)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('presentateur.demandes.show', $demande) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">Voir</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $demandes->links() }}
                </div>
            @else
                <p class="text-gray-500">Vous n'avez soumis aucune demande de présentation pour le moment.</p>
                <a href="{{ route('presentateur.demandes.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-all duration-200">
                    Soumettre une nouvelle demande
                </a>
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