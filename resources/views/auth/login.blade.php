@extends('layouts.ecommerce')

@section('content')

<div class="login container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-5 col-11">
            <h3>NUEVOS CLIENTES</h3>
            <p>Al crear una cuenta en nuestra tienda, podrá moverse a través del proceso de pago más rápido, almacenar
                múltiples direcciones de envío, ver y rastrear sus pedidos en su cuenta y más.</p>
            <a href="{{ route('register') }}" class="btn-siscom">Crea una cuenta</a>
        </div>
        <form class="col-md-7 login-cont col-11" method="POST" action="{{ route('login') }}">
            @csrf
            <h3>INGRESE A SU CUENTA</h3>
            <div class="form-group from-siscom">
                <input type="email" class="input-siscom form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email" value="{{ old('email') }}" aria-label="Dirección de correo electrónico" required placeholder="Dirección de correo electrónico"
                    autofocus>

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @else
                    <span class="focus-border">
                        <i></i>
                    </span>
                @endif
            </div>


            <div class="form-group from-siscom">
                <input type="password" class="input-siscom form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" placeholder="Contraseña" aria-label="Contraseña" required>
                @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @else
                <span class="focus-border">
                    <i></i>
                </span>
                @endif
            </div>

            <div class="content-buttons d-flex align-items-center">
                @if (Route::has('password.request'))
                <a class="btn btn-link forgot" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
                <!--<button class="btn-google" type="button">
                    <span class="d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48">
                            <defs>
                                <path id="a" d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                            </defs>
                            <clipPath id="b">
                                <use xlink:href="#a" overflow="visible" />
                            </clipPath>
                            <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                            <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                            <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                            <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                        </svg>
                        <span>Iniciar sesión con google</span>
                    </span>
                </button>-->
                <button type="submit" class="btn-siscom">Iniciar Sesión</button>
            </div>
        </form>
    </div>
</div>
@endsection
