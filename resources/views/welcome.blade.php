<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'The Journey Couples Retreat') }}</title>

        @fonts

       @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <main>
            <div class="flex items-center justify-center w-full min-h-screen space-y-20 flex-col">
                <img src="{{ asset('logo.png') }}" class="w-1/2"/>
                <p class="text-sm text-gray-300">This website is under development</p>
            </div>
        </main>
    </body>
</html>
