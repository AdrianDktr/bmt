@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <h5 class="display-4 text-center mb-4 mt-4" style="font-family: 'Roboto', sans-serif; font-size: 24px;">Search Results for "{{ $keyword ?? '' }}"</h5>
            </div>
            <div class="row">
                @if(isset($searchResults))
                @foreach ($searchResults as $result)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        @if ($result instanceof \App\Models\News)
                        <img src="{{ asset('assets/img/thumbnail/' . $result->thumbnail_path) }}" class="card-img-top" alt="Featured News Image" style="height: 200px; object-fit: cover;">
                        @elseif ($result instanceof \App\Models\NewsBottom)
                        <div class="text-center">
                            <img src="{{ asset('assets/img2/thumbnail2/' . $result->thumbnail) }}" class="card-img-top" alt="Featured News Bottom Image" style="height: 200px; object-fit: cover;">
                            <h5 class="card-title mt-4" style="font-size: 14px;">{{ $result->judul_bawah }}</h5>
                        </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 14px;">{{ $result->judul }}</h5>
                            <p class="card-text">{{ \Illuminate\Support\Str::limit($result->content, 100) }}</p>
                            <a href="{{ route('news-show', ['news' => $result->id]) }}" class="btn btn-primary">Read More</a>
                        </div>
                        @if (Auth::check() && Auth::user()->is_admin)
                        <div class="card-footer">
                            <a href="{{ route('news-edit', ['news' => $result->id]) }}" class="btn btn-warning me-2">Edit</a>
                            <form action="{{ route('news-delete', ['news' => $result->id]) }}" method="post" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Delete</button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
