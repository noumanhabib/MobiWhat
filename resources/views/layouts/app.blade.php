<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MobiWhat</title>

    {{-- Meta tags --}}
    <meta name="description"
        content="This website is to show mobile informations and latest mobile price with lot of features like search and comparison." />
    <meta name="robots" content="index,follow" />
    <meta property="og:type" content="information" />
    <meta property="og:title" content="MobiWhat" />
    <meta property="og:description"
        content="This website is to show mobile informations and latest mobile price with lot of features like search and comparison." />
    <meta property="og:site_name" content="MobiWhat" />
    <meta name="twitter:title" content="MobiWhat" />
    <meta name="twitter:description"
        content="This website is to show mobile informations and latest mobile price with lot of features like search and comparison." />
    <meta name="twitter:site" content="@noumanhabib" />
    <meta name="twitter:creator" content="@noumanhabib" />
    <meta name="keywords" content="mobiwhat, what mobile, mobiles, mobile prices, mobiles info," />
    <meta name="description"
        content="This website is to show mobile informations and latest mobile price with lot of features like search and comparison." />
    <meta name="subject" content="Mobile Information Website" />
    <meta name="copyright" content="MobiWhat" />
    <meta name="language" content="en" />
    <meta name="abstract" content="All about mobiles." />
    <meta name="topic" content="Mobiles Information and Comparison" />
    <meta name="summary"
        content="This website is to show mobile informations and latest mobile price with lot of features like search and comparison." />
    <meta name="Classification" content="Informational" />
    <meta name="author" content="noumanhabib, noumanhabib521@gmail.com" />
    <meta name="designer" content="Nouman Habib" />
    <meta name="copyright" content="all rights reserved to mobiwhat" />
    <meta name="reply-to" content="noumanhabib521@gmail.com" />
    <meta name="owner" content="Nouman Habib" />
    <meta name="url" content="localhost:8000" />
    <meta name="coverage" content="Worldwide" />
    <meta name="distribution" content="Global" />
    <meta name="rating" content="General" />
    <meta name="revisit-after" content="7 days" />
    <meta http-equiv="Expires" content="0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Cache-Control" content="no-cache" />

    {{-- Fav icon --}}

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    MobiWhat
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item {{ Route::currentRouteName() === 'index' ? 'active': '' }}">
                            <a href="/" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() === 'brands' ? 'active': '' }}">
                            <a href="/brands" class="nav-link">Brands</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() === 'top-mobiles' ? 'active': '' }}">
                            <a href="/top-mobiles" class="nav-link">Top Mobiles</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() === 'comparison' ? 'active': '' }}">
                            <a href="/comparison" class="nav-link">Comparison</a>
                        </li>
                        <li class="nav-item {{ Route::currentRouteName() === 'search' ? 'active': '' }}">
                            <a href="/search" class="nav-link">Search</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item d-flex align-items-center nav-comp">
                            <a title="Comparison" href="/comparison" class="nav-link pb-0 d-none d-lg-block">
                                <i class="fas fa-equals" style="font-size: 1.4rem;"></i>
                            </a>
                            <a href="/comparison" class="nav-link d-lg-none">Comparison</a>
                            <span class="comp-added" id="comp-added">0</span>
                        </li>
                        <li
                            class="nav-item d-flex align-items-center nav-fav {{ Route::currentRouteName() === 'favourites' ? 'active': '' }}">
                            <a title="Favourites" href="/favourites" class="nav-link pb-0 d-none d-lg-block">
                                <i class="fa fa-heart" style="font-size: 1.4rem;"></i>
                            </a>
                            <a href="/favourites" class="nav-link d-lg-none">Favourite</a>
                            <span class="fav-added" id="fav-added">0</span>

                        </li>
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item {{ Route::currentRouteName() === 'login' ? 'active': '' }}">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item {{ Route::currentRouteName() === 'register' ? 'active': '' }}">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->type === "admin")
                                <a href="/admin" class="dropdown-item">Admin</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>


                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @if (session('message'))
        <div class="alert alert-success text-center mt-3"
            style="justify-content: center;font-size: 1rem;padding: 0.5rem 0;margin: 0;">
            {{ session('message') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger text-center mt-3"
            style="justify-content: center;font-size: 1rem;padding: 0.5rem 0;margin: 0;">
            {{ session('error') }}
        </div>
        @endif
        @yield('searchBar')
        <main>
            @yield('content')
        </main>

        <footer class="footer">
            <h1 style="margin-bottom: 20px;letter-spacing: 1.8px;color: white;">Mobi What</h1>
            <div class="footer_main">
                <form method="POST" action="#" class="newsletter">
                    @csrf
                    <div class="input">
                        <label for="sub-email">Subscribe to news letter</label>
                        <input type="email" name="email" placeholder="Email">
                    </div>
                    <div class="submit">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                    </div>
                </form>

                <div class="cols">
                    <div class="col">
                        <div class="title">Brands</div>
                        <a href="#" style="text-transform: capitalize">
                            All </a>
                        <a href="#" style="text-transform: capitalize">
                            Samsung </a>
                        <a href="#" style="text-transform: capitalize">
                            Google </a>
                        <a href="#" style="text-transform: capitalize">
                            Oppo </a>
                        <a href="#" style="text-transform: capitalize">
                            Huwavie </a>


                    </div>
                    <div class="col">
                        <div class="title">Services</div>
                        <a href="#">Mobile Info</a>
                        <a href="#">Advance Search</a>
                        <a href="#">Brands Info</a>
                        <a href="#">Mobile Comparison</a>
                        <a href="#">Top Mobiles</a>
                    </div>
                    <div class="col">
                        <div class="title">Pages</div>
                        <a href="/">Home</a>
                        <a href="#">Brands</a>
                        <a href="#">Top Mobiles</a>
                        <a href="#">Comparison</a>
                        <a href="#">Search</a>
                    </div>
                </div>
            </div>
            <div class="links footer-container">
                <ul>
                    <li class="item"><a class="social-links" href="#" target="_blank"><i
                                class="fab fa-facebook"></i></a></li>
                    <li class="item"><a class="social-links" href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="item"><a class="social-links" href="#" target="_blank"><i
                                class="fab fa-instagram"></i></a></li>
                    <li class="item"><a class="social-links" href="#" target="_blank"><i
                                class="fab fa-linkedin"></i></a></li>
                    <li class="item"><a class="social-links" href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                    </li>
                </ul>
            </div>
            <div class="footer-container">
                <p>&copy; Copyright 2021 MobiWhat Pvt Ltd</p>
            </div>

        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>

