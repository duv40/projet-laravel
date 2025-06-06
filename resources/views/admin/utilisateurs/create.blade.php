<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un Utilisateur - {{ config('app.name', 'Laravel') }}</title>
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
        .form-bloc {
            background: linear-gradient(90deg, #f3f4f6 0%, #e0e7ff 100%);
            border-radius: 1.5rem;
            box-shadow: 0 2px 12px 0 rgba(99, 102, 241, 0.07);
            padding: 2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #4338ca;
            margin-bottom: 1.5rem;
            text-align: center;
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
        .submit-btn {
            background: linear-gradient(90deg, #6366f1 0%, #fbbf24 100%);
            color: #fff;
            border: none;
            font-weight: bold;
            border-radius: 9999px;
            padding: 0.9rem 2.2rem;
            font-size: 1.1rem;
            box-shadow: 0 4px 16px 0 rgba(99, 102, 241, 0.13);
            transition: background 0.2s, transform 0.2s;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            display: inline-block;
            text-align: center;
        }
        .submit-btn:hover {
            background: linear-gradient(90deg, #fbbf24 0%, #6366f1 100%);
            transform: translateY(-2px) scale(1.04);
        }
        .cancel-link {
            margin-right: 1.5rem;
            color: #6366f1;
            font-weight: 600;
            text-decoration: underline;
            transition: color 0.2s;
        }
        .cancel-link:hover {
            color: #f59e42;
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
            <div class="hero-title">Ajouter un Utilisateur</div>
            <div class="hero-desc">Remplissez le formulaire ci-dessous pour ajouter un nouvel utilisateur à la plateforme.</div>
            <div class="form-bloc">
                <div class="form-title">Informations de l'utilisateur</div>
                <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nom Complet*')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Adresse Email*')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Rôle -->
                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Rôle*')" />
                        <select name="role" id="role" required class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            @foreach($roles as $roleValue)
                                <option value="{{ $roleValue }}" {{ old('role') == $roleValue ? 'selected' : '' }}>
                                    {{ ucfirst($roleValue) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Recevoir Notifications -->
                    <div class="block mt-4">
                        <label for="recoit_notifications_seminaires" class="inline-flex items-center">
                            <input id="recoit_notifications_seminaires" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                   name="recoit_notifications_seminaires" value="1"
                                   {{ old('recoit_notifications_seminaires') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-600">{{ __('Recevoir les notifications des séminaires') }}</span>
                        </label>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Mot de passe*')" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required
                                      autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe*')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation"
                                      required
                                      autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-center mt-8">
                        <a href="{{ route('admin.utilisateurs.index') }}" class="cancel-link">Annuler</a>
                        <button type="submit" class="submit-btn">
                            Créer l'utilisateur
                        </button>
                    </div>
                </form>
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