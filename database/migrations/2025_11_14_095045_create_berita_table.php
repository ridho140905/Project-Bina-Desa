<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id('berita_id');
            $table->foreignId('kategori_id')
                  ->constrained('kategori_berita', 'kategori_id')
                  ->onDelete('cascade');
            $table->string('judul', 255);
            $table->string('slug', 300)->unique();
            $table->text('isi_html');
            $table->string('penulis', 100);
            $table->string('cover_foto', 255)->nullable();
            $table->enum('status', ['draft', 'terbit'])->default('draft');
            $table->timestamp('terbit_at')->nullable();
            $table->timestamps();

            $table->index('kategori_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
