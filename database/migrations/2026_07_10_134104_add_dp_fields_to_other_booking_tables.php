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
        Schema::table('booking_drones', function (Blueprint $table) {
            $table->integer('dp_booking_tanggal')->nullable();
            $table->string('bukti_pembayaran_dp')->nullable();
        });

        Schema::table('servis_drones', function (Blueprint $table) {
            $table->integer('dp_booking_tanggal')->nullable();
            $table->string('bukti_pembayaran_dp')->nullable();
        });

        Schema::table('order_drones', function (Blueprint $table) {
            $table->integer('dp_booking_tanggal')->nullable();
            $table->string('bukti_pembayaran_dp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_drones', function (Blueprint $table) {
            $table->dropColumn(['dp_booking_tanggal', 'bukti_pembayaran_dp']);
        });

        Schema::table('servis_drones', function (Blueprint $table) {
            $table->dropColumn(['dp_booking_tanggal', 'bukti_pembayaran_dp']);
        });

        Schema::table('order_drones', function (Blueprint $table) {
            $table->dropColumn(['dp_booking_tanggal', 'bukti_pembayaran_dp']);
        });
    }
};
