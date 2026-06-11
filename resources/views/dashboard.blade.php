<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('imagenes/copa_mundial.png') }}" alt="copa mundial" class="h-10 sm:h-12 md:h-14 drop-shadow-md shrink-0">
                <div>
                    <h2 class="font-black text-lg sm:text-2xl md:text-3xl text-blue-900 leading-tight">
                        La Polla Mundialista
                    </h2>
                    <p class="text-sm font-semibold text-gray-600">
                        {{ auth()->user()->esAdministrador() ? 'Panel de administrador' : 'Panel de apostador' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                @if (auth()->user()->esSuperAdmin())
                    <a href="{{ route('superadmin.pendientes') }}" class="inline-flex min-h-[44px] items-center justify-center rounded-md bg-yellow-500 px-4 py-2 text-sm font-bold text-yellow-950 shadow-sm transition hover:bg-yellow-400">
                        Autorizar Admins
                    </a>
                @endif

                @if (auth()->user()->esAdministrador())
                    <form method="POST" action="{{ route('partidos.actualizar') }}">
                        @csrf
                        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700">
                            Actualizar partidos
                        </button>
                    </form>

                    <a href="{{ route('pollas.create') }}" class="inline-flex min-h-[44px] items-center justify-center rounded-md bg-blue-700 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-blue-800">
                        Crear polla
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="relative min-h-screen overflow-hidden bg-white py-6 sm:py-10">
        <div class="absolute inset-0 bg-center bg-cover bg-no-repeat opacity-10 grayscale" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Colombia.svg');"></div>
        <div class="absolute inset-0 bg-white/80"></div>

        <div class="relative z-10 mx-auto max-w-7xl px-3 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800">
                    {{ session('status') }}
                </div>
            @endif

            @if (auth()->user()->esAdministrador())
                <section class="mb-8">
                    <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-extrabold text-blue-950 sm:text-2xl">Tus pollas</h3>
                            <p class="text-sm text-gray-700">Crea una polla, fija el monto y comparte el enlace de ngrok con tus apostadores.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @forelse ($misPollas as $polla)
                            <div class="rounded-lg border border-blue-100 bg-white p-5 shadow-md">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h4 class="text-lg font-black text-blue-950">{{ $polla->nombre }}</h4>
                                        @if($polla->partido)
                                            <p class="mt-1 text-xs font-bold text-blue-800">
                                                Partido: <x-bandera :equipo="$polla->partido->equipo_local" /> {{ $polla->partido->equipo_local }} vs <x-bandera :equipo="$polla->partido->equipo_visitante" /> {{ $polla->partido->equipo_visitante }}
                                                <span class="text-gray-500 font-normal">({{ \Carbon\Carbon::parse($polla->partido->fecha_inicio)->format('d M') }})</span>
                                            </p>
                                        @endif
                                        <p class="mt-1 text-sm text-gray-600">{{ $polla->descripcion ?: 'Sin descripcion' }}</p>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-bold uppercase text-green-800">{{ $polla->estado }}</span>
                                        <form method="POST" action="{{ route('pollas.destroy', $polla) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta polla? Esta acción no se puede deshacer.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800 hover:underline transition">Eliminar polla</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                                    <div class="rounded-md bg-gray-50 p-3">
                                        <p class="font-semibold text-gray-500">Monto</p>
                                        <p class="text-lg font-black text-gray-900">${{ number_format($polla->monto, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="rounded-md bg-gray-50 p-3">
                                        <p class="font-semibold text-gray-500">Apostadores</p>
                                        <p class="text-lg font-black text-gray-900">{{ $polla->apostadores_count }}</p>
                                    </div>
                                    <div class="col-span-2 rounded-md bg-gray-50 p-3">
                                        <p class="font-semibold text-gray-500 mb-2">Marcadores Registrados</p>
                                        <div class="flex flex-wrap gap-2">
                                            @forelse($polla->apostadores as $apostador)
                                                <span class="rounded bg-white px-2 py-1 text-xs border font-bold text-gray-800">
                                                    {{ $apostador->pivot->marcador_local }} - {{ $apostador->pivot->marcador_visitante }}
                                                    <span class="font-normal text-gray-500">({{ $apostador->name }})</span>
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400">Nadie se ha unido aún</span>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-blue-300 bg-white/90 p-6 text-center md:col-span-2 xl:col-span-3">
                                <p class="font-bold text-blue-950">Todavia no tienes pollas creadas.</p>
                                <a href="{{ route('pollas.create') }}" class="mt-4 inline-flex min-h-[44px] items-center justify-center rounded-md bg-blue-700 px-4 py-2 text-sm font-bold text-white hover:bg-blue-800">
                                    Crear primera polla
                                </a>
                            </div>
                        @endforelse
                    </div>
                </section>
            @else
                <section class="mb-8">
                    <h3 class="mb-4 text-xl font-extrabold text-blue-950 sm:text-2xl">Pollas disponibles</h3>

                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @forelse ($pollasDisponibles as $polla)
                            <div class="rounded-lg border border-emerald-100 bg-white p-5 shadow-md">
                                <h4 class="text-lg font-black text-emerald-950">{{ $polla->nombre }}</h4>
                                @if($polla->partido)
                                    <div class="mt-2 rounded bg-emerald-50 px-3 py-2 text-sm border border-emerald-100">
                                        <p class="font-bold text-emerald-900 flex items-center gap-1">
                                            Partido: <x-bandera :equipo="$polla->partido->equipo_local" /> {{ $polla->partido->equipo_local }} vs <x-bandera :equipo="$polla->partido->equipo_visitante" /> {{ $polla->partido->equipo_visitante }}
                                        </p>
                                        <p class="text-xs text-emerald-700">{{ \Carbon\Carbon::parse($polla->partido->fecha_inicio)->format('d M - H:i') }}</p>
                                    </div>
                                @endif
                                <p class="mt-1 text-sm text-gray-600">Admin: {{ $polla->administrador->name }}</p>
                                <p class="mt-3 text-sm text-gray-700">{{ $polla->descripcion ?: 'Sin descripcion' }}</p>
                                <p class="mt-4 text-lg font-black text-gray-900">${{ number_format($polla->monto, 0, ',', '.') }}</p>

                                <form method="POST" action="{{ route('pollas.join', $polla) }}" class="mt-4 border-t pt-4">
                                    @csrf
                                    <p class="text-sm font-bold text-gray-700 mb-2">Elige tu marcador para esta polla:</p>
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="flex-1 text-center">
                                            <label class="flex justify-center items-center gap-1 text-xs text-gray-500 mb-1 truncate">
                                                @if($polla->partido) <x-bandera :equipo="$polla->partido->equipo_local" /> @endif
                                                {{ $polla->partido ? $polla->partido->equipo_local : 'Local' }}
                                            </label>
                                            <input type="number" name="marcador_local" min="0" required class="w-16 rounded border-gray-300 px-2 py-1 text-center font-bold text-gray-900 shadow-sm" placeholder="L">
                                        </div>
                                        <span class="font-bold text-gray-500 mt-4">-</span>
                                        <div class="flex-1 text-center">
                                            <label class="flex justify-center items-center gap-1 text-xs text-gray-500 mb-1 truncate">
                                                @if($polla->partido) <x-bandera :equipo="$polla->partido->equipo_visitante" /> @endif
                                                {{ $polla->partido ? $polla->partido->equipo_visitante : 'Visitante' }}
                                            </label>
                                            <input type="number" name="marcador_visitante" min="0" required class="w-16 rounded border-gray-300 px-2 py-1 text-center font-bold text-gray-900 shadow-sm" placeholder="V">
                                        </div>
                                    </div>
                                    <button type="submit" class="inline-flex min-h-[44px] w-full items-center justify-center rounded-md bg-emerald-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-emerald-700">
                                        Unirme a esta polla
                                    </button>
                                </form>
                                <div class="mt-4 text-sm bg-gray-50 p-2 rounded">
                                    <p class="font-bold text-gray-600 mb-1 text-xs uppercase tracking-wide">Marcadores ya tomados:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($polla->apostadores as $apostador)
                                            <span class="rounded bg-white px-2 py-0.5 text-xs font-bold text-gray-600 border border-gray-200">
                                                {{ $apostador->pivot->marcador_local }} - {{ $apostador->pivot->marcador_visitante }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">Ninguno todavía. ¡Sé el primero!</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-emerald-300 bg-white/90 p-6 text-center md:col-span-2 xl:col-span-3">
                                <p class="font-bold text-emerald-950">No hay pollas abiertas por ahora.</p>
                                <p class="mt-1 text-sm text-gray-600">Cuando un administrador cree una, aparecera aqui.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="mb-8">
                    <h3 class="mb-4 text-xl font-extrabold text-blue-950 sm:text-2xl">Mis pollas</h3>
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                        @forelse ($misPollas as $polla)
                            <div class="rounded-lg border border-yellow-200 bg-white p-5 shadow-md">
                                <h4 class="text-lg font-black text-blue-950">{{ $polla->nombre }}</h4>
                                @if($polla->partido)
                                    <p class="mt-1 text-sm font-bold text-blue-800">
                                        <x-bandera :equipo="$polla->partido->equipo_local" /> {{ $polla->partido->equipo_local }} vs <x-bandera :equipo="$polla->partido->equipo_visitante" /> {{ $polla->partido->equipo_visitante }}
                                    </p>
                                @endif
                                <p class="mt-1 text-sm text-gray-600">Admin: {{ $polla->administrador->name }}</p>
                                <p class="mt-4 text-lg font-black text-gray-900">${{ number_format($polla->monto, 0, ',', '.') }}</p>
                                
                                @php
                                    $miApostador = $polla->apostadores->firstWhere('id', auth()->id());
                                @endphp
                                @if($miApostador)
                                <div class="mt-3 rounded-md bg-yellow-50 p-2 border border-yellow-100">
                                    <p class="text-sm text-yellow-800 font-semibold">Tu marcador: 
                                        <span class="font-black">{{ $miApostador->pivot->marcador_local }} - {{ $miApostador->pivot->marcador_visitante }}</span>
                                    </p>
                                </div>
                                @endif

                                <div class="mt-3 text-xs border-t border-yellow-100 pt-3">
                                    <p class="font-bold text-gray-600 mb-2">Todos los marcadores de la polla:</p>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($polla->apostadores as $apostador)
                                            <span class="rounded {{ $apostador->id === auth()->id() ? 'bg-yellow-200 text-yellow-900 border-yellow-300' : 'bg-gray-100 text-gray-700 border-gray-200' }} px-2 py-0.5 font-bold border">
                                                {{ $apostador->pivot->marcador_local }} - {{ $apostador->pivot->marcador_visitante }}
                                                <span class="font-normal opacity-75">({{ $apostador->name }})</span>
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border border-dashed border-yellow-300 bg-white/90 p-6 text-center md:col-span-2 xl:col-span-3">
                                <p class="font-bold text-blue-950">Aun no te has unido a ninguna polla.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            @endif

            <section>
                <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-extrabold text-red-700 sm:text-2xl">Proximos partidos</h3>
                        <p class="text-sm text-gray-700">Estos son los eventos que llegan desde la API y todavia no han iniciado.</p>
                    </div>
                    @if (auth()->user()->esAdministrador())
                        <form method="POST" action="{{ route('partidos.actualizar') }}">
                            @csrf
                            <button type="submit" class="inline-flex min-h-[40px] items-center justify-center rounded-md border border-emerald-200 bg-white px-4 py-2 text-sm font-bold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                                Sincronizar API
                            </button>
                        </form>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse ($partidosProximos as $partido)
                        <div class="rounded-lg border-t-4 border-yellow-400 bg-white p-5 text-center shadow-md">
                            <div class="mb-3 inline-block rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600">
                                Cierra: {{ \Carbon\Carbon::parse($partido->fecha_inicio)->format('d M Y - h:i A') }}
                            </div>

                            <div class="my-5 flex items-center justify-between gap-2 text-lg font-black text-blue-900">
                                <span class="flex-1 break-words text-center flex flex-col items-center gap-1">
                                    <x-bandera :equipo="$partido->equipo_local" />
                                    {{ $partido->equipo_local }}
                                </span>
                                <span class="shrink-0 text-sm text-red-600">VS</span>
                                <span class="flex-1 break-words text-center flex flex-col items-center gap-1">
                                    <x-bandera :equipo="$partido->equipo_visitante" />
                                    {{ $partido->equipo_visitante }}
                                </span>
                            </div>

                            <a href="#" class="inline-flex min-h-[44px] w-full items-center justify-center rounded-md bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-blue-800">
                                Hacer mi jugada
                            </a>
                        </div>
                    @empty
                        <div class="rounded-lg border border-dashed border-red-300 bg-white/95 p-6 text-center sm:col-span-2 xl:col-span-3">
                            <p class="font-bold text-red-800">Todavia no hay partidos futuros cargados.</p>
                            <p class="mt-1 text-sm text-gray-600">Si eres administrador, usa “Actualizar partidos” para traerlos desde la API.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="mt-10">
                <h3 class="mb-4 text-xl font-extrabold text-blue-950 sm:text-2xl">Partidos importados</h3>

                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white/95 shadow-md">
                    <ul class="divide-y divide-gray-200">
                        @forelse ($partidosImportados as $partido)
                            <li class="flex flex-wrap items-center justify-between gap-3 p-4">
                                <div>
                                    <p class="text-xs font-bold uppercase text-gray-500">
                                        {{ \Carbon\Carbon::parse($partido->fecha_inicio)->format('d M Y - h:i A') }} · {{ ucfirst($partido->estado) }}
                                    </p>
                                    <p class="mt-1 text-base font-black text-gray-900 flex items-center gap-1">
                                        <x-bandera :equipo="$partido->equipo_local" /> {{ $partido->equipo_local }} vs <x-bandera :equipo="$partido->equipo_visitante" /> {{ $partido->equipo_visitante }}
                                    </p>
                                </div>

                                <div class="rounded-md bg-blue-50 px-3 py-2 text-sm font-black text-blue-950">
                                    {{ $partido->goles_local ?? '-' }} - {{ $partido->goles_visitante ?? '-' }}
                                </div>
                            </li>
                        @empty
                            <li class="p-6 text-center">
                                <p class="font-bold text-blue-950">Aun no hay partidos importados.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </section>
        </div>

    </div>
</x-app-layout>
