<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('booking_crews', function (Blueprint $table) {
            if (!Schema::hasColumn('booking_crews', 'layanan')) {
                $table->string('layanan', 100)->after('id');
            }
            if (!Schema::hasColumn('booking_crews', 'paket')) {
                $table->string('paket', 100)->after('layanan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking_crews', function (Blueprint $table) {
            if (Schema::hasColumn('booking_crews', 'layanan')) $table->dropColumn('layanan');
            if (Schema::hasColumn('booking_crews', 'paket')) $table->dropColumn('paket');
        });
    }
};
