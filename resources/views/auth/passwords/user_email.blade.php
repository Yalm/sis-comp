@extends('layouts.login')
@section('content')
<div class="container">
    <form class="row d-flex justify-content-center pt-5" method="POST" action="{{ route('user.password.email') }}">
        @csrf
        <md-card class="col-lg-5 col-md-6 mt-5 col-11">
            <md-card-header>
                <div class="md-title">¿Olvidaste tu contraseña?</div>
            </md-card-header>
            <md-card-content>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="p-l-20">Por favor ingrese la dirección de correo electrónico que usó para registrarse. Recibirá un enlace temporal para restablecer su contraseña.</p>
                <md-field class="{{ $errors->has('email') ? 'md-invalid' : '' }}">
                    <md-icon>email</md-icon>
                    <label>Dirección de correo electrónico</label>
                    <md-input type='email' name="email" value="{{ old('email') }}" required autofocus></md-input>
                    @if ($errors->has('email'))
                        <span class="md-error">{{ $errors->first('email') }}</span>
                     @endif
                </md-field>
                <p>¿Recuerdas tu contraseña? <a href="{{ route('user.login') }}">Iniciar Sesión</a></p>
            </md-card-content>
            <md-card-actions>
                <md-button class="md-raised md-primary" type="submit">Enviar enlace de restablecimiento</md-button>
            </md-card-actions>
        </md-card>
    </form>
</div>
@endsection


