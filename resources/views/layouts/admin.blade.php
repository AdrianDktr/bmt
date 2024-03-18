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

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        {{-- <link rel="stylesheet" href="{{ asset('/assets/css/runningtext.css')}}"> --}}
        <link rel="stylesheet" href="{{ asset('assets/css/runtext.css') }}">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>

<body>
        <marquee style="color:aliceblue;  background-color:#212529;width:100%;font-size:16px;font-family:'Raleway',sans-serif;font-weight:150;height:20px; display: block;"> The New Mamasa Bersih Melayani ! </marquee>
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm pb-3" style="background-color:#212529;">
            <div class="container-fluid">
                <img src="{{ asset('assets/logo/bsrmamasa.png') }}" alt="Logo" height="40" class="d-inline-block align-text-top rounded-circle" style="background-color:#212529;">
                <strong style="margin-left: 10px; color:white ">BUSUR MAMASA</strong>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse justify-content-end  " id="navbarSupportedContent">
                <ul class="navbar-nav">
                 <li class="nav-item">
                    <a class="nav-link" href="{{ route('events-create') }}">Create Events</a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('create-news-bottom') }}">Create News Bottom</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('news-create') }}">Create News</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Logout</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        {{-- nav baru --}}
        <!-- Navigation -->

       {{-- <nav class="navbar navbar-expand-md navbar-light bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="color: white; display: flex; align-items: center; margin-top: 10px;">
                    <img src="{{ asset('assets/logo/bsrmamasa.png') }}" alt="Logo" height="40" class="d-inline-block align-text-top rounded-circle">
                    <strong style="margin-left: 10px; font-size: 1rem;">Busur Mamasa</strong>
                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" style="border-color: white;">
                    <span class="navbar-toggler-icon" style="background-color: white;"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
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
                                    <a class="dropdown-item" href="{{ route('news-create') }}">Create News</a>
                                    <a class="dropdown-item" href="{{ route('create-news-bottom') }}">Create Bottom News</a>
                                    <div class="dropdown-divider"></div>
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
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm ">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto">
                        @foreach(\App\Models\NewsCategory::all() as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('category-news', ['category' => $category->id]) }}" style="font-size: 10px; margin-right: 10px;">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav> --}}


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Search Form -->
                    <form action="{{ route('index-news') }}" method="GET" id="searchForm">
                        <div class="input-group mb-3 mt-4">
                            <input type="text" class="form-control" placeholder="Search news..." name="query" value="{{ request('query') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <!-- Large Featured News -->
                    <div class="card mb-4">
                      <div class="card-header"> <strong>{{ __('Trending News') }}</strong></div>
                        <div class="card-body bg-light">
                            @foreach ($searchResults['news'] ?? $news as $data)
                                @if(is_object($data))
                                    @if($loop->first)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="{{ route('news-show',['news'=> $data->id]) }}">
                                                <img class="card-img-top" src="{{ asset('assets/img/thumbnail/' . $data->thumbnail_path) }}" alt="Featured News Image">
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                            <h5 class="card-title mt-3">
                                                <a href="{{ route('news-show',['news'=> $data->id]) }}" style="color: inherit; text-decoration: none;">{{ $data->judul }}</a>
                                            </h5>
                                            <p class="card-text">{{ $data->deskripsi }}</p>
                                            <p class="post-meta text-dark" style="font-size: 12px;">
                                                Posted by {{ optional($data->penulis)->name }}
                                                on {{ \Carbon\Carbon::parse($data->tanggal_terbit)->format('d F Y') }}
                                            </p>

                                            @if (Auth::check() && Auth::user()->is_admin)
                                                <div class="mt-2">
                                                    <a href="{{ route('news-edit', ['news' => $data->id]) }}" class="btn btn-warning me-2">Edit</a>
                                                    <form action="{{ route('news-delete', ['news' => $data->id]) }}" method="post" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4 mt-4">
                        <div class="card-header">{{ __('Trending ') }}</div>
                        @php
                        $displayedNewsIds = [];
                        @endphp

                        <div class="card-body h-100" style="max-height: 500px; overflow-y: auto;">
                            @foreach ($searchResults['news'] ?? $news as $data)
                                @if(is_object($data) && !$loop->first && !in_array($data->id, $displayedNewsIds) && count($displayedNewsIds) < 6)
                                <div class="item">
                                    <div class="media mb-3 d-flex flex-column align-items-center">
                                        <a href="{{ route('news-show', ['news' => $data->id]) }}" class="text-decoration-none text-dark">
                                            <img src="{{ asset('assets/img/thumbnail/' . $data->thumbnail_path) }}" class="align-self-center mb-3 img-fluid" alt="News Thumbnail" style="width: 200px; height: 150px; object-fit: cover;">

                                            <div class="media-body text-center">
                                                <h5 class="mb-0" style="font-size: 14px;">{{ $data->judul }}</h5>
                                                <div class="post-meta text-dark mt-2" style="font-size: 12px;">
                                                    <p>Posted by {{ optional($data->penulis)->name }}</p>
                                                    <p>on {{ \Carbon\Carbon::parse($data->tanggal_terbit)->format('d F Y') }}</p>
                                                </div>
                                                <p>{{ $data->deskripsi }}</p>
                                                @if (Auth::check() && Auth::user()->is_admin)
                                                    <div>
                                                        <a href="{{ route('news-edit', ['news' => $data->id]) }}" class="btn btn-warning me-2">Edit</a>
                                                        <form action="{{ route('news-delete', ['news' => $data->id]) }}" method="post" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                    @php
                                        $displayedNewsIds[] = $data->id;
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script>
            document.querySelector("#searchForm").addEventListener("submit", function(event) {
                var query = event.target.elements.query.value;
                if (!query.trim()) {
                    event.preventDefault();
                    window.location.href = "{{ route('index-news') }}";
                }
            });
        </script>
        <br>
        <br>
        <div class="video mb-auto">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/rdenq1CP1h4" title="PART 1 EKSEKUSI LANGSUNG PEMDA KABUPATEN MAMASA! 🚀" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    <br>
    <br>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="row">
                        <h5 class="display-4 text-center mb-4" style="font-size: 2rem; font-family: 'Roboto', sans-serif;">News</h5>
                    </div>
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @php
                                $chunked_news = collect($searchResults['newsbottom'] ?? $newsbottom)->chunk(4);
                            @endphp
                            @foreach ($chunked_news as $key => $chunk)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <div class="row justify-content-center">
                                        @foreach ($chunk as $newsbot)
                                            @if(is_object($newsbot))
                                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 mb-lg-0">
                                                <div class="card h-100 d-flex flex-column">
                                                    <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}" class="text-dark text-decoration-none">
                                                        <img src="{{ asset('assets/img2/thumbnail2/' . $newsbot->thumbnail) }}" class="card-img-top" alt="News Thumbnail">
                                                        <div class="card-body flex-grow-1">
                                                            <h5 class="card-title fs-6">{{ $newsbot->judul_bawah }}</h5>
                                                            <p class="card-text">{{ \Carbon\Carbon::parse($newsbot->tanggal_terbit)->format('d F Y') }}</p>
                                                        </div>
                                                    </a>
                                                    @if (Auth::check() && Auth::user()->is_admin)
                                                        <div class="card-footer mt-auto">
                                                            <a href="{{ route('news-bottom-edit', ['newsbottom' => $newsbot->id]) }}" class="btn btn-warning me-2">Edit</a>
                                                            <form action="{{ route('news-bottom-delete', ['newsbottom' => $newsbot->id]) }}" method="post" style="display: inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev" style="background-color: #050505; width: 40px; height: 40px; margin-top: -50px;">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next" style="background-color: #050505; width: 40px; height: 40px; margin-top: -50px;">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <br>
                        <br>
                        <ol class="carousel-indicators">
                            @foreach ($chunked_news as $key => $chunk)
                                <li data-bs-target="#carouselExampleControls" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" style="background-color: #050505;"></li>
                            @endforeach
                        </ol>
                    </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('show-all-news') }}" class="btn btn-primary">View More</a>
                        </div>
                    </div>
            </div>
        </div>

        <div class="container mt-5 mb-5">
            <div class="row">
                <h5 class="display-4 text-center mb-4" style="font-family: 'Roboto', sans-serif; font-size: 2rem;">Explore Mamasa</h5>
            </div>
            <div class="owl-carousel owl-theme mx-auto">
                <div class="item">
                    <div class="card">
                        <img src="{{ asset('assets/slide/BuntuKepa/DSCF8339.JPG') }}" class="card-img-top" alt="Slide 1">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 0.8rem; font-weight: bold;">Buntu Kepa</h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="{{ asset('assets/slide/SARMBULIAWANSUMARORONG/DSCF9007.JPG') }}" class="card-img-top" alt="Slide 2">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 0.8rem; font-weight: bold;">Sarmbu Liawan Sumararorong</h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="{{ asset('assets/slide/TondokBakaru/tondokbakaru.jpg') }}" class="card-img-top" alt="Slide 3">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 0.8rem; font-weight: bold;">Tondok Bakaru</h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="{{ asset('assets/slide/Liarawan/diatasawanliarra.jpeg') }}" class="card-img-top" alt="Slide 3">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 0.8rem; font-weight: bold;">Buntu Liarra</h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card">
                        <img src="{{ asset('assets/slide/SebelahTondokBakaru/DSCF3582.jpg') }}" class="card-img-top" alt="Slide 3">
                        <div class="card-body text-center">
                            <h5 class="card-title" style="font-size: 0.8rem; font-weight: bold;">Rantai Pokok</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
           $(document).ready(function(){
                $(".owl-carousel").owlCarousel({
                    loop: true,
                    margin: 10,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:2
                        },
                        1000:{
                            items:4
                        }
                    }
                });
            });

        </script>

        <footer class="bg-dark shadow-sm text-white text-center py-2">
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
