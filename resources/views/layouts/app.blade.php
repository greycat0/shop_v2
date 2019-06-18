<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <style>
        .catalog-bg{
            background-color: #f4f4f4;
        }
        .content{
        //background-color: #f4f4f4;
            min-height: 800px;
        }
        .list-group-striped li:nth-child(2n+1){
          background-color: #eee;
        }
    </style>


</head>
<body class="bg-white">
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-light bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Главная
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Доставка</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Оплата</a>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Войти</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Зарегистрироваться</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <cart-button></cart-button>

                <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

            </div>
        </nav>

        <nav class="navbar navbar-expand-sm catalog-bg navbar-light btn-group px-3 p-0">
            <div class="container">
                <div class="navbar-brand d-sm-none" href="{{ url('/') }}">
                    Категории
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#catalog" aria-controls="#catalog" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="catalog">
                    <ul class="navbar-nav">

                        @foreach( App\Category::all() as $category )
                            <li class="nav-item">
                            <button onclick="location = '/?category={{$category->id}}'" class="btn btn-light"> {{$category->name}} </button>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </nav>

        <main class="container mt-5 mx-sm-n0 content bg-white py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>