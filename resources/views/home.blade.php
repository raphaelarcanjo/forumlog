@extends('templates.layout')
@section('title',$title)

@section('content')
    @foreach ($posts as $post)
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{url('blog/'.$post->created_by)}}">{{$post->user_name}}</a>
                </span>
                <p>{{$post->message}}</p>
            </div>
            @can ('delete-post', $post)
                <div class="card-action">
                    <a href="{{url('post/delete/'.$post->id)}}" class="waves-effect waves-red btn-flat red-text"><i class="material-icons left">delete</i>Excluir post</a>
                    <a href="{{url('post/private/'.$post->id)}}" class="btn waves-effect waves-light {{($post->private) ? 'red' : 'green'}}"><i class="material-icons left">message</i>{{($post->private) ? 'Não privado' : 'privado'}}</a>
                </div>
            @endcan

            @if (!$post->private)
                <details>
                    <summary class="btn"><i class="material-icons right">message</i> {{$post->comments_count}}</summary>
                    <form action="{{url('post/comment')}}" method="post">
                        @csrf
                        <div class="card-content">
                            <p class="card-title">Comentários</p>
                            @foreach ($post->comments as $comment)
                                <p>
                                    <a href="{{url('blog/'.$comment->comment_by)}}">{{$comment->comment_by}}:</a>
                                    {{$comment->comment}}
                                    @can ('delete-comment', $comment)
                                        <a href="{{url('post/deletecomment/'.$comment->id)}}" class="btn-flat waves-effect waves-red"><i class="material-icons">delete</i></a>
                                    @endcan
                                </p>
                            @endforeach
                            <textarea name="comment" class="materialize-textarea"></textarea>
                        </div>
                        @auth
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <div class="card-action">
                                <button type="reset" class="waves-effect waves-red btn-flat red-text"><i class="material-icons left">delete_sweep</i>Limpar</button>
                                <button type="submit" class="btn waves-effect waves-light"><i class="material-icons right">send</i>Enviar</button>
                            </div>
                        @endauth
                    </form>
                </details>
            @endif
        </div>
    @endforeach
@endsection
