<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'category', 'author_id', 'author_name', 'status', 'description', 'document_name', 'document_path', 'document_size', 'submitted_at'])]
class Naskah extends Model
{
    use HasFactory;

    protected $table = 'naskah';

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $this->status));
    }
}
