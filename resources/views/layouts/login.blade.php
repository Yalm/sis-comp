<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','Admin - Sis & Comp, lo mejor en equipos de computo y accesorios')</title>
    <meta name="robots" content="noindex,follow" />
    <meta name="description" content="Sis & Comp Perú lo mejor en equipos de computo y accesorios, solo las mejores marcas">

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
</head>
    <body>
        <div id="dashboard">
            <div>
                @yield('content')
            </div>
        </div>
        <!-- Scripts -->
        @yield('myjsfile')
        <script src="{{ asset('js/dashboard.js') }}" defer></script>
    </body>
</html>

