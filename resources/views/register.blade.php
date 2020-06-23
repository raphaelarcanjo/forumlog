@extends('templates.layout')
@section('title',$title)

@section('content')
    <h4>Cadastro</h4>

    <form action="{{url('user/register')}}" method="post">
        @csrf
        <div class="row">
            <div class="input-field col s12 m9">
                <input value="{{ $name ?? '' }}" type="text" id="name" name="name" class="validate" required />
                <label for="name">Nome completo</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $date ?? '' }}" type="date" id="birth" name="birth" class="validate" required />
                <label for="birth">Data de nascimento</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4">
                <input value="{{ $tagname ?? '' }}" type="text" id="tagname" name="tagname" pattern="[a-z0-9.]{8,24}" class="validate" v-model="tag" required />
                <label for="tagname">Nome único (login)</label>
            <span class="helper-text" data-error="Apenas letras minúsculas sem espaço, números ou caracteres especiais são permitidos" v-bind:data-success="'http://forumlog/blog/' + tag">
                    Esse nome será usado para visitas ao seu blog por outros usuários e também para fazer login na usa conta.
                </span>
            </div>
            <div class="input-field col s12 m8">
                <input value="{{ $email ?? '' }}" type="email" id="email" name="email" class="validate" required />
                <label for="email">E-mail</label>
                <span class="helper-text" data-error="Formato de e-mail inválido" data-success="E-mail válido">Digite um e-mail válido</span>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m4">
                <input value="{{ $phone[0] ?? '' }}" type="text" id="phone1" name="phones[]" />
                <label for="phone1">Telefone 1</label>
            </div>
            <div class="input-field col s12 m4">
                <input value="{{ $phone[1] ?? '' }}" type="text" id="phone2" name="phones[]" />
                <label for="phone2">Telefone 2</label>
            </div>
            <div class="input-field col s12 m4">
                <input value="{{ $phone[2] ?? '' }}" type="text" id="phone3" name="phones[]" />
                <label for="phone3">Telefone 3</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m2">
                <input value="{{ $cep ?? '' }}" type="text" id="cep" name="cep" pattern="[0-9]{8}" class="validate" v-model.lazy="cep" v-on:change="getAddress" required />
                <label for="cep">CEP</label>
                <span class="helper-text" data-error="Digite apenas números" data-success="">Digite apenas números</span>
            </div>
            <div class="input-field col s12 m5">
                <input value="{{ $address ?? '' }}" type="text" id="address" name="address" class="validate" v-model="address.logradouro" required />
                <label v-bind:class="{'active':address.logradouro}" for="address">Endereço</label>
            </div>
            <div class="input-field col s12 m5">
                <input value="{{ $complement ?? '' }}" type="text" id="complement" name="complement" class="validate" v-model="address.complemento" required />
                <label v-bind:class="{'active':address.logradouro}" for="complement">Complemento<small>(nº, apt., lt., qd., casa, loja)</small></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input value="{{ $suburb ?? '' }}" type="text" id="suburb" name="suburb" class="validate" v-model="address.bairro" required />
                <label v-bind:class="{'active':address.logradouro}" for="suburb">Bairro</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $city ?? '' }}" type="text" id="city" name="city" class="validate" v-model="address.localidade" required />
                <label v-bind:class="{'active':address.logradouro}" for="city">Cidade</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $state ?? '' }}" type="text" id="state" name="state" class="validate" v-model="address.uf" required />
                <label v-bind:class="{'active':address.logradouro}" for="state">Estado/província</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $country ?? '' }}" type="text" id="country" name="country" class="validate" v-model="country" required />
                <label v-bind:class="{'active':address.logradouro}" for="country">País</label>
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
                <button type="submit" class="waves-effect waves-light btn">Enviar</button>
            </div>
            <div class="input-field col right">
                <a href="{{url('/')}}" class="waves-effect waves-light red btn">Voltar</a>
            </div>
        </div>
    </form>

    <div id="wait" v-show="wait"><i class="large material-icons">cached</i></div>
@endsection