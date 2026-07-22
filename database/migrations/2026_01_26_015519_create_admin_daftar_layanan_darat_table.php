<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_daftar_layanan_darat', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();     // photographer, videographer
            $table->string('nama', 150);               // Photographer, Videographer
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_daftar_layanan_darat');
    }
};
