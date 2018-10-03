@extends('layouts.base')

@section('title')
NPJ - SISTEM
@endsection

@section('content')

    <div class="row justify-content-center mt-5">
        <div class="col-md-5 mt-5">
            
            <div class="card mt-5">
                <div class="card-body">
                    <div class="box-parent-login">
                        <div class="well bg-white box-login">
                            <h1 style="font-size: 70px" class="ls-login-logo text-center">
                                NPJ                                
                                <!--<img src="{{URL::asset('storage/logo.png')}}" class="img-responsive img-thumbnail" style="width:450px; height:160px; margin:0 auto">-->
                            </h1>
                            <h5 class="text-center mb-4">Núcleo de Práticas Jurídicas</h5>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <fieldset>

                                    <div class="form-group ls-login-user">

                                        <input class="form-control ls-login-bg-user input-lg form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" aria-label="Email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>Email inválido</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group ls-login-password">

                                        <input class="form-control ls-login-bg-password input-lg form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="userPassword" type="password" name="password"  aria-label="Senha" placeholder="Senha" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>Senha Inválida</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <input type="submit" value="Entrar" class="btn btn-dark btn-lg btn-block mt-4">

                                </fieldset>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>

                
        </div>
    </div>

@endsection
