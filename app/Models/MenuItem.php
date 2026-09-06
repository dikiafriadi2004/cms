<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'type',
        'target_id',
        'target',
        'css_class',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'target_id');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'target_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'target_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Resolve the URL for this menu item.
     *
     * Reads from raw `attributes['url']` to avoid recursion through the
     * `getUrlAttribute` accessor.
     */
    public function getUrl(): string
    {
        $rawUrl = $this->attributes['url'] ?? null;

        if (!empty($rawUrl)) {
            return $rawUrl;
        }

        return match ($this->type) {
            'page' => $this->page ? route('page.show', $this->page->slug) : '#',
            'post' => $this->post ? route('blog.show', $this->post->slug) : '#',
            'category' => $this->category ? route('blog.category', $this->category->slug) : '#',
            'external' => $rawUrl ?? '#',
            default => '#',
        };
    }

    /**
     * Eloquent accessor for `url` attribute.
     *
     * Falls back to computed URL via getUrl() when the column is empty.
     * Note: relations (page/post/category) should be eager-loaded by the
     * caller to avoid N+1 when rendering menus.
     */
    public function getUrlAttribute($value): string
    {
        if (!empty($value)) {
            return $value;
        }

        return $this->getUrl();
    }

    protected static function boot()
    {
        parent::boot();

        $invalidate = function ($item) {
            // Invalidate parent menu cache (lookup by location of parent menu)
            $location = optional($item->menu)->location;
            if ($location) {
                \Illuminate\Support\Facades\Cache::forget("menu.{$location}");
            }
        };

        static::saved($invalidate);
        static::deleted($invalidate);
    }
}