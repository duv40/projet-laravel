<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($seminaire) ? 'Modifier le Séminaire' : 'Programmer un Nouveau Séminaire' }} - {{ config('app.name', 'Laravel') }}</title>
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
            max-width: 900px;
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
            <h1 class="text-2xl font-bold text-indigo-800 mb-6">
                {{ isset($seminaire) ? 'Modifier le Séminaire' : 'Programmer un Nouveau Séminaire' }}
            </h1>
            <form method="POST" action="{{ $seminaire->exists ? route('secretaire.seminaires.update', $seminaire) : route('secretaire.seminaires.store') }}">
    @csrf
    @if($seminaire->exists) {{-- Vérifie si le modèle existe déjà en BDD (donc a un ID) --}}
        @method('PUT')
    @endif

                {{-- Champ caché pour la demande liée si on vient d'une demande --}}
                @if(isset($demandeLiee) && !isset($seminaire))
                    <input type="hidden" name="demande_presentation_id" value="{{ $demandeLiee->id }}">
                    <input type="hidden" name="presentateur_id" value="{{ $demandeLiee->presentateur_id }}">
                    <input type="hidden" name="titre" value="{{ $demandeLiee->titre }}">
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                        <p class="text-sm text-blue-700">
                            Programmation du séminaire pour la demande : <strong>{{ $demandeLiee->titre }}</strong> par <strong>{{ $demandeLiee->presentateur->name }}</strong>.
                        </p>
                    </div>
                @endif

                <!-- Titre -->
                <div class="mt-4">
                    <label for="titre" class="block font-semibold mb-2">Titre du séminaire*</label>
                    <input id="titre" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="titre" value="{{ old('titre', $seminaire->titre ?? ($demandeLiee->titre ?? '')) }}" required />
                    @error('titre')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Présentateur -->
                <div class="mt-4">
                    <label for="presentateur_id" class="block font-semibold mb-2">Présentateur*</label>
                    <select name="presentateur_id" id="presentateur_id" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Choisir un présentateur --</option>
                        @foreach($presentateurs as $presentateur)
                            <option value="{{ $presentateur->id }}"
                                {{ old('presentateur_id', $seminaire->presentateur_id ?? ($demandeLiee->presentateur_id ?? '')) == $presentateur->id ? 'selected' : '' }}>
                                {{ $presentateur->name }} ({{ $presentateur->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('presentateur_id')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Résumé (optionnel à ce stade, peut être rempli par le présentateur) -->
                <div class="mt-4">
                    <label for="resume" class="block font-semibold mb-2">Résumé (peut être complété plus tard)</label>
                    <textarea id="resume" name="resume" rows="5"
                              class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ old('resume', $seminaire->resume ?? '') }}</textarea>
                    @error('resume')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date et Heures -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="date_presentation" class="block font-semibold mb-2">Date de présentation*</label>
                        <input id="date_presentation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="date" name="date_presentation" value="{{ old('date_presentation', $seminaire->date_presentation ? $seminaire->date_presentation->format('Y-m-d') : '') }}" required />
                        @error('date_presentation')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="heure_debut" class="block font-semibold mb-2">Heure de début*</label>
                        <input id="heure_debut" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="time" name="heure_debut" value="{{ old('heure_debut', $seminaire->heure_debut ?? '') }}" required />
                        @error('heure_debut')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="heure_fin" class="block font-semibold mb-2">Heure de fin*</label>
                        <input id="heure_fin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="time" name="heure_fin" value="{{ old('heure_fin', $seminaire->heure_fin ?? '') }}" required />
                        @error('heure_fin')
                            <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Lieu -->
                <div class="mt-4">
                    <label for="lieu" class="block font-semibold mb-2">Lieu (ou lien de conférence)</label>
                    <input id="lieu" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="lieu" value="{{ old('lieu', $seminaire->lieu ?? '') }}" />
                    @error('lieu')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                @if(isset($seminaire))
                <!-- Statut (seulement en édition) -->
                <div class="mt-4">
                    <label for="statut" class="block font-semibold mb-2">Statut*</label>
                    <select name="statut" id="statut" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="programmé" {{ old('statut', $seminaire->statut ?? '') == 'programmé' ? 'selected' : '' }}>Programmé</option>
                        <option value="passé" {{ old('statut', $seminaire->statut ?? '') == 'passé' ? 'selected' : '' }}>Passé</option>
                        <option value="annulé" {{ old('statut', $seminaire->statut ?? '') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    @error('statut')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('secretaire.seminaires.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4 transition-colors duration-200">
                        Annuler
                    </a>
                    <button type="submit" class="save-btn">
                        {{ isset($seminaire) ? 'Mettre à jour le séminaire' : 'Programmer le séminaire' }}
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