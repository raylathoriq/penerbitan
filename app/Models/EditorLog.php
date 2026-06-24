<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EditorLog extends Model
{
    use HasFactory;

    protected $table = 'editor_log';

    protected $fillable = [
        'id_user',
        'id_naskah',
        'comments',
        'decision',
        'tanggal_edit',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_edit' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the manuscript associated with the editor log.
     */
    public function naskah(): BelongsTo
    {
        return $this->belongsTo(Naskah::class, 'id_naskah');
    }

    /**
     * Get the editor (user) associated with the log.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Alias for editor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
