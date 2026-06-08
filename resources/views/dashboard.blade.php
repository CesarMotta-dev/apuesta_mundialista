<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-2 sm:space-x-4 w-full md:w-auto justify-center md:justify-start">
                <img src="{{ asset('imagenes/copa_mundial.png') }}" alt="copa mundial" class="h-10 sm:h-12 md:h-14 drop-shadow-md shrink-0">
                <h2 class="font-black text-lg sm:text-2xl md:text-3xl text-blue-900 leading-tight text-center md:text-left">
                    La Polla Mundialista
                </h2>
            </div>

            <img src="https://upload.wikimedia.org/wikipedia/commons/a/aa/FIFA_logo_without_slogan.svg" alt="FIFA Logo" class="h-6 sm:h-8 md:h-10 drop-shadow-md hidden md:block shrink-0">
        </div>
    </x-slot>

    <div class="relative py-4 sm:py-8 md:py-12 min-h-screen bg-fixed bg-center bg-cover bg-no-repeat" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/2/21/Flag_of_Colombia.svg');">

        <div class="absolute inset-0 bg-white/85 backdrop-blur-sm"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">

            <div class="mb-8 sm:mb-10">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-red-700 mb-4 border-b-4 border-yellow-400 pb-2 inline-block drop-shadow-sm px-2 sm:px-0">
                    🔥 Partidos Abiertos
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
                    @foreach ($partidos as $partido)
                        @if(\Carbon\Carbon::parse($partido->fecha_inicio)->isFuture())
                            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border-t-8 border-yellow-400 transform transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                                <div class="p-4 sm:p-6 text-center">
                                    <div class="text-xs sm:text-sm text-gray-500 mb-3 font-bold bg-gray-100 rounded-full py-1 px-3 inline-block">
                                        ⏱️ Cierra: {{ \Carbon\Carbon::parse($partido->fecha_inicio)->format('d M Y - h:i A') }}
                                    </div>

                                    <div class="flex items-center justify-between gap-1 sm:gap-2 text-lg sm:text-2xl font-black text-blue-900 my-4 sm:my-6 w-full">
                                        <span class="text-center flex-1 leading-tight break-words">{{ $partido->equipo_local }}</span>
                                        <span class="text-red-600 text-sm sm:text-lg shrink-0 px-1">VS</span>
                                        <span class="text-center flex-1 leading-tight break-words">{{ $partido->equipo_visitante }}</span>
                                    </div>

                                    <a href="#" class="inline-flex items-center justify-center mt-2 w-full min-h-[44px] bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-4 rounded-xl transition duration-300 shadow-md text-sm sm:text-base">
                                        ¡Hacer mi jugada! 🇨🇴
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-8 sm:mt-12">
                <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-blue-900 mb-4 border-b-4 border-red-600 pb-2 inline-block drop-shadow-sm px-2 sm:px-0">
                    🏆 Resultados y Ganancias
                </h3>

                <div class="bg-white/95 overflow-hidden shadow-2xl rounded-2xl border border-gray-200">
                    <ul class="divide-y divide-gray-200">
                        @foreach ($partidos as $partido)
                            @if(\Carbon\Carbon::parse($partido->fecha_inicio)->isPast())
                                <li class="p-4 sm:p-5 flex flex-wrap lg:flex-nowrap items-center justify-between hover:bg-yellow-50 transition duration-150 gap-4">
                                    <div class="flex flex-col text-center sm:text-left w-full lg:w-auto flex-1">
                                        <span class="text-xs sm:text-sm text-gray-500 font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($partido->fecha_inicio)->format('d M') }} - {{ ucfirst($partido->estado) }}</span>

                                        <div class="flex items-center justify-center sm:justify-start flex-wrap gap-2 mt-2 font-black text-base sm:text-xl text-gray-800">
                                            <span class="text-center">{{ $partido->equipo_local }}</span>
                                            <span class="bg-blue-900 text-white px-3 py-1 rounded-lg shadow-inner whitespace-nowrap shrink-0">
                                                {{ $partido->goles_local ?? 0 }} - {{ $partido->goles_visitante ?? 0 }}
                                            </span>
                                            <span class="text-center">{{ $partido->equipo_visitante }}</span>
                                        </div>
                                    </div>

                                    <div class="w-full lg:w-auto mt-2 lg:mt-0 shrink-0">
                                        <button class="w-full lg:w-auto min-h-[44px] inline-flex items-center justify-center px-4 py-2 rounded-full text-sm font-extrabold bg-green-500 text-white shadow-md hover:bg-green-600 transition">
                                            Ver ganancias 💰
                                        </button>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
