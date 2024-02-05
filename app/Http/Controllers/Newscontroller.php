<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsBottom;
use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        $newsbottom = NewsBottom::all();
        return View::make('news.index-news', compact('news', 'newsbottom'));
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
            'penulis_id' => 'required',
            'category_id'=>'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail_path' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail_path.required' => 'File thumbnail harus diunggah.',
            'thumbnail_path.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail_path.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);

        // Proses gambar thumbnail
        $file = $request->file('thumbnail_path');
        $imageFileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/assets/img/thumbnail', $imageFileName);
        $file->move(public_path('assets/img/thumbnail'), $imageFileName);
        // Simpan berita ke dalam database
        $news = News::create([
            'judul' => $request->judul,
            'isi' => '', // Teks Summernote tidak disimpan di sini, kita akan proses terpisah
            'penulis_id' => $request->penulis_id,
            'category_id'=>$request->category_id,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail_path' => $imageFileName,
        ]);

        // Proses teks Summernote untuk gambar dan menyimpannya terpisah
        $dom = new \DomDocument();
        $dom->loadHtml($request->isi, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $imageFileName = time() . '_' . Str::random(10) . '.png'; // Nama file gambar acak
            $path = public_path('assets/img/berita') . '/' . $imageFileName;
            file_put_contents($path, $data);

            // Simpan path atau URL gambar ke dalam kolom 'isi'
            $img->removeAttribute('src');
            $img->setAttribute('src', asset('assets/img/berita/' . $imageFileName));
        }

        // Simpan teks Summernote yang telah dimodifikasi dengan URL gambar ke dalam kolom 'isi'
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
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'penulis_id' => 'required',
            'category_id'=>'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail_path' => 'image|mimes:jpeg,png,jpg',
        ], [
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail_path.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail_path.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);

        // Jika thumbnail baru diunggah, simpan yang baru
        if ($request->hasFile('thumbnail_path')) {
            $file = $request->file('thumbnail_path');
            $imageFileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/assets/img/thumbnail', $imageFileName);
            $file->move(public_path('assets/img/thumbnail'), $imageFileName);

            // Update data News
            $news->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'penulis_id' => $request->penulis_id,
                'category_id'=>$request->category_id,
                'tanggal_terbit' => $request->tanggal_terbit,
                'thumbnail_path' => $imageFileName,
            ]);
        } else {
            // Jika thumbnail tidak diunggah, hanya update data lainnya
            $news->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'penulis_id' => $request->penulis_id,
                'category_id'=>$request->category_id,
                'tanggal_terbit' => $request->tanggal_terbit,
            ]);
        }

        return redirect()->route('index-news')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete(News $news){

        $news->delete();

        return redirect()->back();
    }



    // newsbottom
    public function create2(){
        $users = User::all();
        $category = NewsCategory::all();
        return view('admin.create-newsbottom', compact('users', 'category'));
    }

    public function store2(Request $request)
{
    $request->validate([
        'judul_bawah' => 'required',
        'berita' => 'required',
        'penulis_id' => 'required',
        'category_id'=>'required',
        'tanggal_terbit' => 'required|date_format:Y-m-d',
        'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
    ], [
        'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
        'thumbnail.required' => 'File thumbnail harus diunggah.',
        'thumbnail.image' => 'File thumbnail harus berupa gambar.',
        'thumbnail.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
    ]);

    $file = $request->file('thumbnail');
    $imageFileName = time() . '_' . $file->getClientOriginalName(); // Ganti 'name' dengan 'getClientOriginalName'
    $path = $file->storeAs('public/assets/img2/thumbnail2', $imageFileName);
    $file->move(public_path('assets/img2/thumbnail2'), $imageFileName);

    $dom = new \DomDocument();
    $dom->loadHtml($request->berita, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    $images = $dom->getElementsByTagName('img');

    foreach ($images as $img) {
        $data = $img->getAttribute('src');
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);

        // Hapus bagian ini
        // $imageFileName = time() . '_' . Str::random(10) . '.png';

        $path = public_path('assets/img2/berita2') . '/' . $imageFileName;
        file_put_contents($path, $data);

        $img->removeAttribute('src');
        $img->setAttribute('src', asset('assets/img2/berita2/' . $imageFileName));
    }

    $newsBottom = NewsBottom::create([
        'judul_bawah' => $request->judul_bawah,
        'berita' => $dom->saveHTML(),
        'penulis_id' => $request->penulis_id,
        'category_id'=>$request->category_id,
        'tanggal_terbit' => $request->tanggal_terbit,
        'thumbnail' => $imageFileName,
    ]);
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
        $request->validate([
            'judul_bawah' => 'required',
            'berita' => 'required',
            'penulis_id' => 'required',
            'category_id'=>'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail.required' => 'File thumbnail harus diunggah.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);
        $file = $request->file('thumbnail');
        $imageFileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('/assets/img2/thumbnail2', $imageFileName);
        $file->move(public_path('assets/img2/thumbnail2'), $imageFileName);

        $newsbottom->update([
            'judul_bawah' => $request->judul_bawah,
            'berita' => $request->berita,
            'penulis_id' => $request->penulis_id,
            'category_id'=>$request->category_id,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail' => $imageFileName,
        ]);
    }
    public function delete2(NewsBottom $newsbottom){

        $newsbottom->delete();

        return redirect()->back();
    }
}

