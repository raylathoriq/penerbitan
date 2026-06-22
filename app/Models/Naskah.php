<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Naskah extends Model
{
    use HasFactory;

    protected $table = 'naskah';

    protected $fillable = [
        'author_id',
        'category_id',
        'package_id',
        'title',
        'description',
        'co_author',
        'document_name',
        'document_path',
        'document_size',
        'status',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'submitted_at' => 'datetime',
            'co_author' => 'array',
        ];
    }

    /**
     * Get the status label formatted nicely.
     */
    public function getStatusLabelAttribute(): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $this->status));
    }

    /**
     * Get the user (author) who submitted this manuscript.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Alias relationship to match author terminology.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the category of the manuscript.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the publication package selected for this manuscript.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
