<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identity_number')->unique()->after('name');
            $table->enum('role', ['student', 'lecturer', 'technician', 'admin'])->default('student')->after('identity_number');
            $table->string('phone')->nullable()->after('role');
            $table->string('department')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('department');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['identity_number', 'role', 'phone', 'department', 'is_active']);
        });
    }
};