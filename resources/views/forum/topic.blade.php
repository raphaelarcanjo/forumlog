@extends('templates.layout')
@section('title',$title)

@section('content')
    <div class="row">
        <div class="col s12">
            <h4>{{ $forum->title }} - Tópico de <a href="{{ url('blog/'.$forum->user->username) }}">{{ $forum->user->name }}</a></h4>
        </div>
        <div class="col s12">
            <p>
                <b>-{{ $forum->message }}</b>
            </p>
            <ul>
                @foreach ($forum->comments as $comment)
                    <li>
                        <a href="{{ url('blog/'.$comment->user->username) }}">{{ $comment->user->name }}</a>
                        {{ $comment->message }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col s12">
            <form action="{{ url('forum/comment/'.$forum->id) }}" method="post">
                @csrf
                <div class="input-field">
                    <input type="text" name="message" id="comment_message" required="">
                    <label for="comment_message">Comentário</label>
                </div>
                <div class="input-field right">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                </div>
            </form>
        </div>
    </div>
@endsection