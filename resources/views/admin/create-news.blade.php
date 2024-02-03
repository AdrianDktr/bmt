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
<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load Bootstrap 5 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Load Summernote CSS and JS for Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<!-- Inisialisasi Summernote -->
<script>
    $(document).ready(function() {
        $('#berita').summernote({
            placeholder: 'Hello Bootstrap 5',
            tabsize: 2,
            height: 300 // Sesuaikan dengan kebutuhan
        });
    });
</script>

@endsection
