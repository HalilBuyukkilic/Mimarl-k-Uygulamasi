<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">




    <meta name="keywords" content="@yield('meta_keys')">

    <meta name="description" content="@yield('meta_desc')">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project_core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ui/ui_core.css') }}">
    @yield('modul_css')
    <style>
        .nav-item {
            margin: 0 10px;
        }

        .active_ui_menu_buttons {
            border-bottom: 2px solid #e6191a;

        }

        .navbar-light .navbar-nav .nav-link {
            color: #424242;
            font-weight: 450;
            font-family: Verdana, Geneva, Tahoma, sans-serif
        }
    </style>
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
            style="background-color:white;border-top:5px solid #e6191a; box-shadow: rgba(0, 0, 0, 0.20) 0px 5px 10px;">
            <ul class="nav-item">
                <a href="/"><img src="{{ asset('/img/site/logo.png') }}" alt="Girl in a jacket" width="150"
                        height="50"></a>
            </ul>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse mt-2" id="main_nav">
                @php
                    $active_competition = \App\Models\Competition::where('status', 1)->exists();
                @endphp
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item {{ Route::currentRouteNamed('ui.home') ? 'active_ui_menu_buttons' : '' }}"> <a
                            class="nav-link" href="/">Anasayfa </a> </li>
                    <li class="nav-item {{ Request::segment(1) === 'haberler' ? 'active_ui_menu_buttons' : '' }}">
                        <a class="nav-link" href="{{ route('ui.news.list') }}"> Haberler</a>
                    </li>

                    <li class="nav-item {{ Request::segment(1) === 'etkinlik' ? 'active_ui_menu_buttons' : '' }}"><a
                            class="nav-link" href="{{ route('ui.event.list') }}"> Etkinlik </a></li>
                    <li class="nav-item {{ Request::segment(1) === 'konular' ? 'active_ui_menu_buttons' : '' }}"><a
                            class="nav-link" href="{{ route('ui.topic.list') }}"> Konular </a></li>
                    @if ($active_competition)
                        <li class="nav-item {{ Request::segment(1) === 'yarisma' ? 'active_ui_menu_buttons' : '' }}"><a
                                class="nav-link pulsingButton scalingButton" href="{{ route('ui.competition.page') }}">
                                Yarışma
                            </a>
                        </li>
                    @endif


                    <li
                        class="nav-item dropdown {{ Request::segment(1) === 'biz_kimiz' ? 'active_ui_menu_buttons' : '' }} {{ Request::segment(1) === 'oda_kaydi_nasil_yapilir' ? 'active_ui_menu_buttons' : '' }}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hakkımızda
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('ui.about_we.page') }}">Biz Kimiz ?</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('ui.room_register.page') }}">Oda Kaydı Nasıl
                                Yapılır ?</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" id="scrollButton" style="cursor: pointer">İletişim</a>

                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Diğer
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Mevzuatlar</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Another action</a>
                        </div>
                    </li>
                    <li class="nav-item"><a class="btn" style="background-color: #f44336;color:white;"
                            href="/login"><i class="far fa-user mr-1"></i>
                            {{ isset(Auth::user()->name) ? (Auth::user()->status == 1 ? Auth::user()->name : 'Giriş yap') : 'Giriş yap' }}
                        </a></li>
                </ul>
            </div> <!-- navbar-collapse.// -->
        </nav>




        <main>
            @yield('content')
        </main>

        <section style="background-color: #e6191a;padding:20px">
            <div class="row">
                <div class="offset-md-2 col-md-1 p-2" style="color:white">
                    <div class="row">
                        <a href="/"><img src="{{ asset('/img/site/logo_reverse.png') }}"
                                alt="Girl in a jacket" width="150" height="50"></a>
                    </div>
                </div>
                <div class="offset-md-1 col-md-6 p-2">
                    <div class="row">

                        <div class="col-md-8 p-1" style="color:white">
                            <ul class="li_remove_dots">
                                <li class="m-1"><i class="fas fa-map-marker-alt mr-1"></i> adres Where can I get
                                    some
                                    What is Lorem
                                    Ipsum Where does it come from Where does it no:43 /3</li>
                                <li class="m-1"><i class="fas fa-envelope mr-1"></i> mimarlar_as@info.com</li>
                                <li class="m-1"><i class="fas fa-phone mr-1"></i> +90 212 444 444</li>
                            </ul>
                        </div>
                        <div class="col-md-4 p-1">
                            <ul class="li_remove_dots">
                                <li class="m-1">
                                    <a href="#" style="color:white">
                                        <i class="fab fa-facebook mr-1"></i>Facebook
                                    </a>
                                </li>
                                <li class="m-1 ">
                                    <a href="#" style="color:white">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" class="mr-1"
                                            fill="#ffffff"
                                            viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z" />
                                        </svg> Twitter
                                    </a>
                                </li>
                                <li class="m-1">
                                    <a href="#" style="color:white">
                                        <i class="fab fa-instagram-square mr-1"></i>İnstagram
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container mt-1">
                <div class="d-flex justify-content-center">
                    <h6><img src="{{ asset('/img/site/ıced.png') }}" class="mr-2" width="25"
                            height="22">Bu
                        web sitesi bir ICED Company ürünüdür.</h6>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    @yield('modul_js')
    <script>
        document.getElementById("scrollButton").addEventListener("click", function() {
            // Sayfanın en altına gitmek için body elementinin yüksekliğini alın
            const bodyHeight = document.body.scrollHeight;

            // Sayfayı en altına kaydırın
            window.scrollTo(0, bodyHeight);
        });
    </script>
</body>

</html>
