<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="vapid-public-key" content="{{ config('webpush.vapid.public_key') }}">

    <title>{{ $title ?? 'Service Reminder' }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

@php
    $unread = auth()->user()->unreadNotifications()->count();
@endphp

<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">

    <div class="container">

        <a class="navbar-brand" href="{{ route('dashboard') }}">
            Service Reminder
        </a>

        <div class="d-flex flex-wrap gap-2 align-items-center">

            <a class="btn btn-sm btn-outline-light"
               href="{{ route('clients.index') }}">
                Clients
            </a>

            <a class="btn btn-sm btn-outline-light"
               href="{{ route('service-types.index') }}">
                Service Types
            </a>

            <a class="btn btn-sm btn-outline-light"
               href="{{ route('client-services.index') }}">
                Services
            </a>

            <a class="btn btn-sm btn-outline-light position-relative"
               href="{{ route('notifications.index') }}">
                Notifications

                @if($unread)
                    <span class="badge bg-danger">
                        {{ $unread }}
                    </span>
                @endif
            </a>

            <button
                id="enable-push"
                type="button"
                class="btn btn-sm btn-warning">
                🔔 Enable Browser Notifications
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button class="btn btn-sm btn-secondary">
                    Logout
                </button>
            </form>

        </div>
    </div>
</nav>

<main class="container pb-5">

    @if(session('ok'))
        <div class="alert alert-success">
            {{ session('ok') }}
        </div>
    @endif

    @if($errors->any())

        <div class="alert alert-danger">
            <ul class="mb-0">

                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach

            </ul>
        </div>

    @endif

    @yield('content')

</main>

<script src="{{ asset('js/push.js') }}"></script>

</body>
</html>