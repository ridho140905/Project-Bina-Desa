<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Agenda extends Model
{
    use HasFactory;

    protected $primaryKey = 'agenda_id';
    protected $table = 'agenda';

    protected $fillable = [
        'judul',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'penyelenggara',
        'deskripsi'
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    /**
     * Relasi dengan media (poster/dokumen)
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'ref_id', 'agenda_id')
                    ->where('ref_table', 'agenda')
                    ->orderBy('sort_order');
    }

    /**
     * Get poster (gambar pertama)
     */
    public function getPosterAttribute()
    {
        return $this->media()
                    ->where('mime_type', 'like', 'image/%')
                    ->where('sort_order', 1)
                    ->first();
    }

    /**
     * Get dokumen (non-gambar)
     */
    public function getDokumenAttribute()
    {
        return $this->media()
                    ->where('mime_type', 'not like', 'image/%')
                    ->get();
    }

    /**
     * Accessor untuk URL poster
     */
    public function getPosterUrlAttribute()
    {
        $poster = $this->poster;
        return $poster ? asset('storage/media/agenda/' . $poster->file_name) : null;
    }

    /**
     * Accessor untuk gambar pendukung (FIXED - tanpa scope images)
     */
    public function getGambarPendukungAttribute()
    {
        return $this->media()
                    ->where('mime_type', 'like', 'image/%')
                    ->where('sort_order', '>', 1)
                    ->get();
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
}
