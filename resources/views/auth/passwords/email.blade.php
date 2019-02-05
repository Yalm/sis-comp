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

                <md-field class="{{ $errors->has('email') ? 'md-invalid' : '' }}">
                    <md-icon>email</md-icon>
                    <label>Dirección de correo electrónico</label>
                    <md-input type='email' name="email" value="{{ old('email') }}" required autofocus></md-input>
                    @if ($errors->has('email'))
                        <span class="md-error">{{ $errors->first('email') }}</span>
                    @endif
                 </md-field>

                <div class="form-group">
                    <md-button class="md-raised md-primary" type="submit">Enviar enlace de restablecimiento</md-button>
                </div>
            </form>
            <a class="d-flex align-items-center back-login" href="{{ route('login') }}"><i class="material-icons">navigate_before</i> <span>Atrás para iniciar sesión</span></a>
        </div>
    </div>
</div>


@endsection
