<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $_ENV['APP_NAME'] }} - {{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    {{ $slot }}
    @livewireScripts
</body>

</html>
