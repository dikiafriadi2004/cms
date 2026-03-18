<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\Ad;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $homepage = Page::where('is_homepage', true)->published()->first();
        
        $context = ['page' => 'home'];
        $ads = [
            'header' => Ad::getByPosition('header', $context),
            'footer' => Ad::getByPosition('footer', $context),
        ];
        
        $latestPosts = Post::published()
            ->with(['user', 'category', 'tags'])
            ->latest('published_at')
            ->limit(6)
            ->get();
        
        $viewPath = TemplateService::getTemplatePath('home');
        
        if (!$homepage) {
            return view($viewPath, compact('latestPosts', 'ads'));
        }

        $this->trackPageView($homepage);

        return view($viewPath, compact('homepage', 'latestPosts', 'ads'));
    }

    public function page(Page $page)
    {
        if (!$page->isPublished()) {
            abort(404);
        }

        $this->trackPageView($page);

        $context = [
            'page' => 'static_page',
            'post' => $page->id,
        ];
        $ads = [
            'content_top' => Ad::getByPosition('content_top', $context),
            'content_bottom' => Ad::getByPosition('content_bottom', $context),
        ];

        $template = TemplateService::getCurrentTemplate();
        $viewPath = TemplateService::getView($template, 'page');

        return view($viewPath, compact('page', 'ads'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    private function trackPageView($page)
    {
        // Simple page view tracking
        // You can implement more sophisticated tracking here
        $page->increment('views_count');
    }
}