@extends('templates.layout')
@section('title',$title)

@section('content')
    <h4>Perfil de <span class="teal-text">{{$user->name}}</span></h4>


    <form action="{{url('user/profile/'.$user->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="input-field col s12 m6">
                <img src="{{url('public/users/'.$user->photo)}}" alt="Foto" width="200" height="200" id="previewPhoto">
            </div>
            <div class="input-field col s12 m6">
                <input type="file" accept="image/jpg, image/png, image/jpeg" id="photo" name="photo" onchange="preview_photo(event)" />
                <label for="photo"></label>
            </div>
            <div class="input-field col s12 m6">
                <input value="{{ $user->name ?? old('name') }}" type="text" id="name" name="name" class="validate" />
                <label for="name">Nome completo</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->tagname ?? old('tagname') }}" type="text" id="tagname" name="tagname" class="validate" />
                <label for="tagname">Nome de usuário</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->birth ?? old('birth') }}" type="text" id="birth" name="birth" class="validate datepicker date" />
                <label for="birth" class="active">Data de nascimento</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input value="{{ $user->email ?? old('email') }}" type="email" id="email" name="email" class="validate" />
                <label for="email">E-mail</label>
                <span class="helper-text" data-error="Formato de e-mail inválido" data-success="E-mail válido">Digite um e-mail válido</span>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->phones[0] != null?$user->phones[0]:'' ?? old('phones')[0] }}" type="text" class="phone" minlength="14" maxlength="15" id="phone1" name="phones[]" />
                <label for="phone1">Telefone 1</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->phones[1] != null?$user->phones[1]:'' ?? old('phones')[1] }}" type="text" class="phone" minlength="14" maxlength="15" id="phone2" name="phones[]" />
                <label for="phone2">Telefone 2</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->phones[2] != null?$user->phones[2]:'' ?? old('phones')[2] }}" type="text" class="phone" minlength="14" maxlength="15" id="phone3" name="phones[]" />
                <label for="phone3">Telefone 3</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m2">
                <input value="{{ $user->cep ?? old('cep') }}" type="text" id="cep" name="cep" minlength="9" maxlength="9" class="validate cep" onchange="getAddress()" />
                <label for="cep">CEP</label>
                <span class="helper-text" data-error="Digite apenas números" data-success="" id="cepMsg">Digite apenas números</span>
            </div>
            <div class="input-field col s12 m5">
                <input value="{{ $user->address ?? old('address') }}" type="text" id="address" name="address" class="validate" />
                <label class="" for="address">Endereço</label>
            </div>
            <div class="input-field col s12 m5">
                <input value="{{ $user->complement ?? old('complement') }}" type="text" id="complement" name="complement" class="validate" />
                <label class="" for="complement">Complemento<small>(nº, apt., lt., qd., casa, loja)</small></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input value="{{ $user->suburb ?? old('suburb') }}" type="text" id="suburb" name="suburb" class="validate" />
                <label class="" for="suburb">Bairro</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->city ?? old('city') }}" type="text" id="city" name="city" class="validate" />
                <label class="" for="city">Cidade</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->state ?? old('state') }}" type="text" id="state" name="state" class="validate" />
                <label class="" for="state">Estado/província</label>
            </div>
            <div class="input-field col s12 m3">
                <input value="{{ $user->country ?? old('country') }}" type="text" id="country" name="country" class="validate" />
                <label class="" for="country">País</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col">
                <button type="submit" class="waves-effect waves-light btn">Enviar</button>
            </div>
        </div>
    </form>

    <div id="wait" style="display: none"><i class="large material-icons">cached</i></div>
@endsection
