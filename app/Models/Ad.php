<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'position',
        'rotation_group',
        'rotation_weight',
        'rotation_mode',
        'code',
        'image',
        'link',
        'open_new_tab',
        'is_active',
        'start_date',
        'end_date',
        'display_rules',
        'sort_order',
        'in_content_paragraph',
        'size_preset',
        'custom_width',
        'custom_height',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'open_new_tab' => 'boolean',
        'display_rules' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get analytics for this ad
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(AdAnalytic::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now()->toDateString());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now()->toDateString());
            });
    }

    /**
     * Check if ad is expired
     */
    public function isExpired(): bool
    {
        if (!$this->end_date) {
            return false;
        }
        
        return $this->end_date->isPast();
    }

    /**
     * Check if ad is scheduled (not started yet)
     */
    public function isScheduled(): bool
    {
        if (!$this->start_date) {
            return false;
        }
        
        return $this->start_date->isFuture();
    }

    /**
     * Get status label
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }
        
        if ($this->isExpired()) {
            return 'expired';
        }
        
        if ($this->isScheduled()) {
            return 'scheduled';
        }
        
        return 'active';
    }

    /**
     * Get status color for badge
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'scheduled' => 'blue',
            'expired' => 'red',
            'inactive' => 'gray',
            default => 'gray',
        };
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Auto-invalidate the per-position cache when an ad is saved/deleted.
     */
    protected static function boot()
    {
        parent::boot();

        $invalidate = function ($ad) {
            \Illuminate\Support\Facades\Cache::forget("ads.position.{$ad->position}");
        };

        static::saved($invalidate);
        static::deleted($invalidate);
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
        // Cache the active ads list per-position for 5 minutes. Filtering by
        // context (page/post/category) and rotation selection still happens
        // in PHP because they depend on per-request data, but the underlying
        // active ads query is cached so we don't hit DB on every render.
        $cacheKey = "ads.position.{$position}";

        $allAdsForPosition = \Illuminate\Support\Facades\Cache::remember(
            $cacheKey,
            300, // 5 minutes
            function () use ($position) {
                return static::active()
                    ->byPosition($position)
                    ->orderBy('sort_order')
                    ->get();
            }
        );

        $ads = $allAdsForPosition->filter(function ($ad) use ($context) {
            return $ad->shouldDisplay($context);
        });

        // Group ads by rotation_group
        $grouped = $ads->groupBy('rotation_group');

        $result = collect();

        foreach ($grouped as $group => $groupAds) {
            if ($group && $groupAds->count() > 1) {
                // This is a rotation group - select one ad based on rotation mode
                $selected = static::selectAdFromGroup($groupAds);
                if ($selected) {
                    $result->push($selected);
                }
            } else {
                // Not a rotation group - add all ads
                $result = $result->merge($groupAds);
            }
        }

        return $result;
    }

    /**
     * Select one ad from rotation group based on rotation mode
     */
    protected static function selectAdFromGroup($ads)
    {
        if ($ads->isEmpty()) {
            return null;
        }

        $mode = $ads->first()->rotation_mode ?? 'random';

        switch ($mode) {
            case 'weighted':
                return static::selectWeightedAd($ads);
            
            case 'sequential':
                return static::selectSequentialAd($ads);
            
            case 'random':
            default:
                return $ads->random();
        }
    }

    /**
     * Select ad based on weight
     */
    protected static function selectWeightedAd($ads)
    {
        $totalWeight = $ads->sum('rotation_weight');
        $random = rand(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($ads as $ad) {
            $currentWeight += $ad->rotation_weight;
            if ($random <= $currentWeight) {
                return $ad;
            }
        }
        
        return $ads->first();
    }

    /**
     * Select ad sequentially based on impressions
     */
    protected static function selectSequentialAd($ads)
    {
        // Get ad with least impressions today
        $adIds = $ads->pluck('id');
        
        $impressions = \App\Models\AdAnalytic::whereIn('ad_id', $adIds)
            ->impressions()
            ->whereDate('event_date', today())
            ->selectRaw('ad_id, COUNT(*) as count')
            ->groupBy('ad_id')
            ->pluck('count', 'ad_id');
        
        // Find ad with minimum impressions
        $minImpressions = PHP_INT_MAX;
        $selectedAd = $ads->first();
        
        foreach ($ads as $ad) {
            $count = $impressions[$ad->id] ?? 0;
            if ($count < $minImpressions) {
                $minImpressions = $count;
                $selectedAd = $ad;
            }
        }
        
        return $selectedAd;
    }

    /**
     * Render the ad HTML with tracking
     */
    public function render(): string
    {
        $trackingAttr = sprintf('data-ad-id="%d"', $this->id);
        
        // If it's an image ad with link
        if ($this->image && $this->link) {
            $target = $this->open_new_tab ? '_blank' : '_self';
            $rel = $this->open_new_tab ? 'noopener noreferrer' : '';
            
            $maxWidthStyle = $this->getCachedMaxWidthStyle();
            
            return sprintf(
                '<div %s><a href="%s" target="%s" rel="%s" class="block"><img src="%s" alt="%s" class="rounded-lg" style="%swidth: 100%%; height: auto; display: block; margin: 0 auto;"></a></div>',
                $trackingAttr,
                e($this->link),
                $target,
                $rel,
                asset('storage/' . $this->image),
                e($this->name),
                $maxWidthStyle
            );
        }
        
        // If it's just an image without link
        if ($this->image && !$this->link) {
            $maxWidthStyle = $this->getCachedMaxWidthStyle();
            
            return sprintf(
                '<div %s><img src="%s" alt="%s" class="rounded-lg" style="%swidth: 100%%; height: auto; display: block; margin: 0 auto;"></div>',
                $trackingAttr,
                asset('storage/' . $this->image),
                e($this->name),
                $maxWidthStyle
            );
        }
        
        // Otherwise return the code (HTML/JavaScript) wrapped with tracking
        // Sanitize ad code to prevent XSS attacks
        $sanitizedCode = $this->sanitizeAdCode($this->code);
        return sprintf('<div %s>%s</div>', $trackingAttr, $sanitizedCode);
    }

    /**
     * Get the max-width style for an image ad. Cached 1 week per image path
     * so admin replacing an image with the same path eventually picks up
     * new dimensions (vs. forever which never refreshes).
     */
    private function getCachedMaxWidthStyle(): string
    {
        if (!$this->image) {
            return '';
        }

        $cacheKey = 'ad.image.dim.' . sha1($this->image);

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 604800, function () {
            $imagePath = storage_path('app/public/' . $this->image);
            if (!file_exists($imagePath)) {
                return '';
            }
            $info = @getimagesize($imagePath);
            if (!$info || empty($info[0])) {
                return '';
            }
            return "max-width: {$info[0]}px; ";
        });
    }

    /**
     * Sanitize ad code to prevent XSS attacks
     *
     * Multi-layer defense:
     * 1. strip_tags with whitelist
     * 2. Remove dangerous attributes (on*, javascript:, data: URI scripts)
     * 3. Whitelist iframe/script sources to known ad networks only
     * 4. Strip inline scripts that aren't from allowed domains
     */
    private function sanitizeAdCode(string $code): string
    {
        // Layer 1: Allow only safe HTML tags
        $allowedTags = '<div><span><a><img><iframe><script><ins><p><br><strong><em><b><i><h1><h2><h3><h4><h5><h6>';
        $sanitized = strip_tags($code, $allowedTags);

        // Layer 2: Strip event handler attributes (onclick, onerror, onload, etc)
        // Match: ' on\w+="..."' or " on\w+='...'" or ' on\w+=value'
        $sanitized = preg_replace('/\s+on\w+\s*=\s*(["\'])(?:(?!\1).)*\1/i', '', $sanitized);
        $sanitized = preg_replace('/\s+on\w+\s*=\s*[^\s>]+/i', '', $sanitized);

        // Layer 3: Strip javascript: pseudo-protocol from href/src
        $sanitized = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $sanitized);

        // Layer 4: Strip data: URI when used in script/iframe contexts (allow data: in img only)
        $sanitized = preg_replace_callback(
            '/<(script|iframe)([^>]*)>/i',
            function ($m) {
                $attrs = $m[2];
                $attrs = preg_replace('/(src|href)\s*=\s*(["\'])\s*data:[^"\']*\2/i', '', $attrs);
                return '<' . $m[1] . $attrs . '>';
            },
            $sanitized
        );

        // Layer 5: Whitelist iframe/script sources to known ad networks
        $allowedDomains = [
            'googlesyndication.com',
            'doubleclick.net',
            'googletagservices.com',
            'adnxs.com',
            'amazon-adsystem.com',
            'media.net',
        ];

        // Build allowed pattern: matches if URL contains one of allowed domains
        $allowedPattern = implode('|', array_map(fn($d) => preg_quote($d, '/'), $allowedDomains));

        // Strip <iframe> with src that does not match allowed domains
        $sanitized = preg_replace_callback(
            '/<iframe[^>]*\bsrc\s*=\s*(["\'])([^"\']*)\1[^>]*>(.*?)<\/iframe>/is',
            function ($m) use ($allowedPattern) {
                $src = $m[2];
                if (preg_match('/^https?:\/\/(?:[^\/]+\.)?(' . $allowedPattern . ')\//i', $src)
                    || str_starts_with($src, '/')
                    || str_starts_with($src, asset(''))) {
                    return $m[0];
                }
                return '';
            },
            $sanitized
        );

        // Strip <script src="..."> with src that does not match allowed domains
        $sanitized = preg_replace_callback(
            '/<script[^>]*\bsrc\s*=\s*(["\'])([^"\']*)\1[^>]*>(.*?)<\/script>/is',
            function ($m) use ($allowedPattern) {
                $src = $m[2];
                if (preg_match('/^https?:\/\/(?:[^\/]+\.)?(' . $allowedPattern . ')\//i', $src)
                    || str_starts_with($src, '/')
                    || str_starts_with($src, asset(''))) {
                    return $m[0];
                }
                return '';
            },
            $sanitized
        );

        // Layer 6: Strip <script> WITHOUT src (inline scripts) — these are dangerous
        // Allow only AdSense-style inline pushes (very narrow whitelist)
        $sanitized = preg_replace_callback(
            '/<script\b(?![^>]*\bsrc\s*=)[^>]*>(.*?)<\/script>/is',
            function ($m) {
                $body = trim($m[1]);
                // Allow Google AdSense push pattern only
                if (preg_match('/^\(adsbygoogle\s*=\s*window\.adsbygoogle\s*\|\|\s*\[\]\)\.push\(\{[^}]*\}\)\s*;?\s*$/i', $body)) {
                    return $m[0];
                }
                return '';
            },
            $sanitized
        );

        return $sanitized;
    }

    /**
     * Inject ads into content at specified paragraph positions
     */
    public static function injectIntoContent(string $content, array $context = []): string
    {
        // Get all in_content ads cached for 5 min. Same pattern as getByPosition().
        $ads = \Illuminate\Support\Facades\Cache::remember(
            'ads.position.in_content',
            300,
            function () {
                return static::active()
                    ->where('position', 'in_content')
                    ->orderBy('in_content_paragraph')
                    ->orderBy('sort_order')
                    ->get();
            }
        )->filter(function ($ad) use ($context) {
            return $ad->shouldDisplay($context);
        });

        if ($ads->isEmpty()) {
            return $content;
        }

        // Split content by closing paragraph tags. We accept tags like
        // </p>, </P>, </p > with optional whitespace. Note: TinyMCE may
        // emit content without explicit </p> in some structures (lists,
        // tables); in those cases the paragraph counter simply doesn't
        // advance and ads attached to those positions are skipped. This is
        // acceptable defensive behavior — content with malformed structure
        // gets fewer ads, not duplicated or wrong-position ads.
        $paragraphs = preg_split('/(<\/p\s*>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        // Group ads by paragraph number
        $adsByParagraph = $ads->groupBy('in_content_paragraph');

        $result = '';
        $paragraphCount = 0;

        foreach ($paragraphs as $index => $part) {
            $result .= $part;
            
            // Check if this is a closing </p> tag (allow whitespace)
            if (preg_match('#^\s*</p\s*>\s*$#i', $part)) {
                $paragraphCount++;
                
                // Insert ads after this paragraph if any
                if (isset($adsByParagraph[$paragraphCount])) {
                    foreach ($adsByParagraph[$paragraphCount] as $ad) {
                        $result .= '<div class="my-8 ad-container">' . $ad->render() . '</div>';
                    }
                }
            }
        }

        return $result;
    }
}