<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            $table->foreignId('reviewer_id')->nullable()->constrained('users')->nullOnDelete()->after('author_id');
            $table->string('reviewer_name')->nullable()->after('reviewer_id');
        });
    }

    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn(['reviewer_id', 'reviewer_name']);
        });
    }
};
