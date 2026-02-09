<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Menu;
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
        
        if (!$homepage) {
            // If no homepage is set, show latest posts
            $posts = Post::published()
                ->with(['user', 'category', 'tags'])
                ->latest('published_at')
                ->limit(6)
                ->get();
                
            return view('frontend.home', compact('posts', 'settings', 'headerMenu', 'footerMenu'));
        }

        // Track page view
        $this->trackPageView($homepage);

        return view('frontend.home', compact('homepage', 'settings', 'headerMenu', 'footerMenu'));
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

        return view('frontend.page', compact('page', 'settings', 'headerMenu', 'footerMenu'));
    }

    private function trackPageView($page)
    {
        // Simple page view tracking
        // You can implement more sophisticated tracking here
        $page->increment('views_count');
    }
}