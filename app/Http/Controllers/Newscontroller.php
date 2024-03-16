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
use Carbon\Carbon;


class NewsController extends Controller
{

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

        return view('news.index-news', compact('searchResults', 'news', 'newsbottom'));
    }


public function allnews()
{
    $news = News::all();
    $newsbottom = NewsBottom::all();
    $all_news = $news->merge($newsbottom);
    $total_news = $all_news->count();

    return view('news.show-all-news', compact('all_news','total_news'));
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
                    $videoFileName = null;
                }
            } elseif ($request->video_option == 'import') {
                $request->validate([
                    'video_link' => 'nullable|url',
                ]);
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
            'photo_by' => $request->photo_by,
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

        if ($request->has('remove_video')) {

            if ($news->video_file) {
                $oldVideoPath = public_path('assets/vid/' . $news->video_file);
                if (File::exists($oldVideoPath)) {
                    File::delete($oldVideoPath);
                }
        }
            $news->update(['video_file' => null]);

            return redirect()->route('news-edit', ['news' => $news])->with('success', 'Video berhasil dihapus.');
        }

        $request->validate([
            'judul' => 'required',
            'isi' => 'required',
            'user_id' => 'required',
            'penulis_berita' => 'required',
            'photo_by' => 'required',
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

        $oldThumbnail = $news->thumbnail_path;

        $oldVideo = $news->video_file;

        $videoPath = null;
        $videoFileName = null;

        if ($request->has('video_option')) {
        if ($request->video_option == 'upload' && $request->hasFile('video_file')) {
                $request->validate([
                    'video_file' => 'mimes:mp4,webm,quicktime|max:50000',
                ]);

                $videoFile = $request->file('video_file');
                $videoFileName = time() . '_' . $videoFile->getClientOriginalName();
                $videoPath = $videoFile->move(public_path('assets/vid'), $videoFileName);
        } elseif ($request->video_option == 'import') {
                $request->validate([
                    'video_link' => 'url',
                ]);

                $videoPath = $request->video_link;
            }
        }

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
            'photo_by' => $request->photo_by,
            'category_id' => $request->category_id,
            'video_file' => $videoFileName ? $videoFileName : $oldVideo,
            'video_link' => $request->video_link,
            'thumbnail_path' => $thumbnailPath ? $thumbnailFileName : $oldThumbnail,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        if (!empty($content)) {
            $content = preg_replace('/<o:p>.*?<\/o:p>/', '', $content);
            $dom = new \DOMDocument();
            $dom->loadHtml(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $errors = libxml_get_errors();
            if (!empty($errors)) {

                foreach ($errors as $error) {

                }

            } else {

                $images = $dom->getElementsByTagName('img');
                foreach ($images as $img) {
                    $data = $img->getAttribute('src');
                    if (strpos($data, 'data:image') === 0) {
                        list($type, $data) = explode(';', $data);
                        list(, $data) = explode(',', $data);
                        $data = base64_decode($data);
                        $imageFileName = time() . '_' . Str::random(10) . '.png';
                        $path = public_path('assets/img/berita') . '/' . $imageFileName;
                        file_put_contents($path, $data);
                        $img->removeAttribute('src');
                        $img->setAttribute('src', asset('assets/img/berita/' . $imageFileName));
                    }
                }


                $news->isi = $dom->saveHTML();
                $news->save();
            }
        }



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

    public function showByCategory($category)
    {
        $category = NewsCategory::findOrFail($category);

        $news = News::where('category_id', $category->id)->get();

        $newsBottom = NewsBottom::where('category_id', $category->id)->get();

        $mergedNews = $news->merge($newsBottom);

        return view('news.news-show-category', compact('category', 'mergedNews'));
    }



}

