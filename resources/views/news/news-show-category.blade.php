@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header"><strong>{{ $category->name }}</strong></div>
                <div class="container px-4 px-lg-5">
                    <div class="row gx-4 gx-lg-5 justify-content-center">
                        <div class="col-md-10 col-lg-8 col-xl-7">
                            <br>
                            @foreach ($mergedNews as $newsItem)
                                @if ($loop->first) <!-- Hanya tampilkan satu berita pertama -->
                                    <div class="card mb-4">
                                        <div class="card-body bg-light">
                                            <!-- Memeriksa apakah artikel berasal dari model News atau NewsBottom -->
                                            @if ($newsItem instanceof \App\Models\News)
                                                <a href="{{ route('news-show', ['news' => $newsItem->id]) }}">
                                                    <img class="card-img-top img-fluid mb-3" src="{{ asset('assets/img/thumbnail/' . $newsItem->thumbnail_path) }}" alt="Card image cap">
                                                </a>
                                            @elseif ($newsItem instanceof \App\Models\NewsBottom)
                                                <a href="{{ route('news-bottom-show', ['newsbottom' => $newsItem->id]) }}">
                                                    <img src="{{ asset('assets/img2/thumbnail2/' . $newsItem->thumbnail) }}" class="img-fluid shadow-1-strong rounded mb-3" />
                                                </a>
                                            @endif

                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <a href="{{ $newsItem instanceof \App\Models\News ? route('news-show', ['news' => $newsItem->id]) : route('news-bottom-show', ['newsbottom' => $newsItem->id]) }}">{{ $newsItem->judul }}</a>
                                                </h5>
                                                <p class="post-meta">Posted by {{ optional($newsItem->penulis)->name }} on {{ \Carbon\Carbon::parse($newsItem->tanggal_terbit)->format('d F Y') }}</p>
                                                {{-- <p class="card-text">{{ $newsItem->judul }}</p> --}}
                                                <a href="{{ $newsItem instanceof \App\Models\News ? route('news-show', ['news' => $newsItem->id]) : route('news-bottom-show', ['newsbottom' => $newsItem->id]) }}" class="btn btn-primary">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
