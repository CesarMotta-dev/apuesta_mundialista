@props(['equipo'])

@php
    $codigos = [
        'Mexico' => 'mx',
        'Sudafrica' => 'za',
        'Corea del Sur' => 'kr',
        'Republica Checa' => 'cz',
        'Canada' => 'ca',
        'Bosnia y Herzegovina' => 'ba',
        'Qatar' => 'qa',
        'Suiza' => 'ch',
        'Brasil' => 'br',
        'Marruecos' => 'ma',
        'Haiti' => 'ht',
        'Escocia' => 'gb-sct',
        'Estados Unidos' => 'us',
        'Paraguay' => 'py',
        'Australia' => 'au',
        'Turquia' => 'tr',
        'Argentina' => 'ar',
        'Egipto' => 'eg',
        'Dinamarca' => 'dk',
        'Japon' => 'jp',
        'Inglaterra' => 'gb-eng',
        'Colombia' => 'co',
        'Costa de Marfil' => 'ci',
        'Croacia' => 'hr',
        'España' => 'es',
        'Nigeria' => 'ng',
        'Ecuador' => 'ec',
        'Suecia' => 'se',
        'Francia' => 'fr',
        'Senegal' => 'sn',
        'Uruguay' => 'uy',
        'Iran' => 'ir',
        // Fallbacks o adiciones si vienen más de la API
        'Polonia' => 'pl',
        'Arabia Saudita' => 'sa',
        'Gales' => 'gb-wls',
        'Tunez' => 'tn',
        'Costa Rica' => 'cr',
        'Alemania' => 'de',
        'Belgica' => 'be',
        'Serbia' => 'rs',
        'Camerun' => 'cm',
        'Portugal' => 'pt',
        'Ghana' => 'gh',
        'Paises Bajos' => 'nl',
    ];

    $codigo = $codigos[$equipo] ?? null;
@endphp

@if($codigo)
    <img src="https://flagcdn.com/w40/{{ $codigo }}.png" alt="Bandera de {{ $equipo }}" class="inline-block h-4 w-auto rounded-sm border border-gray-200 shadow-sm align-middle mx-1" title="{{ $equipo }}">
@endif
