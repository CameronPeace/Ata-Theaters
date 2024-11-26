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
        Schema::create('theater', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('location_name');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('street')->nullable();
            $table->string('zip5')->nullable();
            $table->date('created')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theater');
    }
};
