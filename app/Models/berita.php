<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'berita_id';
    public $timestamps = true;

    protected $fillable = [
        'kategori_id',
        'judul',
        'slug',
        'isi_html',
        'penulis',
        'cover_foto',
        'status',
        'terbit_at'
    ];

    protected $casts = [
        'terbit_at' => 'datetime'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id', 'kategori_id');
    }
}


