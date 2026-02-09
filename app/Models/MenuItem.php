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

    public function getUrl(): string
    {
        if ($this->url) {
            return $this->url;
        }

        return match ($this->type) {
            'page' => $this->page ? route('page.show', $this->page->slug) : '#',
            'post' => $this->post ? route('blog.show', $this->post->slug) : '#',
            'category' => $this->category ? route('blog.category', $this->category->slug) : '#',
            'external' => $this->attributes['url'] ?? '#',
            default => '#',
        };
    }

    public function getUrlAttribute($value): string
    {
        if ($value) {
            return $value;
        }

        return $this->getUrl();
    }
}