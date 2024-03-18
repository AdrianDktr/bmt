@extends('layouts.app')

@section('content')
    <!-- Trending News Section -->
    <div class="container">
        <div class="bg-img">

        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Search Form -->
                <br>
                <form action="{{ route('index-news') }}" method="GET" id="searchForm">
                    <div class="input-group mb-3 mt-4">
                        <input type="text" class="form-control" placeholder="Search news..." name="query" value="{{ request('query') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
                <br>
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
                {{-- Event --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Upcoming Events</strong>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row">
                            @foreach($events as $event)
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <img class="card-img-top" src="{{ asset('assets/events/' . $data->thumbnail_event) }}" alt="Featured News Image">
                                        <h5 class="card-title">{{ $event->title }}</h5>
                                        <p class="card-text text-center mt-3"><b>{{ $event->date }}</b></p>
                                        <p class="text-center"><b>{{ $event->location }}</b></p>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                            <a href="{{ route('events-edit', ['event' => $event->id]) }}" class="btn btn-warning me-2 text-center">Edit</a>
                                            <form action="{{ route('events-delete', ['event' => $event->id]) }}" method="post" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4">
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
                                    <div class="card">
                                        <a href="{{ route('news-show', ['news' => $data->id]) }}" class="text-decoration-none text-dark">
                                            <img src="{{ asset('assets/img/thumbnail/' . $data->thumbnail_path) }}" class="card-img-top" alt="News Thumbnail" style="object-fit: cover; height: 250px;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $data->judul }}</h5>
                                                <p class="card-text">{{ $data->deskripsi }}</p>
                                                <div class="post-meta text-muted">
                                                    <p>Posted by {{ optional($data->penulis)->name }} on {{ \Carbon\Carbon::parse($data->tanggal_terbit)->format('d F Y') }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                        <div class="card-footer">
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
                <iframe width="100%" height="400" src="https://www.youtube.com/embed/rdenq1CP1h4" title="PART 1 EKSEKUSI LANGSUNG PEMDA KABUPATEN MAMASA! 🚀" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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



@endsection

