<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Page;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Maximum URLs per sitemap file (Google limit: 50,000).
     * Use a more conservative limit to keep file size small.
     */
    private const MAX_URLS_PER_SITEMAP = 5000;

    /**
     * Sitemap index entry-point. If total URLs exceed MAX_URLS_PER_SITEMAP,
     * generate a sitemap index that references multiple paginated sitemaps.
     * Otherwise return a single sitemap directly.
     */
    public function index(Request $request)
    {
        // Sub-sitemap pages: /sitemap-posts-{page}.xml etc.
        if ($request->filled('type') && $request->filled('page')) {
            return $this->paginatedSitemap($request->type, (int) $request->page);
        }

        $totalPosts = Post::published()->count();
        $totalPages = Page::published()->count();

        // If small site, single sitemap is fine
        if ($totalPosts + $totalPages < self::MAX_URLS_PER_SITEMAP) {
            return $this->singleSitemap();
        }

        return $this->sitemapIndex($totalPosts);
    }

    private function singleSitemap(): Response
    {
        $xml = cache()->remember('sitemap.xml.full', now()->addHours(6), function () {
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $sitemap .= $this->urlEntry(url('/'), now(), 'daily', '1.0');
            $sitemap .= $this->urlEntry(route('blog.index'), now(), 'daily', '0.9');

            Post::published()->select('slug', 'updated_at')->chunk(500, function ($posts) use (&$sitemap) {
                foreach ($posts as $post) {
                    $sitemap .= $this->urlEntry(
                        route('blog.show', $post->slug),
                        $post->updated_at,
                        'weekly',
                        '0.8'
                    );
                }
            });

            foreach (Category::active()->whereHas('publishedPosts')->select('slug', 'updated_at')->get() as $category) {
                $sitemap .= $this->urlEntry(
                    route('blog.category', $category->slug),
                    $category->updated_at,
                    'weekly',
                    '0.7'
                );
            }

            foreach (Tag::active()->whereHas('publishedPosts')->select('slug', 'updated_at')->get() as $tag) {
                $sitemap .= $this->urlEntry(
                    route('blog.tag', $tag->slug),
                    $tag->updated_at,
                    'weekly',
                    '0.6'
                );
            }

            Page::published()->select('slug', 'updated_at')->chunk(500, function ($pages) use (&$sitemap) {
                foreach ($pages as $page) {
                    $sitemap .= $this->urlEntry(
                        route('page.show', $page->slug),
                        $page->updated_at,
                        'monthly',
                        '0.7'
                    );
                }
            });

            $sitemap .= '</urlset>';
            return $sitemap;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function sitemapIndex(int $totalPosts): Response
    {
        $xml = cache()->remember('sitemap.xml.index', now()->addHours(1), function () use ($totalPosts) {
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            $sitemap .= '<sitemap><loc>' . url('/sitemap.xml?type=static&page=1') . '</loc></sitemap>';

            $postPages = (int) ceil($totalPosts / self::MAX_URLS_PER_SITEMAP);
            for ($i = 1; $i <= $postPages; $i++) {
                $sitemap .= '<sitemap><loc>' . url('/sitemap.xml?type=posts&page=' . $i) . '</loc></sitemap>';
            }

            $sitemap .= '<sitemap><loc>' . url('/sitemap.xml?type=pages&page=1') . '</loc></sitemap>';
            $sitemap .= '<sitemap><loc>' . url('/sitemap.xml?type=taxonomies&page=1') . '</loc></sitemap>';
            $sitemap .= '</sitemapindex>';

            return $sitemap;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function paginatedSitemap(string $type, int $page): Response
    {
        $page = max(1, $page);
        $cacheKey = "sitemap.xml.{$type}.{$page}";

        $xml = cache()->remember($cacheKey, now()->addHours(6), function () use ($type, $page) {
            $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $offset = ($page - 1) * self::MAX_URLS_PER_SITEMAP;

            switch ($type) {
                case 'static':
                    $sitemap .= $this->urlEntry(url('/'), now(), 'daily', '1.0');
                    $sitemap .= $this->urlEntry(route('blog.index'), now(), 'daily', '0.9');
                    break;

                case 'posts':
                    Post::published()
                        ->select('slug', 'updated_at')
                        ->offset($offset)
                        ->limit(self::MAX_URLS_PER_SITEMAP)
                        ->chunk(500, function ($posts) use (&$sitemap) {
                            foreach ($posts as $post) {
                                $sitemap .= $this->urlEntry(
                                    route('blog.show', $post->slug),
                                    $post->updated_at,
                                    'weekly',
                                    '0.8'
                                );
                            }
                        });
                    break;

                case 'pages':
                    Page::published()
                        ->select('slug', 'updated_at')
                        ->offset($offset)
                        ->limit(self::MAX_URLS_PER_SITEMAP)
                        ->chunk(500, function ($pages) use (&$sitemap) {
                            foreach ($pages as $page) {
                                $sitemap .= $this->urlEntry(
                                    route('page.show', $page->slug),
                                    $page->updated_at,
                                    'monthly',
                                    '0.7'
                                );
                            }
                        });
                    break;

                case 'taxonomies':
                    foreach (Category::active()->whereHas('publishedPosts')->select('slug', 'updated_at')->get() as $category) {
                        $sitemap .= $this->urlEntry(
                            route('blog.category', $category->slug),
                            $category->updated_at,
                            'weekly',
                            '0.7'
                        );
                    }
                    foreach (Tag::active()->whereHas('publishedPosts')->select('slug', 'updated_at')->get() as $tag) {
                        $sitemap .= $this->urlEntry(
                            route('blog.tag', $tag->slug),
                            $tag->updated_at,
                            'weekly',
                            '0.6'
                        );
                    }
                    break;
            }

            $sitemap .= '</urlset>';
            return $sitemap;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function urlEntry(string $loc, $lastmod, string $changefreq, string $priority): string
    {
        $lastmodIso = $lastmod ? $lastmod->toAtomString() : now()->toAtomString();
        return sprintf(
            '<url><loc>%s</loc><lastmod>%s</lastmod><changefreq>%s</changefreq><priority>%s</priority></url>',
            htmlspecialchars($loc, ENT_XML1 | ENT_QUOTES, 'UTF-8'),
            $lastmodIso,
            $changefreq,
            $priority
        );
    }

    public function robots()
    {
        $robots = cache()->remember('robots.txt', 3600, function () {
            $custom = \App\Models\Setting::where('key', 'robots_txt')->value('value');

            if ($custom) {
                if (!str_contains($custom, 'Sitemap:')) {
                    $custom = rtrim($custom) . "\n\nSitemap: " . url('/sitemap.xml');
                }
                return $custom;
            }

            return "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /login\n\nSitemap: " . url('/sitemap.xml');
        });

        return response($robots, 200)
            ->header('Content-Type', 'text/plain');
    }

    /**
     * Centralized sitemap cache invalidation. Call from anywhere that
     * changes data appearing in the sitemap (Post, Page, Category, Tag, Setting).
     */
    public static function flushCache(): void
    {
        $cache = cache();
        $cache->forget('sitemap.xml.full');
        $cache->forget('sitemap.xml.index');
        $cache->forget('robots.txt');

        // Forget all paginated sitemap caches by type+page combinations.
        // Only iterate up to a reasonable upper bound — paginated sitemaps
        // are recreated lazily.
        foreach (['static', 'posts', 'pages', 'taxonomies'] as $type) {
            for ($i = 1; $i <= 100; $i++) {
                $cache->forget("sitemap.xml.{$type}.{$i}");
            }
        }
    }
}
