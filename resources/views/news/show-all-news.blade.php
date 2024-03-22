@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    <h5 class="display-4 text-center mb-4 mt-4" style="font-family: 'Roboto', sans-serif;">All News</h5>
                </div>
                <div class="row">
                    <h6 class="display-6 text-left mb-2 fs-3" style="font-family: 'Roboto', sans-serif;">Trending</h6>
                    @foreach ($news as $newsItem)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card mt-4 mb-4">
                                <a href="{{ route('news-show',['news'=> $newsItem->id]) }}" class="text-dark text-decoration-none">
                                    <img src="{{ asset('assets/img/thumbnail/' . $newsItem->thumbnail_path) }}" class="card-img-top" alt="News Thumbnail" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title fs-6">{{ $newsItem->judul }}</h5>
                                        <h5 class="card-title fs-6">{{ $newsItem->judul_bawah }}</h5>
                                        <p class="card-text">{{ \Carbon\Carbon::parse($newsItem->tanggal_terbit)->format('d F Y') }}</p>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                            <div>
                                                <a href="{{ route('news-edit', ['news' => $newsItem->id]) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('news-delete', ['news' => $newsItem->id]) }}" method="post" style="display: inline-block;">
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
                    @endforeach
                </div>
                <div class="row">
                    <h6 class="display-6 text-left mb-2 fs-3" style="font-family: 'Roboto', sans-serif;">News</h6>
                    @foreach ($newsbottom as $newsItem)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card mt-4 mb-4">
                                <a href="{{ route('news-bottom-show',['newsbottom'=> $newsItem->id]) }}" class="text-dark text-decoration-none">
                                    <img src="{{ asset('assets/img2/thumbnail2/' . $newsItem->thumbnail) }}" class="card-img-top" alt="News Thumbnail" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title fs-6">{{ $newsItem->judul }}</h5>
                                        <h5 class="card-title fs-6">{{ $newsItem->judul_bawah }}</h5>
                                        <p class="card-text">{{ \Carbon\Carbon::parse($newsItem->tanggal_terbit)->format('d F Y') }}</p>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                            <div>
                                                <a href="{{ route('news-bottom-edit', ['newsbottom' => $newsItem->id]) }}" class="btn btn-warning">Edit</a>
                                                <form action="{{ route('news-bottom-delete', ['newsbottom' => $newsItem->id]) }}" method="post" style="display: inline-block;">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
