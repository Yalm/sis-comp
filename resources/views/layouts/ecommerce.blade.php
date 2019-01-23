<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sis & Comp, lo mejor en equipos de computo y accesorios</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/ecommerce.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/ecommerce.css') }}" rel="stylesheet">
</head>

<body>
    <div id="ecommerce">
        <header>
            <nav class="navbar container header-top">
                <a class="navbar-brand header_title flex-grow-1" href="{{ url('/') }}">SIS & COMP</a>
                <form action class="search-ui p-2 d-flex align-items-center">
                    <input type="text" aria-label="search products" name="search" placeholder="Search..." class="search-input"
                        autocomplete="off">
                    <button type="submit" aria-label="search products">
                        <i class="material-icons">search</i>
                    </button>
                </form>
                <cart-modal-component :count="count"></cart-modal-component>
            </nav>

            <nav class="top-menu">
                <ul class="d-flex top-menu-content container">
                    <li class="item-page">
                        <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="item-page">
                        <a class="nav-link" href="{{ url('/about') }}">Nosotros</a>
                    </li>
                    <li class="item-page">
                        <a class="nav-link" href="{{ url('/shop') }}">Tienda</a>
                    </li>
                    <li class="item-page">
                        <a class="nav-link" href="{{ url('/contact') }}">Contáctanos</a>
                    </li>
                    <li class="item-page mobile">
                        <button title="show menu" type="button" class="nav-link">
                            Menu
                            <i class="material-icons">menu</i>
                        </button>
                    </li>
                </ul>
            </nav>
        </header>

        <div class="container">
            <div class="row">@yield('content')</div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="footer-title-items">SIS & COMP</h2>
                        <a class="item-link" href="">Envios</a>
                        <a class="item-link" href="">Nosotros</a>
                        <a class="item-link" href="">Seguridad de pago</a>
                    </div>
                    <div class="col-md-4">
                        <h2 class="footer-title-items">Productos</h2>
                        <a class="item-link" href="">Envios</a>
                        <a class="item-link" href="">Nosotros</a>
                        <a class="item-link" href="">Seguridad de pago</a>
                    </div>
                    <div class="col-md-4">
                        <h2 class="footer-title-items"> DETALLES DE CONTACTO</h2>
                    </div>
                    <div class="col-12 text-center copyright">
                        <span>© {{ date('Y') }} SIS & COM todos los derechos reservados</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>
