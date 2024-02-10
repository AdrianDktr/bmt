<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
protected $fillable = [
    'judul',
    'isi',
    'user_id',
    'penulis_berita',
    'category_id',
    'video_file',
    'video_link',
    'tanggal_terbit',
    'thumbnail_path',
];
protected $table = 'news';

public function penulis()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function category()
{
    return $this->belongsToMany(NewsCategory::class, 'category_id');
}

}
