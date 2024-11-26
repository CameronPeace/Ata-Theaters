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
        Schema::create('movie', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('genre')->nullable();
            $table->string('director')->nullable();
            $table->string('poster_url')->nullable();
            $table->date('release_date')->nullable();
            $table->date('created')->useCurrent();
            $table->date('updated')->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie');
    }
};
