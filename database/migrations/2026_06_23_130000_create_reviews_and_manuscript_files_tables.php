<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create review table
        Schema::create('review', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_naskah')->constrained('naskah')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users')->cascadeOnDelete(); // reviewer
            $table->text('assignment_note')->nullable();
            $table->text('comments')->nullable();
            $table->string('decision', 20)->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        // 2. Create manuscript_files table
        Schema::create('manuscript_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_naskah')->constrained('naskah')->cascadeOnDelete();
            $table->string('jenis_file', 30); // original, reviewer_coretan, editor_editing
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->integer('version')->default(1);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });

        // 3. Migrate existing records from naskah table to manuscript_files
        $naskahs = DB::table('naskah')->get();
        foreach ($naskahs as $naskah) {
            if (!empty($naskah->document_path)) {
                $sizeInBytes = null;
                if (!empty($naskah->document_size)) {
                    $sizeStr = strtolower($naskah->document_size);
                    if (str_contains($sizeStr, 'mb')) {
                        $sizeInBytes = intval(floatval($sizeStr) * 1024 * 1024);
                    } elseif (str_contains($sizeStr, 'kb')) {
                        $sizeInBytes = intval(floatval($sizeStr) * 1024);
                    } else {
                        $sizeInBytes = intval($sizeStr);
                    }
                }
                
                DB::table('manuscript_files')->insert([
                    'id_naskah' => $naskah->id,
                    'jenis_file' => 'original',
                    'file_name' => $naskah->document_name ?? basename($naskah->document_path),
                    'file_path' => $naskah->document_path,
                    'file_size' => $sizeInBytes,
                    'version' => 1,
                    'uploaded_at' => $naskah->created_at,
                    'created_at' => $naskah->created_at,
                    'updated_at' => $naskah->updated_at,
                ]);
            }
        }

        // 4. Drop columns from naskah table
        Schema::table('naskah', function (Blueprint $table) {
            $table->dropColumn(['document_name', 'document_path', 'document_size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Add back columns to naskah table
        Schema::table('naskah', function (Blueprint $table) {
            $table->string('document_name')->nullable()->after('description');
            $table->string('document_path')->nullable()->after('document_name');
            $table->string('document_size')->nullable()->after('document_path');
        });

        // 2. Restore file data from manuscript_files to naskah table (fallback to first version of original)
        $files = DB::table('manuscript_files')
            ->where('jenis_file', 'original')
            ->orderBy('version')
            ->get();
        foreach ($files as $file) {
            $sizeStr = $file->file_size ? round($file->file_size / 1024, 1) . ' KB' : null;
            DB::table('naskah')->where('id', $file->id_naskah)->update([
                'document_name' => $file->file_name,
                'document_path' => $file->file_path,
                'document_size' => $sizeStr,
            ]);
        }

        // 3. Drop tables
        Schema::dropIfExists('manuscript_files');
        Schema::dropIfExists('review');
    }
};
