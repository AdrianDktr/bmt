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
    'penulis_id',
    'category_id',
    'tanggal_terbit',
    'thumbnail_path',
];
protected $table = 'news';

public function penulis()
{
    return $this->belongsTo(User::class, 'penulis_id');
}

public function category()
{
    return $this->belongsToMany(NewsCategory::class, 'category_id');
}

}
