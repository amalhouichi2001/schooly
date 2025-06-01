<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-indigo-600 mb-6">Créer un compte</h2>
        <p class="text-sm text-gray-500 text-center mb-8">Rejoignez notre plateforme de gestion scolaire</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nom -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Nom ')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="prenom" :value="__('prenom ')" />
                <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>
                    <!-- Role -->
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="eleve">Élève</option>
                    <option value="enseignant">Enseignant</option>
                    <option value="parent">Parent</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Adresse email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Lien vers connexion + bouton -->
            <div class="flex items-center justify-between">
                <a class="text-sm text-gray-600 hover:text-indigo-600" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ?') }}
                </a>

                <x-primary-button class="ml-3">
                    {{ __('S’inscrire') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>