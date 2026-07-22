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
    Schema::create('news_items', function (Blueprint $table) {
        $table->id();
        $table->string('source', 120);          // nama sumber
        $table->string('title');                // judul
        $table->string('slug')->unique();       // slug unik
        $table->string('url')->unique();        // link asli
        $table->text('excerpt')->nullable();    // ringkasan
        $table->timestamp('published_at')->nullable();
        $table->string('guid', 255)->nullable()->unique(); // id dari RSS (kalau ada)
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_items');
    }
};
