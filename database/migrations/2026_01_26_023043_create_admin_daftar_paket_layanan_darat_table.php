<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('admin_daftar_paket_layanan_darat')) {
            Schema::create('admin_daftar_paket_layanan_darat', function (Blueprint $table) {
                $table->id();
                $table->foreignId('layanan_id')
                    ->constrained('admin_daftar_layanan_darat')
                    ->cascadeOnDelete();

                $table->string('kode')->unique();
                $table->string('nama');
                $table->text('deskripsi')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_daftar_paket_layanan_darat');
    }
};
