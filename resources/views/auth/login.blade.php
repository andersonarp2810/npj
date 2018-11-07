@extends('layouts.base')

@section('title')
NPJ - SISTEMA
@endsection

@section('content')
    <div class="container bg-home">
        <div style="height: 100vh;" class="row align-items-center justify-content-center">
            <div class="col-lg-5 col-md-8 col-10">
                
                <div style="border-radius: 2%" class="card">
                    <div class="card-body">
                        <div class="box-parent-login">
                            <div class="well bg-white box-login">
                                <div class="text-center mb-3">
                                    <img src="{{URL::asset('assets/img/logo-NPJ.png')}}" class="img-fluid" style="height:100px;">
                                </div>
                                
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <fieldset>

                                        @if(Session::has('erro'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ Session::get('erro') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>                  
                                        @endif

                                        <div class="form-group ls-login-user">

                                            <input class="form-control ls-login-bg-user input-lg form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" type="email" aria-label="Email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                                            <!--
                                            @#if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <strong>Email inválido</strong>
                                                </span>
                                            @#endif
                                            -->
                                        </div>

                                        <div class="form-group ls-login-password">

                                            <input class="form-control ls-login-bg-password input-lg form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="userPassword" type="password" name="password"  aria-label="Senha" placeholder="Senha" required>
                                            
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback">
                                                    <!--strong>Senha Inválida</strong-->
                                                    <strong>Credenciais inválidas</strong>
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
    </div>
@endsection
