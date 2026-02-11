<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Ad;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get settings
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // Get menus
        $headerMenu = Menu::where('location', 'header')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
        }])->first();
        
        $footerMenu = Menu::where('location', 'footer')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
        }])->first();
        
        // Get homepage or default content
        $homepage = Page::where('is_homepage', true)->published()->first();
        
        // Get ads for homepage
        $context = ['page' => 'home'];
        $ads = [
            'header' => Ad::getByPosition('header', $context),
            'footer' => Ad::getByPosition('footer', $context),
        ];
        
        // Get latest posts for blog section
        $posts = Post::published()
            ->with(['user', 'category', 'tags'])
            ->latest('published_at')
            ->limit(6)
            ->get();
        
        if (!$homepage) {
            // If no homepage is set, show landing page with posts
            return view('frontend.home', compact('posts', 'settings', 'headerMenu', 'footerMenu', 'ads'));
        }

        // Track page view
        $this->trackPageView($homepage);

        return view('frontend.home', compact('homepage', 'posts', 'settings', 'headerMenu', 'footerMenu', 'ads'));
    }

    public function page(Page $page)
    {
        if (!$page->isPublished()) {
            abort(404);
        }

        // Track page view
        $this->trackPageView($page);

        // Get settings and menus
        $settings = Setting::pluck('value', 'key')->toArray();
        $headerMenu = Menu::where('location', 'header')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
        }])->first();
        $footerMenu = Menu::where('location', 'footer')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
        }])->first();

        // Get ads for page
        $context = [
            'page' => 'static_page',
            'post' => $page->id,
        ];
        $ads = [
            'content_top' => Ad::getByPosition('content_top', $context),
            'content_bottom' => Ad::getByPosition('content_bottom', $context),
        ];

        return view('frontend.page', compact('page', 'settings', 'headerMenu', 'footerMenu', 'ads'));
    }

    public function about()
    {
        // Get settings and menus
        $settings = Setting::pluck('value', 'key')->toArray();
        $headerMenu = Menu::where('location', 'header')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order')->with('children');
        }])->first();
        $footerMenu = Menu::where('location', 'footer')->with(['items' => function($query) {
            $query->where('is_active', true)->whereNull('parent_id')->orderBy('sort_order');
        }])->first();

        return view('frontend.about', compact('settings', 'headerMenu', 'footerMenu'));
    }

    private function trackPageView($page)
    {
        // Simple page view tracking
        // You can implement more sophisticated tracking here
        $page->increment('views_count');
    }
}