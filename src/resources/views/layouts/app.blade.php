<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @if(Request::path() === 'cart')
    <script async src="https://api-maps.yandex.ru/2.1/?lang=ru_RU"
            type="text/javascript" onload="window.ymapsLoaded ? ymapsLoaded() : null">
    </script>
    @endif
    <script defer src="{{ asset('js/app.js') }}"></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="{{ asset('css/Nunito-Light.ttf') }} rel="stylesheet"> --}}

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

        .footer {
            min-height: 200px;
            background-color: #222;
        }
        .carousel-image {
            display: none;
            object-fit: cover;
            width: 100%;
            height: 300px
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
                            <a class="nav-link" href="/about">О нас</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/delivery">Доставка</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/payment">Оплата</a>
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
                            <toggle-admin
                                    :admin="{{Auth::user()->isAdmin ? 'true' : 'false'}}"
                            ></toggle-admin>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выход') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <div class="ml-auto">
                    <cart-button></cart-button>
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </nav>
        <a-carousel effect="fade" autoplay>
            <div>
                <img class="carousel-image" src="/img/img-1">
            </div>
            <div>
                <img class="carousel-image" src="/img/img-2">
            </div>
            <div>
                <img class="carousel-image" src="/img/img-3">
            </div>
            <div>
                <img class="carousel-image" src="/img/img-4">
            </div>
            <div>
                <img class="carousel-image" src="/img/img-5">
            </div>
        </a-carousel>
        <category-tab style="margin-top: -6px"></category-tab>

        <main class="container mt-5 mx-sm-n0 content bg-white py-4" style="overflow-x: auto;">
            @yield('content')
        </main>
        <footer class="footer">
            <div class="container p-3">
                <span style="color: #6ab8ee; font-family: Roboto; font-size: 11.5px; font-weight: bold;">ДОКУМЕНТАЦИЯ ПОЛЬЗОВАТЕЛЯ </span>
                <div class="d-flex flex-column flex-md-row">
                    <div class="m-3" style="color: #89949b; font-family: Roboto; font-size: 14px;">
                        <div>Название документа 1</div>
                        <div><a href="document/doc1.txt" download>Скачать</a></div>
                    </div>
                    <div class="m-3" style="color: #89949b; font-family: Roboto; font-size: 14px;">
                        <div>Название документа 2</div>
                        <div><a href="document/doc1.txt" download>Скачать</a></div>
                    </div>
                </div>
            </div>
            <div align="center" class="mt-md-5 text-light">© 2019 All rights reserved.</div>
        </footer>
    </div>
<script>
</script>
</body>
</html>