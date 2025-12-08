<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Galeri extends Model
{
    protected $table = 'galeri';
    protected $primaryKey = 'galeri_id';
    protected $fillable = [
        'judul',
        'deskripsi',
    ];

    /**
     * Relationship dengan media
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'galeri_id')
                    ->where('ref_table', 'galeri')
                    ->orderBy('sort_order')
                    ->orderBy('media_id');
    }

    /**
     * Accessor untuk foto utama
     */
    public function getFotoUtamaAttribute()
    {
        $foto = $this->media->first();
        return $foto ? $foto->file_name : null;
    }

    /**
     * Accessor untuk URL foto utama
     */
    public function getFotoUtamaUrlAttribute()
    {
        $foto = $this->media->first();
        return $foto ? asset('storage/media/galeri/' . $foto->file_name) : null;
    }

    /**
     * Accessor untuk semua foto
     */
    public function getSemuaFotoAttribute()
    {
        return $this->media;
    }

    /**
     * Accessor untuk jumlah foto
     */
    public function getJumlahFotoAttribute()
    {
        return $this->media->count();
    }

    /**
     * Scope untuk filter
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
     * Scope untuk search
     */
    public function scopeSearch($query, $request, array $columns)
    {
        if ($request->filled('search')) {
            $query->where(function($q) use ($request, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $request->search . '%');
                }
            });
        }
    }
}
