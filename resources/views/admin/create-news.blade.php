@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" >
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body" >
                    <form action="{{ route('news-store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="fw-bold" for="judul">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="fw-bold" for="isi">Berita</label>
                            <textarea name="isi" id="berita" class="form-control" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold" for="penulis">Penulis</label>
                            <select name="penulis_id" id="penulis" class="form-control">
                                <option selected disabled>Select Admin</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold" for="penulis">Kategori Berita</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option selected disabled>Select Category</option>
                                @foreach ($category as $categories)
                                    <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="fw-bold" for="tanggal_terbit">Tanggal Pembuatan</label>
                            <input type="date" name="tanggal_terbit" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="fw-bold" for="thumbnail_path">Thumbnail</label>
                            <input type="file" name="thumbnail_path" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-3">Create News</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#berita').summernote({
            placeholder: 'masukan berita',
            tabsize: 2,
            height: 300
        });
    });
</script>

@endsection
