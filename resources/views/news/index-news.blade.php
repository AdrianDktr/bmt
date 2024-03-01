@extends('layouts.app')

@section('content')
    <!-- Trending News Section -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-8">
                        <form action="{{ route('index-news') }}" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search news..." name="query" value="{{ request('query') }}" style="background-color: rgba(255, 255, 255, 0.9); border: 1px solid #ced4da; padding: 10px;" >
                                <button type="submit" id="searchButton" class="btn btn-primary">
                                    <strong> Search</strong>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    document.querySelector("form").addEventListener("submit", function(event) {
                        var query = event.target.elements.query.value;
                        if (!query.trim()) {
                            event.preventDefault();
                            window.location.href = "{{ route('index-news') }}";
                        }
                    });
                </script>
                <div class="card mb-4" >
                    <div class="card-header">{{ __('Trending') }}</div>
                    <div class="container px-4 px-lg-5" style="max-height: 600px; overflow-y: auto;">
                        <div class="row gx-4 gx-lg-5 justify-content-center">
                            <div class="col-md-10 col-lg-8 col-xl-7">
                                <br>
                                @if(empty($searchResults['news']))
                                    <p class="text-center"></p>
                                @endif
                                @foreach ($searchResults['news'] ?? $news as $data)
                                    @if(is_object($data))
                                        <div class="card mb-4">
                                            <div class="card-body bg-light news-item-wrapper">
                                                <a href="{{ is_object($data) ? route('news-show', ['news' => $data->id]) : '#' }}">

                                                    @if (is_object($data) && !empty($data->thumbnail_path))
                                                        <img class="card-img-top news-thumbnail" src="{{ asset('assets/img/thumbnail/' . $data->thumbnail_path) }}" alt="card image cap">
                                                    @else
                                                        <img class="card-img-top news-thumbnail" src="{{ asset('placeholder-image.jpg') }}" alt="placeholder image">
                                                    @endif

                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <a href="{{ route('news-show',['news'=>$data->id]) }}">{{ $data->judul }}</a>
                                                        </h5>
                                                    </div>
                                                </a>
                                                <p class="post-meta">
                                                    Posted by {{ optional($data->penulis)->name }}
                                                    on {{ \Carbon\Carbon::parse($data->tanggal_terbit)->format('d F Y') }}
                                                </p>
                                                @if (Auth::check() && Auth::user()->is_admin)
                                                    <div class="d-flex">
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
                                        <hr class="my-4" />
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="running-text-container">
                    <div class="running-text">
                        The New Mamasa Bersih Melayani !
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="col-md-6 mb-4">
            <div class="d-flex align-items-start">
                <video width="320" height="200" controls class="me-3">
                    <source src="{{ asset('assets/vid/mamasa.mp4') }}" type="video/mp4">
                        {{-- hCITOL HILL, PENAWAR SAAT LELAH DENGAN BISINGNYA KOTA --}}
                </video>
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
                {{-- @if ($all_news > 10) Jika total berita lebih dari 10, tampilkan tombol View More --}}
                    <div class="text-center mt-4">
                        <a href="{{ route('show-all-news') }}" class="btn btn-primary">View More</a>
                    </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>


@endsection
