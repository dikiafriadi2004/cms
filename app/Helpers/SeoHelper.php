<?php

namespace App\Helpers;

class SeoHelper
{
    /**
     * Generate SEO-friendly slug
     */
    public static function generateSlug(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        $text = trim($text, '-');
        
        return $text;
    }

    /**
     * Calculate reading time in minutes
     */
    public static function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        
        return max(1, $minutes);
    }

    /**
     * Generate meta description from content
     */
    public static function generateMetaDescription(string $content, int $length = 160): string
    {
        $text = strip_tags($content);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);
        
        if (strlen($text) <= $length) {
            return $text;
        }
        
        $text = substr($text, 0, $length);
        $lastSpace = strrpos($text, ' ');
        
        if ($lastSpace !== false) {
            $text = substr($text, 0, $lastSpace);
        }
        
        return $text . '...';
    }

    /**
     * Calculate SEO score for content
     */
    public static function calculateSeoScore(array $data): int
    {
        $score = 0;

        // Title optimization (20 points)
        if (isset($data['title'])) {
            $titleLength = strlen($data['title']);
            if ($titleLength >= 30 && $titleLength <= 60) {
                $score += 20;
            } elseif ($titleLength >= 20) {
                $score += 10;
            }
        }

        // Meta description (20 points)
        if (isset($data['meta_description'])) {
            $descLength = strlen($data['meta_description']);
            if ($descLength >= 120 && $descLength <= 160) {
                $score += 20;
            } elseif ($descLength >= 100) {
                $score += 10;
            }
        }

        // Focus keyword in title (15 points)
        if (isset($data['focus_keyword']) && isset($data['title'])) {
            if (stripos($data['title'], $data['focus_keyword']) !== false) {
                $score += 15;
            }
        }

        // Focus keyword in content (15 points)
        if (isset($data['focus_keyword']) && isset($data['content'])) {
            if (stripos($data['content'], $data['focus_keyword']) !== false) {
                $score += 15;
            }
        }

        // Featured image (10 points)
        if (isset($data['featured_image']) && $data['featured_image']) {
            $score += 10;
        }

        // Content length (10 points)
        if (isset($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            if ($wordCount >= 300) {
                $score += 10;
            } elseif ($wordCount >= 150) {
                $score += 5;
            }
        }

        // Category assigned (5 points)
        if (isset($data['category_id']) && $data['category_id']) {
            $score += 5;
        }

        // Tags assigned (5 points)
        if (isset($data['tags']) && is_array($data['tags']) && count($data['tags']) > 0) {
            $score += 5;
        }

        return min(100, $score);
    }

    /**
     * Generate Open Graph data
     */
    public static function generateOpenGraph(array $data): array
    {
        return [
            'og:title' => $data['title'] ?? '',
            'og:description' => $data['description'] ?? '',
            'og:image' => $data['image'] ?? '',
            'og:url' => $data['url'] ?? url()->current(),
            'og:type' => $data['type'] ?? 'website',
            'og:site_name' => config('app.name'),
        ];
    }

    /**
     * Generate Twitter Card data
     */
    public static function generateTwitterCard(array $data): array
    {
        return [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $data['title'] ?? '',
            'twitter:description' => $data['description'] ?? '',
            'twitter:image' => $data['image'] ?? '',
        ];
    }

    /**
     * Generate structured data (JSON-LD)
     */
    public static function generateStructuredData(string $type, array $data): array
    {
        $baseData = [
            '@context' => 'https://schema.org',
            '@type' => $type,
        ];

        return array_merge($baseData, $data);
    }

    /**
     * Sanitize HTML content
     */
    public static function sanitizeHtml(string $html): string
    {
        // Allow specific HTML tags
        $allowedTags = '<p><br><strong><em><u><a><img><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote><code><pre>';
        
        return strip_tags($html, $allowedTags);
    }

    /**
     * Extract keywords from content
     */
    public static function extractKeywords(string $content, int $limit = 10): array
    {
        $text = strip_tags($content);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', '', $text);
        
        $words = explode(' ', $text);
        $words = array_filter($words, function($word) {
            return strlen($word) > 3; // Filter short words
        });
        
        $stopWords = ['this', 'that', 'with', 'from', 'have', 'been', 'will', 'your', 'their', 'what', 'about', 'which', 'when', 'make', 'like', 'time', 'just', 'know', 'take', 'people', 'into', 'year', 'good', 'some', 'could', 'them', 'than', 'then', 'look', 'only', 'come', 'over', 'think', 'also', 'back', 'after', 'work', 'first', 'well', 'even', 'want', 'because', 'these', 'give', 'most'];
        
        $words = array_diff($words, $stopWords);
        $wordCounts = array_count_values($words);
        arsort($wordCounts);
        
        return array_slice(array_keys($wordCounts), 0, $limit);
    }
}