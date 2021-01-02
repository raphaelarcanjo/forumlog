@extends('templates.layout')
@section('title',$title)

@section('content')
    <div class="row">
        <div class="col s12 l8">
            <h1>Boas-vindas ao <span class="teal-text">Forum</span><span class="red-text text-accent-2">Log</span></h1>
            <h4>Seu Fórum e Blog num só lugar!</h4>

            <blockquote>
                <a href="{{url('user/register')}}">Cadastre-se</a> e aproveite para conferir os tópicos do fórum, postados pelos usuários já cadastrados.
            </blockquote>
        </div>

        <div class="col s12 l4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Login</span>
                    <form action="{{url('user/login')}}" method="post">
                        @csrf
                        <div class="input-field">
                            <label for="loginM">Login</label>
                            <input type="email" name="email" id="loginM" class="validate" required />
                        </div>
                        <div class="input-field">
                            <label for="passwordM">Senha</label>
                            <input type="password" name="password" id="passwordM" class="validate" required />
                        </div>
                        <div class="input-field center-align">
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" name="remember" value="1" />
                                    <span>Permanecer logado</span>
                                </label>
                            </p>
                        </div>
                        <div class="input-field center-align">
                            <button type="submit" class="waves-effect waves-light btn-small">Entrar</button>
                        </div>
                        <div class="input-field center-align">
                            <a href="{{url('user/recover')}}">Recuperar senha</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
