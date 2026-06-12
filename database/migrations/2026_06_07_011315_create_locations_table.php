<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // כיתה 101
            $table->string('building');      // בניין א
            $table->string('floor')->nullable();
            $table->text('description')->nullable();
            $table->string('qr_token')->unique(); // UUID שמוטמע ב-QR
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};