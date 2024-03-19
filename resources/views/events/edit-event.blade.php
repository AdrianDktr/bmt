@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">Edit Event</div>
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('events-update', ['event' => $event->id]) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="mt-2" for="title">Event Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="ex: Ulang Tahun Mamasa" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label class="mt-2" for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}">
                        </div>
                        <div class="form-group">
                            <label class="mt-2" for="location">Event Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Tribun Mamasa" value="{{ old('location') }}">
                        </div>
                        <div class="form-group">
                            <label class="mt-2" for="location">Thumbnail Event</label>
                            <input type="file" name="thumbnail_event" class="form-control">
                                @if($event->thumbnail_event)
                                    <img src="{{ asset('assets/events/' . $news->thumbnail_event) }}" alt="Current Thumbnail" class="img-fluid mt-2" style="max-width: 200px;">
                                @endif
                            <small class="text-muted">Current Thumbnail</small>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
