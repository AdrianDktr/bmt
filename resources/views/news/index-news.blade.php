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
                <form action="{{ route('index-news') }}" method="GET" id="searchForm">
                    <div class="input-group mb-3">
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
                                            <h5 class="card-title">{{ $data->judul }}</h5>
                                            <p class="card-text">{{ $data->deskripsi }}</p>
                                                <p class="post-meta">
                                                    Posted by {{ optional($data->penulis)->name }}
                                                    on {{ \Carbon\Carbon::parse($data->tanggal_terbit)->format('d F Y') }}
                                                </p>
                                            <div class="d-flex justify-content-between mt-2">
                                                <a href="{{ route('news-show',['news'=> $data->id]) }}" class="btn btn-primary me-2">View More</a>
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
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Other News -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Trending ') }}</div>
                    <div class="card-body">
                        @foreach ($searchResults['news'] ?? $news as $data)
                            @if(is_object($data) && !$loop->first)
                                <div class="media mb-3">
                                    <img src="{{ asset('assets/img/thumbnail/' . $data->thumbnail_path) }}" class="align-self-start mr-3" alt="News Thumbnail">
                                    <div class="media-body">
                                        <h5 class="mt-0">{{ $data->judul }}</h5>
                                        <p>{{ $data->deskripsi }}</p>
                                        <a href="{{ route('news-show', ['news' => $data->id]) }}" class="btn btn-primary">Read more</a>
                                    </div>
                                </div>
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
    <div class="container">
        <div class="row">
            <div class="col">
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="col-md-6 mb-4">
            <div class="d-flex align-items-center">
                <video style="" width="320" height="200" controls class="me-3">
                    <source src="{{ asset('assets/vid/mamasa.mp4') }}" type="video/mp4">
                </video>
            </div>

<div class="d-flex justify-content-center">
    <div>2</div>
    <div>1</div>
</div>

            <div class="mt-2">
                <div>
                    <h4><strong>CITOL HILL, PENAWAR SAAT LELAH DENGAN BISINGNYA KOTA</strong></h4>
                </div>
                <p class="text-muted">
                    Dari ketinggian di atas 1.000 MdPL. kawasan wisata Citol Hill di Kabupaten Mamasa menawarkan kesejukan dan keindahan tak terperi. Lokasi ini relatif tidak jauh dari pusat
                </p>
            </div>
        </div>
    </div>
    <!-- Main News Section -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h5 class="display-4 text-center mb-4" style="font-family: 'Roboto', sans-serif;">News</h5>
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
                                                <div class="card h-100">
                                                    <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}" class="text-dark text-decoration-none">
                                                        <img src="{{ asset('assets/img2/thumbnail2/' . $newsbot->thumbnail) }}" class="card-img-top" alt="News Thumbnail">
                                                        <div class="card-body">
                                                            <h5 class="card-title fs-6">{{ $newsbot->judul_bawah }}</h5>
                                                            <p class="card-text">{{ \Carbon\Carbon::parse($newsbot->tanggal_terbit)->format('d F Y') }}</p>
                                                            {{-- <a href="#" class="btn btn-primary">View more</a> --}}
                                                        </div>
                                                        @if (Auth::check() && Auth::user()->is_admin)
                                                            <div class="card-footer">
                                                                <a href="{{ route('news-bottom-edit', ['newsbottom' => $newsbot->id]) }}" class="btn btn-warning">Edit</a>
                                                                <form action="{{ route('news-bottom-delete', ['newsbottom' => $newsbot->id]) }}" method="post" style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </a>
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

    <div class="container mt-5">
        <div class="row">
            <h5 class="display-4 text-center mb-4" style="font-family: 'Roboto', sans-serif; font-size: 2rem;">Explore Mamasa</h5>
        </div>
        <div class="owl-carousel owl-theme mx-auto">
            <div class="item">
                <div class="card">
                    <img src="{{ asset('assets/slide/BuntuKepa/DSCF8339.JPG') }}" class="card-img-top" alt="Slide 1">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">Buntu Kepa</h5>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <img src="{{ asset('assets/slide/SARMBULIAWANSUMARORONG/DSCF9007.JPG') }}" class="card-img-top" alt="Slide 2">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">Sarmbu Liawan Sumararorong</h5>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <img src="{{ asset('assets/slide/TondokBakaru/tondokbakaru.jpeg') }}" class="card-img-top" alt="Slide 3">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">Tondok Bakaru</h5>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card">
                    <img src="{{ asset('assets/slide/Liarawan/diatasawanliarra.jpeg') }}" class="card-img-top" alt="Slide 3">
                    <div class="card-body text-center">
                        <h5 class="card-title" style="font-size: 1rem; font-weight: bold;">Buntu Liarra</h5>
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
                autoplay: true, // Bergeser setiap 5 detik
                autoplayTimeout: 5000, // Durasi 5 detik
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
{{-- <div class="item">
                <div class="card">
                    <img src="{{ asset('assets/slide/TondokBakaru/DJI_0693.JPG') }}" class="card-img-top" alt="Slide 4">
                    <div class="card-body">
                        <h5 class="card-title">Slide 4</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div> --}}
