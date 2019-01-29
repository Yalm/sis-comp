@extends('layouts.ecommerce')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <form class="col-md-12 col-11 register-user mb-5" method="POST" action="{{ route('register') }}">
            @csrf
            <h2>Crea una cuenta</h2>
            <h4 class="register-text">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión en su lugar!</a></h4>
            <div class="form-group from-siscom">
                <input id="name" type="text" class="input-siscom form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    name="name" value="{{ old('name') }}" placeholder="Nombre" required autofocus>
                @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @else
                <span class="focus-border">
                    <i></i>
                </span>
                @endif
            </div>

            <div class="form-group from-siscom">
                <input id="email" type="email" class="input-siscom form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email" value="{{ old('email') }}" placeholder="Dirección de correo electrónico" required>
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
                <input id="password" type="password" class="input-siscom form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                    name="password" placeholder="Contraseña" required>
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

            <div class="form-group from-siscom">
                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="input-siscom form-control"
                    name="password_confirmation" required>
                @if (!$errors->has('password'))
                <span class="focus-border">
                    <i></i>
                </span>
                @endif
            </div>
            <div class="custom-control custom-checkbox check-p">
                <input type="checkbox" class="custom-control-input" id="terms" name="terms" v-validate="'required'">
                <label class="custom-control-label" for="terms">He leído y estoy de acuerdo con los <a href="/terms_and_conditions" class="hover_ch">términos y condiciones</a> de la web</label>
            </div>
            <button type="submit" class="btn-siscom d-block">Registrarse</button>
        </form>
    </div>
</div>
@endsection
