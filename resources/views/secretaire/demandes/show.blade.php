<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Détail de la Demande - {{ config('app.name', 'Laravel') }}</title>
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
            <div>
                <a href="{{ route('secretaire.demandes.index') }}" class="text-sm text-indigo-600 hover:underline">← Retour à la liste des demandes</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $demandePresentation->titre }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Présentateur</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $demandePresentation->presentateur->name ?? 'N/A' }} ({{ $demandePresentation->presentateur->email ?? 'N/A' }})</p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date de soumission</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $demandePresentation->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Statut Actuel</h3>
                    <p class="mt-1 text-lg">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full capitalize
                            @if($demandePresentation->statut == 'accepte') bg-green-100 text-green-800
                            @elseif($demandePresentation->statut == 'rejete') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ str_replace('_', ' ', $demandePresentation->statut) }}
                        </span>
                    </p>
                </div>
            </div>

            @if($demandePresentation->description_courte)
            <div class="mt-6">
                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Description</h3>
                <div class="mt-1 prose max-w-none text-gray-700">
                    {!! nl2br(e($demandePresentation->description_courte)) !!}
                </div>
            </div>
            @endif

            @if($demandePresentation->document_joint)
            <div class="mt-6">
                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Document Joint</h3>
                <p class="mt-1">
                    <a href="{{ Storage::url($demandePresentation->document_joint) }}" target="_blank"
                       class="text-indigo-600 hover:underline">
                        {{ basename($demandePresentation->document_joint) }} (Télécharger)
                    </a>
                </p>
            </div>
            @endif

            @if($demandePresentation->statut == 'en_attente')
                <div class="mt-6 pt-6 border-t border-gray-200 flex space-x-3">
                    <form action="{{ route('secretaire.demandes.valider', $demandePresentation) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="action-btn">Valider la Demande</button>
                    </form>
                    <form action="{{ route('secretaire.demandes.rejeter', $demandePresentation) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="action-btn" style="background:linear-gradient(90deg,#f87171 0%,#6366f1 100%);">Rejeter la Demande</button>
                    </form>
                </div>
            @elseif($demandePresentation->statut == 'accepte' && !$demandePresentation->seminaire)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('secretaire.seminaires.create', ['demande_id' => $demandePresentation->id]) }}"
                       class="action-btn">Programmer le Séminaire correspondant</a>
                </div>
            @elseif($demandePresentation->seminaire)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Un séminaire a déjà été programmé pour cette demande :
                        <a href="{{ route('secretaire.seminaires.show', $demandePresentation->seminaire) }}" class="font-medium text-indigo-600 hover:underline">
                            Voir le séminaire "{{ $demandePresentation->seminaire->titre }}"
                        </a>
                    </p>
                </div>
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