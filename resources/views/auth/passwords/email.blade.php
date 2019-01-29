@extends('layouts.ecommerce')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12  col-11 forgot-password">
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h2>¿Olvidaste tu contraseña?</h2>
            <p>Por favor ingrese la dirección de correo electrónico que usó para registrarse. Recibirá un enlace temporal
                para restablecer su contraseña.</p>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group from-siscom">
                    <input id="email" type="email" class="input-siscom form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        name="email" value="{{ old('email') }}" aria-label="Dirección de correo electrónico" required placeholder="Dirección de correo electrónico">
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

                <div class="form-group">
                    <button type="submit" class="btn-siscom">
                        Enviar enlace de restablecimiento
                    </button>
                </div>
            </form>
            <a class="d-flex align-items-center back-login" href="{{ route('login') }}"><i class="material-icons">navigate_before</i> <span>Atrás para iniciar sesión</span></a>
        </div>
    </div>
</div>


@endsection
