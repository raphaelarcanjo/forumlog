@extends('templates.layout')
@section('title',$title)

@section('content')
    @if (isset($name))
        <h3>Blog de {{$name}}</h3>
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