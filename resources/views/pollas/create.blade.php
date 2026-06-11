<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black leading-tight text-blue-950">Crear polla</h2>
                <p class="text-sm text-gray-600">Define el nombre y el monto de entrada para tus apostadores.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-blue-700 hover:text-blue-900">Volver</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('pollas.store') }}" class="rounded-lg border border-gray-200 bg-white p-6 shadow-md">
                @csrf

                <div>
                    <x-input-label for="nombre" value="Nombre de la polla" />
                    <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required autofocus />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="partido_id" value="Partido a apostar" />
                    <select id="partido_id" name="partido_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="" disabled selected>Selecciona un partido...</option>
                        @foreach($partidos as $partido)
                            <option value="{{ $partido->id }}" {{ old('partido_id') == $partido->id ? 'selected' : '' }}>
                                {{ $partido->equipo_local }} vs {{ $partido->equipo_visitante }} ({{ \Carbon\Carbon::parse($partido->fecha_inicio)->format('d M - H:i') }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('partido_id')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="monto" value="Monto por apostador" />
                    <x-text-input id="monto" name="monto" type="number" min="0" step="1000" class="mt-1 block w-full" :value="old('monto')" required />
                    <x-input-error :messages="$errors->get('monto')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="descripcion" value="Descripcion" />
                    <textarea id="descripcion" name="descripcion" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-primary-button>
                        Crear polla
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
