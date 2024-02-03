<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsBottom;
use App\Models\User;

class NewsBottomController extends Controller
{
    public function index(){
        $newsbottom = NewsBottom::all();
        return view('news.index-news', compact('newsbottom'));
    }
    public function create(){
        $users = User::all();
        return view('admin.create-news', compact('users'));
    }

    public function store(Request $request){
        NewsBottom::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'penulis_id' => $request->penulis_id,
            'tanggal_terbit' => $request->tanggal_terbit,
            'thumbnail_path' => $request->thumbnail_path,
        ]);
        return redirect()->route('index_news')->with('success', 'Data berhasil diperbarui.');
    }
}
