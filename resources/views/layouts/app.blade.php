<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Busur mamasa</title>

        <link rel="icon" type="image/png" href="{{ asset('assets/logo/mamasa.png') }}">
        <!-- Fonts -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/assets/owl.theme.default.min.css">

        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Owl Carousel JS -->
        <script src="https://cdn.jsdelivr.net/npm/owl.carousel@2.3.4/dist/owl.carousel.min.js"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/runtext.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/aboutus.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/events.css') }}">
        
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>

<body class="d-flex flex-column min-vh-100">
        <marquee style="color:aliceblue;  background-color:#212529;width:100%;font-size:16px;font-family:'Raleway',sans-serif;font-weight:150;height:20px; display: block;"> The New Mamasa Bersih Melayani ! </marquee>
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm pb-1" style="background-color:#212529;">
            <div class="container-fluid">
                <a  href="{{ route('index-news') }}" class="navbar-brand d-flex align-items-center" style="color: white;">
                    <img src="{{ asset('assets/logo/bsrmamasa.png') }}" alt="Logo" height="40" class="d-inline-block align-text-top rounded-circle" style="background-color:#212529;">
                    <strong style="margin-left: 10px; color:white ">BUSUR MAMASA</strong>
                </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-end  " id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <br>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="#"><b>Berkarya Bersama</b></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('about') }}"><b>Tentang Busur Mamasa</b></a>
                  </li>
                  @if (Auth::check() && Auth::user()->is_admin)
                  <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('admin-index') }}"><b>Admin Dashboard</b></a>
                  </li>
                  @endif
                </ul>
              </div>
            </div>
          </nav>

          <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color:#212529;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        @foreach(\App\Models\NewsCategory::all() as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category-news', ['category' => $category->id]) }}" style="font-size: 12px; margin-right: 10px;">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">
            @yield('content')
        </main>

        <footer class="bg-dark shadow-sm text-white text-center py-2 mt-auto">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-3 mb-md-0 d-flex justify-content-center" style="">
                        <a href="https://www.facebook.com/profile.php?id=61555978468767" target="_blank" class="text-white">
                            <img src="{{ asset('assets/logo/fblogo.png') }}" alt="Facebook" height="20" style="margin-right: 15px;">
                        </a>
                        <a href="https://www.youtube.com/@BusurMamasa" target="_blank" class="text-white">
                            <img src="{{ asset('assets/logo/youtube.png') }}" alt="YouTube" height="20" style="margin-right: 15px; margin-left: 15px;">
                        </a>
                        <a href="https://www.tiktok.com/@busurmamasa" target="_blank" class="text-white">
                            <img src="{{ asset('assets/logo/tiktok.png') }} "alt="TikTok" height="20" style="margin-right: 15px; margin-left: 15px;">
                        </a>
                        <a href="https://www.instagram.com/busurmamasa" target="_blank" class="text-white">
                            <img src="{{ asset('assets/logo/instagram.png') }}" alt="Instagram" height="20" style="margin-left: 15px;">
                        </a>
                    </div>
                    <div class="col-md-12">
                        <h6 style="font-size: 10px;" class="mb-0 mt-2" style="margin-left: 15px">&copy; {{ date('Y') }} Busur Mamasa. All rights reserved.</h6>
                    </div>
                </div>
            </div>
        </footer>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
