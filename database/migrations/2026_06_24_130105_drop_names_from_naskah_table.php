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
            $table->dropColumn(['reviewer_name', 'editor_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            $table->string('reviewer_name')->nullable()->after('reviewer_id');
            $table->string('editor_name')->nullable()->after('editor_id');
        });
    }
};
