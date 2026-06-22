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
            if (! Schema::hasColumn('naskah', 'document_path')) {
                $table->string('document_path')->nullable()->after('document_name');
            }

            if (! Schema::hasColumn('naskah', 'category')) {
                $table->string('category')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            if (Schema::hasColumn('naskah', 'document_path')) {
                $table->dropColumn('document_path');
            }

            if (Schema::hasColumn('naskah', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
