@extends('layouts.app')

@section('content')
    <!-- Trending News Section -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">{{ __('Trending') }}</div>
                    <div class="container px-4 px-lg-5">
                        <div class="row gx-4 gx-lg-5 justify-content-center">
                            <div class="col-md-10 col-lg-8 col-xl-7">
                                <br>
                                @foreach ($news as $data)
                                    <div class="card mb-4">
                                        <div class="card-body bg-light">
                                            <a href="{{ route('news-show', ['news' => $data->id]) }}">
                                                <!-- Link to detail page -->
                                                <img class="card-img-top" src="{{ asset('assets/img/thumbnail/' . $data->thumbnail_path) }}" alt="card image cap" height="216" width="216">
                                                <h2 class="post-title">{{ $data->judul }}</h2>
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
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main News Section -->
    <div class="container">
        <div class="row">
            <span class="display-3 fw-bold text-center mb-4">{{ __('News') }}</span>
        </div>
        <div class="container"></div>
        <section>
            <div class="row gx-lg-5">
                @foreach ($newsbottom as $newsbot)
                    <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                        <div>
                            <a href="{{ route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}" class="text-dark">
                                <div class="row mb-4 border-bottom pb-2">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/img2/thumbnail2/' . $newsbot->thumbnail) }}" class="img-fluid shadow-1-strong rounded"  />
                                    </div>
                                    <div class="col-9">
                                        <p class="mb-2"><strong>{{ $newsbot->judul_bawah }}</strong></p>
                                            <p>
                                                <u>
                                                    {{ \Carbon\Carbon::parse($newsbot->tanggal_terbit)->format('d F Y') }}
                                                </u>
                                            </p>
                                        <p>
                                            <a href="{{route('news-bottom-show',['newsbottom'=>$newsbot->id]) }}">Read more</a>
                                        </p>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                        <a href="{{ route('news-bottom-edit', ['newsbottom' => $newsbot->id]) }}" class="btn btn-primary">Edit</a>
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
                @endforeach
            </div>
        </section>
    </div>
@endsection
