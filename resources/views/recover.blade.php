@extends('templates.layout')
@section('title',$title)

@section('content')
    <h4>Criar nova senha</h4>

    @if ($valid)
        <form action="{{url('forumlog/user/recover')}}" method="post">
            @csrf
            <input type="hidden" name="recover" value="recover">
            <input type="hidden" name="user" value="{{$user}}">

            <div class="input-field">
                <input type="password" id="regPassword" name="password" minlength="8" class="validate" required />
                <label for="regPassword">Senha</label>
                <span class="helper-text" data-error="A senha deve conter no mínimo 8 caracteres" data-success="Para sua segurança, use uma senha complexa">Digite uma senha segura</span>
            </div>
            <div class="input-field">
                <input type="password" id="confirm" name="password_confirmation" onfocusout="confirmPass()" required />
                <label for="confirm">Confirmar senha</label>
                <span id="confirmHelper" class="helper-text" data-error="As senhas não conferem" data-success="Senhas conferem">Confirme a sua senha</span>
            </div>
            <div class="input-field">
                <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                <a href="{{url('forumlog/')}}" class="waves-effect waves-light red btn right">Voltar</a>
            </div>
        </form>
    @else
        <form action="{{url('forumlog/user/recover')}}" method="post">
            @csrf
            <div class="input-field">
                <input type="email" id="regemail" name="email" minlength="8" class="validate" required />
                <label for="regemail">E-mail</label>
            </div>
            <div class="input-field">
                <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                <a href="{{url('forumlog/')}}" class="waves-effect waves-light red btn right">Voltar</a>
            </div>
        </form>
    @endif
@endsection