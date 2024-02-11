<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Busur mamasa</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/mamasa.png') }}">
    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="color: white; display: flex; align-items: center;">
                    <img src="{{ asset('assets/img/bsrmamasa.png') }}" alt="Logo" height="40" class="d-inline-block align-text-top rounded-circle">
                    <strong style="margin-left: 10px;">Busur Mamasa</strong>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" style="border-color: white;">
                    <span class="navbar-toggler-icon" style="background-color: white;"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-color: white;">
                                Categories
                            </button>
                            <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                                @foreach(\App\Models\NewsCategory::all() as $category)
                                    <a class="dropdown-item" href="{{ route('category-news', ['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </li>

                        @guest
                            @if (auth()->check() && !auth()->user()->is_admin)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" style="color: white;">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                                    <strong>{{ Auth::user()->name }}</strong>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Link untuk Create News -->
                                    <a class="dropdown-item" href="{{ route('news-create') }}">Create News</a>

                                    <!-- Link untuk Create Bottom News -->
                                    <a class="dropdown-item" href="{{ route('create-news-bottom') }}">Create Bottom News</a>

                                    <div class="dropdown-divider"></div>

                                    <!-- Link untuk Logout -->
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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




        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-dark shadow-sm text-white text-center py-3">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3 mb-md-0 d-flex justify-content-center">
                        <a href="https://www.facebook.com/profile.php?id=61555978468767" target="_blank" class="text-white" style="margin-left: 0;">
                            <img src="{{ asset('assets/img/fblogo.png') }}" alt="Facebook" height="30">
                        </a>
                        <a href="https://www.youtube.com/@BusurMamasa" target="_blank" class="text-white" style="margin-left: 13px;">
                            <img src="{{ asset('assets/img/youtube.png') }}" alt="YouTube" height="30">
                        </a>
                        <a href="https://www.tiktok.com/@busurmamasa" target="_blank" class="text-white" style="margin-left: 12px;">
                            <img src="{{ asset('assets/img/tiktok.png') }}" alt="TikTok" height="30">
                        </a>
                        <a href="https://www.instagram.com/busurmamasa" target="_blank" class="text-white" style="margin-left: 12px;">
                            <img src="{{ asset('assets/img/instagram.png') }}" alt="Instagram" height="30">
                        </a>
                    </div>

                    <div class="col-md-12">
                        <p class="mb-0 mt-2" style="margin-left: 30px">&copy; {{ date('Y') }} Busur Mamasa. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
