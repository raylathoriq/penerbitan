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
        'reviewer_id',
        'editor_id',
        'title',
        'description',
        'co_author',
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
        $labels = [
            'diajukan' => 'Diajukan',
            'dalam review' => 'Dalam Review',
            'revisi' => 'Revisi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
            'pengajuan_isbn' => 'Pengajuan ISBN',
            'perlu_edit' => 'Menunggu Edit',
            'editing' => 'Sedang Disunting',
            'selesai' => 'Selesai Disunting',
        ];

        return $labels[$this->status] ?? ucwords(str_replace(['-', '_'], ' ', $this->status));
    }

    /**
     * Get the files associated with this manuscript.
     */
    public function files()
    {
        return $this->hasMany(ManuscriptFile::class, 'id_naskah');
    }

    /**
     * Get the reviews associated with this manuscript.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_naskah');
    }

    /**
     * Get the editor logs associated with this manuscript.
     */
    public function editorLogs()
    {
        return $this->hasMany(EditorLog::class, 'id_naskah');
    }

    /**
     * Get the latest original file submitted by the author.
     */
    public function originalFile()
    {
        return $this->files()
            ->where('jenis_file', 'original')
            ->orderByDesc('version')
            ->first();
    }

    /**
     * Get the latest reviewer feedback file (with corrections).
     */
    public function reviewerFile()
    {
        return $this->files()
            ->where('jenis_file', 'reviewer_coretan')
            ->orderByDesc('version')
            ->first();
    }

    /**
     * Get the latest revision file submitted by the author.
     */
    public function latestRevisionFile()
    {
        return $this->files()
            ->where('jenis_file', 'revisi')
            ->orderByDesc('version')
            ->first();
    }

    /**
     * Get the latest active file from the author (either revision or original).
     */
    public function latestAuthorFile()
    {
        return $this->files()
            ->whereIn('jenis_file', ['original', 'revisi'])
            ->orderByDesc('version')
            ->first();
    }

    /**
     * Get the latest editor file submitted by the editor.
     */
    public function editorFile()
    {
        return $this->files()
            ->where('jenis_file', 'editor_editing')
            ->orderByDesc('version')
            ->first();
    }

    /**
     * Get the latest cover file submitted by the editor.
     */
    public function editorCoverFile()
    {
        return $this->files()
            ->where('jenis_file', 'cover')
            ->orderByDesc('version')
            ->first();
    }

    public function getActiveReviewAssignmentAttribute()
    {
        if ($this->relationLoaded('reviews')) {
            return $this->reviews->where('id_user', auth()->id())->sortByDesc('created_at')->first();
        }
        return $this->reviews()
            ->where('id_user', auth()->id())
            ->latest()
            ->first();
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
     * Get the user (reviewer) assigned to review this manuscript.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the user (editor) assigned to edit this manuscript.
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id');
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
