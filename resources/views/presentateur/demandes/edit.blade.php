<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier la Demande de Présentation - {{ config('app.name', 'Laravel') }}</title>
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
            <h1 class="text-2xl font-bold text-indigo-800 mb-6">Modifier la Demande de Présentation</h1>
            <form method="POST" action="{{ route('presentateur.demandes.update', $demandePresentation) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Titre -->
                <div>
                    <label for="titre" class="block font-semibold mb-2">Titre de la présentation*</label>
                    <input id="titre" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="titre" value="{{ old('titre', $demandePresentation->titre ?? '') }}" required autofocus />
                    @error('titre')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description Courte -->
                <div class="mt-4">
                    <label for="description_courte" class="block font-semibold mb-2">Description Courte (optionnel)</label>
                    <textarea id="description_courte" name="description_courte" rows="4"
                              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('description_courte', $demandePresentation->description_courte ?? '') }}</textarea>
                    @error('description_courte')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Document Joint -->
                <div class="mt-4">
                    <label for="document_joint" class="block font-semibold mb-2">Document Joint (PDF, DOC, TXT - Max 5MB, optionnel)</label>
                    <input id="document_joint" type="file" name="document_joint"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100 mt-1">
                    @error('document_joint')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                    @if($demandePresentation->document_joint)
                        <p class="mt-2 text-sm text-gray-600">
                            Fichier actuel : <a href="{{ Storage::url($demandePresentation->document_joint) }}" target="_blank" class="text-indigo-600 hover:underline">{{ basename($demandePresentation->document_joint) }}</a>
                            <label for="supprimer_document_joint" class="ml-4 inline-flex items-center">
                                <input id="supprimer_document_joint" type="checkbox" name="supprimer_document_joint" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Supprimer le fichier actuel</span>
                            </label>
                        </p>
                    @endif
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('presentateur.demandes.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4 transition-colors duration-200">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-full shadow hover:bg-indigo-700 transition-all duration-200">
                        Mettre à jour la demande
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
