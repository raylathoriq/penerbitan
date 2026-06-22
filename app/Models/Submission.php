<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'package_id',
        'title',
        'sinopsis',
        'status',
        'co_author',
        'file_path',
    ];

    protected $casts = [
        'co_author' => 'array', // cast JSON to array automatically
    ];

    /**
     * Get the user (author) who submitted this manuscript.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the manuscript.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the publication package selected for this manuscript.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}

