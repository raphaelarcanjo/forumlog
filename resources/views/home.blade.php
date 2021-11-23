@extends('templates.layout')
@section('title',$title)

@section('content')
    @foreach ($blogs as $blog)
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{url('blog/'.$blog->user_id)}}">{{$blog->user_name}}</a>
                </span>
                <p>{{$blog->message}}</p>
            </div>
            @can ('delete-blog', $blog)
                <div class="card-action">
                    <a href="{{url('blog/delete/'.$blog->id)}}" class="waves-effect waves-red btn-flat red-text"><i class="material-icons left">delete</i>Excluir post</a>
                    <a href="{{url('blog/private/'.$blog->id)}}" class="btn waves-effect waves-light {{($blog->private) ? 'green' : 'red'}}" title="Torna o post privado ou não, liberando ou proibindo comentários">
                        <i class="material-icons left">{{ ($blog->private) ? 'do_not_disturb_off' : 'do_not_disturb_on' }}</i>{{($blog->private) ? 'Não privado' : 'privado'}}
                    </a>
                </div>
            @endcan

            @if (!$blog->private)
                <details>
                    <summary class="btn"><i class="material-icons right">message</i> {{$blog->comments_count}}</summary>
                    <form action="{{url('blog/comment')}}" method="post">
                        @csrf
                        <div class="card-content">
                            <p class="card-title">Comentários</p>
                            @foreach ($blog->comments as $comment)
                                <p>
                                    @can ('delete-comment', $comment)
                                        <a href="{{url('blog/deletecomment/'.$comment->id)}}" class="btn-flat waves-effect waves-red" style="padding: 0">
                                            <i class="material-icons">delete</i>
                                        </a>
                                    @endcan
                                    <a href="{{url('blog/'.$comment->user_id)}}">{{$comment->author_name}}:</a>
                                    {{$comment->message}}
                                </p>
                            @endforeach
                            <textarea name="comment" class="materialize-textarea"></textarea>
                        </div>
                        @auth
                            <input type="hidden" name="blog_id" value="{{$blog->id}}">
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
