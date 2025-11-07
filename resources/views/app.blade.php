<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/img/img-logo/recurso.png" type="image/x-icon" style="height: 40px; width: 40px;"
        class="favicon">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2E3A59">
    {{-- <link rel="icon" href="/img/img-logo/Logo_itzat.svg" type="image/svg+xml" /> --}}


    <title inertia>{{ config('app.name', 'Itz´at') }}</title>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    @inertia
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js')
                .then(() => console.log('✅ Service Worker registrado'))
                .catch(err => console.error('❌ Error al registrar el SW:', err));
        }
    </script>

</body>

</html>
