@extends('templates.layout')
@section('title',$title)

@section('content')
    <h4>Criar nova senha</h4>

    <form action="{{url('user/recover')}}" method="post">
        @csrf
        @if (request()->has('email'))
            <input type="hidden" id="regemail" name="email" minlength="8" value="{{ request()->get('email') }}" />
        @else
            <div class="input-field">
                <input type="email" id="regemail" name="email" minlength="8" class="validate" required />
                <label for="regemail">E-mail</label>
            </div>
        @endif

        @isset ($token)
            <input type="hidden" name="token" value="{{$token ?? old('token')}}">

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
        @endisset

        <div class="input-field">
            <a href="{{url('/')}}" class="waves-effect waves-light red btn">Voltar</a>
            <button type="submit" class="waves-effect waves-light btn right">Enviar</button>
        </div>
    </form>
@endsection
