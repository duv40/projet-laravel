<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détails Utilisateur - {{ config('app.name', 'Laravel') }}</title>
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
            max-width: 700px;
            width: 100%;
            position: relative;
        }
        .hero-title {
            font-size: 2rem;
            font-weight: 900;
            color: #4338ca;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .hero-desc {
            font-size: 1.1rem;
            color: #374151;
            text-align: center;
            margin-bottom: 2.5rem;
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
        .action-btn {
            background: linear-gradient(90deg, #6366f1 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            border-radius: 9999px;
            padding: 0.7rem 2rem;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            transition: background 0.2s, transform 0.2s;
            margin-right: 1rem;
            margin-bottom: 1rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: inline-block;
        }
        .action-btn:hover {
            background: linear-gradient(90deg, #fbbf24 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.04);
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
            <div class="hero-title" style="font-size:2rem;font-weight:900;color:#4338ca;text-align:center;margin-bottom:0.5rem;">
                Détails de l'Utilisateur
            </div>
            <div class="hero-desc" style="font-size:1.1rem;color:#374151;text-align:center;margin-bottom:2.5rem;">
                Informations détaillées sur l'utilisateur sélectionné.
            </div>
            <div class="mb-6">
                <a href="{{ route('admin.utilisateurs.index') }}" class="text-sm text-indigo-600 hover:underline hover:text-indigo-800 transition-colors duration-200">← Retour à la liste des utilisateurs</a>
            </div>
            <h1 class="text-2xl font-bold text-indigo-800 mb-6">Détails de l'Utilisateur : {{ $utilisateur->name }}</h1>
            <div class="space-y-4">
                @foreach([
                    ['ID Utilisateur', $utilisateur->id],
                    ['Nom Complet', $utilisateur->name],
                    ['Adresse Email', $utilisateur->email],
                    ['Rôle', ucfirst($utilisateur->role)],
                    ['Reçoit les notifications des séminaires', $utilisateur->recoit_notifications_seminaires ? 'Oui' : 'Non'],
                    ['Date d\'inscription', $utilisateur->created_at->format('d/m/Y à H:i')],
                    ['Dernière modification', $utilisateur->updated_at->format('d/m/Y à H:i')],
                ] as [$label, $value])
                <div class="rounded-lg bg-white/80 shadow p-4 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $label }}</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $value }}</p>
                </div>
                @endforeach
                <div class="rounded-lg bg-white/80 shadow p-4 hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email Vérifié</h3>
                    <p class="mt-1 text-lg">
                        @if ($utilisateur->email_verified_at)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 animate-fade-in">
                                Oui (le {{ $utilisateur->email_verified_at->format('d/m/Y H:i') }})
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 animate-fade-in">
                                Non
                            </span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center space-x-3">
                <a href="{{ route('admin.utilisateurs.edit', $utilisateur) }}" class="action-btn">Modifier l'Utilisateur</a>
                @if(Auth::id() !== $utilisateur->id)
                <form action="{{ route('admin.utilisateurs.destroy', $utilisateur) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ? Cette action est irréversible.');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="action-btn" style="background:linear-gradient(90deg,#f87171 0%,#6366f1 100%);">Supprimer l'Utilisateur</button>
                </form>
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