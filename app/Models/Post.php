<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, HasSlug, Searchable;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'status',
        'category_id',
        'user_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'open_graph',
        'twitter_card',
        'focus_keyword',
        'seo_score',
        'views_count',
        'reading_time',
        'published_at',
    ];

    protected $casts = [
        'open_graph' => 'array',
        'twitter_card' => 'array',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')->where('published_at', '>', now());
    }

    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    public function getFeaturedImageAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }
        
        // Jika sudah berisi URL lengkap (http/https), return as is
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        
        // Jika berisi path relatif, tambahkan asset
        return asset('storage/' . $value);
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: $this->excerpt ?: substr(strip_tags($this->content), 0, 160);
    }

    public function getReadingTimeAttribute($value): int
    {
        if ($value) {
            return $value;
        }

        $wordCount = str_word_count(strip_tags($this->content));
        return max(1, ceil($wordCount / 200)); // Average reading speed: 200 words per minute
    }

    public function calculateSeoScore(): int
    {
        $score = 0;

        // Title optimization (20 points)
        if ($this->title && strlen($this->title) >= 30 && strlen($this->title) <= 60) {
            $score += 20;
        } elseif ($this->title && strlen($this->title) >= 20) {
            $score += 10;
        }

        // Meta description (20 points)
        if ($this->meta_description && strlen($this->meta_description) >= 120 && strlen($this->meta_description) <= 160) {
            $score += 20;
        } elseif ($this->meta_description && strlen($this->meta_description) >= 100) {
            $score += 10;
        }

        // Focus keyword in title (15 points)
        if ($this->focus_keyword && stripos($this->title, $this->focus_keyword) !== false) {
            $score += 15;
        }

        // Focus keyword in content (15 points)
        if ($this->focus_keyword && stripos($this->content, $this->focus_keyword) !== false) {
            $score += 15;
        }

        // Featured image (10 points)
        if ($this->featured_image) {
            $score += 10;
        }

        // Content length (10 points)
        $wordCount = str_word_count(strip_tags($this->content));
        if ($wordCount >= 300) {
            $score += 10;
        } elseif ($wordCount >= 150) {
            $score += 5;
        }

        // Category assigned (5 points)
        if ($this->category_id) {
            $score += 5;
        }

        // Tags assigned (5 points)
        if ($this->tags()->count() > 0) {
            $score += 5;
        }

        return min(100, $score);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($post) {
            $post->reading_time = $post->getReadingTimeAttribute(null);
            $post->seo_score = $post->calculateSeoScore();
        });
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => strip_tags($this->content),
            'excerpt' => $this->excerpt,
            'category' => $this->category?->name,
            'tags' => $this->tags->pluck('name')->toArray(),
            'published_at' => $this->published_at?->timestamp,
        ];
    }
}