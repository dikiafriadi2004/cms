<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        return response(
            cache()->remember('sitemap.xml', now()->addHours(6), function () {
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            
            // Homepage
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . url('/') . '</loc>';
            $sitemap .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>daily</changefreq>';
            $sitemap .= '<priority>1.0</priority>';
            $sitemap .= '</url>';
            
            // Blog Index
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . route('blog.index') . '</loc>';
            $sitemap .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>daily</changefreq>';
            $sitemap .= '<priority>0.9</priority>';
            $sitemap .= '</url>';
            
            // Blog Posts
            $posts = Post::published()->get();
            foreach ($posts as $post) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . route('blog.show', $post->slug) . '</loc>';
                $sitemap .= '<lastmod>' . $post->updated_at->toAtomString() . '</lastmod>';
                $sitemap .= '<changefreq>weekly</changefreq>';
                $sitemap .= '<priority>0.8</priority>';
                $sitemap .= '</url>';
            }
            
            // Categories
            $categories = Category::active()->get();
            foreach ($categories as $category) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . route('blog.category', $category->slug) . '</loc>';
                $sitemap .= '<lastmod>' . $category->updated_at->toAtomString() . '</lastmod>';
                $sitemap .= '<changefreq>weekly</changefreq>';
                $sitemap .= '<priority>0.7</priority>';
                $sitemap .= '</url>';
            }
            
            // Tags
            $tags = Tag::active()->get();
            foreach ($tags as $tag) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . route('blog.tag', $tag->slug) . '</loc>';
                $sitemap .= '<lastmod>' . $tag->updated_at->toAtomString() . '</lastmod>';
                $sitemap .= '<changefreq>weekly</changefreq>';
                $sitemap .= '<priority>0.6</priority>';
                $sitemap .= '</url>';
            }
            
            // Static Pages
            $pages = Page::published()->get();
            foreach ($pages as $page) {
                $sitemap .= '<url>';
                $sitemap .= '<loc>' . route('page.show', $page->slug) . '</loc>';
                $sitemap .= '<lastmod>' . $page->updated_at->toAtomString() . '</lastmod>';
                $sitemap .= '<changefreq>monthly</changefreq>';
                $sitemap .= '<priority>0.7</priority>';
                $sitemap .= '</url>';
            }
            
            $sitemap .= '</urlset>';
            return $sitemap;
        }), 200)->header('Content-Type', 'application/xml');
    }
    
    public function robots()
    {
        $custom = \App\Models\Setting::where('key', 'robots_txt')->value('value');

        if ($custom) {
            // Pastikan sitemap URL selalu ada
            if (!str_contains($custom, 'Sitemap:')) {
                $custom = rtrim($custom) . "\n\nSitemap: " . url('/sitemap.xml');
            }
            $robots = $custom;
        } else {
            $robots = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /login\n\nSitemap: " . url('/sitemap.xml');
        }

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }
}
