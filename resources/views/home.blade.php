@extends('templates.layout')
@section('title',$title)

@section('content')

@if (session('user') && session('token'))
    @foreach ($posts as $post)
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{url('blog/'.$post->created_by)}}">{{$post->created_by}}</a>
                </span>
                <p>{{$post->message}}</p>
            </div>
            @if (session('user') && session('token'))
                @if (session('user') === $post->created_by)
                    <div class="card-action">
                        <a href="{{url('post/delete/'.$post->id)}}" class="waves-effect waves-red btn-flat red-text"><i class="material-icons left">delete</i>Excluir post</a>
                        <a href="{{url('post/private/'.$post->id)}}" class="btn waves-effect waves-light {{($post->private) ? 'red' : 'green'}}"><i class="material-icons left">message</i>{{($post->private) ? 'Não privado' : 'privado'}}</a>
                    </div>
                @endif
            @endif

            @if (!$post->private)
                <details>
                    <summary><i class="material-icons right">message</i></summary>
                    <form action="{{url('post/comment')}}" method="post">
                        @csrf
                        <div class="card-content">
                            <p class="card-title">Comentários</p>
                            @if ($comments)
                                @foreach ($comments as $the)
                                    @if ($the->post == $post->id)
                                        <p>
                                            <a href="{{url('blog/'.$the->comment_by)}}">{{$the->comment_by}}:</a>
                                            {{$the->comment}}
                                            @if ($the->comment_by === session('user'))
                                                <a href="{{url('post/deletecomment/'.$the->id)}}" class="btn-flat waves-effect waves-red"><i class="material-icons">delete</i></a>
                                            @endif
                                        </p>
                                    @endif
                                @endforeach
                            @endif
                            <textarea name="comment" class="materialize-textarea"></textarea>
                        </div>
                        @if (session('user') && session('token'))
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <input type="hidden" name="comment_by" value="{{session('user')}}">
                            <div class="card-action">
                                <button type="reset" class="waves-effect waves-red btn-flat red-text"><i class="material-icons left">delete_sweep</i>Limpar</button>
                                <button type="submit" class="btn waves-effect waves-light"><i class="material-icons left">send</i>Enviar</button>
                            </div>
                        @endif
                    </form>
                </details>
            @endif
        </div>
    @endforeach
    @else
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
                                <input type="text" name="login" id="loginM" class="validate" required />
                            </div>
                            <div class="input-field">
                                <label for="passwordM">Senha</label>
                                <input type="password" name="password" id="passwordM" class="validate" required />
                            </div>
                            <div class="input-field center-align">
                                <p>
                                    <label>
                                      <input type="checkbox" class="filled-in" name="logged" />
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
    @endif

@endsection