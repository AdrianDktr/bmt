@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">{{ __('Show News') }}</div>
                <div class="card-body text-center overflow-auto">
                    <a href="{{ route('index-news') }}" class="btn btn-primary mb-3 text-left" style="float: left;">Kembali</a>
                    <div style="clear: both;"></div>
                    <br>
                    <div style="margin-bottom: 20px;">
                        <h1 class="fs-4">{{ $newsbottom->judul_bawah }}</h1>
                    </div>
                    <br>
                    <img src="{{ asset('assets/img2/thumbnail2/' . $newsbottom->thumbnail) }}" class="align-self-start mr-3 img-fluid" alt="News Thumbnail" width="450">
                    <p>
                        Sumber gambar : {{ $newsbottom->photo_by }}
                    </p>
                    <br>
                    <div class="mx-auto" style="max-width: 800px;">
                        <div style="text-align: left; margin-bottom: 20px;">
                            <style>
                                img {
                                    display: block;
                                    margin-left: auto;
                                    margin-right: auto;
                                }
                            </style>
                             @if($newsbottom->penulis_berita)
                             <p>Penulis Berita: {{ $newsbottom->penulis_berita }}</p>
                             @endif
                            {!! $newsbottom->berita !!}
                        </div>
                    </div>
                    @if($newsbottom->video_link)
                        <iframe width="560" height="315" src="{{ $newsbottom->video_link }}" frameborder="0" allowfullscreen></iframe>
                    @elseif($newsbottom->video_file)
                        <video width="560" height="315" controls>
                            <source src="{{ asset('assets/vid/' . $newsbottom->video_file) }}" type="video/mp4">
                            Browser tidak mendukung tag video.
                        </video>
                    @endif
                    <p>
                        Diposting oleh {{ optional($newsbottom->penulis)->name }} pada {{ \Carbon\Carbon::parse($newsbottom->tanggal_terbit)->format('F d, Y') }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
