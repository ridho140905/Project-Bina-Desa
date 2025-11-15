<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    use HasFactory;

    protected $table = 'kategori_berita';
    protected $primaryKey = 'kategori_id';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi'
    ];

    public function berita()
    {
        return $this->hasMany(Berita::class, 'kategori_id', 'kategori_id');
    }
}
