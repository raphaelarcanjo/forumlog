@extends('templates.layout')
@section('title',$title)

@section('content')
    @if ($name)
        <h3>Blog de {{$name}}</h3>
        @if (session('user') && session('token'))
            <a href="{{url('post/create')}}" class="waves-effect waves-light btn"><i class="material-icons left">add_circle</i> Criar um post</a>
        @endif
    @else
        <h3>Blog não encontrado!</h3>
        <a href="{{url('/')}}" class="btn wave-effects wave-light">Voltar</a>
    @endif
    @isset($posts)
        <ul>
            @foreach ($posts as $post)
                <li>{{$post}}</li>
            @endforeach
        </ul>
    @endisset
@endsection