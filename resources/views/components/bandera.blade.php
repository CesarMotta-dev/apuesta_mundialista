@props(['equipo'])

@php
    $codigos = [
        'Mexico' => 'mx',
        'South Africa' => 'za',
        'South Korea' => 'kr',
        'Canada' => 'ca',
        'Qatar' => 'qa',
        'Switzerland' => 'ch',
        'Brazil' => 'br',
        'Morocco' => 'ma',
        'Haiti' => 'ht',
        'Scotland' => 'gb-sct',
        'USA' => 'us',
        'Paraguay' => 'py',
        'Australia' => 'au',
        'Germany' => 'de',
        'Curaçao' => 'cw',
        'Côte d\'Ivoire' => 'ci',
        'Ecuador' => 'ec',
        'Netherlands' => 'nl',
        'Japan' => 'jp',
        'Tunisia' => 'tn',
        'Belgium' => 'be',
        'Egypt' => 'eg',
        'IR Iran' => 'ir',
        'New Zealand' => 'nz',
        'Spain' => 'es',
        'Cabo Verde' => 'cv',
        'Saudi Arabia' => 'sa',
        'Uruguay' => 'uy',
        'France' => 'fr',
        'Senegal' => 'sn',
        'Norway' => 'no',
        'Argentina' => 'ar',
        'Algeria' => 'dz',
        'Austria' => 'at',
        'Jordan' => 'jo',
        'Portugal' => 'pt',
        'Uzbekistan' => 'uz',
        'Colombia' => 'co',
        'England' => 'gb-eng',
        'Croatia' => 'hr',
        'Ghana' => 'gh',
        'Panama' => 'pa',
        
        // Spanish fallbacks just in case
        'Sudafrica' => 'za',
        'Corea del Sur' => 'kr',
        'Republica Checa' => 'cz',
        'Bosnia y Herzegovina' => 'ba',
        'Suiza' => 'ch',
        'Brasil' => 'br',
        'Marruecos' => 'ma',
        'Turquia' => 'tr',
        'Egipto' => 'eg',
        'Dinamarca' => 'dk',
        'Inglaterra' => 'gb-eng',
        'Costa de Marfil' => 'ci',
        'España' => 'es',
        'Nigeria' => 'ng',
        'Suecia' => 'se',
        'Iran' => 'ir',
        'Polonia' => 'pl',
        'Arabia Saudita' => 'sa',
        'Gales' => 'gb-wls',
        'Tunez' => 'tn',
        'Costa Rica' => 'cr',
        'Alemania' => 'de',
        'Belgica' => 'be',
        'Serbia' => 'rs',
        'Camerun' => 'cm',
        'Paises Bajos' => 'nl',
    ];

    $codigo = $codigos[$equipo] ?? null;

    // Si es un equipo por definir o "Winner", usamos una bandera genérica (ej. ONU o una en blanco)
    if (!$codigo && (str_contains($equipo, 'Winner') || str_contains($equipo, 'Por definir') || preg_match('/^[0-9]/', $equipo))) {
        // 'un' es United Nations, sirve como genérico
        $codigo = 'un';
    }
@endphp

@if($codigo)
    <img src="https://flagcdn.com/w40/{{ $codigo }}.png" alt="Bandera de {{ $equipo }}" class="inline-block h-4 w-auto rounded-sm border border-gray-200 shadow-sm align-middle mx-1" title="{{ $equipo }}">
@endif
