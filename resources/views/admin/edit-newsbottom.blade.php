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
                            <label class="fw-bold" for="judul">Judul</label>
                            <input type="text" name="judul_bawah" placeholder="Judul" class="form-control" value="{{ old('judul_bawah', $newsbottom->judul_bawah) }}">
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="isi">Berita</label>
                            <textarea name="berita" id="summernote" class="form-control" rows="10">{{ old('berita', $newsbottom->berita) }}</textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="penulis">Admin</label>
                            <select name="user_id" id="penulis" class="form-control">
                                <option selected disabled>Select Admin</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $newsbottom->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="judul">Penulis</label>
                            <input type="text" name="penulis_berita" placeholder="Penulis berita" class="form-control" value="{{ old('penulis_berita',$newsbottom->penulis_berita) }}">
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
                                    <option value="{{ $categories->id }}"{{ old('category_id', $newsbottom->category_id) == $categories->id ? 'selected' : '' }}>{{ $categories->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label class="fw-bold" for="tanggal_terbit">Tanggal Pembuatan</label>
                            <input type="date" name="tanggal_terbit" class="form-control" value="{{ old('tanggal_terbit', $newsbottom->tanggal_terbit) }}">
                        </div>
                        <div class="form-group mt-3">
                            <label class="fw-bold" for="video">Video</label>
                            <div class="d-flex flex-row align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="video_upload" name="video_option" value="upload" {{ old('video_option', isset($newsbottom->video_file) ? 'upload' : '') == 'upload' ? 'checked' : '' }} onchange="toggleVideoInput()">
                                    <label class="form-check-label" for="video_upload">Upload Video</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="video_import" name="video_option" value="import" {{ old('video_option', isset($newsbottom->video_link) ? 'import' : '') == 'import' ? 'checked' : '' }} onchange="toggleVideoInput()">
                                    <label class="form-check-label" for="video_import">Import Tautan Video</label>
                                </div>
                            </div>
                            @if($newsbottom->video_file)
                            <div class="mt-3">
                                    <video controls style="max-width: 40%;">
                                        <source src="{{ asset('assets/vid/' . $newsbottom->video_file) }}" type="video/mp4">
                                    </video>
                                    <small class="text-muted">Current Video</small>
                                </div>

                                <div class="mt-3">
                                    <form id="removeVideoForm" action="{{ route('remove-video-bottom', ['newsbottom' => $newsbottom->id]) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="remove_video" value="true">
                                        <button id="removeVideoButton" type="submit" class="btn btn-danger">Remove Video</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <br>
                        <div id="videoInput">
                            <div id="videoUploadDiv" style="{{ old('video_option', $newsbottom->video_file ? 'display:block;' : 'display:none;') }}">
                                <label class="btn btn-primary">
                                    <input type="file" id="videoUpload" accept="video/mp4,video/webm,video/quicktime" name="video_file" style="display:none;" onchange="displaySelectedFile()">
                                    Choose File
                                </label>
                                <span id="fileSelected">{{ old('video_file') ? 'Selected File: ' . old('video_file')->getClientOriginalName() : '' }}</span>
                            </div>
                        </div>
                        <div id="videoLinkDiv" style="{{ old('video_option', $newsbottom->video_link ? 'import' : '') == 'import' ? 'display:block;' : 'display:none;' }}">
                            <label class="fw-bold" for="videoLink">Link Url Video:</label><br>
                            <input type="text" id="videoLink" name="video_link" class="form-control" value="{{ old('video_link', $newsbottom->video_link) }}"><br>
                        </div>

                        <div class="form-group mt-3">
                            <label class="fw-bold" for="thumbnail_path">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control">
                            @if($newsbottom->thumbnail)
                                <img src="{{ asset('assets/img2/thumbnail2/' . $newsbottom->thumbnail) }}" alt="Current Thumbnail" class="img-fluid mt-2" style="max-width: 200px;">
                                <input type="hidden" name="thumbnail" value="{{ $newsbottom->thumbnail }}">
                                <small class="text-muted">Current Thumbnail: {{ $newsbottom->thumbnail }}</small><br>
                            @endif
                        </div>


                        <div class="form-group mt-3">
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
