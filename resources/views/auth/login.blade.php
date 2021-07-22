@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                <div class="auth-logo text-center mb-4">
                                    <img src="assets/images/logo.png" alt="">
                                </div>
                                <h1 class="mb-3 text-18">{{ __('Iniciar Sesión') }}</h1>
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">{{ __('Usuario') }}</label>
                                        <input id="email" class="form-control form-control-rounded  @error('email') is-invalid @enderror" type="email" 
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('Contraseña') }}</label>
                                        <input id="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" 
                                        type="password" name="password" required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-block mt-2"> {{ __('Ingresar') }}</button>

                                </form>
                                    @if (Route::has('password.request'))
                                    <div class="mt-3 text-center">
                                        <a href="{{ route('password.request') }}" class="text-muted"><u>{{ __('¿Olvidó su contraseña?') }}</u></a>
                                    </div>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
