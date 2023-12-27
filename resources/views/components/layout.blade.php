<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Restaurant Reservation</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="mx-auto mt-10 max-w-2xl bg-slate-200 text-slate-700 bg-gradient-to-r from-red-100 from-10% to-yellow-100 to-90%">
        @livewireScripts

        <nav class="mb-8 flex justify-end text-lg font-medium">
            <ul class="flex space-x-2">
                @auth
                <li>
                    <a href="{{ route('restaurants.index') }}">
                        Restaurants
                    </a>
                </li>
                <li>
                    <form action="{{ route('auth.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Logout</button>
                    </form>
                </li>
                @else
                    <a href="{{ route('auth.create')}}">Sign in</a>
                @endauth
            </ul>
        </nav>

        @if(session('success'))
            <div role="alert" class="my-8 rounded-md border-l-4 border-green-300 bg-green-100 p-4 text-green-700 opacity-75">
                <p class="font-bold">
                    Success!
                </p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div role="alert" class="my-8 rounded-md border-l-4 border-red-300 bg-red-100 p-4 text-red-700 opacity-75">
                <p class="font-bold">
                    Error!
                </p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{ $slot }}
    </body>
</html>
