<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;
protected $fillable = [
    'judul',
    'slug',
    'isi',
    'user_id',
    'penulis_berita',
    'photo_by',
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

public function getSlugAttribute()
{
    return Str::slug($this->judul);
}

public function getRouteKeyName()
{
    return 'slug';
}


}
