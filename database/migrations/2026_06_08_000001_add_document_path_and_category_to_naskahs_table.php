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
        Schema::table('naskahs', function (Blueprint $table) {
            if (! Schema::hasColumn('naskahs', 'document_path')) {
                $table->string('document_path')->nullable()->after('document_name');
            }

            if (! Schema::hasColumn('naskahs', 'category')) {
                $table->string('category')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskahs', function (Blueprint $table) {
            if (Schema::hasColumn('naskahs', 'document_path')) {
                $table->dropColumn('document_path');
            }

            if (Schema::hasColumn('naskahs', 'category')) {
                $table->dropColumn('category');
            }
        });
    }
};
