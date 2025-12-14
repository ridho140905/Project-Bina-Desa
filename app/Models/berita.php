<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table      = 'berita';
    protected $primaryKey = 'berita_id';
    public $timestamps    = true;

    protected $fillable = [
        'kategori_id',
        'judul',
        'slug',
        'isi_html',
        'penulis',
        'cover_foto',
        'status',
        'terbit_at',
    ];

    protected $casts = [
        'terbit_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBerita::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Relationship dengan media - BARU DITAMBAHKAN
     */
    public function media()
    {
        return $this->hasMany(Media::class, 'ref_id', 'berita_id')
            ->where('ref_table', 'berita')
            ->orderBy('sort_order')
            ->orderBy('media_id');
    }

    /**
     * Accessor untuk cover foto - BARU DITAMBAHKAN
     * Menggunakan file_name dari tabel media
     */
    public function getCoverFotoAttribute()
    {
        $cover = $this->media->where('sort_order', 1)->first();
        return $cover ? $cover->file_name : null;
    }

    /**
     * Accessor untuk URL cover foto
     */
    public function getCoverFotoUrlAttribute()
    {
        $cover = $this->media->where('sort_order', 1)->first();
        return $cover ? asset('storage/media/berita/' . $cover->file_name) : null;
    }

    /**
     * Accessor untuk gambar pendukung - BARU DITAMBAHKAN
     */
    public function getGambarPendukungAttribute()
    {
        return $this->media->where('sort_order', '>', 1);
    }

    public function scopeFilter(Builder $query, $request, array $filterableColumns)
    {
        foreach ($filterableColumns as $column) {
            if ($request->filled($column)) {
                $query->where($column, $request->input($column));
            }
        }
        return $query;
    }

    public function scopeSearch($query, $request, array $columns)
    {
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', '%' . $request->search . '%');
                }
            });
        }
    }
}
