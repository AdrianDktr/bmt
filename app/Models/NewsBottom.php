<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsBottom extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'judul_bawah',
        'berita',
        'penulis_id',
        'tanggal_terbit',
        'thumbnail'
    ];
    protected $table = 'news_bottom';
}
