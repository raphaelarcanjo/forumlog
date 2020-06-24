@include('templates.head')
<body>

<header>
    <nav>
        <div class="nav-wrapper">
            <a href="{{url('/')}}" class="brand-logo">
                <img src="{{asset('img/logo-rgba.png')}}" alt="ForumLog">
            </a>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>

            <ul id="nav-desktop" class="right hide-on-med-and-down">
                <li class="@if ($title == 'Home') active @endif"><a href="{{url('/')}}">Home</a></li>
                <li class="@if ($title == 'Forum') active @endif"><a href="{{url('forum')}}">Forum</a></li>
                <li class="@if ($title == 'Blog') active @endif"><a href="{{url('blog')}}">Blog</a></li>
                <li class="@if ($title == 'Sobre') active @endif"><a href="{{url('about')}}">Sobre</a></li>
                @if (session('user') && session('token'))
                    <li class="red accent-2">
                        <a href="{{url('user/logout')}}" class="white-text">
                            Logout
                        </a>
                    </li>
                @else
                    <li class="teal">
                        <a href="#modalLogin" class="modal-trigger">
                            Login
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
    
    <ul id="nav-mobile" class="sidenav">
        <li class="@if ($title == 'Home') active @endif"><a href="{{url('/')}}">Home</a></li>
        <li class="@if ($title == 'Forum') active @endif"><a href="{{url('forum')}}">Forum</a></li>
        <li class="@if ($title == 'Blog') active @endif"><a href="{{url('blog')}}">Blog</a></li>
        <li class="@if ($title == 'Sobre') active @endif"><a href="{{url('about')}}">Sobre</a></li>
        @if (session('user') && session('token'))
            <li class="red accent-2">
                <a href="{{url('user/logout')}}" class="white-text">
                    Logout
                </a>
            </li>
        @else
            <li>
                <a href="#!" class="dropdown-trigger" data-target="dropdownLogin">
                    Login<i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        @endif
    </ul>

    <ul id="dropdownLogin" class="dropdown-content">
        <li>
            <div class="container">
                <h4>Login</h4>
                <form action="{{url('user/login')}}" method="post">
                    @csrf
                    <div class="input-field">
                        <input type="text" id="login" name="login" class="validate" required />
                        <label for="login">Login</label>
                    </div>
                    <div class="input-field">
                        <input type="password" id="password" name="password" class="validate" required />
                        <label for="password">Senha</label>
                    </div>
                    <div class="input-field">
                        <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                        <a href="{{url('user/register')}}" class="waves-effect waves-light btn">Cadastre-se</a>
                    </div>
                    <a href="{{url('user/recover')}}" class="waves-effect btn-flat">Esqueci a senha</a>
                </form>
            </div>
        </li>
    </ul>

    <div id="modalLogin" class="modal">
        <div class="modal-content">
            <h4>Login</h4>
            <form action="{{url('user/login')}}" method="post">
                @csrf
                <div class="input-field">
                    <label for="loginM">Login</label>
                    <input type="text" name="login" id="loginM" class="validate" required />
                </div>
                <div class="input-field">
                    <label for="passwordM">Senha</label>
                    <input type="password" name="password" id="passwordM" class="validate" required />
                </div>
                <div class="input-field">
                    <button type="submit" class="waves-effect waves-light btn">Enviar</button>
                    <a href="{{url('user/register')}}" class="waves-effect waves-light btn">Cadastre-se</a>
                </div>
                <a href="{{url('user/recover')}}" class="waves-effect btn-flat">Esqueci a senha</a>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-light red btn">Cancelar</a>
        </div>
    </div>
    @yield('header')
</header>

<div class="container">
    @if (session('success'))
        <p class="card-panel green green-text lighten-4">{{session('success')}}</p>
    @endif
    
    @if (session('error'))
        <p class="card-panel red red-text lighten-4">{{session('error')}}</p>
    @endif

    @if ($errors->any())
        <div class="card-panel red red-text lighten-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <main>
        @yield('content')