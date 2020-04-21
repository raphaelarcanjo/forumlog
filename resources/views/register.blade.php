@extends('templates.layout')
@section('title',$title)

@section('content')
    <h3>Cadastro</h3>

    <form action="{{url('forumlog/user/register')}}" method="post">
        <div class="input-field">
            <input type="text" id="name" name="name" class="validate" maxlength="80" required />
            <label for="name">Nome completo</label>
        </div>
        <div class="input-field">
            <input type="text" id="regLogin" name="login" class="validate" required />
            <label for="regLogin">Nome único (login)</label>
            <small>Esse nome será usado para visitas ao seu blog por outros usuários e também para fazer login na usa conta.</small>
        </div>
        <div class="input-field">
            <input type="email" id="email" name="email" class="validate" maxlength="80" required />
            <label for="email">E-mail</label>
            <span class="helper-text" data-error="Formato de e-mail inválido" data-success="E-mail válido">Digite um e-mail válido</span>
        </div>
        <div class="input-field">
            <input type="password" id="regPassword" name="password" minlength="8" class="validate" required />
            <label for="regPassword">Senha</label>
            <span class="helper-text" data-error="A senha deve conter no mínimo 8 caracteres" data-success="Para sua segurança, use uma senha complexa">Digite uma senha segura</span>
        </div>
        <div class="input-field">
            <input type="password" id="confirm" name="confirm" required />
            <label for="confirm">Confirmar senha</label>
            <span id="confirmHelper" class="helper-text" data-error="As senhas não conferem" data-success="Senhas conferem">Confirme a sua senha</span>
        </div>
        <div class="input-field">
            <button type="submit" class="waves-effect waves-light btn">Enviar</button>
            <a href="{{url('forumlog/')}}" class="waves-effect waves-light red btn right">Voltar</a>
        </div>
    </form>
@endsection