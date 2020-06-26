@extends('templates.layout')
@section('title',$title)

@section('content')
    <div class="row">
        @if ($name)
            <div class="col s12">
                <h3>Blog de {{$name}}</h3>
            </div>
            <div class="col s12">
                @if (session('user') && session('token'))
                    @if (session('user') === $tagname)
                        <p class="right">
                            <a href="{{url('post/create')}}" class="waves-effect waves-light btn"><i class="material-icons left">create</i>Criar um post</a>
                        </p>
                    @endif
                @endif
            </div>
        @else
            <div class="col s12">
                <h3>Blog não encontrado!</h3>
                <a href="{{url('/')}}" class="btn waves-effect waves-light">Voltar</a>
            </div>
        @endif
    </div>
    @isset($posts)
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
                        <summary title="Comentários">
                            <i class="material-icons right">message</i>
                        </summary>
                        <form action="{{url('post/comment')}}" method="post">
                            @csrf
                            <div class="card-content">
                                <p class="card-title">Comentários</p>
                                @if ($comments[$post->id])
                                    @foreach ($comments[$post->id] as $the)
                                        <p>
                                            <a href="{{url('blog/'.$the->comment_by)}}">{{$the->comment_by}}:</a>
                                            {{$the->comment}}
                                            @if ($the->comment_by === session('user'))
                                                <a href="{{url('post/deletecomment/'.$the->id)}}" class="btn-flat waves-effect waves-red"><i class="material-icons">delete</i></a>
                                            @endif
                                        </p>
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
    @endisset
@endsection