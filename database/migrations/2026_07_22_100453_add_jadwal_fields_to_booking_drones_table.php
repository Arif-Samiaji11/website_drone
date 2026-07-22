<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_drones', function (Blueprint $table) {
            $table->string('tipe_jadwal')->nullable()->after('portofolio_id');
            $table->date('tanggal_selesai_acara')->nullable()->after('tipe_jadwal');
            $table->string('estimasi_selesai_acara')->nullable()->after('tanggal_selesai_acara');
            $table->string('waktu_mulai_acara')->nullable()->after('estimasi_selesai_acara');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_drones', function (Blueprint $table) {
            $table->dropColumn(['tipe_jadwal', 'tanggal_selesai_acara', 'estimasi_selesai_acara', 'waktu_mulai_acara']);
        });
    }
};
