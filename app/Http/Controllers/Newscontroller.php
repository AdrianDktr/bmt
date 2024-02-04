<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsBottom;
use App\Models\User;
use Illuminate\Support\Facades\View;

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
        return View::make('admin.create-news', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'penulis_id' => 'required',
            'tanggal_terbit' => 'required|date_format:Y-m-d',
            'thumbnail_path' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'tanggal_terbit.date_format' => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'thumbnail_path.required' => 'File thumbnail harus diunggah.',
            'thumbnail_path.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail_path.mimes' => 'Format gambar tidak valid. Hanya mendukung format jpeg, png, dan jpg.',
        ]);

        $file = $request->file('thumbnail_path');
        $imageFileName = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();
        $path =$file->storeAs('public/assets/img/thumbnail',$imageFileName);
        $file->move(public_path('assets/img/thumbnail'), $imageFileName);

        $news = News::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'penulis_id' => $request->penulis_id,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail_path' => $imageFileName,
        ]);

        return redirect()->route('index_news')->with('success', 'Data berhasil disimpan.');
    }

    public function show(News $news){

        return view('news.show-news',compact('news'));
    }

    public function edit( News $news){
        $users=User::all();
        return view('admin.edit-news',compact('news','users'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'penulis_id' => 'required',
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
                'tanggal_terbit' => $request->tanggal_terbit,
                'thumbnail_path' => $imageFileName,
            ]);
        } else {
            // Jika thumbnail tidak diunggah, hanya update data lainnya
            $news->update([
                'judul' => $request->judul,
                'isi' => $request->isi,
                'penulis_id' => $request->penulis_id,
                'tanggal_terbit' => $request->tanggal_terbit,
            ]);
        }

        return redirect()->route('index_news')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete(News $news){

        $news->delete();

        return redirect()->back();
    }



    // newsbottom
    public function create2(){
        $users = User::all();
        return view('admin.create-newsbottom', compact('users'));
    }

    public function store2(Request $request){
        $request->validate([
            'judul_bawah' => 'required',
            'berita' => 'required',
            'penulis_id' => 'required',
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
        $path =$file->storeAs('/assets/img2/thumbnail2',$imageFileName);
        $file->move(public_path('assets/img2/thumbnail2'), $imageFileName);
       $store= NewsBottom::create([
            'judul_bawah' => $request->judul_bawah,
            'berita' => $request->berita,
            'penulis_id' => $request->penulis_id,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail' => $imageFileName,
        ]);



        return redirect()->route('index_news')->with('success', 'Data berhasil diperbarui.');
    }


    public function show2(NewsBottom $newsbottom){

        return view('news.show-newsbottom',compact('newsbottom'));
    }

    public function edit2( NewsBottom $newsbottom){
        $users=User::all();
        return view('admin.edit-newsbottom',compact('newsbottom','users'));
    }

}

