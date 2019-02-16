@extends('layouts.ecommerce')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-center">
        <form class="col-md-12 col-11 register-user mb-5" method="POST" action="{{ route('register') }}">
            @csrf
            <h2>Crea una cuenta</h2>
            <h4 class="register-text">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión en su lugar!</a></h4>

            <md-field class="{{ $errors->has('name') ? 'md-invalid' : '' }}">
                <md-icon>face</md-icon>
                <label>Nombre</label>
                <md-input type='text' name="name" value="{{ old('name') }}" required autofocus></md-input>
                @if ($errors->has('name'))
                    <span class="md-error">{{ $errors->first('name') }}</span>
                @endif
            </md-field>

            <md-field class="{{ $errors->has('email') ? 'md-invalid' : '' }}">
                <md-icon>email</md-icon>
                <label>Dirección de correo electrónico</label>
                <md-input type='email' name="email" value="{{ old('email') }}" required></md-input>
                @if ($errors->has('email'))
                    <span class="md-error">{{ $errors->first('email') }}</span>
                @endif
            </md-field>

            <md-field class="{{ $errors->has('password') ? 'md-invalid' : '' }}">
                <md-icon>lock</md-icon>
                <label>Contraseña </label>
                <md-input type="password" name="password" required></md-input>
                @if ($errors->has('email'))
                    <span class="md-error">{{ $errors->first('email') }}</span>
                @endif
            </md-field>

            <md-field>
                <md-icon>lock</md-icon>
                <label>Confirmar Contraseña </label>
                <md-input type="password" name="password_confirmation" required></md-input>
            </md-field>
            <div class="custom-control custom-checkbox check-p">
                <input type="checkbox" class="custom-control-input" id="terms" name="terms" v-validate="'required'">
                <label class="custom-control-label" for="terms">He leído y estoy de acuerdo con los <a href="/terms_and_conditions" class="hover_ch">términos y condiciones</a> de la web</label>
            </div>
            <md-button class="md-raised md-primary" type="submit">Registrarse</md-button>
        </form>
    </div>
</div>
@endsection
