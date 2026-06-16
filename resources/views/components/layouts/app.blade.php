@props(
['title' => "Home"]
)

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} " data-theme="corporate" >

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

<body class="flex flex-col min-h-screen">

    <main class="flex-1">
        {{$slot}}
    </main>
    
</body>

</html>