<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

{{-- 🔹 Title (nama tab browser) --}}
<title>{{ $title ?? 'Ampel' }}</title>

{{-- 🔹 Favicon (ikon tab browser) --}}
<link rel="icon" type="image/png" href="{{ asset('assets/img/Pictorial Mark Logo - AMPEL.png') }}" sizes="32x32">
<link rel="shortcut icon" href="{{ asset('assets/img/Pictorial Mark Logo - AMPEL.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/img/Pictorial Mark Logo - AMPEL.png') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
