<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center">

    <div class="text-center">
        <div class="mb-6">
            <h1 class="text-4xl font-bold text-gray-900">
                {{ config('app.name', 'Laravel') }}
            </h1>

            <p class="mt-2 text-gray-500">
                Service Reminder System
            </p>
        </div>

        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="inline-block px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800"
            >
                Go to Dashboard
            </a>
        @else
            <a
                href="{{ route('login') }}"
                class="inline-block px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800"
            >
                Login
            </a>
        @endauth
    </div>

</body>
</html>