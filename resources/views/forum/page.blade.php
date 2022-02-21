@extends('templates.layout')
@section('title',$title)

@section('content')
    <div class="row">
        <div class="col s12">
            <h4>Tópicos</h4>
        </div>
        <div class="col s12">
            <p class="right">
                <a href="{{url('forum/create')}}" class="waves-effect waves-light btn"><i class="material-icons left">create</i>Criar um tópico</a>
            </p>
        </div>
    </div>
    <ul>
        @foreach ($topics as $topic)
            <li>
                <a href="{{ url('forum/'.$topic->id) }}">
                    {{ $topic->title }}
                </a>
                <span class="new badge" data-badge-caption="comentários">{{ $topic->comments_count }}</span>
            </li>
            <hr>
        @endforeach
    </ul>
@endsection