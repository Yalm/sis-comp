<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sis & Comp, lo mejor en equipos de computo y accesorios</title>
    <meta name="description" content="Sis & Comp Perú lo mejor en equipos de computo y accesorios, solo las mejores marcas">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/ecommerce.css') }}" rel="stylesheet">
</head>

<body>
    <div id="ecommerce">
        <header>
            <nav class="navbar container header-top">
                <a class="navbar-brand header_title flex-grow-1" href="{{ url('/') }}">SIS & COMP</a>
                <form action="{{ url('shop') }}" method="get" class="search-ui p-2 d-flex align-items-center">
                    <input type="text" aria-label="search products" name="search" placeholder="Buscar..." class="search-input"
                        autocomplete="off">
                    <button type="submit" aria-label="search products">
                        <i class="material-icons">search</i>
                    </button>
                </form>
                @guest
                <a  title="Login" class="p-2 account_circle_login" href="{{ url('login') }}"><i class="material-icons">account_circle</i></a>
                @else
                <div class="user-circle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <img src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png" class="img-fluid" alt="customer photo">
                </div>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ url('/profile') }}">Perfil</a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        Salir
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                @endguest
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
                        <a class="nav-link" href="{{ url('/shop?page=1') }}">Tienda</a>
                    </li>
                    <li class="item-page">
                        <a class="nav-link" href="{{ url('/contact') }}">Contáctanos</a>
                    </li>
                    <li class="item-page mobile">
                        <button title="show menu" type="button" class="nav-link d-flex align-items-center">
                            <span>Menu</span>
                            <i class="material-icons">menu</i>
                        </button>
                    </li>
                </ul>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="footer-title-items">SIS & COMP</h2>
                        <a class="item-link" href="/terms_and_conditions">Terms & Condiciones</a>
                        <a class="item-link" href="/about">Nosotros</a>
                    </div>
                    <div class="col-md-4">
                        <h2 class="footer-title-items">Productos</h2>
                        @foreach ($providerCategories as $category)
                        <a class="item-link" href="/shop?category={{$category->id}}">{{ $category->name }}</a>
                        @break($loop->index == 5)
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        <h2 class="footer-title-items"> DETALLES DE CONTACTO</h2>
                        <p class="d-flex align-items-center item-link"><i class="material-icons">location_on</i><span class="ml-2">Jr.Loreto #594 - Huancayo</span></p>
                        <p class="d-flex align-items-center item-link"><i class="material-icons">phone</i><span class="ml-2">(064) 782433</span></p>
                        <p class="d-flex align-items-center item-link"><i class="material-icons">email</i><span class="ml-2">soporte@tiendassiscomp.com</span></p>
                    </div>
                    <div class="col-12 text-center copyright">
                        <span>© {{ date('Y') }} SIS & COM todos los derechos reservados</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    @yield('myjsfile')
    <script src="{{ asset('js/ecommerce.js') }}" defer></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-134452397-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-134452397-1');
    </script>
</body>
</html>
