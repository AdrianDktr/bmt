@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">{{ __('Show News') }}</div>
                    <div class="card-body text-center overflow-auto">
                        <a href="{{ route('index-news') }}" class="btn btn-primary mb-3 text-left" style="float: left;">Kembali</a>
                    <div style="float: left;">
                        <h1>{{ $news->judul }}</h1>
                    </div>
                    <div class="mx-auto" style="max-width: 800px;">
                        <div style="text-align: left;">
                            <style>
                                img {
                                    display: block;
                                    margin-left: auto;
                                    margin-right: auto;
                                }
                            </style>
                            {!! $newsbottom->berita !!}
                        </div>
                    </div>
                    <p>
                        Posted by {{ optional($newsbottom->penulis)->name }} on {{ \Carbon\Carbon::parse($newsbottom->tanggal_terbit)->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
