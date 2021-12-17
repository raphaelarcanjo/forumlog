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
    @foreach ($topics as $topic)
        @php dd($topic)
    @endforeach
@endsection