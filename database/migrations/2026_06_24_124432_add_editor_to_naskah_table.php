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
            $table->foreignId('editor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('editor_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            $table->dropForeign(['editor_id']);
            $table->dropColumn(['editor_id', 'editor_name']);
        });
    }
};
