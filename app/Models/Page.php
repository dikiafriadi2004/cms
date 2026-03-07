<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'template',
        'status',
        'user_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'open_graph',
        'twitter_card',
        'show_in_menu',
        'is_homepage',
        'sort_order',
        'views_count',
    ];

    protected $casts = [
        'open_graph' => 'array',
        'twitter_card' => 'array',
        'show_in_menu' => 'boolean',
        'is_homepage' => 'boolean',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: substr(strip_tags($this->content), 0, 160);
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

    /**
     * Auto-generate Open Graph meta tags
     */
    public function generateOpenGraphData(): array
    {
        return [
            'og:title' => $this->meta_title ?: $this->title,
            'og:description' => $this->meta_description ?: substr(strip_tags($this->content), 0, 160),
            'og:image' => $this->featured_image ?: asset('images/default-og-image.jpg'),
            'og:url' => route('page.show', $this->slug),
            'og:type' => 'website',
            'og:site_name' => config('app.name'),
        ];
    }

    /**
     * Auto-generate Twitter Card meta tags
     */
    public function generateTwitterCardData(): array
    {
        return [
            'twitter:card' => $this->featured_image ? 'summary_large_image' : 'summary',
            'twitter:title' => $this->meta_title ?: $this->title,
            'twitter:description' => $this->meta_description ?: substr(strip_tags($this->content), 0, 160),
            'twitter:image' => $this->featured_image ?: asset('images/default-og-image.jpg'),
            'twitter:site' => config('app.twitter_handle', '@yoursite'),
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if ($page->is_homepage) {
                // Ensure only one homepage exists
                static::where('is_homepage', true)->where('id', '!=', $page->id)->update(['is_homepage' => false]);
            }
            
            // Auto-generate Open Graph and Twitter Card data
            if (!$page->relationLoaded('user')) {
                $page->load('user');
            }
            
            $page->open_graph = $page->generateOpenGraphData();
            $page->twitter_card = $page->generateTwitterCardData();
        });
    }
}