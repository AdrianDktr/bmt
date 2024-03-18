<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsBottom;
use App\Models\User;
use App\Models\NewsCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        $news = News::where('judul', 'LIKE', "%$query%")
                    ->orWhere('isi', 'LIKE', "%$query%")
                    ->get();

        $newsbottom = NewsBottom::where('judul_bawah', 'LIKE', "%$query%")
                                ->orWhere('berita', 'LIKE', "%$query%")
                                ->get();

        $searchResults = $news->merge($newsbottom);
        $searchResults = $searchResults->unique('judul');

        $newsViewedIds = News::whereDate('created_at', '<', Carbon::now()->subDays(5))->pluck('id')->toArray();

        $news = News::where('judul', 'LIKE', "%$query%")
                    ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                    ->whereNotIn('id', $newsViewedIds)
                    ->get();
        return view('layouts.admin',compact('news','newsViewedIds','newsbottom','query','searchResults'));
    }
}
