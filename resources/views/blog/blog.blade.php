@php
    // dd($tagname);
@endphp

@extends('templates.layout')
@section('title',$title)

@section('content')
    <div class="row">
        <div class="col s12">
            <h4>Blog de <span class="teal-text">{{$name}}</span></h4>
        </div>
        <div class="col s12">
            <p class="right">
                <a href="{{url('post/create')}}" class="waves-effect waves-light btn"><i class="material-icons left">create</i>Criar um post</a>
            </p>
        </div>
    </div>
    @foreach ($posts as $post)
        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <a href="{{url('blog/'.id)}}">{{name}}</a>
                </span>
                <p>{{$post->message}}</p>
            </div>

            @can('delete-post', $post)
                <div class="card-action">
                    <a href="{{url('post/delete/'.$post->id)}}" class="waves-effect waves-red btn-flat red-text"><i class="material-icons left">delete</i>Excluir post</a>
                    <a href="{{url('post/private/'.$post->id)}}" class="btn waves-effect waves-light {{($post->private) ? 'red' : 'green'}}"><i class="material-icons left">message</i>{{($post->private) ? 'Não privado' : 'privado'}}</a>
                </div>
            @endcan

            @if (! $post->private)
                <details>
                    <summary title="Comentários" class="btn">
                        <i class="material-icons right">message</i> {{$post->comments_count}}
                    </summary>

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
                                <button type="submit" class="btn waves-effect waves-light"><i class="material-icons left">send</i>Enviar</button>
                            </div>
                        @endauth
                    </form>
                </details>
            @endif
        </div>
    @endforeach
@endsection
