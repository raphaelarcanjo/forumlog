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
            </ul>
        </div>
    </nav>
    
    <ul id="nav-mobile" class="sidenav">
        <li class="@if ($title == 'Home') active @endif"><a href="{{url('/')}}">Home</a></li>
        <li class="@if ($title == 'Forum') active @endif"><a href="{{url('forum')}}">Forum</a></li>
        <li class="@if ($title == 'Blog') active @endif"><a href="{{url('blog')}}">Blog</a></li>
        <li class="@if ($title == 'Sobre') active @endif"><a href="{{url('about')}}">Sobre</a></li>
    </ul>

    @if (session('user') && session('token'))
    <ul id="userMenu" class="dropdown-content">
        <li>
            <a href="{{url('user/profile/'.session('user'))}}">
                <i class="material-icons small">assignment_ind</i>Perfil
            </a>
        </li>
        <li>
            <a href="{{url('user/logout')}}" class="red-text">
                <i class="material-icons small">close</i>Logout
            </a>
        </li>
    </ul>
    <nav>
        <div class="nav-wrapper teal">
            <ul>
                <li>
                    <form id="searchForm">
                        <div class="input-field">
                            <i class="material-icons prefix">search</i>
                            <input id="search" type="text" class="autocomplete" autocomplete="off" />
                            <label for="search">
                                Buscar usuário
                            </label>
                        </div>
                    </form>
                </li>
                <li class="right">
                    <a href="#" class="dropdown-trigger" data-target="userMenu">
                        <i class="material-icons left">account_circle</i>Usuário<i class="material-icons right">arrow_drop_down</i></a>
                </li>
            </ul>
        </div>
    </nav>
    @endif
    @yield('header')
</header>

<div class="fixed-action-btn" id="btnTop" style="display: none">
    <button type="button" onclick="goToTop()" class="btn-floating btn-large"><i class="material-icons">arrow_upward</i></button>
</div>

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