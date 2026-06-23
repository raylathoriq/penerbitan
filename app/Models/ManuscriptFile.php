<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManuscriptFile extends Model
{
    use HasFactory;

    protected $table = 'manuscript_files';

    protected $fillable = [
        'id_naskah',
        'jenis_file',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'version',
        'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the manuscript associated with this file.
     */
    public function naskah(): BelongsTo
    {
        return $this->belongsTo(Naskah::class, 'id_naskah');
    }
}
