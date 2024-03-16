@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('News') }}</div>
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
                    <form action="{{ route('news-store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="fw-bold" for="judul">Judul</label>
                            <input type="text" name="judul" placeholder="Judul" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="isi">Berita</label>
                            <textarea name="isi" id="berita" class="form-control" rows="10"></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="penulis">Admin</label>
                            <select name="user_id" id="penulis" class="form-control">
                                <option selected disabled>Select Admin</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ Auth::check() && Auth::user()->id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="judul">Penulis</label>
                            <input type="text" name="penulis_berita" placeholder="Penulis berita" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="foto_oleh">Sumber Foto</label>
                            <input type="text" name="photo_by" placeholder="Sumber Foto" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="penulis">Kategori Berita</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option selected disabled>Select Category</option>
                                @foreach ($category as $categories)
                                    <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="tanggal_terbit">Tanggal Pembuatan</label>
                            <input type="date" name="tanggal_terbit" class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label for="video" class="fw-bold">Video</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="video_upload" name="video_option" value="upload" checked onchange="toggleVideoInput()">
                                <label class="form-check-label" for="video_upload">Upload Video</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="video_import" name="video_option" value="import" onchange="toggleVideoInput()">
                                <label class="form-check-label" for="video_import">Import Tautan Video</label>
                            </div>
                        </div>

                        <div id="videoInput">
                            <div id="videoUploadDiv">
                                <label class="btn btn-primary">
                                    <input type="file" id="videoUpload" accept="video/mp4,video/webm,video/quicktime" name="video_file" style="display:none;" onchange="displaySelectedFile()">
                                    Choose File
                                </label>
                            </div>
                            <div id="videoLinkDiv" style="display:none;">
                                <label class="fw-bold" for="videoLink">Tautan Video:</label><br>
                                <input type="text" id="videoLink" name="video_link" class="form-control"><br>
                            </div>
                        </div>

                        <div id="fileSelected"></div>
                        <div class="form-group mt-3">
                            <label class="fw-bold" for="thumbnail_path">Thumbnail</label>
                            <input type="file" name="thumbnail_path" class="form-control">
                        </div>

                        <div class="form-group mt-3">
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
            placeholder: 'Masukkan berita',
            tabsize: 2,
            height: 300
        });
    });

    function toggleVideoInput() {
        var option = document.querySelector('input[name="video_option"]:checked').value;
        var videoUploadDiv = document.getElementById("videoUploadDiv");
        var videoLinkDiv = document.getElementById("videoLinkDiv");

        if (option === "upload") {
            videoUploadDiv.style.display = "block";
            videoLinkDiv.style.display = "none";
        } else {
            videoUploadDiv.style.display = "none";
            videoLinkDiv.style.display = "block";
        }

    }

    function displaySelectedFile() {
    var input = document.getElementById('videoUpload');
    var output = document.getElementById('fileSelected');
    output.innerHTML = 'Selected File: ' + input.files[0].name;
}
</script>

@endsection
