<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'media_id';

    // Tentukan nama tabel jika berbeda
    protected $table = 'media';

    // Kolom yang bisa diisi massal - HANYA KOLOM YANG ADA DI DATABASE
    protected $fillable = [
        'ref_table',
        'ref_id',
        'file_name',
        'caption',
        'mime_type',
        'sort_order'
    ];

    // Kolom yang harus di-cast
    protected $casts = [
        'sort_order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Accessor untuk URL lengkap file
     * Mengasumsikan file disimpan di storage/app/public/media/
     */
    public function getUrlAttribute()
    {
        return asset('storage/media/' . $this->file_name);
    }

    /**
     * Accessor untuk path lengkap file di filesystem
     * Mengasumsikan file disimpan di storage/app/public/media/
     */
    public function getFullPathAttribute()
    {
        return storage_path('app/public/media/' . $this->file_name);
    }

    /**
     * Scope untuk media berdasarkan tabel referensi
     */
    public function scopeForTable($query, $tableName)
    {
        return $query->where('ref_table', $tableName);
    }

    /**
     * Scope untuk media berdasarkan ID referensi
     */
    public function scopeForRecord($query, $tableName, $recordId)
    {
        return $query->where('ref_table', $tableName)
                    ->where('ref_id', $recordId);
    }

    /**
     * Scope untuk urutan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('media_id');
    }

    /**
     * Scope untuk tipe file tertentu (gambar)
     */
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    /**
     * Cek apakah file adalah gambar
     */
    public function getIsImageAttribute()
    {
        return strpos($this->mime_type, 'image/') === 0;
    }
/**
     * Relasi ke galeri (jika media ini milik galeri)
     */
    public function galeri()
    {
        return $this->belongsTo(Galeri::class, 'ref_id', 'galeri_id')
                    ->where('ref_table', 'galeri');
    }
}
