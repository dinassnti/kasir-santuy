<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kasir Santuy') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .logo-kasir {
                width: 80px;
                height: 80px;
                background-color: #f3f4f6;
                border-radius: 8px;
                border: 2px solid #4b5563;
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 14px;
                font-weight: bold;
                color: #4b5563;
            }

            .logo-kasir::before {
                content: '';
                position: absolute;
                top: 10px;
                left: 10px;
                width: 60px;
                height: 40px;
                background-color: #1f2937;
                border-radius: 4px;
            }

            .logo-kasir .screen {
                position: absolute;
                top: 20px;
                left: 15px;
                width: 50px;
                height: 10px;
                background-color: #ffffff;
                border-radius: 3px;
            }

            .logo-kasir .drawer {
                position: absolute;
                bottom: 10px;
                left: 5px;
                width: 70px;
                height: 15px;
                background-color: #4b5563;
                border-radius: 4px;
            }

            .logo-kasir .text {
                position: absolute;
                font-size: 10px;
                top: 25px;
                color: #fff;
                font-weight: normal;
                display: none;
            }

            .logo-kasir:hover .text {
                display: block;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <!-- Logo Kasir -->
                <a href="/">
                    <div class="logo-kasir">
                        <div class="screen"></div>
                        <div class="drawer"></div>
                        <div class="text">Kasir Santuy</div>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
