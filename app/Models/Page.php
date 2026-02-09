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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if ($page->is_homepage) {
                // Ensure only one homepage exists
                static::where('is_homepage', true)->where('id', '!=', $page->id)->update(['is_homepage' => false]);
            }
        });
    }
}