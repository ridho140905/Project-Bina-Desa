<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Galeri extends Model
{
    use HasFactory;

    protected $primaryKey = 'galeri_id';
    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'deskripsi'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi dengan media
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'ref_id', 'galeri_id')
                    ->where('ref_table', 'galeri')
                    ->orderBy('sort_order');
    }

    /**
     * Get foto utama (gambar pertama - sort_order = 1)
     */
    public function getFotoUtamaAttribute()
    {
        return $this->media()
                    ->where('mime_type', 'like', 'image/%')
                    ->where('sort_order', 1)
                    ->first();
    }

    /**
     * Get foto pendukung (sort_order > 1)
     */
    public function getFotoPendukungAttribute()
    {
        return $this->media()
                    ->where('mime_type', 'like', 'image/%')
                    ->where('sort_order', '>', 1)
                    ->get();
    }

    /**
     * Accessor untuk URL foto utama
     */
    public function getFotoUtamaUrlAttribute()
    {
        $fotoUtama = $this->fotoUtama;
        return $fotoUtama ? asset('storage/media/galeri/' . $fotoUtama->file_name) : null;
    }

    /**
     * Accessor untuk jumlah foto
     */
    public function getJumlahFotoAttribute()
    {
        return $this->media()->count();
    }

    /**
     * Accessor untuk thumbnail (jika diperlukan untuk tabel)
     */
    public function getThumbnailAttribute()
    {
        $fotoUtama = $this->fotoUtama;
        if ($fotoUtama) {
            return asset('storage/media/galeri/' . $fotoUtama->file_name);
        }
        return asset('images/default-gallery.png'); // gambar default jika tidak ada
    }

    /**
     * Scope untuk filter (sama seperti Agenda)
     */
    public function scopeFilter(Builder $query, $request, array $filterableColumns): Builder
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }

    /**
     * Scope untuk search (sama seperti Agenda)
     */
    public function scopeSearch(Builder $query, $request, array $searchableColumns): Builder
    {
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'like', '%' . $searchTerm . '%');
                }
            });
        }
        return $query;
    }

    /**
     * Scope untuk mengambil galeri dengan foto utama (agar bisa ditampilkan di frontend)
     */
    public function scopeWithFotoUtama(Builder $query): Builder
    {
        return $query->with(['media' => function($q) {
            $q->where('sort_order', 1)->where('mime_type', 'like', 'image/%');
        }]);
    }

    /**
     * Scope untuk mengambil galeri dengan semua foto
     */
    public function scopeWithAllMedia(Builder $query): Builder
    {
        return $query->with(['media' => function($q) {
            $q->orderBy('sort_order');
        }]);
    }
}
