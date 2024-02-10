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
                                <button type="submit" class="btn btn-primary">
                                    <strong> Search</strong>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    document.getElementById("searchButton").addEventListener("click", function(event) {
                        var query = document.getElementById("searchInput").value;
                        if (!query.trim()) {
                            event.preventDefault(); // Mencegah pengiriman formulir
                            window.location.href = "{{ route('index-news') }}"; // Arahkan kembali ke halaman index-news
                        }
                    });
                </script>
                <div class="card mb-4" style="max-height: 600px; overflow-y: auto;">
                    <div class="card-header">{{ __('Trending') }}</div>
                    <div class="container px-4 px-lg-5">
                        <div class="row gx-4 gx-lg-5 justify-content-center">
                            <div class="col-md-10 col-lg-8 col-xl-7">
                                <br>
                                @if(empty($searchResults['news']))
                                    <p class="text-center"></p>
                                @endif
                                @foreach ($searchResults['news'] ?? $news as $data)
                                    @if(is_object($data)) <!-- Periksa apakah $data adalah objek -->
                                        <div class="card mb-4">
                                            <div class="card-body bg-light news-item-wrapper">
                                                <a href="{{ is_object($data) ? route('news-show', ['news' => $data->id]) : '#' }}">
                                                    <!-- Link to detail page -->
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

    <div class="container">
        <div class="col-md-6 mb-4">
            <div class="d-flex align-items-start">
                <video width="320" height="200" controls class="me-3">
                    <source src="{{ asset('assets/vid/mamasa.mp4') }}" type="video/mp4">
                        CITOL HILL, PENAWAR SAAT LELAH DENGAN BISINGNYA KOTA
                </video>
            </div>
            <div class="mt-2">
                <div>
                    <h4><strong>Facilis consequatur eligendi</strong></h4>
                </div>
                <p class="text-muted">
                    Dari ketinggian di atas 1.000 MdPL. kawasan wisata Citol Hill di Kabupaten Mamasa menawarkan kesejukan dan keindahan tak terperi. Lokasi ini relatif tidak jauh dari pusat
                </p>
            </div>
        </div>
    </div>
    <!-- Main News Section -->
    <div class="container">
        <div class="row">
            <span class="display-3 fw-bold text-center mb-4">{{ __('News') }}</span>
        </div>
        <section>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $chunked_news = collect($searchResults['newsbottom'] ?? $newsbottom)->chunk(6);
                    @endphp
                    @foreach ($chunked_news as $key => $chunk)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="row gx-lg-5">
                                @foreach ($chunk->take(3) as $newsbot)
                                    @if(is_object($newsbot))
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                            <div>
                                                <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}" class="text-dark">
                                                    <div class="row mb-4 border-bottom pb-2">
                                                        <div class="col-4">
                                                            <img src="{{ asset('assets/img2/thumbnail2/' . $newsbot->thumbnail) }}" class="img-fluid shadow-1-strong rounded mb-3" />
                                                        </div>
                                                        <div class="col-8">
                                                            <p class="mb-2"><strong>{{ $newsbot->judul_bawah }}</strong></p>
                                                            <p>
                                                                <u>{{ \Carbon\Carbon::parse($newsbot->tanggal_terbit)->format('d F Y') }}</u>
                                                            </p>
                                                            <p>
                                                                <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}">Read more</a>
                                                            </p>
                                                            @if (Auth::check() && Auth::user()->is_admin)
                                                                <a href="{{ route('news-bottom-edit', ['newsbottom' => $newsbot->id]) }}" class="btn btn-warning">Edit</a>
                                                                <form action="{{ route('news-bottom-delete', ['newsbottom' => $newsbot->id]) }}" method="post" style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row gx-lg-5">
                                @foreach ($chunk->slice(3, 3) as $newsbot)
                                    @if(is_object($newsbot))
                                        <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                            <div>
                                                <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}" class="text-dark">
                                                    <div class="row mb-4 border-bottom pb-2">
                                                        <div class="col-4">
                                                            <img src="{{ asset('assets/img2/thumbnail2/' . $newsbot->thumbnail) }}" class="img-fluid shadow-1-strong rounded mb-3" />
                                                        </div>
                                                        <div class="col-8">
                                                            <p class="mb-2"><strong>{{ $newsbot->judul_bawah }}</strong></p>
                                                            <p>
                                                                <u>{{ \Carbon\Carbon::parse($newsbot->tanggal_terbit)->format('d F Y') }}</u>
                                                            </p>
                                                            <p>
                                                                <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}">Read more</a>
                                                            </p>
                                                            @if (Auth::check() && Auth::user()->is_admin)
                                                                <a href="{{ route('news-bottom-edit', ['newsbottom' => $newsbot->id]) }}" class="btn btn-warning">Edit</a>
                                                                <form action="{{ route('news-bottom-delete', ['newsbottom' => $newsbot->id]) }}" method="post" style="display: inline-block;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    </div>


    <script>
        $(document).ready(function() {
            $('#carouselExampleControls').carousel();
        });
    </script>



@endsection
