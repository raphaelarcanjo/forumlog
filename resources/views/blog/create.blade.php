@extends('templates.layout')
@section('title',$title)

@section('content')
    <h4>Criar postagem</h4>

    <form action="{{url('post/create')}}" method="post">
        @csrf
        <div class="row">
            <div class="input-field col s12">
                <textarea name="message" id="message" class="materialize-textarea" data-length="150" required></textarea>
                <label for="message">Conteúdo</label>
            </div>
            <div class="input-field col s12">
                <p>
                    <label>
                        <input name="private" type="checkbox" class="filled-in" value="1" />
                        <span>Post privado</span>
                    </label>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="input-field col">
                <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                <button type="reset" class="waves-effect waves-light red btn">Limpar</button>
            </div>
            <div class="input-field col right">
                <a href="{{url('blog/'.session('user'))}}" class="waves-effect waves-light red btn">Voltar</a>
            </div>
        </div>
    </form>
@endsection