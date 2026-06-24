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
        Schema::table('naskah', function (Blueprint $table) {
            $table->string('status', 30)->default('diajukan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            $table->enum('status', ['diajukan', 'dalam review', 'revisi', 'diterima', 'ditolak'])->default('diajukan')->change();
        });
    }
};
