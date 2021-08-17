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
                                <div class="text-center mb-4">
                                    <img src="{{asset("assets/images/logo.jpeg")}}" alt="">
                                </div>
                                <h1 class="mb-3 text-18">{{ __('Cambiar Contraseña') }}</h1>
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group">
                                        <label for="email">{{ __('Email') }}</label>
                                        <input id="email" class="form-control form-control-rounded  @error('email') is-invalid @enderror" type="email" 
                                        name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('Contraseña') }}</label>
                                        <input id="password" class="form-control form-control-rounded @error('password') is-invalid @enderror" 
                                        type="password" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm">{{ __('Contraseña') }}</label>
                                        <input id="password-confirm" class="form-control form-control-rounded" 
                                        type="password" name="password_confirmation" required autocomplete="new-password">

                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-block mt-2"> {{ __('Cambiar contraseña') }}</button>
    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
