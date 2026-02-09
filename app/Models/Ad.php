<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'position',
        'code',
        'is_active',
        'display_rules',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_rules' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function shouldDisplay($context = []): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->display_rules) {
            return true;
        }

        $rules = $this->display_rules;

        // Check page rules
        if (isset($rules['pages']) && !empty($rules['pages'])) {
            $currentPage = $context['page'] ?? null;
            if ($currentPage && !in_array($currentPage, $rules['pages'])) {
                return false;
            }
        }

        // Check post rules
        if (isset($rules['posts']) && !empty($rules['posts'])) {
            $currentPost = $context['post'] ?? null;
            if ($currentPost && !in_array($currentPost, $rules['posts'])) {
                return false;
            }
        }

        // Check category rules
        if (isset($rules['categories']) && !empty($rules['categories'])) {
            $currentCategory = $context['category'] ?? null;
            if ($currentCategory && !in_array($currentCategory, $rules['categories'])) {
                return false;
            }
        }

        return true;
    }

    public static function getByPosition(string $position, array $context = [])
    {
        return static::active()
            ->byPosition($position)
            ->orderBy('sort_order')
            ->get()
            ->filter(function ($ad) use ($context) {
                return $ad->shouldDisplay($context);
            });
    }
}