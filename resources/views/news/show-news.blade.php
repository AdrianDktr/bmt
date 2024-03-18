@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card mt-4 mb-4">
                <div class="card-header">{{ __('Show News') }}</div>
                <div class="card-body text-center overflow-auto">
                    <a href="{{ route('index-news') }}" class="btn btn-primary mb-3 text-left" style="float: left;">Kembali</a>
                    <div style="clear: both;"></div>
                    <br>
                    <div style="margin-bottom: 20px;">
                        <h1 class="fs-4">{{ $news->judul }}</h1>
                    </div>
                    <br>
                    <img  src="{{ asset('assets/img/thumbnail/' . $news->thumbnail_path) }}" alt="Featured News Image" width="450">
                    <p>
                        Sumber gambar : {{ $news->photo_by }}
                    </p>
                    <br>
                    <div class="mx-auto" style="max-width: 800px;">
                        <div style="text-align: left;">
                            <style>
                                img {
                                    display: block;
                                    margin-left: auto;
                                    margin-right: auto;
                                }
                            </style>
                              @if($news->penulis_berita)
                              <p>Penulis : {{ $news->penulis_berita }}</p>
                              @endif
                            {!! $news->isi !!}
                        </div>
                    </div>
                    @if($news->video_link)
                        <iframe width="560" height="315" src="{{ $news->video_link }}" frameborder="0" allowfullscreen></iframe>
                    @elseif($news->video_file)
                        <video width="560" height="315" controls>
                            <source src="{{ asset('assets/vid/' . $news->video_file) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                    <p>
                        Posted by {{ optional($news->penulis)->name }} on {{ \Carbon\Carbon::parse($news->tanggal_terbit)->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
