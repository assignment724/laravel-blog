<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col md:flex-row">
            <div class="hidden md:flex md:w-1/2 bg-indigo-600 flex-col justify-center items-center p-8">
                <div class="max-w-md">
                    <a href="/" class="flex justify-center mb-8">
                        <x-application-logo class="w-20 h-20 fill-current text-white" />
                    </a>
                    <h1 class="text-4xl font-bold text-white mb-4">Welcome to Our School Blog</h1>
                    <p class="text-indigo-100 text-lg">Share knowledge, inspire minds, and connect with our educational community.</p>
                </div>
            </div>

            <div class="flex-1 flex flex-col justify-center items-center p-6 bg-gray-50">
                <div class="md:hidden mb-6">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="w-full sm:max-w-md bg-white shadow-md overflow-hidden sm:rounded-lg p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>