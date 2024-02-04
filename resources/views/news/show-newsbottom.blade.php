@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-13">
            <div class="card">
                <div class="card-header">{{ __('Show News') }}</div>
                    <div class="card-body text-center overflow-auto">
                        <h1>{{ $news->judul }}</h1>
                    <div class="mx-auto" style="max-width: 800px;">
                        <div style="text-align: left;">
                            {!! $news->isi !!}
                        </div>
                    </div>
                    <p>
                        Posted by {{ optional($news->penulis)->name }} on {{ \Carbon\Carbon::parse($news->tanggal_terbit)->format('F d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
