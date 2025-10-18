<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'berita';
    protected $primaryKey = 'berita_id';
    protected $fillable = [
        'kategori_id',
        'judul',
        'slug',
        'cover_foto',
        'isi_html',
        'penulis',
        'status',
        'terbit_at',
    ];

    public $timestamps = true;

    // Relasi ke tabel kategori_berita
    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id', 'kategori_id');
    }
}
