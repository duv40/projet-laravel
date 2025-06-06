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
            <h1 class="text-2xl font-bold text-indigo-800 mb-6">Détail de la Demande : {{ $demandePresentation->titre }}</h1>
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Titre</h3>
                    <p class="text-gray-700">{{ $demandePresentation->titre }}</p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Statut</h3>
                    <p class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full capitalize
                        @if($demandePresentation->statut == 'accepte') bg-green-100 text-green-800
                        @elseif($demandePresentation->statut == 'rejete') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ str_replace('_', ' ', $demandePresentation->statut) }}
                    </p>
                </div>

                @if($demandePresentation->description_courte)
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Description Courte</h3>
                    <p class="text-gray-700 prose max-w-none">{!! nl2br(e($demandePresentation->description_courte)) !!}</p>
                </div>
                @endif

                @if($demandePresentation->document_joint)
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Document Joint</h3>
                    <a href="{{ Storage::url($demandePresentation->document_joint) }}" target="_blank"
                       class="text-indigo-600 hover:underline">
                       {{ basename($demandePresentation->document_joint) }} (Télécharger)
                    </a>
                </div>
                @endif

                <div class="text-sm text-gray-500">
                    Soumise le: {{ $demandePresentation->created_at->format('d/m/Y à H:i') }}
                </div>

                @if($demandePresentation->statut == 'accepte' && $demandePresentation->seminaire)
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">
                        <p class="font-medium text-green-700">
                            Félicitations ! Votre demande a été acceptée.
                            Votre séminaire est programmé pour le {{ $demandePresentation->seminaire->date_presentation ? $demandePresentation->seminaire->date_presentation->format('d/m/Y') : 'N/D' }}
                            @if($demandePresentation->seminaire->heure_debut)
                                à {{ \Carbon\Carbon::parse($demandePresentation->seminaire->heure_debut)->format('H:i') }}.
                            @endif
                            <br>N'oubliez pas de <a href="{{ route('presentateur.seminaires.resume.form', $demandePresentation->seminaire) }}" class="font-bold underline">soumettre votre résumé</a> au moins 10 jours avant.
                        </p>
                    </div>
                @elseif($demandePresentation->statut == 'accepte' && !$demandePresentation->seminaire)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                         <p class="font-medium text-blue-700">Votre demande a été acceptée. La programmation du séminaire est en cours.</p>
                    </div>
                @elseif($demandePresentation->statut == 'rejete')
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
                        <p class="font-medium text-red-700">Votre demande a été rejetée.</p>
                    </div>
                @endif

                <div class="mt-6 flex space-x-3">
                    <a href="{{ route('presentateur.demandes.index') }}" class="text-indigo-600 hover:underline hover:text-indigo-800 transition-colors duration-200">
                        ← Retour à mes demandes
                    </a>
                    @if($demandePresentation->statut == 'en_attente')
                        <a href="{{ route('presentateur.demandes.show', $demandePresentation) }}" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 transition-all duration-200">
                            Modifier
                        </a>
                    @endif
                </div>
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