@extends('layouts.extern')

@section('content')
    <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
        <div class="container">
            <div class="py-4">
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <div class="container mt--200">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary border-0 mb-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="alert-text">Email ou senha invalida</span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="form-group mb-3 {{ $errors->any() ? 'has-danger' : null }}">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text {{ $errors->any() ? 'text-danger' : null }}"><i
                                                    class="fas fa-envelope"></i></span>
                                    </div>
                                    <input class="form-control {{ $errors->any() ? 'is-invalid' : null }}"
                                           placeholder="Email" type="email" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus
                                    >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="Password" type="password"
                                           name="password" required autocomplete="current-password">
                                </div>
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" id="customCheckLogin" type="checkbox"
                                       name="remember" {{ old('remember') ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-muted">Manter sessão</span>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <a href="#" class="text-light">
                            <small>Esqueceu sua senha?</small>
                        </a>
                    </div>
                    <div class="col-6 text-right">
                        <a href="#" class="text-light">
                            <small>Contato com suporte</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
