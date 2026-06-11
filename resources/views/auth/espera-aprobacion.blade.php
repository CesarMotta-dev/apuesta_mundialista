<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Gracias por registrarte como Administrador en nuestra plataforma. Por motivos de seguridad, tu cuenta ha sido puesta en espera de revisión.') }}
    </div>

    <div class="mb-4 text-sm font-bold text-blue-800">
        {{ __('El Súper Administrador (César Bedoya) revisará tu solicitud. Una vez autorizado, podrás acceder al sistema y crear tus pollas.') }}
    </div>

    <div class="mt-4 flex items-center justify-end">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Cerrar Sesión') }}
            </button>
        </form>
    </div>
</x-guest-layout>
