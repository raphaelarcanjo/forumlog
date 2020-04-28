@extends('templates.layout')
@section('title',$title)

@section('content')

@if (session('error'))
    <p class="card-panel red red-text lighten-4">{{session('error')}}</p>
@endif

<h1>Boas-vindas ao <span class="teal-text">Forum</span><span class="red-text text-accent-2">Log</span></h1>
<h4>Seu Fórum e Blog num só lugar!</h4>

<blockquote>
    <a href="{{url('forumlog/user/register')}}">Cadastre-se</a> e aproveite para conferir os tópicos do fórum, postados pelos usuários já cadastrados.
</blockquote>

@endsection