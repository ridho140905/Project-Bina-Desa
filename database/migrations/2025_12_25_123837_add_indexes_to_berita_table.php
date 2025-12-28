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
    Schema::table('berita', function (Blueprint $table) {
        $table->index('judul');
        $table->index('penulis');
        $table->index('terbit_at');
    });
}

public function down(): void
{
    Schema::table('berita', function (Blueprint $table) {
        $table->dropIndex(['judul']);
        $table->dropIndex(['penulis']);
        $table->dropIndex(['terbit_at']);
    });
}
};
