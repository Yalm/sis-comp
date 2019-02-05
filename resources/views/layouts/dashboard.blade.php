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
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" v-bind:class="{ active:activeMenu }">
                    <a class="navbar-logo" >
                        <img src="{{ url('svg/logo.svg') }}" alt="logo" class="img-fluid">
                        <span class="ml-2 title-logo">Sis & Comp</span>
                    </a>
                </div>
                <div class="align-items-center d-flex justify-content-between">
                    <md-button class="md-icon-button md-primary" v-on:click="storeMenu()">
                        <md-icon>menu</md-icon>
                    </md-button>
                </div>
            </nav>
        </header>
        <sidebar-component :active="activeMenu" name="{{ Auth('user')->user()->name }}"></sidebar-component>
        <main class="content_wrapper" v-bind:class="{ active:activeMenu }">
            @yield('content')
        </main>
        <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <!-- Scripts -->
    @yield('myjsfile')
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
</body>

</html>
