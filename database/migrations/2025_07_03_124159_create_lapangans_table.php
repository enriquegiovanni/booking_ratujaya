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
        Schema::create('lapangan', function (Blueprint $table) {
            $table->id();
            $table->string('title');
           $table->enum('category', ['Lapangan 1', 'Lapangan 2', 'Lapangan 3', 'Lapangan 4', 'Lapangan 5', 'Lapangan 6', 'Lapangan 7']);
            $table->longText('description');
            $table->decimal('price', 10, 2)->default(0);
            $table->json('images'); // Maksimal 3 gambar
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
