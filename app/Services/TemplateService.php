<?php

namespace App\Services;

use App\Models\Setting;

class TemplateService
{
    /**
     * Available frontend templates
     */
    public static function getAvailableTemplates(): array
    {
        return [
            'default' => [
                'name' => 'Default Modern',
                'description' => 'Clean and modern design with gradient accents and animations',
                'preview' => '/images/templates/default-preview.jpg',
                'features' => ['Responsive', 'Animated', 'Colorful', 'Dynamic']
            ],
            'minimal' => [
                'name' => 'Minimal Clean',
                'description' => 'Minimalist design focused on content readability and simplicity',
                'preview' => '/images/templates/minimal-preview.jpg',
                'features' => ['Ultra Clean', 'Typography Focus', 'Distraction-free', 'Fast']
            ],
            'magazine' => [
                'name' => 'Magazine Bold',
                'description' => 'Bold magazine-style layout with large images and strong typography',
                'preview' => '/images/templates/magazine-preview.jpg',
                'features' => ['Bold Design', 'Image Heavy', 'Grid Layout', 'Editorial']
            ],
            'corporate' => [
                'name' => 'Corporate Professional',
                'description' => 'Professional business-oriented design that builds trust and credibility',
                'preview' => '/images/templates/corporate-preview.jpg',
                'features' => ['Professional', 'Trust Building', 'Clean', 'Business Ready']
            ],
            'elegant' => [
                'name' => 'Elegant Luxury',
                'description' => 'Sophisticated and luxurious design with premium aesthetics',
                'preview' => '/images/templates/elegant-preview.jpg',
                'features' => ['Luxury', 'Sophisticated', 'Premium', 'Refined']
            ],
        ];
    }

    /**
     * Get current active template
     */
    public static function getCurrentTemplate(): string
    {
        $setting = Setting::where('key', 'frontend_template')->first();
        return $setting?->value ?? 'default';
    }

    /**
     * Get template view path
     */
    public static function getTemplatePath(string $view): string
    {
        $template = self::getCurrentTemplate();
        $templatePath = "frontend.templates.{$template}.{$view}";
        
        // Check if template view exists, fallback to default
        if (view()->exists($templatePath)) {
            return $templatePath;
        }
        
        return "frontend.{$view}";
    }

    /**
     * Get view path for specific template with fallback
     * 
     * @param string $template Template name (e.g., 'minimal', 'magazine')
     * @param string $view View name (e.g., 'home', 'blog.index')
     * @return string View path
     */
    public static function getView(string $template, string $view): string
    {
        $templatePath = "frontend.templates.{$template}.{$view}";
        
        // Check if template view exists, fallback to default
        if (view()->exists($templatePath)) {
            return $templatePath;
        }
        
        return "frontend.{$view}";
    }

    /**
     * Check if a specific view exists for a template
     * 
     * @param string $template Template name
     * @param string $view View name
     * @return bool
     */
    public static function viewExists(string $template, string $view): bool
    {
        $templatePath = "frontend.templates.{$template}.{$view}";
        return view()->exists($templatePath);
    }

    /**
     * Check if template exists
     */
    public static function templateExists(string $template): bool
    {
        return array_key_exists($template, self::getAvailableTemplates());
    }
}
