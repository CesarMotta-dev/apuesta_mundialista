<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 grid gap-3 sm:grid-cols-2">
        <a href="{{ route('register', ['rol' => 'administrador']) }}" class="block rounded-lg border border-blue-200 bg-blue-50 p-4 transition hover:border-blue-400 hover:bg-blue-100">
            <p class="text-sm font-bold uppercase tracking-wide text-blue-800">Administrador</p>
            <p class="mt-1 text-sm text-blue-950">Crea tu polla, define el monto y administra tus apostadores.</p>
        </a>

        <a href="{{ route('register', ['rol' => 'apostador']) }}" class="block rounded-lg border border-emerald-200 bg-emerald-50 p-4 transition hover:border-emerald-400 hover:bg-emerald-100">
            <p class="text-sm font-bold uppercase tracking-wide text-emerald-800">Apostador</p>
            <p class="mt-1 text-sm text-emerald-950">Unete a una polla abierta y juega con el administrador que elijas.</p>
        </a>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
