<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'author', 'isbn', 'publisher', 'published_at', 'abstract', 'pdf_url', 'cover_image', 'status'])]
class Book extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
        ];
    }
}
