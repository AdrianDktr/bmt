<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsBottom extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'judul',
        'isi',
        'penulis_id',
        'tanggal_terbit',
        'thumbnail_path'
    ];
    protected $table = 'news_bottom';
}
