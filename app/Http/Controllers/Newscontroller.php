<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsBottom;
use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class NewsController extends Controller
{
    public function index(Request $request)
{
    $query = $request->input('query');


    $news = News::where('judul', 'LIKE', "%$query%")->get();
    $newsbottom = NewsBottom::where('judul_bawah', 'LIKE', "%$query%")->get();


    $searchResults = $news->merge($newsbottom);


    $searchResults = $searchResults->unique('judul');


    return view('news.index-news', compact('searchResults','news','newsbottom'));
}


    public function create()
    {
        $users = User::all();
        $category = NewsCategory::all();
        return View::make('admin.create-news', compact('users', 'category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'user_id' => 'required',
            'penulis_berita' => 'required',
            'category_id' => 'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail_path' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'isi.required' => 'Isi berita wajib diisi.',
            'penulis_id.required' => 'Penulis wajib dipilih.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail_path.required' => 'File thumbnail harus diunggah.',
            'thumbnail_path.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail_path.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);


        $videoFileName = null;
        $videoPath = null;

        if ($request->has('video_option')) {
            if ($request->video_option == 'upload') {
                $request->validate([
                    'video_file' => 'nullable|mimes:mp4,webm,quicktime|max:50000',
                ]);
                if ($request->hasFile('video_file')) {
                    $videoFile = $request->file('video_file');
                    $videoFileName = time() . '_' . $videoFile->getClientOriginalName();
                    $videoPath = $videoFile->storeAs('public/assets/vid', $videoFileName);
                    $videoFile->move(public_path('assets/vid'), $videoFileName);
                } else {
                    // Jika file video tidak diunggah, atur nilai $videoFileName ke null atau kosong
                    $videoFileName = null;
                }
            } elseif ($request->video_option == 'import') {
                $request->validate([
                    'video_link' => 'nullable|url',
                ]);
                // Jika tautan video tidak diisi, atur nilai $videoPath ke null atau kosong
                $videoPath = $request->input('video_link', null);
            }
        }


        $file = $request->file('thumbnail_path');
        $imageFileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/assets/img/thumbnail', $imageFileName);
        $file->move(public_path('assets/img/thumbnail'), $imageFileName);

        $news = News::create([
            'judul' => $request->judul,
            'isi' => '',
            'user_id' => $request->user_id,
            'penulis_berita' => $request->penulis_berita,
            'category_id' => $request->category_id,
            'video_file' => $videoFileName,
            'video_link' => $request->video_link,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail_path' => $imageFileName,
        ]);

        $content = preg_replace('/<o:p>.*?<\/o:p>/', '', $request->isi);
        $dom = new \DomDocument();
        $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        $imagePaths = [];

        foreach ($images as $img) {
            $data = $img->getAttribute('src');
            if (strpos($data, 'data:image') === 0) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $imageFileName = time() . '_' . Str::random(10) . '.png';
                $path = public_path('assets/img/berita') . '/' . $imageFileName;
                file_put_contents($path, $data);

                $imagePaths[] = asset('assets/img/berita/' . $imageFileName);
                $img->removeAttribute('src');
                $img->setAttribute('src', asset('assets/img/berita/' . $imageFileName));
            }
        }

        $news->isi = $dom->saveHTML();
        $news->save();

        return redirect()->route('index-news')->with('success', 'Data berhasil disimpan.');
    }



    public function show(News $news){

        return view('news.show-news',compact('news'));
    }

    public function edit( News $news){
        $users=User::all();
        $category = NewsCategory::all();
        return view('admin.edit-news',compact('news','users','category'));
    }



        public function update(Request $request, News $news)
    {
        // Handle penghapusan video
        if ($request->has('remove_video')) {
            // Hapus video lama jika ada
            if ($news->video_file) {
                $oldVideoPath = public_path('assets/vid/' . $news->video_file);
                if (File::exists($oldVideoPath)) {
                    File::delete($oldVideoPath); // Menghapus file video lama
                }
            }
            // Set path video menjadi null
            $news->update(['video_file' => null]);

            return redirect()->route('news-edit', ['news' => $news])->with('success', 'Video berhasil dihapus.');
        }

        // Validasi request
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'user_id' => 'required',
            'penulis_berita' => 'required',
            'category_id' => 'required',
            'video_file' => 'nullable|mimes:mp4,webm,quicktime|max:50000',
            'video_link' => 'nullable|url',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail_path' => $request->hasFile('thumbnail') ? 'required|image|mimes:jpeg,png,jpg|max:2048' : 'nullable',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'isi.required' => 'Isi berita wajib diisi.',
            'user_id.required'=>'Admin wajib diisi.',
            'penulis_berita.required' => 'Penulis wajib dipilih.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'tanggal_terbit.required' => 'Tanggal terbit wajib diisi.',
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail_path.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail_path.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);

        // Simpan thumbnail lama untuk digunakan kembali jika thumbnail tidak diubah
        $oldThumbnail = $news->thumbnail_path;

        // Simpan video lama untuk digunakan kembali jika video tidak diubah
        $oldVideo = $news->video_file;

        // Simpan video baru jika diunggah atau diimpor
        $videoPath = null;
        $videoFileName = null;

        if ($request->has('video_option')) {
            if ($request->video_option == 'upload' && $request->hasFile('video_file')) {
                // Validasi dan simpan video baru jika diunggah
                $request->validate([
                    'video_file' => 'mimes:mp4,webm,quicktime|max:50000',
                ]);

                $videoFile = $request->file('video_file');
                $videoFileName = time() . '_' . $videoFile->getClientOriginalName();
                $videoPath = $videoFile->move(public_path('assets/vid'), $videoFileName);
            } elseif ($request->video_option == 'import') {
                // Simpan link video jika diimpor
                $request->validate([
                    'video_link' => 'url',
                ]);

                $videoPath = $request->video_link;
            }
        }

        // Simpan thumbnail baru jika diunggah
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail_path')) {
            $thumbnailFile = $request->file('thumbnail_path');
            $thumbnailFileName = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailPath = $thumbnailFile->move(public_path('assets/img/thumbnail'), $thumbnailFileName);
        }

        // Update data berita
        $news->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'user_id' => $request->user_id,
            'penulis_berita' => $request->penulis_berita,
            'category_id' => $request->category_id,
            'video_file' => $videoFileName ? $videoFileName : $oldVideo,
            'video_link' => $request->video_link,
            'thumbnail_path' => $thumbnailPath ? $thumbnailFileName : $oldThumbnail,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        return redirect()->route('index-news')->with('success', 'Data berhasil diperbarui.');
    }





    public function delete(News $news){
        // Menghapus thumbnail
        $thumbnailPath = public_path('assets/img/thumbnail/' . $news->thumbnail_path);
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }

        // Menghapus gambar-gambar terkait
        $content = preg_replace('/<o:p>.*?<\/o:p>/', '', $news->isi);
        $content = preg_replace('/<p[^>]*>/', '', $content);
        $content = preg_replace('/<\/p>/', '', $content);

        $dom = new \DomDocument();
        $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $imagePath = public_path('assets/img/berita') . '/' . basename($img->getAttribute('src'));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        // Menghapus berita
        $news->delete();

        return redirect()->back();
    }















// News Bottoms


    public function create2(){
        $users = User::all();
        $category = NewsCategory::all();
        return view('admin.create-newsbottom', compact('users', 'category'));
    }

    public function store2(Request $request) {
        $request->validate([
            'judul_bawah' => 'required',
            'berita' => 'required',
            'user_id' => 'required',
            'penulis_berita' => 'required',
            'category_id' => 'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'judul_bawah.required' => 'Judul harus diisi.',
            'berita.required' => 'Berita harus diisi.',
            'penulis_id.required' => 'Penulis harus dipilih.',
            'category_id.required' => 'Kategori harus dipilih.',
            'tanggal_terbit.required' => 'Tanggal terbit harus diisi.',
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail.required' => 'File thumbnail harus diunggah.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
            'video_file.mimes' => 'Format file video tidak valid. Hanya mendukung format mp4, webm, dan quicktime.',
            'video_file.max' => 'Ukuran file video terlalu besar. Maksimum 50 MB diizinkan.',
            'video_link.url' => 'Format tautan video tidak valid. Pastikan tautan diawali dengan http:// atau https://.',
            'video_file.nullable_without' => 'File video harus diunggah jika tidak ada tautan video yang disertakan.',
            'video_link.nullable_without' => 'Tautan video harus disertakan jika tidak ada file video yang diunggah.',
        ]);

        $videoFileName = null;
        $videoPath = null;

        if ($request->has('video_option')) {
            if ($request->video_option == 'upload') {
                $request->validate([
                    'video_file' => 'nullable|mimes:mp4,webm,quicktime|max:50000',
                ]);
                if ($request->hasFile('video_file')) {
                    $videoFile = $request->file('video_file');
                    $videoFileName = time() . '_' . $videoFile->getClientOriginalName();
                    $videoPath = $videoFile->storeAs('public/assets/vid', $videoFileName);
                    $videoFile->move(public_path('assets/vid'), $videoFileName);
                } else {
                    // Jika file video tidak diunggah, atur nilai $videoFileName ke null atau kosong
                    $videoFileName = null;
                }
            } elseif ($request->video_option == 'import') {
                $request->validate([
                    'video_link' => 'nullable|url',
                ]);
                // Jika tautan video tidak diisi, atur nilai $videoPath ke null atau kosong
                $videoPath = $request->input('video_link', null);
            }
        }


        $thumbnailFile = $request->file('thumbnail');
        $thumbnailFileName = time() . '_' . $thumbnailFile->getClientOriginalName();
        $thumbnailPath = $thumbnailFile->storeAs('public/assets/img2/thumbnail2', $thumbnailFileName);
        $thumbnailFile->move(public_path('assets/img2/thumbnail2'), $thumbnailFileName);

        $content = preg_replace('/<o:p>.*?<\/o:p>/', '', $request->berita);
        $dom = new \DomDocument();
        $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');
        $imagePaths = [];

        foreach ($images as $img) {
            $data = $img->getAttribute('src');
            if (strpos($data, 'data:image') === 0) {
                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);
                $imageFileName = time() . '_' . Str::random(10) . '.png';
                $path = public_path('assets/img2/berita2') . '/' . $imageFileName;
                file_put_contents($path, $data);

                $imagePaths[] = asset('assets/img2/berita2/' . $imageFileName);
                $img->removeAttribute('src');
                $img->setAttribute('src', asset('assets/img2/berita2/' . $imageFileName));
            }
        }


        $newsBottom = NewsBottom::create([
            'judul_bawah' => $request->judul_bawah,
            'berita' => $dom->saveHTML(),
            'user_id' => $request->user_id,
            'penulis_berita' => $request->penulis_berita,
            'category_id' => $request->category_id,
            'video_file' => $videoFileName,
            'video_link' => $request->video_link,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail' => $thumbnailFileName,
        ]);

        $newsBottom->berita = $dom->saveHTML();
        $newsBottom->save();

        return redirect()->route('index-news')->with('success', 'Data berhasil diperbarui.');
    }




    public function show2(NewsBottom $newsbottom){

        return view('news.show-newsbottom',compact('newsbottom'));
    }

    public function edit2( NewsBottom $newsbottom){
        $users=User::all();
        $category = NewsCategory::all();
        return view('admin.edit-newsbottom',compact('newsbottom','users','category'));
    }

    public function update2(Request $request, NewsBottom $newsbottom){
        if ($request->has('remove_video')) {
            // Hapus video lama jika ada
            if ($newsbottom->video_file) {
                $oldVideoPath = public_path('assets/vid/' . $newsbottom->video_file);
                if (File::exists($oldVideoPath)) {
                    File::delete($oldVideoPath); // Menghapus file video lama
                }
            }
            // Set path video menjadi null
            $newsbottom->update(['video_file' => null]);

            return redirect()->route('news-bottom-edit', ['newsbottom' => $newsbottom])->with('success', 'Video berhasil dihapus.');
        }

        $request->validate([
            'judul_bawah' => 'required',
            'berita' => 'required',
            'user_id' => 'required',
            'penulis_berita' => 'required',
            'category_id' => 'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail' => $request->hasFile('thumbnail') ? 'required|image|mimes:jpeg,png,jpg|max:2048' : 'nullable',
        ], [
            'user_id.required'=>'Admin wajib diisi.',
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail.required' => 'File thumbnail harus diunggah.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);

        // Hapus thumbnail lama jika ada
        if ($newsbottom->thumbnail) {
            $oldThumbnailPath = public_path('assets/img2/thumbnail2/' . $newsbottom->thumbnail);
            if (file_exists($oldThumbnailPath)) {
                unlink($oldThumbnailPath);
            }
        }

        // Simpan video baru jika diunggah atau diimpor
        $videoFileName = null;
        if ($request->has('video_option')) {
            if ($request->video_option == 'upload' && $request->hasFile('video_file')) {
                $request->validate([
                    'video_file' => 'mimes:mp4,webm,quicktime|max:50000',
                ]);
                $videoFile = $request->file('video_file');
                $videoFileName = time() . '_' . $videoFile->getClientOriginalName();
                $videoFile->move(public_path('assets/vid'), $videoFileName);
            } elseif ($request->video_option == 'import' && $request->filled('video_link')) {
                $videoFileName = $request->video_link;
            }
        }

        // Validasi video link setelah logika upload atau import
        if ($request->filled('video_link')) {
            $request->validate([
                'video_link' => 'url',
            ]);
        }

        // Simpan thumbnail baru jika diunggah
        $thumbnailFileName = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailFileName = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('assets/img2/thumbnail2'), $thumbnailFileName);
        }

        $newsbottom->update([
            'judul_bawah' => $request->judul_bawah,
            'berita' => $request->berita,
            'user_id' => $request->user_id,
            'penulis_berita' => $request->penulis_berita,
            'category_id' => $request->category_id,
            'video_file'=>$videoFileName,
            'video_link' => $request->video_link,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail' => $thumbnailFileName ? $thumbnailFileName : $newsbottom->thumbnail, // Gunakan thumbnail baru jika diunggah, jika tidak, gunakan thumbnail lama
        ]);

        return redirect()->route('index-news')->with('success', 'Data berhasil diperbarui.');
    }


    public function delete2(NewsBottom $newsbottom){

        $newsbottom->delete();

        return redirect()->back();
    }




    public function showByCategory($category)
    {
        $category = NewsCategory::findOrFail($category);

        $news = News::where('category_id', $category->id)->get();

        $newsBottom = NewsBottom::where('category_id', $category->id)->get();

        $mergedNews = $news->merge($newsBottom);

        return view('news.news-show-category', compact('category', 'mergedNews'));
    }



}

