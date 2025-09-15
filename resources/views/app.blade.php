<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
    </body>
</html>
