@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">Create Event</div>
                <div class="card-body">
                        @if ($errors->any())
                         <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                   @endforeach
                                </ul>
                         </div>
                        @endif
                    <form action="{{ route('events-store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="mt-2" for="title">Event Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="ex: Ulang Tahun Mamasa" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mt-2" for="date">Date</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mt-2" for="location">Event Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" placeholder="Tribun Mamasa" value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mt-2" for="thumbnail_event">Thumbnail Event</label>
                            <input type="file" class="form-control @error('thumbnail_event') is-invalid @enderror" id="thumbnail_event" name="thumbnail_event">
                            @error('thumbnail_event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
