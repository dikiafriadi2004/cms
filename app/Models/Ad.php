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
        $ads = static::active()
            ->byPosition($position)
            ->orderBy('sort_order')
            ->get()
            ->filter(function ($ad) use ($context) {
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
            
            // Get image dimensions to set max-width
            $imagePath = storage_path('app/public/' . $this->image);
            $maxWidthStyle = '';
            
            if (file_exists($imagePath)) {
                list($width, $height) = getimagesize($imagePath);
                $maxWidthStyle = "max-width: {$width}px; ";
            }
            
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
            // Get image dimensions to set max-width
            $imagePath = storage_path('app/public/' . $this->image);
            $maxWidthStyle = '';
            
            if (file_exists($imagePath)) {
                list($width, $height) = getimagesize($imagePath);
                $maxWidthStyle = "max-width: {$width}px; ";
            }
            
            return sprintf(
                '<div %s><img src="%s" alt="%s" class="rounded-lg" style="%swidth: 100%%; height: auto; display: block; margin: 0 auto;"></div>',
                $trackingAttr,
                asset('storage/' . $this->image),
                e($this->name),
                $maxWidthStyle
            );
        }
        
        // Otherwise return the code (HTML/JavaScript) wrapped with tracking
        return sprintf('<div %s>%s</div>', $trackingAttr, $this->code);
    }

    /**
     * Inject ads into content at specified paragraph positions
     */
    public static function injectIntoContent(string $content, array $context = []): string
    {
        // Get all in_content ads for this context
        $ads = static::active()
            ->where('position', 'in_content')
            ->orderBy('in_content_paragraph')
            ->orderBy('sort_order')
            ->get()
            ->filter(function ($ad) use ($context) {
                return $ad->shouldDisplay($context);
            });

        if ($ads->isEmpty()) {
            return $content;
        }

        // Split content by paragraphs (looking for </p> tags)
        $paragraphs = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        
        // Group ads by paragraph number
        $adsByParagraph = $ads->groupBy('in_content_paragraph');

        $result = '';
        $paragraphCount = 0;

        foreach ($paragraphs as $index => $part) {
            $result .= $part;
            
            // Check if this is a closing </p> tag
            if (strtolower(trim($part)) === '</p>') {
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