<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $fillable = [
        'id_naskah',
        'id_user',
        'assignment_note',
        'comments',
        'decision',
        'reviewed_at',
        'revision_note',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the manuscript being reviewed.
     */
    public function naskah(): BelongsTo
    {
        return $this->belongsTo(Naskah::class, 'id_naskah');
    }

    /**
     * Get the reviewer (user) who performs the review.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get the reviewer (user) alias as user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
