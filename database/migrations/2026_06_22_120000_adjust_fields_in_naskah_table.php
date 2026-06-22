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
            // Add new dynamic columns
            if (!Schema::hasColumn('naskah', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('author_id')->constrained('categories')->nullOnDelete();
            }
            if (!Schema::hasColumn('naskah', 'package_id')) {
                $table->foreignId('package_id')->nullable()->after('category_id')->constrained('packages')->nullOnDelete();
            }
            if (!Schema::hasColumn('naskah', 'co_author')) {
                $table->text('co_author')->nullable()->after('description');
            }

            // Drop old columns if they exist
            if (Schema::hasColumn('naskah', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('naskah', 'author_name')) {
                $table->dropColumn('author_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            if (!Schema::hasColumn('naskah', 'category')) {
                $table->string('category')->nullable()->after('title');
            }
            if (!Schema::hasColumn('naskah', 'author_name')) {
                $table->string('author_name')->nullable()->after('author_id');
            }

            if (Schema::hasColumn('naskah', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('naskah', 'package_id')) {
                $table->dropForeign(['package_id']);
                $table->dropColumn('package_id');
            }
            if (Schema::hasColumn('naskah', 'co_author')) {
                $table->dropColumn('co_author');
            }
        });
    }
};
