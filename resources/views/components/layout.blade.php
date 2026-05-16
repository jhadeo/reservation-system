@props(
    ['title' => "Home"]
)

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title }}</title>

    @fonts

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <style>
        /*! tailwindcss v4.0.7 | MIT License | https://tailwindcss.com */
    </style>
    @endif
</head>

<body>
    <header class="flex justify-between align-middle items-center sticky top-0 z-50 bg-white shadow-md p-4 text-sm md:text-base text-center">
        <h1>Company name</h1>
        <nav role="navigation" class="flex items-center gap-4">
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/reserve-slot" class="px-4 py-2 rounded-2xl bg-black text-white font-bold">Reserve a slot now!</a>
        </nav>
    </header>

        {{$slot}}

</body>

</html>