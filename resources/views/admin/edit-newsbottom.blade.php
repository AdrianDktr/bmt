@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit News') }}</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('news-bottom-update', $newsbottom) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control" value="{{ old('judul', $newsbottom->judul) }}">
                        </div>
                        <div class="form-group">
                            <label for="isi">Isi</label>
                            <textarea name="isi" id="summernote" class="form-control" rows="10">{{ old('isi', $newsbottom->isi) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="penulis">Penulis</label>
                            <select name="penulis_id" id="penulis" class="form-control">
                                <option selected disabled>Select Admin</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('penulis_id', $newsbottom->penulis_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
                            <label for="tanggal_terbit">Tanggal Pembuatan</label>
                            <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit', $newsbottom->tanggal_terbit) }}">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail_path">Thumbnail</label>
                            <input type="file" name="thumbnail_path" class="form-control">
                            <img src="{{ asset('assets/img/thumbnail/' . $newsbottom->thumbnail_path) }}" alt="Current Thumbnail" class="img-fluid mt-2" style="max-width: 200px;">
                            <small class="text-muted">Current Thumbnail</small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-3">Update News</button>
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
        $('#summernote').summernote({
            placeholder: 'masukan berita',
            tabsize: 2,
            height: 300
        });
    });
</script>

@endsection
