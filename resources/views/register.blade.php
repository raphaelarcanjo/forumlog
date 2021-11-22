@extends('templates.layout')
@section('title', $title)

@section('content')
    <h4>Cadastro</h4>

    <form action="{{url('user/register')}}" method="post">
        @csrf
        <div class="row">
            <div class="input-field col s12 m9">
                <input value="{{ $name ?? old('name') }}" type="text" id="name" name="name" class="validate" required />
                <label for="name">Nome completo</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $birth ?? old('birth') }}" type="text" id="birth" name="birth" class="validate datepicker date" required />
                <label for="birth" class="active">Data de nascimento</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4">
                <input value="{{ $username ?? old('username') }}" type="text" id="username" name="username" pattern="[a-z0-9.]{8,24}" minlength="8" maxlength="24" class="validate" onchange="tagAddress()" required />
                <label for="username">Nome único (login)</label>
                <span class="helper-text" data-error="Apenas letras minúsculas sem espaço e números. Tamanho entre 8 e 24 caracteres" data-success="" id="tagUrl">
                    Esse nome será usado para visitas ao seu blog por outros usuários e também para fazer login na usa conta.
                </span>
            </div>
            <div class="input-field col s12 m8">
                <input value="{{ $email ?? old('email') }}" type="email" id="email" name="email" class="validate" required />
                <label for="email">E-mail</label>
                <span class="helper-text" data-error="Formato de e-mail inválido" data-success="E-mail válido">Digite um e-mail válido</span>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4">
                <input value="{{ $phones[0] != null?$phones[0]:'' ?? old('phones')[0] }}" type="text" class="phone" minlength="14" maxlength="15" id="phone1" name="phones[]" />
                <label for="phone1">Telefone 1</label>
            </div>
            <div class="input-field col s12 m4">
                <input value="{{ $phones[1] != null?$phones[1]:'' ?? old('phones')[1] }}" type="text" class="phone" minlength="14" maxlength="15" id="phone2" name="phones[]" />
                <label for="phone2">Telefone 2</label>
            </div>
            <div class="input-field col s12 m4">
                <input value="{{ $phones[2] != null?$phones[2]:'' ?? old('phones')[2] }}" type="text" class="phone" minlength="14" maxlength="15" id="phone3" name="phones[]" />
                <label for="phone3">Telefone 3</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m2">
                <input value="{{ $cep ?? old('cep') }}" type="text" id="cep" name="cep" minlength="9" maxlength="9" class="validate cep" onchange="getAddress()" required />
                <label for="cep">CEP</label>
                <span class="helper-text" data-error="Digite apenas números" data-success="" id="cepMsg">Digite apenas números</span>
            </div>
            <div class="input-field col s12 m5">
                <input value="{{ $address ?? old('address') }}" type="text" id="address" name="address" class="validate" required />
                <label class="" for="address">Endereço</label>
            </div>
            <div class="input-field col s12 m5">
                <input value="{{ $complement ?? old('complement') }}" type="text" id="complement" name="complement" class="validate" required />
                <label class="" for="complement">Complemento<small>(nº, apt., lt., qd., casa, loja)</small></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input value="{{ $suburb ?? old('suburb') }}" type="text" id="suburb" name="suburb" class="validate" required />
                <label class="" for="suburb">Bairro</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $city ?? old('city') }}" type="text" id="city" name="city" class="validate" required />
                <label class="" for="city">Cidade</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $province ?? old('province') }}" type="text" id="province" name="province" class="validate" required />
                <label class="" for="province">Estado/província</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $country ?? old('country') }}" type="text" id="country" name="country" class="validate" required />
                <label class="" for="country">País</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="password" id="regPassword" name="password" minlength="8" class="validate" required />
                <label for="regPassword">Senha</label>
                <span class="helper-text" data-error="A senha deve conter no mínimo 8 caracteres" data-success="Para sua segurança, use uma senha complexa">Digite uma senha segura</span>
            </div>
            <div class="input-field col s12 m6">
                <input type="password" id="confirm" name="password_confirmation" class="validate" onfocusout="confirmPass()" required />
                <label for="confirm">Confirmar senha</label>
                <span id="confirmHelper" class="helper-text" data-error="As senhas não conferem" data-success="Senhas conferem">Confirme a sua senha</span>
            </div>
        </div>
        <div class="row">
            <div class="input-field col">
                <a href="{{url('/')}}" class="waves-effect waves-light red btn">Voltar</a>
            </div>
            <div class="input-field col right">
                <button type="submit" class="waves-effect waves-light btn">Enviar</button>
            </div>
        </div>
    </form>

    <div id="wait" style="display: none"><i class="large material-icons">cached</i></div>
@endsection
