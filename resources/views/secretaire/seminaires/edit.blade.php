<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier le Séminaire - {{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ...identique à create.blade.php... */
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
                    <!-- Bouton de déconnexion -->
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
                Modifier le Séminaire
            </h1>
            <form method="POST" action="{{ route('secretaire.seminaires.update', $seminaire) }}">
                @csrf
                @method('PUT')

                {{-- Champ caché pour la demande liée si on vient d'une demande --}}
                @if(isset($demandeLiee) && !isset($seminaire))
                    <input type="hidden" name="demande_presentation_id" value="{{ $demandeLiee->id }}">
                    <input type="hidden" name="presentateur_id" value="{{ $demandeLiee->presentateur_id }}">
                    <input type="hidden" name="titre" value="{{ $demandeLiee->titre }}">
                    <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md">
                        <p class="text-sm text-blue-700 dark:text-blue-200">
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
                    <x-input-label for="presentateur_id" :value="__('Présentateur*')" />
                    <select name="presentateur_id" id="presentateur_id" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">-- Choisir un présentateur --</option>
                        @foreach($presentateurs as $presentateur)
                            <option value="{{ $presentateur->id }}"
                                {{ old('presentateur_id', $seminaire->presentateur_id ?? ($demandeLiee->presentateur_id ?? '')) == $presentateur->id ? 'selected' : '' }}>
                                {{ $presentateur->name }} ({{ $presentateur->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('presentateur_id')" class="mt-2" />
                </div>

                <!-- Résumé (optionnel à ce stade, peut être rempli par le présentateur) -->
                <div class="mt-4">
                    <x-input-label for="resume" :value="__('Résumé (peut être complété plus tard)')" />
                    <textarea id="resume" name="resume" rows="5"
                              class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    >{{ old('resume', $seminaire->resume ?? '') }}</textarea>
                    <x-input-error :messages="$errors->get('resume')" class="mt-2" />
                </div>

                <!-- Date et Heures -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <x-input-label for="date_presentation" :value="__('Date de présentation*')" />
                        <x-text-input id="date_presentation" class="block mt-1 w-full" type="date" name="date_presentation" :value="old('date_presentation', $seminaire->date_presentation ? $seminaire->date_presentation->format('Y-m-d') : '')" required />
                        <x-input-error :messages="$errors->get('date_presentation')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="heure_debut" :value="__('Heure de début*')" />
                        <x-text-input id="heure_debut" class="block mt-1 w-full" type="time" name="heure_debut" :value="old('heure_debut', $seminaire->heure_debut ?? '')" required />
                        <x-input-error :messages="$errors->get('heure_debut')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="heure_fin" :value="__('Heure de fin*')" />
                        <x-text-input id="heure_fin" class="block mt-1 w-full" type="time" name="heure_fin" :value="old('heure_fin', $seminaire->heure_fin ?? '')" required />
                        <x-input-error :messages="$errors->get('heure_fin')" class="mt-2" />
                    </div>
                </div>

                <!-- Lieu -->
                <div class="mt-4">
                    <x-input-label for="lieu" :value="__('Lieu (ou lien de conférence)')" />
                    <x-text-input id="lieu" class="block mt-1 w-full" type="text" name="lieu" :value="old('lieu', $seminaire->lieu ?? '')" />
                    <x-input-error :messages="$errors->get('lieu')" class="mt-2" />
                </div>

                <!-- Statut (seulement en édition) -->
                @if(isset($seminaire))
                <div class="mt-4">
                    <x-input-label for="statut" :value="__('Statut*')" />
                    <select name="statut" id="statut" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="programmé" {{ old('statut', $seminaire->statut ?? '') == 'programmé' ? 'selected' : '' }}>Programmé</option>
                        <option value="passé" {{ old('statut', $seminaire->statut ?? '') == 'passé' ? 'selected' : '' }}>Passé</option>
                        <option value="annulé" {{ old('statut', $seminaire->statut ?? '') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    <x-input-error :messages="$errors->get('statut')" class="mt-2" />
                </div>
                @endif

                {{-- Optionnel: Lier à une demande_presentation_id si création manuelle --}}
                @if(!isset($demandeLiee) && !isset($seminaire))
                    {{-- <div class="mt-4"> ... Champ pour sélectionner une demande_presentation_id ... </div> --}}
                @endif


                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('secretaire.seminaires.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-4 transition-colors duration-200">
                        Annuler
                    </a>
                    <button type="submit" class="save-btn">
                        Mettre à jour le séminaire
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