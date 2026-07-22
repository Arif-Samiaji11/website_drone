<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_daftar_paket_layanan_darat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')
                ->constrained('admin_daftar_layanan_darat')
                ->cascadeOnDelete();

            $table->string('kode', 100);               // photo_basic, video_premium
            $table->string('nama', 150);               // Photo Basic
            $table->string('deskripsi', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['layanan_id', 'kode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_daftar_paket_layanan_darat');
    }
};
