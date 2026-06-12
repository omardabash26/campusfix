<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');                   // מקרן, מזגן, מחשב...
            $table->string('type');                   // סוג הציוד
            $table->string('serial_number')->nullable();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('qr_token')->unique()->nullable(); // QR ייעודי לציוד (אופציונלי)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};