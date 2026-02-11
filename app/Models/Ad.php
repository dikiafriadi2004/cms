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
        'image',
        'link',
        'open_new_tab',
        'is_active',
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

    /**
     * Render the ad HTML
     */
    public function render(): string
    {
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
                '<a href="%s" target="%s" rel="%s" class="block"><img src="%s" alt="%s" class="rounded-lg" style="%swidth: 100%%; height: auto; display: block; margin: 0 auto;"></a>',
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
                '<img src="%s" alt="%s" class="rounded-lg" style="%swidth: 100%%; height: auto; display: block; margin: 0 auto;">',
                asset('storage/' . $this->image),
                e($this->name),
                $maxWidthStyle
            );
        }
        
        // Otherwise return the code (HTML/JavaScript)
        return $this->code;
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