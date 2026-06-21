<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            if (! Schema::hasColumn('naskah', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('created_at');
            }
        });

        // Set submitted_at = created_at for existing rows
        DB::table('naskah')
            ->whereNull('submitted_at')
            ->update(['submitted_at' => DB::raw('created_at')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('naskah', function (Blueprint $table) {
            if (Schema::hasColumn('naskah', 'submitted_at')) {
                $table->dropColumn('submitted_at');
            }
        });
    }
};
