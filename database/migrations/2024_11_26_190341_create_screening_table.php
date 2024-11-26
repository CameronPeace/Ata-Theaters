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
        Schema::create('screening', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id');
            $table->foreignId('theater_id');
            $table->foreign('movie_id')->references('id')->on('movie');
            $table->foreign('theater_id')->references('id')->on('theater');
            $table->tinyInteger('is_showing')->default(1);
            $table->date('screen_end')->nullable();
            $table->date('created')->useCurrent();
            $table->date('updated')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening');
    }
};
