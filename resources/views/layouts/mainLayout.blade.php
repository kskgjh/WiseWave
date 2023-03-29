<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="icon" href="{{asset('assets/imgs/favicon.png')}}">
    @livewire('fontawesome')

    @yield('links')
    @livewireStyles
    <title>@yield('title')</title>
</head>
<body class="sticky">
    @livewire('header')

    <main>
    @yield('main')
    </main>

    <footer>
        @yield('footer')
    </footer>

    @vite('resources/js/app.js')
    @livewireScripts
</body>
</html>