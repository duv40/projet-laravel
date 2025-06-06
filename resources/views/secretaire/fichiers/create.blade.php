<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seminaire->fichierPresentation ? 'Modifier' : 'Ajouter' }} le Fichier de Présentation - {{ config('app.name', 'Laravel') }}</title>
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
        .save-btn {
            background: linear-gradient(90deg, #6366f1 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            border-radius: 9999px;
            padding: 0.7rem 2rem;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            transition: background 0.2s, transform 0.2s;
            margin-top: 1.5rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: inline-block;
        }
        .save-btn:hover {
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
            <div class="mb-6">
                <a href="{{ route('secretaire.seminaires.show', $seminaire) }}" class="text-sm text-indigo-600 hover:underline">← Retour au séminaire</a>
            </div>
            @if ($seminaire->fichierPresentation)
                <div class="mb-4 p-3 bg-gray-50 rounded-md">
                    <p class="text-sm text-gray-700">Fichier actuel :
                        <a href="{{ Storage::url($seminaire->fichierPresentation->chemin_stockage) }}" target="_blank" class="font-medium text-indigo-600 hover:underline">
                            {{ $seminaire->fichierPresentation->nom_original_fichier }}
                        </a>
                        ({{ round($seminaire->fichierPresentation->taille_octets / 1024, 2) }} Ko)
                    </p>
                    <form action="{{ route('secretaire.seminaires.fichier.destroy', $seminaire) }}" method="POST" class="mt-2" onsubmit="return confirm('Voulez-vous vraiment supprimer ce fichier ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-700 transition-all duration-200">Supprimer le fichier actuel</button>
                    </form>
                </div>
            @endif
            <form method="POST" action="{{ route('secretaire.seminaires.fichier.store', $seminaire) }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="fichier_presentation" class="block font-semibold mb-2">Sélectionner le nouveau fichier (PDF, PPT, DOC, ZIP - Max 20MB)</label>
                    <input id="fichier_presentation" type="file" name="fichier_presentation" required
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100 mt-1">
                    @error('fichier_presentation')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                <div class="flex items-center justify-end mt-6">
                    <button type="submit" class="save-btn">
                        {{ $seminaire->fichierPresentation ? 'Remplacer le Fichier' : 'Téléverser le Fichier' }}
                    </button>
                </div>
            </form>
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