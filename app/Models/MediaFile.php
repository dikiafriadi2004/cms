<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MediaFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'dimensions',
        'alt_text',
        'description',
        'user_id',
        'folder',
    ];

    protected $casts = [
        'dimensions' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->isImage()) {
            $thumbnailPath = str_replace('.', '_thumb.', $this->file_path);
            if (Storage::exists('public/' . $thumbnailPath)) {
                return asset('storage/' . $thumbnailPath);
            }
        }
        return $this->url;
    }

    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getTypeBadgeClassAttribute(): string
    {
        return match($this->file_type) {
            'image' => 'bg-green-100 text-green-800',
            'video' => 'bg-purple-100 text-purple-800',
            'audio' => 'bg-blue-100 text-blue-800',
            'document' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    public function isDocument(): bool
    {
        return $this->file_type === 'document';
    }

    public function isAudio(): bool
    {
        return $this->file_type === 'audio';
    }

    public function scopeByType($query, $type)
    {
        return $query->where('file_type', $type);
    }

    public function scopeByFolder($query, $folder)
    {
        return $query->where('folder', $folder);
    }

    public function scopeImages($query)
    {
        return $query->where('file_type', 'image');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($mediaFile) {
            // Delete main file
            if (Storage::exists('public/' . $mediaFile->file_path)) {
                Storage::delete('public/' . $mediaFile->file_path);
            }
            
            // Delete thumbnail if it's an image
            if ($mediaFile->isImage()) {
                $thumbnailPath = str_replace('.', '_thumb.', $mediaFile->file_path);
                if (Storage::exists('public/' . $thumbnailPath)) {
                    Storage::delete('public/' . $thumbnailPath);
                }
            }
        });
    }
}