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
        // Hapus tabel lama jika ada
        Schema::dropIfExists('media');

        // Buat tabel baru yang sederhana
        Schema::create('media', function (Blueprint $table) {
            $table->id('media_id');
            $table->string('ref_table');
            $table->unsignedBigInteger('ref_id');
            $table->string('file_name'); // Ini yang akan menyimpan nama file
            $table->string('mime_type');
            $table->string('caption')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['ref_table', 'ref_id']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
